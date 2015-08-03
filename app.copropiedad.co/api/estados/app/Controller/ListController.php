<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");

//----------------TOKEN----------------
	$app->options("/token/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/token/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
		    $datos = json_decode($requerimiento->getBody());
		    $obj = array('autkey'=>$datos->body->autkey,'user'=>$datos->body->user);
			$token = new Token;
			$tokenEntregado = $token->GetToken($obj);
			enviarRespuesta($app, true, array("token"=>$tokenEntregado), "null");
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Creando el Token", $e->getMessage());
		}
	});

	$app->put("/token/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
		    $datos = json_decode($requerimiento->getBody());
		    $obj = array('autkey'=>$datos->body->autkey,'user'=>$datos->body->user);
			$token = new Token;
			$tokenEntregado = $token->GetTokenCustom($obj,$datos->body->tiempo);
			enviarRespuesta($app, true, array("token"=>$tokenEntregado), "null");
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Creando el Token", $e->getMessage());
		}
	});

//----------------ESTADOS DE USUARIO------------
	//METODO OPTION PARA VALIDACION DE NAVEGADORES
	$app->options('/estados/', function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});

	// METODO PARA CREACION DE USUARIOS
	$app->post('/estados/', function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				enviarInformacion('estadocp',$datos->body,$app);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

	// METODO PARA ACTUALIZACION DE ESTADOS DE USUARIOS
	$app->put('/estados/', function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$dbdata= new DBNosql('estadocp');
				$muestreo = array("id_crm_persona" => $datos->body->id_crm_persona, "email" => $datos->body->email);
				$modificador = array('$set'=>array("estado"=>(int)$datos->body->estado));
				$result=$dbdata->updateDocument($muestreo,$modificador);
				$muestreo = array("email" => $datos->body->email, "id_crm_persona" => array('$ne' => $datos->body->id_crm_persona));
				$modificador = array('$set'=>array("email"=>"UNL-" . $datos->body->email));
				$result=$dbdata->updateDocument($muestreo,$modificador);
				if ($result){enviarRespuesta($app, true, $result, 'null');}
				else {enviarRespuesta($app, true, null,"no result");}
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

	//METODO OPTION PARA VALIDACION DE NAVEGADORES
	$app->options('/obtener/', function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});

	// METODO PARA VALIDACION DE TOKEN DE ACTIVACION
	$app->post('/obtener/', function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$muestreo = array("email" => $datos->body->email);
				$estado = objectToArray(consultaColeccionRespuesta($app, 'estadocp', $muestreo))[0]['estado'];
				enviarRespuesta($app,true,$estado,null);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

	// METODO PARA VALIDACION DE TOKEN DE ACTIVACION
	$app->put('/obtener/', function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$muestreo = array("email" => $datos->body->email);
				$estado = objectToArray(consultaColeccionRespuesta($app, 'estadocp', $muestreo))[0]['id_crm_persona'];
				enviarRespuesta($app,true,$estado,null);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

//traer todos los datos de pregregistro
	$app->options("/preregistro/listar/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/preregistro/listar/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{	
				consultaColeccion($app, 'testpreregistro',array());		
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

	$app->options("/preregistro/mail/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});
	$app->post("/preregistro/mail/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$arr = array();
			$arr["user"] = $datos->user;
			$arr["browser"] = $datos->browser;
			$arr["timestamp"] = Date("c");
			enviarInformacion('preregistromail', $arr, $app);
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
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

	function objectToArray($d) 
	{
	  if (is_object($d)) 
	  {    
	      $d = get_object_vars($d);
	  }
	  if (is_array($d)) 
	  {    
	      return array_map(__FUNCTION__, $d);
	  }
	  else 
	  {
	      return $d;
	  }
	}
	function consultaColeccion($app, $coleccion, $arreglo)
	{
		$dbdata = new DBNosql($coleccion);	
		$resultado = $dbdata->selectDocument($arreglo);	
		if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
		else {enviarRespuesta($app, true, null, null);}
	}