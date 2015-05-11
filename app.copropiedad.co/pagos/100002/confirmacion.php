<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//OBTENER E INTERPRETAR RESPUESTA PayU
$contenido=implode(",", $_POST);
$contenidoArray= explode(',', $contenido);
echo '<pre>';
//var_dump($contenido);
//var_dump($contenidoArray);
if ($contenidoArray[0] == 20) {
	$estadoRx = "Transacción expirada";
}
else if ($contenidoArray[0] == 1) {
	$estadoRx = "Transacción aprobada";
}
else {
	$estadoRx="Transacción declinada";
}

if($estadoRx=="Transacción declinada"){
	$referenceCode=$contenidoArray[54];
}
else if($estadoRx=="Transacción aprobada"){
	$referenceCode=$contenidoArray[58];
}
else {
	$referenceCode=$contenidoArray[58];
}

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
$resultoke = $token1['message']['token'];
//var_dump($resultoke);

//ENVIAR A WS INFORMACION INTERPRETADA DE PayU
date_default_timezone_set('America/Bogota');
$hoy = date("c");
$arr = array('token' => $resultoke, 'body' => array('referenceCode' => $referenceCode,'respuesta' => $contenido, 'fecha_transaccion' => $hoy , 'estado' => $estadoRx));
$data_string = json_encode($arr);
//var_dump($arr);
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

?>

   


