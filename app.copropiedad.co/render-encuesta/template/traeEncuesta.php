<?php //error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<?php
    $decodificador=base64_decode($_GET['stk']);
    $data = array("token" =>$decodificador, "body" => array("_id" => $_GET['ide']));
    $data_string = json_encode($data);
    
    $ch = curl_init('https://appdes.copropiedad.co/api/encuestas/encuesta/copropiedad/filtro/');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );
    
    $datosEnviados=curl_exec($ch);

    //var_dump($datosEnviados);
    $result = json_decode($datosEnviados,true);    
    if($result['status'])
    {
      $nombreEncuesta= $result['message'][0]['nombre'];
      $descEncuesta=$result['message'][0]['descripcion'];
      $estadoEncuesta=$result['message'][0]['estado'];
      $idCrmPersona=$result['message'][0]['id_crm_persona'];
    }    
    echo '<table>                     
            <tr>
                <td><h2><strong>'.$nombreEncuesta.'</strong></h2></td>
            </tr>
            <tr>                
                <td><h3>'.$descEncuesta.'</h3></td>
            </tr>
          </table>';    