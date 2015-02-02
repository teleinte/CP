<?php 
    error_reporting(E_ALL);ini_set('display_errors', 1); 
    $data = array("token" =>base64_decode($_GET['stk']));
    $data_string = json_encode($data);
    $ch = curl_init('http://aws02.sinfo.co/api/encuestas/ValidarTokenEncuesta/');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );    
    $datosEnviados=curl_exec($ch);    
    $result = json_decode($datosEnviados,true);  
    $resultado=explode("|",$result['message']);
    if($result['message']!=false)
    {
        error_reporting(E_ALL);ini_set('display_errors', 1); 
        $dataValida = array("id_encuesta"=>$resultado[0],"id_crm_persona" =>base64_decode($_GET['usr']));
        $data_string_valida = json_encode($dataValida);
        $chValida = curl_init('http://aws02.sinfo.co/api/encuestas/encuesta/ValidarEncuesta/');
        curl_setopt($chValida, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($chValida, CURLOPT_POSTFIELDS, $data_string_valida);
        curl_setopt($chValida, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chValida, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string_valida))
        );

        $datosEnviadosValida=curl_exec($chValida);    
        $resultValida = json_decode($datosEnviadosValida,true);
        
        if ($resultValida['message']==NULL)
        {            
            $envio="http://aws02.sinfo.co/v2/render-encuesta/encuesta.php?ide=".$resultado[0]."&stk=".$_GET['stk']."&usr=".$_GET['usr'];
            header('Location: '.$envio);            
        }
        else
        {
            echo "Usted ya respondio la encuesta muchas gracias por su interes";
        }
    }
    else
    {
        echo "la encuesta ya no esta activa";
    }
    

