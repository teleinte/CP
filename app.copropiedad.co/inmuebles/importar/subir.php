<?php
set_error_handler('exceptions_error_handler');
error_reporting(E_ALL);
ini_set('display_errors', 1); 
ini_set("auto_detect_line_endings", 1);
date_default_timezone_set('America/Bogota');
try
{
  $csv = explode("|", $_POST['importados']);  
  $registros = array();   
  $nombres = array();
  $importacion = array();
  $unidades = array();
  $personas = array();
  $unidad_id = array();  
  $idcopropiedad = $_POST['id_copropiedad'];  
  $idcrmpersona = $_POST['id_crm'];
  $tokenenvio = $_POST['token'];
  $nombre_completo = $_POST['nombrecompleto'];
  $nombrecopropiedad = $_POST['ncp'];
  $contadorUsuarios=0;
  $contadorUnidades=0;
  $contadorUsuariosNuevos=0;
  $contadorUsuariosExistentes=0;
  $errores=array();
  DEFINE('this_url',"https://appdes.copropiedad.co/");

  $tUnidades=0;
  $tContactos=0;
  if(count($csv) > 0)
  {
    $elem = array();
    foreach ($csv as $key => $value) 
    {
      $value=explode(",", $value);        
      $elem['nombre_inmueble'] = $value[0];
      $elem['nombre_contacto'] = $value[1];
      $elem['apellido_contacto'] = $value[2];
      $elem['telefono'] = $value[3];
      $elem['email'] = strtolower($value[4]);
      $elem['grupo'] = $value[5];
      $elem['esprincipal'] = $value[6];
      $importacion[] = $elem;
    }    
    $i = 0;
    try
    {
      foreach ($importacion as $key => $value) 
      {
        //recorrido de unidades
        $und = array();
        $und['nombre_inmueble'] = $value['nombre_inmueble'];
        $unidades[$value['nombre_inmueble']] = $und;
        //recorrido de contactos
        $per = array();
        $per['nombre_inmueble'] = $value['nombre_inmueble'];
        $per["nombre"] = $value["nombre_contacto"];          
        $per["apellido"] = $value["apellido_contacto"];
        $per["telefono"] = $value["telefono"];
        $per["email"] = strtolower($value["email"]);
        $per["grupo"] = strtolower($value["grupo"]);
        
        if ($value["esprincipal"] == "NO" or $value["esprincipal"] == "no") 
          $per["esprincipal"] = false;
        else
          $per["esprincipal"] = true;
        $personas[$i] = $per;
        $i++;
      }
    }
    catch (Exception $ex)
    {        
      guardaErrores($errores, "La linea " . $i . " tiene errores y no es posible interpretar el archivo, corrija el archivo intente de nuevo. Recuerde que no pueden haber campos vacios en el archivo. " . $ex->getMessage(), "critical");
    }

    $restoken = obtenerToken(this_url."api/estados/token",$tokenenvio);
    $restoken = $restoken["message"]["token"];

    //recorremos las unidades para crearlas una a una
    foreach ($unidades as $key => $value) 
    {
      $tUnidades++;  
      $rta = "";
      try
      {
        $rta = crearUnidad($value, $idcopropiedad, $idcrmpersona, $restoken);
        $unidad_id[$value['nombre_inmueble']] = $rta['$id'];
      }
      catch (Exception $ex)
      {
        guardaErrores($errores, "La unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "critical");
      }
    }
    // ahora vamos a crear las personas
    $new_personas = array();
    foreach ($personas as $key => $value) 
    {
      $tContactos++;
      $value['unidad'] =  $unidad_id[$value['nombre_inmueble']];          
      $new_personas[] = $value;
    }
    $rta_arr = array();
    $rtaesp_arr = array();
    $rtaldap_arr = array();
    $rtaemail_arr = array();

    foreach ($new_personas as $key => $value) 
    {
      $idcrm = generarIdCRM();
      $rta = "";
      $resprincipal = "";
      $rtaldap = "";
      $rtaid = "";
      $rtaemail = "";
      

      //validacion de procesos si existen en ldap
      try
      {
        $rta = validaUsuarioLDAP($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken);        
        if(isset($rta["count"]) and $rta["count"]==1)
        {

          try
          {
            $crm = verificarCRMCp($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken);            
            $rta = crearUsuarioCP($value, $idcopropiedad, $idcrmpersona, $crm, $restoken);
            $rta_arr[] = $rta;
            $rtaid = $rta['$id'];
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          }

          //como esta en el Ldap Necesito mirar su tipo en copropiedad y su IDCRM para continuar
          //primero verificar el tipo
          try
          {
            $rta = verificarTipoCp($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken);            
            if($rta==1)
            {
              $crm = verificarCRMCp($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken);                          
              $rtaemail = enviocorreoNotificacionAdmin($value, $nombre_completo, $crm, $nombrecopropiedad, $idcopropiedad, $value['unidad'], $value['nombre_inmueble'], $restoken);              
            }
            if($rta==2)
            {
              $crm = verificarCRMCp($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken);              
              // 0.1 registrando usuario en rolCP con idunidad
              $usuarioRol = crearRolUsuario($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken, $value['unidad'], $value['nombre_inmueble']);
              $rtaemail = enviocorreoNotificacionNoAdmin($value, $restoken, $nombre_completo, $idcrm, $nombrecopropiedad);
            }
            if($rta==3)
            {
              $crm = verificarCRMCp($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken);
              // 0.1 registrando usuario en rolCP con idunidad
              $usuarioRol = crearRolUsuario($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken, $value['unidad'], $value['nombre_inmueble']);
              $rtaemail = enviocorreoNotificacionNoAdmin($value, $restoken, $nombre_completo, $idcrm, $nombrecopropiedad);              
            }
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          } 

        }
        //else{echo "paso";}
        else
        {
          try
          {
            $rta = crearUsuarioCP($value, $idcopropiedad, $idcrmpersona, $idcrm, $restoken);
            $rta_arr[] = $rta;
            $rtaid = $rta['$id'];
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          }
          //lo creo en rolCP
          try
          {
            $rta = crearRolUsuario($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken,$value['unidad'], $value['nombre_inmueble']);
            $rta_arr[] = $rta;
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          } 
          //lo registro en estados en la tabla estados
          try
          {
            $rta = crearEstadoUsuario($value, $idcopropiedad, $idcrm,$nombrecopropiedad, $restoken, $idcrmpersona);
            $rta_arr[] = $rta;
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          }

          //alistar para cuadrar el token y el arreglo para enviar por correo
          try
          {
            $rtaemail = enviarCorreoActivacion($value, $restoken, $nombre_completo,$idcrm, $nombrecopropiedad);//EnviarCorreoActivacion($value, $restoken['message']['token']);
            $rtaemail_arr[] = $rtaemail;
            if(!$rtaemail)
              guardaErrores($errores, "El correo de la persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser enviado. La respuesta del servidor es: " . json_encode($rtaemail) . ". ","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "El correo de la persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser enviado. La respuesta del servidor es: " . json_encode($rtaemail) . ". Excepcion: " . $ex->getMessage(), "warning");
          }
        }
      }
      catch (Exception $ex)
      {
        guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
      }   
    }
    echo "<script>location.href='respuesta.php?idr=1&tc=".$tContactos."&tu=".$tUnidades."'</script>";
  }
}
catch(Exception $ex)
{
  echo $ex->getMessage();
}

function verificarCRMCp($usuario, $idcopropiedad, $idcrmpersona, $nombrecopropiedad ,$token)
{
  $arr = array();
  $arr["email"] = strtolower($usuario["email"]);
  $request = array("token" => $token, "body" => $arr);
  return EnviarDataPUT($request,this_url."api/estados/obtener");
}

function verificarTipoCp($usuario, $idcopropiedad, $idcrmpersona, $nombrecopropiedad ,$token)
{
  $arr = array();
  $arr["email"] = strtolower($usuario["email"]);
  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request,this_url."api/estados/obtener");
}

function enviocorreoNotificacionAdmin($usuario, $nombre_admin, $crm, $nombrecopropiedad, $id_copropiedad, $id_unidad, $nombre_unidad, $token)
{
  //esto es para preparar el rol en la copropiedad
  $restoken = obtenerToken(this_url."api/estados/token",$token);
  $restoken = $restoken["message"]["token"];
  $arr=array();
  $arr["id_crm_persona"] = $crm;
  $arr["id_copropiedad"] = $id_copropiedad;
  $arr["correo"]=strtolower($usuario["email"]);
  $arr["nombre"]=$nombrecopropiedad;
  $arr["rol"]="residente";
  $arr["id_unidad"]=$id_unidad;
  $arr["nombre_unidad"]=$nombre_unidad;
  $arr["imagen"]=" ";
  $request1 = array("token" =>trim($restoken), "body" => $arr);

  $arr2=array();
  $arr2["email"]=strtolower($usuario["email"]);
  $arr2["id_crm_persona"]=$crm;
  $arr2["estado"]=2;  
  $request2 = array("token"=>trim($restoken), "body" => $arr2);

  $rutaAceptacion = this_url."/aceptar/aceptar.php?tk=".base64_encode(json_encode($request1))."&en=".base64_encode(json_encode($request2));

  $mail_message = '<p><strong>'.$nombre_admin.'</strong>, lo ha invitado a ser parte de la copropiedad <strong>'.$nombrecopropiedad.'</strong>.<br>En el momento de aceptar esta invitación, cada vez que ingrese a Copropiedad.co se le preguntará si quiere entrar como administrador o como residente.<br><br><a href="'.$rutaAceptacion.'" style="background:#f51e7c; color:#fff!important; text-decoration: none; margin-top:10px; padding:5px 10px; border-radius: 3px; font-weight:bold;">ACEPTAR INVITACION</a>';
  return soloEnvio2(strtolower($usuario['email']), "Invitación", $mail_message, trim($restoken));
}



function enviocorreoNotificacionNoAdmin($usuario, $token, $nombre_admin, $id_crm, $nombrecopropiedad)
{
  $mail_message ='<p> Su administrador(a) de Propiedad Horizontal <strong>'.$nombre_admin.'</strong>, lo ha adicionado a la copropiedad <strong>'.$nombrecopropiedad.'</strong> en Copropiedad.co<br> Ahora, cuando usted ingrese a copropiedad.co podrá escoger la copropiedad '.$nombrecopropiedad.' para conocer toda la información y servicios en línea que <strong>'.$nombre_admin.'</strong> ha habilitado para usted.';
  
  return soloEnvio2(strtolower($usuario['email']), "Usted tiene una nueva Copropiedad", $mail_message, $token);
  //var_dump($CorreoEnviado);
}

function enviarCorreoActivacion($usuario, $token, $nombre_admin, $id_crm, $nombrecopropiedad)
{
  // echo "<pre>";
  // echo this_url;
  // var_dump($usuario);
  $restoken = obtenerToken(this_url."api/estados/token",$token);
  $restoken = $restoken["message"]["token"];
  $arr=array();
  $arr["nombre"] = $usuario['nombre'];
  $arr["estado"]=1;
  $arr["apellido"] = $usuario['apellido'];
  $arr["email"]="cp-".strtolower($usuario["email"]);
  $arr["genero"]=" ";
  $arr["nacionalidad"]=" ";
  $arr["lugarNacimiento"]=" ";
  $arr["paisNacimiento"]="CO";
  $arr["fechaNacimiento"]="01/01/1901";
  $arr["nombre"]=$nombrecopropiedad;
  $arr["idioma"]="es-CO";
  $arr["id_crm"]=$id_crm;
  $arr["password"]="19283uj9qwnoa98ndfnsdf";
  $arr["tipoDocumento"]="CC";
  $arr["numeroDocumento"]="123465789";  
  $request = array("token" =>trim($restoken), "body" => $arr);
  $rutaAplicativo = this_url."api/mailer/mail/registro/activacion/";
  $rutaActivacion = this_url."registrese/activar.php?token=";  
  $code = base64_encode(urlencode(json_encode($request)));
  $datoCorreo=$rutaActivacion.urlencode(trim($restoken))."&code=".$code."&ecp=3";

  $mail_message='<p> <strong>'.$nombre_admin.'</strong>, administrador(a) de propiedad horizontal, lo ha invitado a ser parte de <strong>'.$nombrecopropiedad.'</strong> en <a href="http://www.copropiedad.co/" >Copropiedad.co </a> <br> Ahora usted podrá ingresar a <a href="http://www.copropiedad.co/" >Copropiedad.co</a> y conocer toda la información y servicios en línea que <strong>'.$nombre_admin.'</strong> ha habilitado para usted. <br><br><strong>El usuario de su cuenta es: '.strtolower($usuario['email']).'</strong><br><br> Para activar su cuenta, es necesario que asigne una contraseña haciendo click en el siguiente botón: <br><a href="'.$datoCorreo.'" style="background:#f51e7c; color:#fff!important; text-decoration: none; padding:5px 10px; border-radius: 3px; font-weight:bold;">Asignar contraseña y activar</a><br></p>';
  return soloEnvio2(strtolower($usuario['email']), "Invitación a Copropiedad.co", $mail_message, $token);
  //var_dump($CorreoEnviado);
}

function soloEnvio($mail_to, $mail_subject, $mail_message, $token)
{   
    $rutaAplicativo = this_url."api/mailer/mail/send";        
    $arr=array('token'=>$token, 'body'=>array('to'=>$mail_to, 'subject'=>$mail_subject, 'message'=>$mail_message ));
    $estadoEnvio=EnviarData($arr,$rutaAplicativo);
    return $estadoEnvio;
}
function soloEnvio2($mail_to, $mail_subject, $mail_message, $token)
{   
    $rutaAplicativo = this_url."api/mailer/mail/send2";        
    $arr=array('token'=>$token, 'body'=>array('to'=>$mail_to, 'subject'=>$mail_subject, 'message'=>$mail_message ));
    $estadoEnvio=EnviarData($arr,$rutaAplicativo);
    return $estadoEnvio;
}


function crearEstadoUsuario($usuario, $idcopropiedad,$idcrmpersona,$nombrecopropiedad , $token, $creador)
{
  $arr = array();
  $arr["creado_por"] = $creador;
  $arr["fecha_creacion"] = date("c");
  $arr["nombre"] = $usuario['nombre'];
  $arr["apellido"] = $usuario['apellido'];
  $arr["email"]=strtolower($usuario["email"]);
  $arr["telefono"]=$usuario['telefono'];
  $arr["estado"]=0;
  $arr["id_crm_persona"]=$idcrmpersona;
  $request = array("token" => $token, "body" => $arr);  
  return EnviarData($request, this_url . "api/estados/estados");
}


function crearRolUsuario($usuario, $idcopropiedad,$idcrmpersona,$nombrecopropiedad, $token,$id_unidad,$nombr_unidad)
{
  $arr = array();
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["correo"] = strtolower($usuario["email"]);
  $arr["nombre"] = $nombrecopropiedad;
  $arr["rol"]="residente";
  $arr["imagen"]="";
  $arr["id_unidad"]=$id_unidad;
  $arr["nombre_unidad"]=$nombr_unidad;
  $request = array("token" => $token, "body" => $arr);  
  return EnviarData($request, this_url . "api/admin/copropiedad/rol/");
}


function validaUsuarioLDAP($usuario, $idcopropiedad, $idcrmpersona, $nombrecopropiedad ,$token)
{
  $arr = array();
  $arr["email"] = "cp-".strtolower($usuario["email"]);
  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request,"https://auth.sinfo.co/auth/verify/");
}




