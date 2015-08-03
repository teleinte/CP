<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");

/******************************************************************
**            			WEB SERVICE USERFLOW              		 **
**                   2014 - TELEINTE S.A.S.                      **
**                  AUTOR: GERMAN VELASQUEZ		                 **
/*****************************************************************/

//METODO OPTION PARA VALIDACION DE NAVEGADORES
$app->options("/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

// METODO PARA VALIDACION DE TOKEN DE ACTIVACION
// token de activacion
$app->post("/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		enviarRespuesta($app,true,checkTokenRegistro($app, urldecode($datos->body->token), $datos->body->email),null);
	}
	catch(Exception $e)
	{
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

// METODO PARA REGISTRO DE INICIO DE SESION
// token de activacion
$app->put("/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		enviarInformacion('iniciosesion', $datos, $app);
	}
	catch(Exception $e)
	{
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

//METODO OPTION PARA VALIDACION DE NAVEGADORES
$app->options("/estados/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

// METODO PARA VALIDACION DE TOKEN DE ACTIVACION
// token de activacion
$app->post("/estados/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		enviarRespuesta($app,true,$datos->body,null);
	}
	catch(Exception $e)
	{
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

//********** FUNCIONES AUXILIARES **************
	function enviarInformacion($lista,$data,$app)
	{
		$dbdata=new DBNosql($lista);
		$arreglo = json_decode(json_encode($data), true);
		$resultado=$dbdata->insertDocument($arreglo);
		$validador=get_object_vars($resultado);
		$validador=implode(",", $validador);
		if ($validador) {enviarRespuesta($app, true, $resultado, "null"); }
		else {enviarRespuesta($app, false, "Error procesando los datos", "no pudo escribir en base de datos");}
	}

	function enviarInformacionDB($lista,$data,$app)
	{
		$dbdata=new DBNosql($lista);
		$arreglo = json_decode(json_encode($data), true);
		$resultado=$dbdata->insertDocument($arreglo);
		$validador=get_object_vars($resultado);
		$validador=implode(",", $validador);
		if ($validador) {return true;}
		else {enviarRespuesta($app, false, "Error procesando los datos", "no pudo escribir en base de datos");}
	}

	function enviarRespuesta($recurso, $estado, $mensaje, $error)
	{	
		$envio=array('status'=>$estado,'message'=>$mensaje,'error'=>$error);

		$recurso->response->headers->set("Content-type", "application/json");
		$recurso->response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
		$recurso->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
		$recurso->response->status(200);
		$recurso->response->body(json_encode($envio));
	}

	function consultaColeccionRespuesta($app, $coleccion, $arreglo)
	{
	  $dbdata = new DBNosql($coleccion);  
	  $resultado = $dbdata->selectDocument($arreglo); 
	  if ($resultado){return $resultado;}
	  else {enviarRespuesta($app, true, null, null);}
	}

	function checkTokenRegistro($app, $token, $email)
	{
		date_default_timezone_set('America/Bogota');
		$d = date("c");
		$tokenactual = consultaColeccionRespuesta($app, 'tokenactivacion', array('token' => $token));
		enviarInformacion('tokenactivacion',array("token" => $token, "date" => $d, "user"=>$email), $app);

		if($tokenactual == null)
			return "1";
		else
			return "2";
	}