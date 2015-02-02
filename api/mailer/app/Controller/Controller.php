<?php
require_once("/var/www/html/api/encuestas/app/Model/Token_Model.php");
require_once("/var/www/html/api/encuestas/app/Model/Log_Model.php");
require_once("/var/www/html/api/encuestas/app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");


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

$app->post("/mail/tareas/compartir/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			//$template = file_get_contents("/var/www/shared_resources/mail_templates/tareas_compartir.html");
			$template = "Hola @NAME@ el usuario @ADMINISTRATOR@ ha compartido una tarea contigo.";
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});



$app->post("/mail/encuestas/enviar/", function() use($app)
{
	 try
	 {
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			//echo "\n primero traer la informacion del envio tal como token y esas cosas";						
			//$encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta))))
			$encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta))));
			foreach ($encuestas as $value) {	

				$urlfinal = $myString = $value->urlencuesta."index.php?stk=".$value->tokenencuesta."&usr=";
				$mensaje = $value->mensaje;
				$asunto = $value->asunto;
				$invitados = $value->invitados;
				$invitados_externos = $value->invitados_externos;
				$id_copropiedad = $value->id_copropiedad;
			}

			
			// echo "\n";
			// echo $mensaje;
			// echo "\n";
			// echo $asunto;
			
			// echo "\n";
			// echo $invitados;
			// echo "\n";
			// echo $invitados_externos;
			// echo "\n";
			// echo $id_copropiedad;


			switch ($invitados) {
				case 'residente':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'grupo'=> array('$in' => array('residente','asamblea','consejo'))))));
					break;
				case 'asamblea':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'grupo'=> array('$in' => array('asamblea','consejo'))))));
					break;
				case 'consejo':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'grupo'=> array('$in' => array('consejo'))))));
					break;
				case 'proveedor':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'tipo'=> array('$in' => array('proveedor'))))));
					break;				
			}		
			if($invitados!="manual")
			{
				foreach ($correos as $mail) 
				{					
					$finalurlfinal=$urlfinal.base64_encode($mail->id_crm_persona);
					$template = $mensaje." ".$finalurlfinal;					
					$resultado = array();
					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
					$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
					$headers[] = "Subject: " . $asunto;
					$headers[] = "X-Mailer: PHP/".phpversion();
					$resultado[] = mail($mail->email, $asunto, $template, implode("\r\n", $headers));					
					// var_dump($resultado);
				}
				if($invitados_externos!="")
				{
					$externos=explode(",", $invitados_externos);
					foreach ($externos as $correoInvitados) 
					{
						$finalurlfinal=$urlfinal.base64_encode($correoInvitados);
						$template = $mensaje." ".$finalurlfinal;					
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
						$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
						$headers[] = "Subject: " . $asunto;
						$headers[] = "X-Mailer: PHP/".phpversion();
						$resultado[] = mail($correoInvitados, $asunto, $template, implode("\r\n", $headers));					
						// var_dump($resultado);
					}
				}								
			}
			else
			{
				$externos=explode(",", $invitados_externos);
				foreach ($externos as $correoInvitados) 
				{
					$finalurlfinal=$urlfinal.base64_encode($correoInvitados);
					$template = $mensaje." ".$finalurlfinal;					
					$resultado = array();
					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
					$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
					$headers[] = "Subject: " . $asunto;
					$headers[] = "X-Mailer: PHP/".phpversion();
					$resultado[] = mail($correoInvitados, $asunto, $template, implode("\r\n", $headers));					
					//var_dump($resultado);
				}
			}
			$resultado="ok";
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});



$app->post("/mail/encuestas/contarInvitados/", function() use($app)
{
	 //try
	 //{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			//echo "\n primero traer la informacion del envio tal como token y esas cosas";						
			//$encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaVotos', array($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta))))
			$encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta))));
			foreach ($encuestas as $value) {	

				$urlfinal = $myString = $value->urlencuesta."index.php?stk=".$value->tokenencuesta."&usr=";
				$mensaje = $value->mensaje;
				$asunto = $value->asunto;
				$invitados = $value->invitados;
				$invitados_externos = $value->invitados_externos;
				$id_copropiedad = $value->id_copropiedad;
			}

			
			// echo "\n";
			// echo $mensaje;
			// echo "\n";
			// echo $asunto;
			
			// echo "\n";
			// echo $invitados;
			// echo "\n";
			// echo $invitados_externos;
			// echo "\n";
			// echo $id_copropiedad;


			switch ($invitados) {
				case 'residente':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'grupo'=> array('$in' => array('residente','asamblea','consejo'))))));
					break;
				case 'asamblea':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'grupo'=> array('$in' => array('asamblea','consejo'))))));
					break;
				case 'consejo':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'grupo'=> array('$in' => array('consejo'))))));
					break;
				case 'proveedor':
					$correos = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $id_copropiedad, 'tipo'=> array('$in' => array('proveedor'))))));
					break;				
			}


			$cuentacorreos=0;


			if($invitados!="manual")
			{
				foreach ($correos as $mail) 
				{					
					$cuentacorreos++;					
				}
				if($invitados_externos!="")
				{
					$externos=explode(",", $invitados_externos);
					foreach ($externos as $correoInvitados) 
					{
						$cuentacorreos++;
					}
				}								
			}
			else
			{
				$externos=explode(",", $invitados_externos);
				foreach ($externos as $correoInvitados) 
				{
					$cuentacorreos++;
				}
			}
			enviarRespuesta($app, true, $cuentacorreos, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	//}
	//catch(Exception $e)
	//{
		//echo "Error: " . $e->getMessage();
	//	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	//}
});