function obtenerToken($url,$token)
{
  $data_string = json_encode(array("token"=>$token, "body" => array("autkey" => "ImportadorCopropiedad".generarIdCRM(), "user" => "copropiedad", "tiempo"=>"+1 year")));
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length:'.strlen($data_string))
  );
  $datosEnviados=curl_exec($ch);
  $result = json_decode($datosEnviados,true);
  return $result;
}
function generarIdCRM()
{
  return mt_rand(1000,9999999999);
}

function crearUnidad($unidad, $idcopropiedad, $idcrmpersona, $token)
{
  $arr = array();
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["tipo_documento"] = "inmueble";
  $arr["tipo_unidad"] = "privada";
  $arr["nombre_inmueble"] = $unidad['nombre_inmueble'];
  $arr["estado"] = 1;
  $arr["fecha_creacion"] = date("c");
  $request = array("token" => $token, "body" => $arr);  
  return EnviarData($request, this_url . "api/unidad/unidad/"); 
}

function EnviarData($arr,$url)
{    
    $data_string = json_encode($arr);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length:'.strlen($data_string))
    );
    $datosEnviados=curl_exec($ch);
    $result = json_decode($datosEnviados,true);
    
    if($result['status']!=false)
    {
        return $result['message'];
    }
    else
    {
        return $result;
    }
}

function EnviarDataPUT($arr,$url)
{    
    $data_string = json_encode($arr);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length:'.strlen($data_string))
    );
    $datosEnviados=curl_exec($ch);
    $result = json_decode($datosEnviados,true);
    
    if($result['status']!=false)
    {
        return $result['message'];
    }
    else
    {
        return $result;
    }
}


function crearUsuarioCP($usuario, $idcopropiedad, $idcrmpersona, $idcrm, $token)
{
  $arr = array();
  $arr["creado_por"] = $idcrmpersona;
  $arr["fecha_creacion"] = date("c");
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["id_crm_persona"] = $idcrm;
  $arr["nombre"] = $usuario['nombre'] . " " . $usuario['apellido'];
  $arr["telefono"] = $usuario['telefono'];
  $arr["email"] = strtolower($usuario['email']);
  $arr["unidad"] = $usuario['unidad'];
  $arr["perfil"] = "residente";
  $arr["tipo"] = "residente";
  $arr["estado"] = 1;
  $arr["grupo"] = $usuario['grupo'];
  $arr["principal"] = $usuario['esprincipal'];
  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request, this_url . "api/admin/copropiedad/usuario/"); 
}