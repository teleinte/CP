<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<?php

    $data = array("token" =>base64_decode($_GET['stk']), "body" => array("id_encuesta" => $_GET['ide']));
    $data_string = json_encode($data);
    $ch = curl_init('http://aws02.sinfo.co/api/encuestas/encuesta/pregunta/listar/');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );
    
    $datosEnviados=curl_exec($ch);
    //echo $datosEnviados; 
    $result = json_decode($datosEnviados,true);
    //echo "<pre>";
    //var_dump($result);    
    $contador=0;
    foreach ($result['message'] as $value)
    {
        //echo "<BR>".$value["tipo"];
        switch ($value["tipo"]) 
        {
            case 'seleccion_multiple_multiple_respuesta':
                
                echo '
                    <h3>';
                    if ($value["obligatorio"]=="SI")
                    {
                        echo $value["pregunta"].' (Esta pregunta es obligaoria debe elegir almenos una opción)';
                        $valor="multiple|SI|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$value["pregunta"];
                    }
                    else {
                        echo $value["pregunta"];
                        $valor="multiple|NO|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$value["pregunta"];

                    }                    
                    echo'</h3>';
                    
                    $sinComasUno = substr($value["opciones"], 0, -1);
                    $sinComas = explode(",",$sinComasUno);
                    echo '<input type="hidden" name="multiple[]" value="'.$valor.'" />';
                    echo '<p class="respuesta">';
                    foreach ($sinComas as $valor)
                    {
                        $sinPalo=  explode("|", $valor);
                        //echo "<br> este es el definitivo ".." ".$sinPalo[1];
                        
                        echo $sinPalo[1].'<input type="checkbox" name="multiple[]" value="'.$sinPalo[0]."|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$sinPalo[1].'"/>';
                        echo "<br>";
                    }
                    echo '</p>';
                   $contador++;
                break;
            case 'seleccion_multiple_unica_respuesta':
                
                echo '
                    <h3>';
                    if ($value["obligatorio"]=="SI")
                    {
                        echo $value["pregunta"].' (Esta pregunta es obligaoria debe elegir almenos una opción)';
                        $valor="unitario|SI|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$value["pregunta"];
                    }
                    else {
                        echo $value["pregunta"];
                        $valor="unitario|NO|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$value["pregunta"];

                    }                    
                    echo'</h3>';
                    
                    $sinComasUno = substr($value["opciones"], 0, -1);
                    $sinComas = explode(",",$sinComasUno);
                    echo '<input type="hidden" name="unitario[]" value="'.$valor.'" />';
                    echo '<p class="respuesta">';
                    foreach ($sinComas as $valor)
                    {
                        $sinPalo=  explode("|", $valor);
                        //echo "<br> este es el definitivo ".." ".$sinPalo[1];
                        
                        echo $sinPalo[1].'<input type="radio" name="unitario[]'.$result['message'][$contador]["_id"]['$id'].'" value="'.$sinPalo[0]."|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$sinPalo[1].'"/>';
                        echo "<br>";
                    }
                    echo '</p>';
                    $contador++;
                break;
            case 'abierta':
                
                
                echo '
                    <h3>';
                    if ($value["obligatorio"]=="SI")
                        {
                        echo $value["pregunta"].' (Esta pregunta es obligaoria debe elegir almenos una opción)';
                        $valor="abierta|SI|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$value["pregunta"];
                        }
                    else {
                        echo $value["pregunta"];
                        $valor="abierta|NO|".$result['message'][$contador]["_id"]['$id']."|".$value["id_encuesta"]."|".$value["pregunta"];

                    }                    
                    echo'</h3>';
                    echo '<p class="respuesta">';
                    echo '<input type="hidden" name="abierta[]" value="'.$valor.'" /><textarea name="abierta[]"></textarea></td>';
                    echo '<input type="hidden" id="usuario" value="35345345" />';
                    echo '<input type="hidden" id="token" value="23452345" />';
                    echo '</p>';
                
                    $contador++;
                break;
        }
    }