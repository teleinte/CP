<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");


$app->post("/login/", function() use($app)
{
	// try
	// {
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$usr = array("yiyi65526@hotmail.com","jgilvillamarin@gmail.com");
		//var_dump($usr);
		// var_dump($datos->body->Usuario);
		if(in_array($datos->body->Usuario,$usr) AND $datos->body->Password == "1236789")
		{
			enviarRespuesta($app, false, "Ok", "Ok");
		}
		else
		{
			enviarRespuesta($app, false, "error", "error");
		}

				
	// }
	// catch(Exception $e)
	// {
	// 	//echo "Error: " . $e->getMessage();
	// 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	// }
});


$app->post("/mensaje/", function() use($app)
{
	// try
	// {
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		if($datos->body->idioma == "lorem")
		{
			//echo "este es el lorem";
			$mensajeDeRegreso="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
			enviarRespuesta($app, false, $mensajeDeRegreso, $mensajeDeRegreso);
		}
		if($datos->body->idioma == "fran")
		{
			//echo "este es el fran";
			$mensajeDeRegreso="Qu’est-ce donc que cette joie du premier soleil ? Pourquoi cette lumière tombée sur la terre nous emplit-elle ainsi du bonheur de vivre ? Le ciel est tout bleu, la campagne toute verte, les maisons toutes blanches ; et nos yeux ravis boivent ces couleurs vives dont ils font de l’allégresse pour nos âmes. Et il nous vient des envies de danser, des envies de courir, des envies de chanter, une légèreté heureuse de la pensée, une sorte de tendresse élargie, on voudrait embrasser le soleil";
			enviarRespuesta($app, false, $mensajeDeRegreso, $mensajeDeRegreso);
			//enviarRespuesta($app, false, "Ok", "Ok");
		}
		if($datos->body->idioma == "espa")
		{
			//echo "este es el español";
			$mensajeDeRegreso="EMERGE tu recuerdo de la noche en que estoy. 
El río anuda al mar su lamento obstinado.
Abandonado como los muelles en el alba. 
Es la hora de partir, oh abandonado!
Sobre mi corazón llueven frías corolas. 
Oh sentina de escombros, feroz cueva de náufragos!
En ti se acumularon las guerras y los vuelos. 
De ti alzaron las alas los pájaros del canto.
Todo te lo tragaste, como la lejanía.
Como el mar, como el tiempo. Todo en ti fue naufragio!";
			enviarRespuesta($app, false, $mensajeDeRegreso, $mensajeDeRegreso);
		}
				
	// }
	// catch(Exception $e)
	// {
	// 	//echo "Error: " . $e->getMessage();
	// 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	// }
});



$app->options("/login/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

function consultaColeccionFiltro($app, $coleccion, $arreglo)
{
	//var_dump($arreglo);
	$dbdata = new DBNosql($coleccion);	
	$resultado = $dbdata->selectDocument($arreglo);		
	if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
	else {enviarRespuesta($app, true, null, null);}
}


function consultaColeccion($app, $coleccion, $arreglo)
{
	//var_dump($arreglo);
	$dbdata = new DBNosql($coleccion);	
	$resultado = $dbdata->selectDocument($arreglo);		
	if ($resultado){enviarRespuesta($app, true, $resultado, $arreglo);}
	else {enviarRespuesta($app, true, null, null);}
}

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

function validateRole()
{
	return true;
}

function enviarRespuesta($recurso, $estado, $mensaje, $error)
{	
	$envio=array('Mensaje'=>$mensaje);

	$recurso->response->headers->set("Content-type", "application/json");
	$recurso->response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
	$recurso->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	$recurso->response->status(200);
	$recurso->response->body(json_encode($envio));
}