<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1); 
date_default_timezone_set('America/Bogota');
//obtenemos el archivo a subir
$file = $_FILES['pic']['name'];

//comprobamos si existe un directorio para subir el archivo
//si no es así, lo creamos
if(!is_dir("files/")) 
    mkdir("files/", 0777);

$data=false;
//comprobamos si el archivo ha subido
if ($file && move_uploaded_file($_FILES['pic']['tmp_name'],"files/".$file))
{
   sleep(3);//retrasamos la petición 3 segundos
   $data = true;
}       
try
{
  $registros = array(); 
  $csv = array();
  $nombres = array();
  $importacion = array();
  $unidades = array();
  $personas = array();
  $unidad_id = array();
  $file = fopen('files/'.$file, 'r');
  $idcopropiedad = $_POST['id_copropiedad'];
  $nombrecopropiedad = $_POST['ncp'];
  $idcrmpersona = $_POST['id_crm'];
  $contadorUsuarios=0;
  $contadorUnidades=0;
  $contadorUsuariosNuevos=0;
  $contadorUsuariosExistentes=0;
  $errores=array();
  DEFINE('this_url',"https://app.copropiedad.co/");
  while (($result = fgetcsv($file,1000, ";")) !== false)
    $csv[] = $result;

  fclose($file);

  //var_dump($csv);

  if(count($csv) > 0)
  {
      foreach ($csv as $key => $value) 
      {
        if($key == 0)
          $nombres = $value;
  
        $elem = array();
        foreach ($value as $k => $v) 
        {
          $elem[$nombres[$k]] = $v;
        }
  
        if($key != 0)
          $importacion[] = $elem;
      }
      
      $i = 0;
      try
      {
        foreach ($importacion as $key => $value) 
        {
          $und = array();
          $und['identificador'] = $value['identificador'];
          $und['tipo_unidad'] = $value['tipo_unidad'];
          $und['detalle'] = $value['detalle'];
          $und['canon'] = $value['canon'];
          $und['coeficiente'] = $value['coeficiente'];
          if ($value['proveedor'] == "NO") 
            $und['proveedor'] = false;
          else
            $und['proveedor'] = true;
          
          $unidades[$value['identificador']] = $und;
    
          $per = array();
    
          $per["nombre"] = $value["nombre"];
          $per['identificador'] = $value['identificador'];
          $per["apellido"] = $value["apellido"];
          $per["telefono"] = $value["telefono"];
          $per["email"] = $value["email"];
          $per["empresa"] = $value["empresa"];
          $per["unidad"] = $value["unidad"];
          $per["tipo"] = $value["tipo"];
          $per["celular"] = $value["celular"];
          $per["grupo"] = $value["grupo"];
          if ($value["esprincipal"] == "NO") 
            $per["esprincipal"] = false;
          else
            $per["esprincipal"] = true;
          if ($value['proveedor'] == "NO") 
            $per['proveedor'] = false;
          else
            $per['proveedor'] = true;
    
          $personas[$i] = $per;
          $i++;
        }
      }
      catch (Exception $ex)
      {
        guardaErrores($errores, "La linea " . $i . " tiene errores y no es posible interpretar el archivo, corrijala e intente de nuevo. Recuerde que no pueden haber campos vacios en el archivo. " . $ex->getMessage(), "critical");
      }
  
      $restoken = obtenerToken(this_url . "api/admin/copropiedad/token"); 

      if($restoken['status'])
      {
        foreach ($unidades as $key => $value) 
        {
          $rta = "";
          try
          {
            $rta = crearUnidad($value, $idcopropiedad, $nombrecopropiedad, $idcrmpersona, $restoken['message']['token']);
            $unidad_id[$value['identificador']] = $rta['$id'];
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La unidad " . $value['identificador']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "critical");
          }
        }
  
        $new_personas = array();
        foreach ($personas as $key => $value) 
        {
          $value['unidad'] =  $unidad_id[$value['identificador']];
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

          try
          {
            $rta = crearUsuarioCP($value, $idcopropiedad, $nombrecopropiedad, $idcrmpersona, $restoken['message']['token']);
            $rta_arr[] = $rta;
            $rtaid = $rta['$id'];
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          }  

          try
          {
            $rta = crearRolUsuario($value, $idcopropiedad, $nombrecopropiedad, $idcrmpersona, $restoken['message']['token']);            
            $rta_arr[] = $rta;
            if(strlen($rtaid) < 10)
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ".","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada. La respuesta del servidor es: " . json_encode($rta) . ". Excepcion: " . $ex->getMessage(), "warning");
          } 


          if($value['esprincipal'])
            try
            {
              $resprincipal = crearPrincipal($value, $unidades, $idcopropiedad, $idcrmpersona, $idcrm, $rtaid, $restoken['message']['token']);
              $rtaesp_arr[] = $resprincipal;
              $rtaprin = $resprincipal['$id'];
              if(strlen($rtaprin) < 10)
                guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada como principal. La respuesta del servidor es: " . json_encode($resprincipal) . ". ","warning");
            }
            catch (Excepction $ex)
            {
              guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada como principal. La respuesta del servidor es: " . json_encode($resprincipal) . ". Excepcion: " . $ex->getMessage(), "warning");
            }  

          try
          {
            $rtaldap = crearUsuarioLDAP($value, $idcrm, $restoken['message']['token']);
            // $rtaldap_arr[] = $rtaldap;
            // if(strlen($rtaldap) < 10)
            //   guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada como principal. La respuesta del servidor es: " . json_encode($rtaldap) . ".","warning");
          }
          catch (Exception $ex)
          {
            //guardaErrores($errores, "La persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser creada como principal. La respuesta del servidor es: " . json_encode($rtaldap) . ". Excepcion: " . $ex->getMessage(), "warning");
          }  

          try
          {
            $rtaemail = EnviarCorreoActivacion($value, $restoken['message']['token']);
            $rtaemail_arr[] = $rtaemail;
            if(!$rtaemail)
              guardaErrores($errores, "El correo de la persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser enviado. La respuesta del servidor es: " . json_encode($rtaemail) . ". ","warning");
          }
          catch (Exception $ex)
          {
            guardaErrores($errores, "El correo de la persona " . $value['nombre'] . " " . $value['apellido'] . " perteneciente a la unidad " . $value['identificador']. " no pudo ser enviado. La respuesta del servidor es: " . json_encode($rtaemail) . ". Excepcion: " . $ex->getMessage(), "warning");
          } 
        }

        //var_dump($rta_arr);
        //var_dump($rtaesp_arr);
        //var_dump($rtaldap_arr);
        //var_dump($rtaemail_arr);
        if(count($errores) > 0)
          //despliegaErrores(false, true, "Proceso finalizado con exito. Valide la lista de errores para validar errores de importacion.", $errores);
          echo "<script>location.href='respuesta.php?idr=2'</script>";
        else
          //despliegaErrores(false, true, "Proceso finalizado con exito. No hay errores.",$errores);
          echo "<script>location.href='respuesta.php?idr=1'</script>";
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
  echo $e->getMessage();
}

function crearRolUsuario($usuario, $idcopropiedad, $nombrecopropiedad, $idcrmpersona, $token)
{
  $arr = array();
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["email"] = $usuario["email"];
  $arr["nombre"] = $nombrecopropiedad;
  $arr["rol"]="residente";
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

function crearUnidad($unidad, $idcopropiedad, $nombrecopropiedad, $idcrmpersona, $token)
{
  $arr = array();
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["nombre_copropiedad"] = $nombrecopropiedad;
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["tipo_unidad"] = $unidad['tipo_unidad'];
  $arr["identificador"] = $unidad['identificador'];
  $arr["reservable"] = false;
  $arr["detalle"] = $unidad['detalle'];
  $arr["estado"] = 1;
  $arr["fecha_creacion"] = date("c");
  $arr["proveedor"] = $unidad['proveedor'];

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
  $arr["nombre"] = $usuario['nombre'] . $usuario['apellido'];
  $arr["telefono"] = $usuario['telefono'];
  $arr["celular"] = $usuario['celular'];
  $arr["email"] = $usuario['email'];
  $arr["empresa"] = $usuario['empresa'];
  $arr["unidad"] = $usuario['unidad'];
  $arr["tipo"] = $usuario['tipo'];
  $arr["estado"] = "1";
  $arr["grupo"] = $usuario['grupo'];

  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request, this_url . "api/admin/copropiedad/usuario/"); 
}

function crearUsuarioLDAP($usuario, $id_crm_persona, $token)
{
  $arr = array(
      'nombre'=>utf8_encode($usuario["nombre"]),
      'estado'=>"0",
      'apellido'=>utf8_encode($usuario["apellido"]),
      'email'=>"cp-" . $usuario["email"],
      'genero'=>" ",
      'nacionalidad'=>" ",
      'lugarNacimiento'=>" ",
      'paisNacimiento'=>"CO",
      'fechaNacimiento'=>"01/01/1901",
      'idioma'=>"Español",
      'id_crm'=>$id_crm_persona,
      'password'=>"19283uj9qwnoa98ndfnsdf",
      'tipoDocumento'=>"CC",
      'numeroDocumento'=>"123465789"
  );

  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request, "http://auth.teleinte.com/auth/"); 
}

