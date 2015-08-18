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
        $elem['nit'] = $value[6]; 
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
          $und['nit'] = $value['nit'];
          $unidades[$value['nombre_inmueble']] = $und;
          //recorrido de contactos
          $per = array();
          $per['nombre_inmueble'] = $value['nombre_inmueble'];
          $per["nombre"] = $value["nombre_contacto"];          
          $per["apellido"] = $value["apellido_contacto"];
          $per["telefono"] = $value["telefono"];
          $per["email"] = strtolower($value["email"]);
          $per["grupo"] = strtolower($value["grupo"]);
          $personas[$i] = $per;
          $i++;
        }
      }
      catch (Exception $ex)
      {        
        guardaErrores($errores, "La linea " . $i . " tiene errores y no es posible interpretar el archivo, corrija el archivo intente de nuevo. Recuerde que no pueden haber campos vacios en el archivo. " . $ex->getMessage(), "critical");
      }
      //solicitando un nuevo token  para  poder insertar la data
      $restoken = obtenerToken(this_url . "api/admin/copropiedad/token");       
      // validando el estado del token
      if($restoken['status'])
      {
        //recorremos las unidades para crearlas una a una
        foreach ($unidades as $key => $value) 
        {
          $tUnidades++;  
          $rta = "";
          try
          {
            $rta = crearUnidad($value, $idcopropiedad, $idcrmpersona, $restoken['message']['token']);
            $unidad_id[$value['nombre_inmueble']] = $rta['$id'];
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La unidad " . $value['nombre_inmueble']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "critical");
          }
        }        
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
          $rtaldap = "";
          $rtaid = "";
          $rtaemail = "";
          try
          {            
            $rta = crearUsuarioCP($value, $idcopropiedad, $idcrmpersona, $idcrm, $restoken['message']['token']);
            
            $rta_arr[] = $rta;
            $rtaid = $rta['$id'];
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_proveedor']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_proveedor']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          }  
          try
          {
            $rta = crearRolUsuario($value, $idcopropiedad, $idcrmpersona,$nombrecopropiedad, $restoken['message']['token']);
            $rta_arr[] = $rta;
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_proveedor']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_proveedor']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          } 
          try
          {
            $rtaemail = EnviarCorreoActivacion($value, $restoken['message']['token']);
            $rtaemail_arr[] = $rtaemail;
            if(!$rtaemail)
              guardaErrores($errores, "El correo de la persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser enviado. La respuesta del servidor es: " . json_encode($rtaemail) . ". ","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "El correo de la persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['nombre_inmueble']. " no pudo ser enviado. La respuesta del servidor es: " . json_encode($rtaemail) . ". Excepcion: " . $ex->getMessage(), "warning");
          } 
        }
        if(count($errores) > 0)
          //despliegaErrores(false, true, "Proceso finalizado con exito. Valide la lista de errores para validar errores de importacion.", $errores);
          echo "<script>location.href='respuesta.php?idr=2&tc=".$tContactos."&tu=".$tUnidades."'</script>";
        else
          //despliegaErrores(false, true, "Proceso finalizado con exito. No hay errores.",$errores);
          echo "<script>location.href='respuesta.php?idr=1&tc=".$tContactos."&tu=".$tUnidades."'</script>";
      }
      
      else
        //guardaErrores($errores, "No fue posible obtener el token de activacion", "critical");
          echo "<script>location.href='respuesta.php?idr=3'</script>";
  }
  else
    //guardaErrores($errores, "El archivo no contiene lineas", "critical");
    echo "<script>location.href='respuesta.php?idr=4'</script>";
  
}
catch(Exception $ex)
{
  echo $ex->getMessage();
}


function crearRolUsuario($usuario, $idcopropiedad,$nombrecopropiedad, $idcrmpersona, $token)
{
  $arr = array();
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["correo"] = strtolower($usuario["email"]);
  $arr["nombre"] = $nombrecopropiedad;
  $arr["rol"]="proveedor";
  $arr["imagen"]="";
  $request = array("token" => $token, "body" => $arr);  
  return EnviarData($request, this_url . "api/admin/copropiedad/rol/");
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

function obtenerToken($url)
{
  $data_string = json_encode(array("body" => array("autkey" => "ImportadorCopropiedad", "user" => "copropiedad")));
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
  return $result;
}

function crearUnidad($unidad, $idcopropiedad, $idcrmpersona, $token)
{
  $arr = array();
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["tipo_documento"] = "proveedor";
  $arr["tipo_unidad"] = "privada";
  $arr["nombre_inmueble"] = $unidad['nombre_inmueble'];
  $arr["estado"] = 1;
  $arr["nit"] = $unidad['nit'];
  $arr["fecha_creacion"] = date("c");
  $request = array("token" => $token, "body" => $arr);  
  return EnviarData($request, this_url . "api/unidad/unidad/"); 
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
  $arr["perfil"] = "proveedor";
  $arr["tipo"] = "proveedor";
  $arr["estado"] = 1;
  $arr["grupo"] = "proveedor";
  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request, this_url . "api/admin/copropiedad/usuario/"); 
}

function crearUsuarioLDAP($usuario, $id_crm_persona, $token)
{
  $arr = array(
      'nombre'=>utf8_encode($usuario["nombre"]),
      'estado'=>"0",
      'apellido'=>utf8_encode($usuario["apellido"]),
      'email'=>"cp-" . strtolower($usuario["email"]),
      'genero'=>" ",
      'nacionalidad'=>" ",
      'lugarNacimiento'=>" ",
      'paisNacimiento'=>"CO",
      'fechaNacimiento'=>"01/01/1901",
      'idioma'=>"es-CO",
      'id_crm'=>$id_crm_persona,
      'password'=>"19283uj9qwnoa98ndfnsdf",
      'tipoDocumento'=>"CC",
      'numeroDocumento'=>"123465789"
  );
  $request = array("token" => $token, "body" => $arr);  
  return EnviarData($request, "http://auth.teleinte.com/auth/"); 
}

function enviarCorreoActivacion($usuario, $token)
{
  $rutaAplicativo = this_url . "api/mailer/mail/registro/activacion/";
  $rutaActivacion = this_url . "registrese/activar.php?token=";
  $code = base64_encode(urlencode($usuario["nombre"])."^cp-".strtolower($usuario["email"]));
  $datoCorreo=($rutaActivacion.  urlencode($token)."&code=".urlencode($code));
  $arr4 = 
  array(
  'token'=>$token,
  'body'=>
  array(  
        'id_crm_persona'=>"registro",
        'fecha_solicitud'=>date('c'),
        'nombre_remitente'=>"registro",
        'destinatarios'=>[  
           array(  
              'nombre'=>utf8_encode($usuario["nombre"])." ".utf8_encode($usuario["apellido"]) ,
              'link'=>$datoCorreo,
              'email'=>strtolower($usuario["email"]),
           )
        ],
      )
  );

  return EnviarData($arr4,$rutaAplicativo);
  //var_dump($CorreoEnviado);
}

function guardaErrores($errores, $contenido, $tipo)
{
  if($tipo == "critical")
  {
    $errores[] = $contenido;
    despliegaErrores(true,false,"", $errores);
  }
  else
  {
    $errores[] = $contenido;
  }
}

function despliegaErrores($critical, $status, $message, $errores)
{
  if($critical)
  {
    $resp = array("status" => false, "message" => "Error critico en la importacion", "error" => $errores);      
  }
  else
  {
    $resp = array("status" => $status, "message" => $message, "error" => $errores);
  }
}
function generarIdCRM()
{
  return mt_rand(100,999999999999999999999);
}
?>