<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");

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

$app->options("/list/", function() use($app)
{
enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/list/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				switch ($datos->body->tipo)
				{
					case 'tarea':
						enviarInformacion('tarea', $datos->body, $app);
						break;	
					case 'cartelera':
						$datos->body->vigencia = date('c',strtotime($datos->body->vigencia));
						enviarInformacion('cartelera', $datos->body, $app);
						break;	
					case 'venta':
						$datos->body->vigencia = date('c',strtotime($datos->body->vigencia));
						enviarInformacion('cartelera', $datos->body, $app);
						break;					
					default:					
						enviarRespuesta($app, false, "Lista Inexistente", "Lista Inexistente");
						break;
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->options("/getlist/", function() use($app)
{
enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/getlist/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				switch ($datos->body->tipo)
				{
					case 'tarea':		
						$ninarray = array("Cerrada", "Completada");															
					    consultaColeccion($app, "tarea", array('id_copropiedad'=>$datos->body->id_copropiedad,'estado'=> array('$nin'=> $ninarray), 'tipo'=>"tarea"));
						break;	
					case 'cartelera':
						date_default_timezone_set('America/Bogota');	
						$today = date('c');														
					    consultaColeccion($app, "cartelera", array('id_copropiedad'=>$datos->body->id_copropiedad,"vigencia" => array('$gte' => $today)));
						break;	
					default:					
						enviarRespuesta($app, false, "Lista Inexistente", "Lista Inexistente");
						break;
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->options("/getlistFilter/", function() use($app)
{
enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/getlistFilter/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				switch ($datos->body->tipo)
				{
					case 'tarea':
					    consultaColeccionFiltro($app, "tarea", array('_id'=> new MongoId($datos->body->_id)));
						break;					
					default:					
						enviarRespuesta($app, false, "Lista Inexistente", "Lista Inexistente");
						break;
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->put("/list/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());		
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				switch ($datos->body->tipo)
				{
					case 'tarea':
						$idGuardado=$datos->body->id;
						unset($datos->body->id);
						$muestreo=array("_id"=>new MongoId($idGuardado));
						$dbdata=new DBNosql('tarea');
						$array = json_decode(json_encode($datos), true);						
						$result=$dbdata->updateDocument($muestreo, $datos->body);
						if ($result){enviarRespuesta($app, true, $result, "null");}
						else {enviarRespuesta($app, true, null, null);}
						break;
					default:					
						enviarRespuesta($app, false, "Lista Inexistente", "Lista Inexistente");
						break;
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 }
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }
});

$app->delete("/list/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				switch ($datos->body->item_type)
				{
					case 'tarea':
						$idGuardado=$datos->body->id;
						unset($datos->body->id);
						$muestreo=array("_id"=>new MongoId($idGuardado));
						$dbdata=new DBNosql('tarea');
						$array = json_decode(json_encode($datos), true);						
						$result=$dbdata->updateDocument($muestreo, $datos->body);
						if ($result){enviarRespuesta($app, true, $result, "null");}
						else {enviarRespuesta($app, true, null, null);}
						break;					
					default:					
						enviarRespuesta($app, false, "Lista Inexistente", "Lista Inexistente");
						break;
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 }
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }
});

$app->options("/list/cartelera/", function() use($app)
{
enviarRespuesta($app, true, "ok", "ok");
});

$app->delete("/list/cartelera/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				switch ($datos->body->tipo)
				{
					case 'cartelera':
				        $idGuardado=$datos->body->id;
				        $aidi = $idGuardado;
				        unset($datos->body->id);
				        $muestreo=array("_id"=>new MongoId($idGuardado));
				        $dbdata=new DBNosql('cartelera');
				        $array = json_decode(json_encode($datos), true);            
				        $result=$dbdata->removeDocument($muestreo, true);
				        if ($result){enviarRespuesta($app, true, ":)" . $result, $result);}
				        else {enviarRespuesta($app, true, null,"no result");}
						break;		
					case 'venta':
				        $idGuardado=$datos->body->id;
				        $aidi = $idGuardado;
				        unset($datos->body->id);
				        $muestreo=array("_id"=>new MongoId($idGuardado));
				        $dbdata=new DBNosql('cartelera');
				        $array = json_decode(json_encode($datos), true);            
				        $result=$dbdata->removeDocument($muestreo, true);
				        if ($result){enviarRespuesta($app, true, $result, "null");}
				        else {enviarRespuesta($app, true, null, null);}
						break;						
					default:					
						enviarRespuesta($app, false, "Lista Inexistente :|", "Lista Inexistente");
						break;
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 }
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }
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
	$envio=array('status'=>$estado,'message'=>$mensaje,'error'=>$error);

	$recurso->response->headers->set("Content-type", "application/json");
	$recurso->response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
	$recurso->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
	$recurso->response->status(200);
	$recurso->response->body(json_encode($envio));
}