function crearPrincipal($usuario, $unidad, $idcopropiedad, $idcrmpersonacreador, $idcrmpersona, $idusuario, $token)
{
  $arr = array();
  $arr["id_copropiedad"] = $idcopropiedad;
  $arr["id_crm_persona"] = $idcrmpersona;
  $arr["creado_por"] = $idcrmpersonacreador;
  $arr["unidad"] = $usuario["unidad"];
  $arr["encargado"] = $usuario["nombre"] . " " . $usuario["apellido"];
  $arr["id_usuario"] = $idusuario;
  $arr["email"] = $usuario["email"];
  $arr["coeficiente"] = $unidad[$usuario["identificador"]]["coeficiente"];
  $arr["canon"] = $unidad[$usuario["identificador"]]["canon"];
  $arr["cargos"] = 0;
  $arr["proveedor"] = $usuario["proveedor"];

  $request = array("token" => $token, "body" => $arr);
  return EnviarData($request, this_url . "api/unidad/unidadEncargado/"); 
}

function enviarCorreoActivacion($usuario, $token)
{
  // echo "<pre>";
  // var_dump($usuario);
  $rutaAplicativo = this_url . "api/mailer/mail/registro/activacion/";
  $rutaActivacion = this_url . "registrese/activar.php?token=";
  $code = base64_encode(urlencode($usuario["nombre"])."^cp-".$usuario["email"]);
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
              'nombre'=>utf8_encode($usuario["nombre"]),
              'link'=>$datoCorreo,
              'email'=>$usuario["email"],
           )
        ],
      )
  );
  //var_dump(json_encode($arr4));
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
    echo json_encode($resp);
    exit;
  }
  else
  {
    $resp = array("status" => $status, "message" => $message, "error" => $errores);
    echo json_encode($resp);    
  }
}

function generarIdCRM()
{
  return mt_rand(100,999999999);
}
?>