$app->post("/mail/tareas/vencidas/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/tareas_vencidas.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/tareas/hoy/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/tareas_hoy.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/tareas/actualizacion/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/tareas_actualizacion.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/registro/activacion/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = "Hola @NAME@ hemos recibido tu registro en copropiedad. Debes continuar con el link que encontrarás a continuacion para activar tu usuario. Este link solo estará disponible por las próximas 24 horas. <a href='@LINK@'>Activar Suscripcion</a>";
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$template = str_replace("@LINK@", htmlspecialchars($to_person->link), $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/registro/notificacion/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = "Hay una suscripcion nueva en copropiedad con los siguientes datos. Nombre: @NAME@, apellidos: @APELLI@, Email: @MAIL@, Telefono: @TEL@, Direccion: @DIR@, nombre edificio: @NOMBREE@ Tipo: @TIP@, Pais: @PAIS@, Ciudad: @CIU@";
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$template = str_replace("@APELLI@", $to_person->apellido, $template);
				$template = str_replace("@MAIL@", $to_person->email, $template);
				$template = str_replace("@TEL@", $to_person->telefono, $template);
				$template = str_replace("@DIR@", $to_person->direccion, $template);
				$template = str_replace("@TIP@", $to_person->tipo, $template);
				$template = str_replace("@PAIS@", $to_person->pais, $template);
				$template = str_replace("@CIU@", $to_person->ciudad, $template);
				$template = str_replace("@NOMBREE@", $to_person->nombreedificio, $template);
				
				$subject = $to_person->nombre . ", se ha inscrito a copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($datos->body->destinos, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/usuario/cambiopassword/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			//$template = file_get_contents("/var/www/shared_resources/mail_templates/usuario_cambiopassword.html");
			if($datos->body->tipo == "primeravez")
			{
				$template = "Hola @NAME@ has finalizado el proceso de activacion correctamente. Puedes entrar a copropiedad desde este momento con las credenciales que has establecido.<a href='http://aws02.copropiedad.co/v2/'>Ir a copropiedad</a>";
			}
			else if($datos->body->tipo == "cambiopasswordinicio")
			{
				$template = "Hola @NAME@ has solicitado un cambio de contraseña. si lo has solicitado haz click en el siguiente enlace <a href='@LINK@'> Cambiar contraseña </a>. En caso de que no lo hayas solicitado tu, puedes hacer caso omiso a este correo.";
			}
			else if($datos->body->tipo == "cambiopasswordfin")
			{
				$template = "Hola @NAME@ has cambiado tu contraseña correctamente. Puedes entrar a copropiedad desde este momento con las credenciales que has establecido de nuevo.";
			}
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				if($datos->body->tipo == "cambiopasswordinicio"){$template = str_replace("@LINK@", $to_person->link, $template);}
				if($datos->body->tipo == "primeravez")
				{
					$subject = $to_person->nombre . ", has completado el proceso de registro con éxito";
				}
				else if($datos->body->tipo == "cambiopasswordinicio")
				{
					$subject = $to_person->nombre . ", has solicitado un cambio de contraseña";
				}
				else if($datos->body->tipo == "cambiopasswordfin")
				{
					$subject = $to_person->nombre . ", has completado el proceso de cambio de contraseña con éxito";	
				}

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/usuario/infoactualizada/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/usuario_infoactualizada.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/usuario/bienvenida/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/usuario_bienvenida.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/reservas/exito/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/reservas_exito.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/encomiendas/recibido/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/encomiendas_recibido.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/frontdesk/crear/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/frontdesk_crear.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/frontdesk/respuesta/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/frontdesk_respuesta.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/solicitudes/crear/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/solicitudes_crear.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

$app->post("/mail/solicitudes/respuesta/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		$tokenValidado = $token->SetToken($datos->token);
		if($tokenValidado)
		{
			$template = file_get_contents("/var/www/shared_resources/mail_templates/solicitudes_respuesta.html");
			$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
			$resultado = array();
			foreach ($datos->body->destinatarios as $to_person) 
			{
				$template = str_replace("@NAME@", $to_person->nombre, $template);
				$subject = $to_person->nombre . ", bienvenido a Copropiedad";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "From: Copropiedad <noreply@copropiedad.co>";
				$headers[] = "Reply-To: Ventas Copropiedad <sales@copropiedad.co>";
				$headers[] = "Subject: " . $subject;
				$headers[] = "X-Mailer: PHP/".phpversion();

				$resultado[$to_person->email] = mail($to_person->email, $subject, $template, implode("\r\n", $headers));
			}
			enviarRespuesta($app, true, $resultado, null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		//echo "Error: " . $e->getMessage();
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});

function consultaColeccionRetorno($app, $coleccion, $arreglo)
{
	$dbdata = new DBNosql($coleccion);	
	$resultado = $dbdata->selectDocument($arreglo);	
	return $resultado;
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