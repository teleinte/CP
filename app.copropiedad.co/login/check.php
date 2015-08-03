<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Bogota');
$correo = str_replace("cp-", "", $_GET['cm']);
$id_crm_persona = $_GET['crm'];
$data = array("token" =>base64_decode($_GET['stk']), "body" => array("id_crm_persona" => $id_crm_persona));
$data_string = json_encode($data);
$urlcurl = base64_decode($_GET['referer']) . '/api/admin/copropiedad/copropiedad/usuarioCopropiedad/';
$ch = curl_init($urlcurl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))
);    
$datosEnviados=curl_exec($ch);    
$result = json_decode($datosEnviados,true);
$vigentes = array();
$vencidos = array();
foreach ($result as $key => $value) 
{
  if(is_array($value))
  {
    foreach ($value as $llave => $valor) 
    {
      if(is_array($valor))
      {
        $idCopropiedad=$valor['_id']['$id'];
        $fechaHoy=date("Y-m-d");
        if ($valor['vigencia'] > $fechaHoy)
        {
          $vigentes[]=$idCopropiedad;
        }
        else
        {
          $vencidos[]=$valor['nombre']."@".$idCopropiedad."@".$valor['vigencia'];
        }
      }
    }
  }
}
$data = array("token" =>base64_decode($_GET['stk']), "body" => array("correo" => $correo));
$data_string = json_encode($data);
$ch = curl_init(base64_decode($_GET['referer']) . '/api/admin/copropiedad/usuario/personacrm');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))
);    
$datosEnviados=curl_exec($ch);    
$result = json_decode($datosEnviados,true);
$admin = $prov = $res = 0;
foreach ($result as $value) 
{
  if(is_array($value))
  {
    foreach ($value as $otrovalue) 
    {
      if(is_array($otrovalue))
      {
        if(in_array($otrovalue['id_copropiedad'], $vigentes))
        {
          foreach ($otrovalue as $key=>$unomas) 
          {
            if (!is_array($unomas))
            {                      
                if ($key == "rol")
                {
                  if ($unomas=="residente"){$res++;}
                  if ($unomas=="administrador"){$admin++;}
                  if ($unomas=="proveedor"){$prov++;}                        
                }
            }                  
          }
        }            
      }
    }  
  }      
}

if(count($vencidos)==0)
{
    $vencidos = 0;
}
else
{
    $vencidos=implode(",",$vencidos);
    $eliminados=0;
}
if ($res>0 and $admin>0 and $prov>0)
    {
       //echo "debe pasar por la pantalla aquilla para seleccionar y reenviar Todos los botones";
       echo "<script>
       var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid')+'|'+6+'|'+'".$vencidos."';
       var envio = btoa(envio);
       alert(envio);
       </script>";
    }
    if ($res>0 and $admin>0 and $prov==0)
    {
       //echo "debe pasar por la pantalla aquilla para seleccionar y reenviar solo dos botones";
       echo "<script>var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid')+'|'+3+'|'+'".$vencidos."';
       var envio = btoa(envio);
       location.href='review.php?dtv='+envio;
       </script>";
    }
    if ($res>0 and $admin==0 and $prov==0 and $eliminados!=0)
    {
       echo "<script>var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid');
       var envio = btoa(envio);
       location.href = 'http://mi.copropiedad.co/inicio/index.php?vrs='+envio;
       </script>";
    }
    if ($res>0 and $admin==0 and $prov==0 and $eliminados==0)
    {
       echo "<script>var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid')+'|'+1+'|'+'".$vencidos."';
       var envio = btoa(envio);
       location.href='review.php?dtv='+envio;
       </script>";
    }
    if ($res==0 and $admin>0 and $prov>0)
    {
       echo "
       <script>
       var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid');
       var envio = btoa(envio);
       location.href = 'http://mi.copropiedad.co/inicio/inicio.php?vrs='+envio;
       </script>";
    }
    if ($res==0 and $admin>0 and $prov==0 and $eliminados!=0)
    {
       echo "<script>location.href = '../inicio/';</script>";
    }
    if ($res==0 and $admin>0 and $prov==0 and $eliminados==0)
    {
       //echo "debe pasar por la pantalla aquilla para seleccionar y reenviar solo dos botones";
       //echo "debe pasar por la pantalla aquilla para seleccionar y reenviar solo dos botones";
       echo "<script>var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid')+'|'+2+'|'+'".$vencidos."';
       var envio = btoa(envio);
       location.href='review.php?dtv='+envio;
       </script>";
    }
    if ($res==0 and $admin==0 and $prov>0)
    {
       echo "<script>location.href = '../index.php?logout=1';</script>";
    }
    if ($res>0 and $admin==0 and $prov>0)
    {
       echo "<script>location.href = '../index.php?logout=1';</script>";
    }
    if ($res==0 and $admin==0 and $prov==0 and $eliminados!=0)
    {
       echo "<script>location.href = '../inicio/inicio.php';</script>";
    }
    if ($res==0 and $admin==0 and $prov==0 and $eliminados==0)
    {
       echo "<script>var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid')+'|'+0+'|'+'".$vencidos."';
       var envio = btoa(envio);
       location.href='review.php?dtv='+envio;
       </script>";
    }
?>