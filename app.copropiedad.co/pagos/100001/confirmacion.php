<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$tst = file_get_contents("log.txt");
file_put_contents("log.txt", $tst . "NUEVO: \n" . json_encode($_POST) . "-----------\n\n");
$res = json_encode($_POST);
$tst = file_get_contents("log.txt");
file_put_contents("log.txt", $tst . json_decode($res) . "_____________________________\n\n");
//OBTENER E INTERPRETAR RESPUESTA PayU
foreach ($_POST as $key => $value) 
	$response = json_decode($key,true);

$tst = file_get_contents("log.txt");
file_put_contents("log.txt", $tst . json_encode($response) . "\n\n");

$tst = file_get_contents("log.txt");
file_put_contents("log.txt", $tst . "FIN: -----------\n\n");
//SOLICITAR Y OBTENER TOKEN
$obtenertoken = json_encode(array('body' =>array('autkey' => 'si','user' => 'yo')));
$handler = curl_init('https://app.copropiedad.co/api/tareas/token');
curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($handler, CURLOPT_POSTFIELDS, $obtenertoken);
curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handler, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($obtenertoken)));
$requerirtoken=curl_exec($handler);
$token1 = json_decode($requerirtoken,true);
$resultoken = $token1['message']['token'];
//var_dump($contenido);

//ENVIAR A WS INFORMACION INTERPRETADA DE PayU
date_default_timezone_set('America/Bogota');
$hoy = date("c");
//var_dump($hoy);
$arr = array('token' => $resultoken, 'body' => array('referenceCode' => $response["referenceCode"], 'respuesta' => json_encode($response), 'fecha_transaccion' => $hoy , 'estado' => $response["pol_response_code"]));
$data_string = json_encode($arr);
var_dump($arr);
$ch = curl_init('https://app.copropiedad.co/api/payu/actualizarinfo');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($data_string)));
$datosEnviados=curl_exec($ch);
$result = json_decode($datosEnviados,true);
$resulta = ($result['status'].','.$result['message'].','.$result['error']);
//var_dump($resulta);

function objectToArray($data)
    {
	if(is_array($data) || is_object($data))
	{
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = $this->objectToArray($value);
            }
            return $result;
	}
	return $data;
    }
?>