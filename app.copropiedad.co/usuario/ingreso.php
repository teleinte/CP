<?php
//echo "esta es la pagina intermedia que valida la cosa esa";
//primer paso mirar en la base de datos para ver que datos se tienen de esa persona
//curl
error_reporting(E_ALL);ini_set('display_errors', 1); 

    $correo = str_replace("cp-", "", $_GET['crm']);
    //echo $correo;
    $data = array("token" =>base64_decode($_GET['stk']), "body" => array("correo" => $correo));
    //echo "<pre>";
    // var_dump($data);
    $data_string = json_encode($data);
    //var_dump($data_string);
    $ch = curl_init('https://app.copropiedad.co/api/admin/copropiedad/usuario/personacrm');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );    
    $datosEnviados=curl_exec($ch);    
    $result = json_decode($datosEnviados,true);
    $admin = $prov = $res =0;

    //var_dump($result);
    foreach ($result as $value) {
      if(is_array($value))
      {
          foreach ($value as $otrovalue) {
          if(is_array($otrovalue))
            {
                foreach ($otrovalue as $key=>$unomas) {
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
    // echo "cantidad de residentes ".$res."<br>";
    // echo "cantidad de Administradores ".$admin."<br>";
    // echo "cantidad de proveedor ".$prov."<br>";
    if ($res>0 and $admin>0 and $prov>0)
    {
       echo "debe pasar por la pantalla aquilla para seleccionar y reenviar Todos los botones";
    }
    if ($res>0 and $admin>0 and $prov==0)
    {
       echo "debe pasar por la pantalla aquilla para seleccionar y reenviar solo dos botones";
       echo "
       <script>
       var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid');
       var envio = btoa(envio);
       alert(envio);
       </script>";
    }
    if ($res>0 and $admin==0 and $prov==0)
    {
       echo "
       <script>
       var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid');
       var envio = btoa(envio);
       alert(envio);
       location.href = 'http://mi.copropiedad.co/dashboard/dashboard.php?vrs='+envio;
       </script>";
    }
    if ($res==0 and $admin>0 and $prov>0)
    {
       echo "
       <script>
       var envio = sessionStorage.getItem('apellido')+'|'+sessionStorage.getItem('documento')+'|'+sessionStorage.getItem('email')+'|'+sessionStorage.getItem('estado')+'|'+sessionStorage.getItem('fechaNacimiento')+'|'+sessionStorage.getItem('genero')+'|'+sessionStorage.getItem('id_crm')+'|'+sessionStorage.getItem('idioma')+'|'+sessionStorage.getItem('lugarNacimiento')+'|'+sessionStorage.getItem('nacionalidad')+'|'+sessionStorage.getItem('nombre')+'|'+sessionStorage.getItem('nombreCompleto')+'|'+sessionStorage.getItem('paisNacimiento')+'|'+sessionStorage.getItem('tipoDocumento')+'|'+sessionStorage.getItem('token')+'|'+sessionStorage.getItem('uid');
       var envio = btoa(envio);
       alert(envio);
       location.href = 'http://mi.copropiedad.co/dashboard/dashboard.php?vrs='+envio;
       </script>";
    }
    if ($res==0 and $admin>0 and $prov==0)
    {
       echo "<script>location.href = '../dashboard/dashboard.php';</script>";
    }
    if ($res==0 and $admin==0 and $prov>0)
    {
       echo "<script>location.href = '../index.php?logout=1';</script>";
    }








?>