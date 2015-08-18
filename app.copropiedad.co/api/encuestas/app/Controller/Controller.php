<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");

//SOLICITAR TOKEN - OK - OK
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

//SOLICITAR TOKEN  PARA ENVIO DE ENCUESTAS- OK - OK

$app->options("/tokenEncuesta/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/tokenEncuesta/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
	    $datos = json_decode($requerimiento->getBody());
	    $obj = array('id_encuesta'=>$datos->body->id_encuesta,'fechaFin'=>$datos->body->fechaFin);
		$token = new Token;
		$tokenEntregado = $token->GetTokenEncuestas($obj);
		//echo $tokenEntregado." <br>";		
		$tokenEntregado=base64_encode($tokenEntregado);
		//echo "Toque encriptado para envio ".$tokenEntregado;
		//exit;
		enviarRespuesta($app, true, array("token"=>$tokenEntregado), "null");
	}
	catch(Exception $e)
	{
		enviarRespuesta($app, false, "Error Creando el Token", $e->getMessage());
	}
});

//DESCOMPRIMIR EL TOKEN

$app->options("/ValidarTokenEncuesta/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});


$app->post("/ValidarTokenEncuesta/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetTokenEncuestas($datos->token);
		// echo "Este es el toque validado";
		// echo "<pre>";
		// var_dump($tokenValidado);
		enviarRespuesta($app, true, $tokenValidado, "null");
		
		
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

//CAMBIAR ESTADO DE LA CABECERA DE LA ENCUESTA E 2. CREADA ENVIADA
$app->options("/creadaenviada/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->put("/creadaenviada/", function() use($app)
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
				$dbdata = new DBNosql('encuestaCabecera');
				$muestreo = array("_id"=>new MongoId($datos->body->id_encuesta));
				$modificador = array('$set'=>array("estado"=>"2"));
				$result=$dbdata->updateDocument($muestreo, $modificador);
				if ($result){enviarRespuesta($app, true, $result, "null");}
				else {enviarRespuesta($app, true, null, null);}
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





//BORRAR PREGUNTAS - OK

$app->options("/encuesta/borrarEnvio/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});


$app->delete("/encuesta/borrarEnvio/", function() use($app)
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
				$idGuardado=$datos->body->id_encuesta;
				unset($datos->body->id_pregunta);

				$muestreo=array("_id"=>new MongoId($idGuardado));

				
				$dbdata=new DBNosql('encuestaEnvio');
				$array = json_decode(json_encode($datos), true);
				$result=$dbdata->removeDocument(array('id_encuesta' => $idGuardado), array("justOne" => true));
				
				if ($result){enviarRespuesta($app, true, $result, "null");}
				else {enviarRespuesta($app, true, null, null);}
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





//CREAR ENVIO ENCUESTA - OK - OK

$app->options("/encuestaEnvio/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});


$app->post("/encuestaEnvio/", function() use($app)
{
	// try
	// {
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				$enviada=consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
				if($enviada==NULL)
				{
					if($datos->body->invitados!="manual")
					{
						$generalInvitados=invitados($app,$datos->body->invitados,$datos->body->id_copropiedad);
						if($datos->body->invitados_externos!="")
						{
							$externos = explode(",",$datos->body->invitados_externos);
							foreach ($externos as $value) {
								$generalInvitados[$value] = $value;
							}
						}
						$cuentaContactos=count($generalInvitados);
						$grabar = array("id_copropiedad"=>$datos->body->id_copropiedad,"id_encuesta"=>$datos->body->id_encuesta,"invitados"=>$datos->body->invitados,"invitados_externos"=>$datos->body->invitados_externos,"tokenencuesta"=>$datos->body->tokenencuesta,"asunto"=>$datos->body->asunto,"mensaje"=>$datos->body->mensaje,"urlencuesta"=>$datos->body->urlencuesta,"correostotales"=>implode(",", $generalInvitados));
						enviarInformacion('encuestaEnvio', $grabar, $app);
						$enviador=array("correostotales"=>implode(",", $generalInvitados),"enviadototal"=>$cuentaContactos);						
						enviarRespuesta($app, true, $enviador, "null");					
					}
					else
					{
						if($datos->body->invitados_externos!="")
						{
							$externos = explode(",",$datos->body->invitados_externos);
							foreach ($externos as $value) {
								$generalInvitados[$value] = $value;
							}
						}
						$cuentaContactos=count($generalInvitados);
						$grabar = array("id_copropiedad"=>$datos->body->id_copropiedad,"id_encuesta"=>$datos->body->id_encuesta,"invitados"=>$datos->body->invitados,"invitados_externos"=>$datos->body->invitados_externos,"tokenencuesta"=>$datos->body->tokenencuesta,"asunto"=>$datos->body->asunto,"mensaje"=>$datos->body->mensaje,"urlencuesta"=>$datos->body->urlencuesta,"correostotales"=>implode(",", $generalInvitados));
						enviarInformacion('encuestaEnvio', $grabar, $app);
						$enviador=array("correostotales"=>implode(",", $generalInvitados),"enviadototal"=>$cuentaContactos);
						enviarRespuesta($app, true, $enviador, "null");
					}
				}
				else
				{
					if($datos->body->invitados!="manual")
					{
						$correosActuales=explode(",", $enviada[0]["correostotales"]);
						$nuevoArreglo=array();
						//traer los datos muevos enviados
						$generalInvitados=invitados($app,$datos->body->invitados,$datos->body->id_copropiedad);
						if($datos->body->invitados_externos!="")
						{
							$externos = explode(",",$datos->body->invitados_externos);
							foreach ($externos as $value) {
								$generalInvitados[$value] = $value;
							}
						}
						foreach ($generalInvitados as $value)
						{
							if(!in_array($value, $correosActuales))
							{
								array_push($nuevoArreglo, $value);
								array_push($correosActuales, $value);
							}
						}
						//eliminar el antiguo envio a la base de datos
						$dbdata=new DBNosql('encuestaEnvio');
						$result=$dbdata->removeDocument(array("id_encuesta"=>$datos->body->id_encuesta));
						$grabar = array("id_copropiedad"=>$datos->body->id_copropiedad,"id_encuesta"=>$datos->body->id_encuesta,"invitados"=>$datos->body->invitados,"invitados_externos"=>$datos->body->invitados_externos,"tokenencuesta"=>$datos->body->tokenencuesta,"asunto"=>$datos->body->asunto,"mensaje"=>$datos->body->mensaje,"urlencuesta"=>$datos->body->urlencuesta,"correostotales"=>implode(",", $correosActuales));
						$cuentaContactos=count($nuevoArreglo);
						enviarInformacionFinal('encuestaEnvio', $grabar, $app);
						$enviador=array("correostotales"=>implode(",", $nuevoArreglo),"enviadototal"=>$cuentaContactos);
						enviarRespuesta($app, true, $enviador, "null");
					}
					else
					{
						$correosActuales=explode(",", $enviada[0]["correostotales"]);
						$nuevoArreglo=array();
						if($datos->body->invitados_externos!="")
						{
							$externos = explode(",",$datos->body->invitados_externos);
							foreach ($externos as $value) {
								$generalInvitados[$value] = $value;
							}
						}
						foreach ($generalInvitados as $value)
						{
							if(!in_array($value, $correosActuales))
							{
								array_push($nuevoArreglo, $value);
								array_push($correosActuales, $value);
							}
						}
						//eliminar el antiguo envio a la base de datos
						$dbdata=new DBNosql('encuestaEnvio');
						$result=$dbdata->removeDocument(array("id_encuesta"=>$datos->body->id_encuesta));
						$grabar = array("id_copropiedad"=>$datos->body->id_copropiedad,"id_encuesta"=>$datos->body->id_encuesta,"invitados"=>$datos->body->invitados,"invitados_externos"=>$datos->body->invitados_externos,"tokenencuesta"=>$datos->body->tokenencuesta,"asunto"=>$datos->body->asunto,"mensaje"=>$datos->body->mensaje,"urlencuesta"=>$datos->body->urlencuesta,"correostotales"=>implode(",", $correosActuales));
						$cuentaContactos=count($nuevoArreglo);
						enviarInformacionFinal('encuestaEnvio', $grabar, $app);
						$enviador=array("correostotales"=>implode(",", $nuevoArreglo),"enviadototal"=>$cuentaContactos);
						enviarRespuesta($app, true, $enviador, "null");
					}
				}
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	// }
	// catch(Exception $e)
	// {
	// 	//echo "Error: " . $e->getMessage();
	// 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	// }
});




//Verificar si existe Envio

$app->options("/encuestaEnvio/listar/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuestaEnvio/listar/", function() use($app)
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
				consultaColeccion($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
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



//CREAR ENCUESTA - OK - OK

$app->options("/encuesta/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/", function() use($app)
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
				enviarInformacion('encuestaCabecera', $datos->body, $app);
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


//MODIFICAR ENCUESTA - OK - OK
$app->put("/encuesta/", function() use($app)
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
				//enviarInformacion('encuestaCabecera', $datos->body, $app);
				$idGuardado=$datos->body->id;
				unset($datos->body->id);
				$muestreo=array("_id"=>new MongoId($idGuardado));
				$dbdata=new DBNosql('encuestaCabecera');
				$array = json_decode(json_encode($datos), true);						
				$result=$dbdata->updateDocument($muestreo, $datos->body);
				if ($result){enviarRespuesta($app, true, $result, "null");}
				else {enviarRespuesta($app, true, null, null);}
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



//AGREGAR PREGUNTAS - OK - OK

$app->options("/encuesta/pregunta/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});


$app->post("/encuesta/pregunta/", function() use($app)
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
				enviarInformacion('encuestaPreguntas', $datos->body, $app);
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

//LISTAR PREGUNTAS POR ENCUESTA- OK - OK

$app->options("/encuesta/pregunta/listar/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/pregunta/listar/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		//if($tokenValidado)
		if(true)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				consultaColeccion($app, 'encuestaPreguntas', array('id_encuesta' => $datos->body->id_encuesta));
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


//LISTAR PREGUNTAS POR ID_PREGUNTA- OK - OK

$app->options("/encuesta/pregunta/filtro/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});


$app->post("/encuesta/pregunta/filtro/", function() use($app)
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
				consultaColeccion($app, 'encuestaPreguntas', array('_id'=> new MongoId($datos->body->_id)));
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


//LISTAR ENCUESTAS ACTIVAS POR ID ENCUESTA- OK - OK

$app->options("/encuesta/copropiedad/filtro/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/copropiedad/filtro/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		//echo $token->SetToken($datos->token);
		if($tokenValidado)
		//if(true)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				consultaColeccion($app, 'encuestaCabecera',array('_id'=> new MongoId($datos->body->_id)));
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

//LISTAR ENCUESTAS ACTIVAS POR COPROPIEDAD- OK - OK

$app->options("/encuesta/copropiedad/activas/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/copropiedad/activas/", function() use($app)
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
				consultaColeccion($app, 'encuestaCabecera', array('id_copropiedad' => $datos->body->id_copropiedad, 'estado'=>array('$ne' => '3'), 'tipo'=>'encuesta'));
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

//LISTAR ENCUESTAS POR COPROPIEDAD- OK - OK

$app->options("/encuesta/copropiedad/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/copropiedad/", function() use($app)
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
				consultaColeccion($app, 'encuestaCabecera', array('id_copropiedad' => $datos->body->id_copropiedad));
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

//MODIFICAR PREGUNTAS - OK
$app->put("/encuesta/pregunta/", function() use($app)
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
				$idGuardado=$datos->body->id;
				unset($datos->body->id);
				$muestreo=array("_id"=>new MongoId($idGuardado));
				$dbdata=new DBNosql('encuestaPreguntas');
				$array = json_decode(json_encode($datos), true);						
				$result=$dbdata->updateDocument($muestreo, $datos->body);
				if ($result){enviarRespuesta($app, true, $result, "null");}
				else {enviarRespuesta($app, true, null, null);}
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



//BORRAR PREGUNTAS - OK
$app->delete("/encuesta/pregunta/", function() use($app)
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
				$idGuardado=$datos->body->id_pregunta;
				unset($datos->body->id_pregunta);
				$muestreo=array("_id"=>new MongoId($idGuardado));
				$dbdata=new DBNosql('encuestaPreguntas');
				$array = json_decode(json_encode($datos), true);						
				$result=$dbdata->removeDocument($muestreo, $datos->body);
				if ($result){enviarRespuesta($app, true, $result, "null");}
				else {enviarRespuesta($app, true, null, null);}
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


//VALIDA ENCUESTA LLENA - OK - OK

$app->options("/encuesta/ValidarEncuesta/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/ValidarEncuesta/", function() use($app)
{
	 /*try
	 {*/
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		
		$validateUsuario=validateRole();
		if ($validateUsuario)
		{
		    consultaColeccion($app, 'encuestaVotos', array('id_encuesta'=>$datos->id_encuesta,'id_crm_persona' => $datos->id_crm_persona));
		}
		else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		
	 /*}
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }*/
});








//VER RESULTADOS DE ENCUESTA - OK - OK

$app->options("/encuesta/resultados/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/resultados/", function() use($app)
{
	 /*try
	 {*/
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		$tokenValidado = $token->SetToken($datos->token);		
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
			    $votos = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array('id_encuesta' => $datos->body->id_encuesta))));
			    $resultados = array();	
			    foreach ($votos as $doc) {
				    $respuesta = $doc->respuesta;
				    if(strlen($doc->respuesta) < 5)
				    {
				    	$rta = (String)$doc->enunciado . "-" . $doc->respuesta;
				    	if(array_key_exists($rta, $resultados))
				    	{
				    		$resultados[$rta] = (int)$resultados[$rta] + (int)1;
				    	}
				    	else
				    	{
				    		$resultados[$rta] = (int)1;
				    	}
				    }
				    else
				    {
				    	$rta = (String)$doc->enunciado . "-Z";
				    	if(array_key_exists($rta, $resultados))
				    	{
				    		$texto = (string)$resultados[$rta] . $doc->respuesta . "|";
				    		$resultados[$rta] = (string)$texto;
				    	}
				    	else
				    	{
				    		$texto = $doc->respuesta . "|";
				    		$resultados[$rta] = $texto;
				    	}
				    }
				}
				enviarRespuesta($app, true, $resultados, null);
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 /*}
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }*/
});

$app->options("/encuesta/resultadosTotales/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/resultadosTotales/", function() use($app)
{
	 /*try
	 {*/
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		$tokenValidado = $token->SetToken($datos->token);		
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
			    $votos = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array('id_encuesta' => $datos->body->id_encuesta))));
			    $resultados = array();
			    $personas = array();
			    if($votos)
			    {
			    	foreach ($votos as $doc) {
				    	$rta = (String)$doc->id_pregunta."|".(String)$doc->enunciado;
				    	if(!array_key_exists($rta, $resultados))
				    	{			    		
				    		if (!in_array((string)$rta.(string)$doc->id_crm_persona, $personas)) 
				    		{
				    			array_push($personas,$rta.(string)$doc->id_crm_persona);
				    			$resultados[$rta] = (int)1;
				    		}
				    	}
				    	else
				    	{
				    		if (!in_array((string)$rta.(string)$doc->id_crm_persona, $personas)) 
				    		{
				    			$resultados[$rta] = (int)$resultados[$rta] + (int)1;
				    			array_push($personas,(string)$rta.(string)$doc->id_crm_persona);
							}						
				    	}					
					}
					enviarRespuesta($app, true, $resultados, null);
				}
				else
				{
					enviarRespuesta($app, true, null, null);
				}			    
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 /*}
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }*/
});

$app->options("/encuesta/VotantesTotales/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/VotantesTotales/", function() use($app)
{
	 /*try
	 {*/
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		$tokenValidado = $token->SetToken($datos->token);		
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
			    $votos = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array('id_encuesta' => $datos->body->id_encuesta))));
			    if($votos)
			    {
			    	$electores = array();
			    	foreach ($votos as $doc) {
				    	//echo $doc->id_crm_persona;
				    	//echo "\n";
			    		if (!in_array($doc->id_crm_persona, $electores)) 
			    		{
			    			array_push($electores,$doc->id_crm_persona);
			    		}				
					}	
					enviarRespuesta($app, true, count($electores), null);
			    }
			    else
			    {
			    	enviarRespuesta($app, true, 0, null);
			    }
			    
				
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 /*}
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }*/
});


$app->options("/encuesta/VotantesFaltantes/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/VotantesFaltantes/", function() use($app)
{
	 /*try
	 {*/
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;		
		$tokenValidado = $token->SetToken($datos->token);		
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
			    $votos = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array('id_encuesta' => $datos->body->id_encuesta))));
			    if($votos)
			    {
			    	$electores = array();
			    	foreach ($votos as $doc) {
				    	//echo $doc->id_crm_persona;
				    	//echo "\n";
			    		if (!in_array($doc->id_crm_persona, $electores)) 
			    		{
			    			array_push($electores,$doc->id_crm_persona);
			    		}				
					}
					/////buscnado los votantes faltantes}
					$votantes = consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
					$votantes = objectToArray($votantes);
					$invitadosAvotar= explode(",", $votantes[0]["correostotales"]);
				 	$noenviados=array_diff($invitadosAvotar,$electores);
					enviarRespuesta($app, true, $noenviados, null);
			    }
			    else
			    {
			    	$votantes = consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
					$votantes = objectToArray($votantes);
					$invitadosAvotar= explode(",", $votantes[0]["correostotales"]);
			    	enviarRespuesta($app, true, $invitadosAvotar, null);
			    }
			    
				
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 /*}
	 catch(Exception $e)
	 {
	 	//echo "Error: " . $e->getMessage();
	 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	 }*/
});



$app->options("/encuesta/resultadosPorPregunta/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/resultadosPorPregunta/", function() use($app)
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
			    $votos = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array('id_pregunta' => $datos->body->id_pregunta))));
			    $resultados = array();			    
			    if ($votos!="")
			    {
			    	$enunciado = $votos[0]->enunciado;			    	
			    	$tipo = $votos[0]->tipo;
			    	$enviadores=array();
			    	$enviadores["enunciado"]=$enunciado;
				    $enviadores["tipo"]=$tipo;
					$parametros=array();				    				    
			    	//echo "A|opcionuno|45";
			    	if($tipo!="A")
			    	{
			    		foreach ($votos as $doc) 
				    	{
				    		$rta=$doc->renunciado;

				    		if(array_key_exists($rta, $parametros))
				    		{
				    			$parametros[$rta] = (int)$parametros[$rta] + (int)1;				    			
				    		}
				    		else
				    		{
				    			$parametros[$rta]=1;				    			
				    		}
				    	}				    	
				    	//cho "<pre>";
				    	//var_dump($enviadores);
				    	array_push($enviadores,$parametros);
				    	$prueba=array();
				    	array_push($prueba,$enviadores);
				    	enviarRespuesta($app, true, $prueba, null);
				    } 
				    else
				    {
				    	$texto="";
				    	foreach ($votos as $doc)
				    	{
				    		$texto .=$doc->respuesta."|";				    		
				    	}
				    	$texto = substr($texto, 0, -1);
				    	$enviadores["opiniones"] = $texto;
				    	//echo "<pre>";
				    	//var_dump($enviadores);
				    	$prueba=array();
				    	array_push($prueba,$enviadores);
				    	enviarRespuesta($app, true, $prueba, null);
				    }
			    }
			    else
			    {
			    	enviarRespuesta($app, true, null, null);
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

$app->options("/encuesta/pregunta/listarIdEncuestas/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});


$app->post("/encuesta/pregunta/listarIdEncuestas/", function() use($app)
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
				$encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaPreguntas', array('id_encuesta' => $datos->body->id_encuesta))));
				
				$enviadores=array();
			    if ($encuestas!="")
			    {
			    	$texto="";
			    	foreach ($encuestas as $doc)
			    	{
			    		$texto .=$doc->_id->{'$id'}."|";				    		
			    	}
			    	$texto = substr($texto, 0, -1);
			    	$enviadores["ids"] = $texto;			    	
			    	enviarRespuesta($app, true, $enviadores, null);
			    }
			    else
			    {
			    	enviarRespuesta($app, true, null, null);
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

//CERRAR ENCUESTA ANTES DE TIEMPO - OK - OK

$app->options("/encuesta/cerrar/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->put("/encuesta/cerrar/", function() use($app)
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
				$idGuardado=$datos->body->id_encuesta;
				unset($datos->body->id_encuesta);
				$muestreo=array("_id"=>new MongoId($idGuardado));
				$dbdata=new DBNosql('encuestaCabecera');
				$array = json_decode(json_encode($datos), true);						
				$result=$dbdata->updateDocument($muestreo, $datos->body);
				if ($result){enviarRespuesta($app, true, $result, "null");}
				else {enviarRespuesta($app, true, null, null);}
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

//VOTAR EN ENCUESTA - OK - OK

$app->options("/encuesta/votar/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/encuesta/votar/", function() use($app)
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
				enviarInformacion('encuestaVotos', $datos->body, $app);
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



function consultaColeccion($app, $coleccion, $arreglo)
{
	$dbdata = new DBNosql($coleccion);	
	$resultado = $dbdata->selectDocument($arreglo);	
	if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
	else {enviarRespuesta($app, true, null, null);}
}

function consultaColeccionRetorno($app, $coleccion, $arreglo)
{
	$dbdata = new DBNosql($coleccion);	
	$resultado = $dbdata->selectDocument($arreglo);	
	return $resultado;
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

function enviarInformacionFinal($lista,$data,$app)
{
	$dbdata=new DBNosql($lista);
	$arreglo = json_decode(json_encode($data), true);
	$resultado=$dbdata->insertDocument($arreglo);
	$validador=get_object_vars($resultado);
	$validador=implode(",", $validador);
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
function invitados($app, $grupoLlegada,$copropiedad)
{
	$grupos = array();
	if($grupoLlegada == "consejo")
	{
		$grupos = array();
		$grupos[] = "consejo";
	}

	if($grupoLlegada == "asamblea")
	{
		$grupos = array();
		$grupos[] = "consejo";
		$grupos[] = "asamblea";
	}

	if($grupoLlegada == "residente")
	{
		$grupos = array();
		$grupos[] = "consejo";
		$grupos[] = "asamblea";
		$grupos[] = "residente";
	}

 	$respuesta = objectToArray(consultaColeccionRespuesta($app, 'usuariocp', array('grupo' => array('$in' => $grupos), 'id_copropiedad' => $copropiedad)));
 	$out = array();
 	if($respuesta)
 	{
 		foreach ($respuesta as $key => $value) 
	 	{
	 		if(!array_key_exists($value['email'], $out))
	 			$out[$value['email']] = $value['email']; 
	 	}	
 	}
 	
 	return $out;
}

function consultaColeccionRespuesta($app, $coleccion, $arreglo)
{
	//var_dump($arreglo);
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
      // Return array
      return $d;
  }
}