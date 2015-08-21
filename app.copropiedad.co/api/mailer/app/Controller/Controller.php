<?php
require_once("/datos/app.copropiedad.co/api/mailer/app/Model/Token_Model.php");
require_once("/datos/app.copropiedad.co/api/mailer/app/Model/Log_Model.php");
require_once("/datos/app.copropiedad.co/api/mailer/app/Model/DBNosql_Model.php");
require_once("ses-mail.php");
if(!defined("SPECIALCONSTANT")) die("Acceso denegado");

//----- TOKEN ---- OK
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
//----- COMPARTIR TAREA ----- OK
	$app->options("/mail/tareas/compartir/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/compartir-tarea.html");
				$template = str_replace("@@NOMBREADMIN@@", $datos->body->nombre_remitente, $template);
				$template = str_replace("@@TAREA@@", $datos->body->nombre_tarea, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@NAME@", $to_person->nombre, $template);
					$subject = $datos->body->nombre_remitente . ", ha compartido una tarea contigo";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- COMPARTIR EVENTOS ----- OK
	$app->options("/mail/eventos/compartir/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/eventos/compartir/", function() use($app)
	{
		// try
		// {
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;			
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$evento = consultaColeccionRetorno($app, 'evento', array("_id"=>new MongoId($datos->body->id_evento)));				
				foreach ($evento as $value) 
				{
					$invitados = $value["compartir_invitados"];
					$invitados_externos = $value["compartir_otros"];
					$nombre = $value["nombre"];	
					$subject="invitacion evento ".$value["nombre"];				
					$id_copropiedad = $value["id_copropiedad"];
					$hinicio=explode("T", $value["fecha_inicio"]);
					$hfin=explode("T", $value["fecha_fin"]);
					$horainicio = $hinicio[1];
					$horafin = $hfin[1];
					$fechaevento = $hinicio[0];
				}				
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/invitacion-evento.html");
				$template = str_replace("@@NOMBREADMIN@@", $datos->body->nombre_remitente, $template);
				$template = str_replace("@@EVENTO@@", $nombre, $template);
				$template = str_replace("@@FECHAEVENTO@@", $fechaevento, $template);
				$template = str_replace("@@HORAINICIO@@", $horainicio, $template);
				$template = str_replace("@@HORAFIN@@", $horafin, $template);
				$resultado = array();
				// var_dump($template);
				// exit;
				if($invitados!="manual")
				{
					foreach ($correos as $mail) 
					{					
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($mail->email, $subject, $template, implode("\r\n", $headers));					
						// var_dump($resultado);
					}
					if($invitados_externos!="")
					{
						$externos=explode(",", $invitados_externos);
						foreach ($externos as $correoInvitados) 
						{
							$resultado = array();
							$headers   = array();
							$headers[] = "MIME-Version: 1.0";
							$headers[] = "Content-type: text/html; charset=utf-8";
							$headers[] = "Subject: " . $subject;
							$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
							$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));					
						}
					}								
				}
				else
				{
					$externos=explode(",", $invitados_externos);
					foreach ($externos as $correoInvitados) 
					{
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
					}
				}
				$resultado="ok";
				enviarRespuesta($app, true, $resultado, null);
			}
		// }
		// catch(Exception $e)
		// {
		// 	//echo "Error: " . $e->getMessage();
		// 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		// }
	});
//----- ENVIAR ENCUESTA ----- OK
	$app->options("/mail/encuestas/enviar/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$encuestas = consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
				$encuestasCab = consultaColeccionRetorno($app, 'encuestaCabecera', array("_id"=>new MongoId($datos->body->id_encuesta)));
				foreach ($encuestas as $value) {
					$urlfinal = $myString = $value["urlencuesta"]."index.php?tp=3&stk=".$value["tokenencuesta"]."&usr=";
					$mensaje = $value["mensaje"];
					$subject = $value["asunto"];
					$invitados = $value["invitados"];
					$invitados_externos = $value["invitados_externos"];
					$id_copropiedad = $value["id_copropiedad"];
				}
				foreach ($encuestasCab as $enc) {
					$fechafin = $enc['fecha_fin'];
				}
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

				$template = file_get_contents("/datos/shared_resources/mail_templates/envio-encuesta.html");
				$template = str_replace("@@MENSAJE@@", $mensaje, $template);
				$template = str_replace("@@FECHAFIN@@", $fechafin, $template);				

				if($invitados!="manual")
				{
					foreach ($correos as $mail) 
					{					
						$finalurlfinal=$urlfinal.base64_encode($mail->id_crm_persona);
						$template = str_replace("@@URL@@", $finalurlfinal, $template);					
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($mail->email, $subject, $template, implode("\r\n", $headers));
						$template = str_replace($finalurlfinal,"@@URL@@",$template);					
						// var_dump($resultado);
					}
					if($invitados_externos!="")
					{
						$externos=explode(",", $invitados_externos);
						foreach ($externos as $correoInvitados) 
						{
							$finalurlfinal=$urlfinal.base64_encode($correoInvitados);	
							$template = str_replace("@@URL@@", $finalurlfinal, $template);			
							$resultado = array();
							$headers   = array();
							$headers[] = "MIME-Version: 1.0";
							$headers[] = "Content-type: text/html; charset=utf-8";
							$headers[] = "Subject: " . $subject;
							$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
							$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
							$template = str_replace($finalurlfinal,"@@URL@@",$template);					
						}
					}								
				}
				else
				{
					$externos=explode(",", $invitados_externos);
					foreach ($externos as $correoInvitados) 
					{
						$finalurlfinal=$urlfinal.base64_encode($correoInvitados);
						$template = str_replace("@@URL@@", $finalurlfinal, $template);				
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
						$template = str_replace($finalurlfinal,"@@URL@@",$template);
					}
				}
				$resultado="ok";
				enviarRespuesta($app, true, $resultado, null);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});





//----- ENVIAR Evento ----- OK
	$app->options("/mail/evento/enviar/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/evento/enviar/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				//en este consulto la coleccion para saver a quien se le envio la encuesta se debe cambiar por la que tiene la iformacion de
				// los eventos o de aqui se le debe enviar el evento ya debe estar en la coleccion
				// creo que esta es la coleccion que debe cambiar
				$encuestas = consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
				// esta es la cabezera de la encuesta osea donde esta el nombre de la encuesta y la descirpcion para adjuntarla al correo 
				// y enviarla
				$encuestasCab = consultaColeccionRetorno($app, 'encuestaCabecera', array("_id"=>new MongoId($datos->body->id_encuesta)));
				//recorro la cabecera de la encuesta y en mensaje empiezo a armar con los datos tanto de invitados externos como los invitados de copropiedades
				foreach ($encuestas as $value) {
					$urlfinal = $myString = $value["urlencuesta"]."index.php?tp=3&stk=".$value["tokenencuesta"]."&usr=";
					$mensaje = $value["mensaje"];
					$subject = $value["asunto"];
					$invitados = $value["invitados"];
					$invitados_externos = $value["invitados_externos"];
					$id_copropiedad = $value["id_copropiedad"];
				}
				//saco la fecha final de la cabecera 
				foreach ($encuestasCab as $enc) {
					$fechafin = $enc['fecha_fin'];
				}
				//recorro invitados que traje encuesta envio osea de la coleccion que tiene los invitados de la copropiedad y recorro el tipo
				//este proceso no se debe tocar porque ya funciona es el que mira segun el grupo para llamar asi a los los invitados 
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
				// aqui es donde verdaderamente enpiezo a parametrizar la encuesta ya en cuanto a la plantilla reemplazando los datos
				$template = file_get_contents("/datos/shared_resources/mail_templates/envio-encuesta.html");
				$template = str_replace("@@MENSAJE@@", $mensaje, $template);
				$template = str_replace("@@FECHAFIN@@", $fechafin, $template);				
				// esto es para si los suarios no fueron de la copropiedad o invitados externos mejor dicho
				if($invitados!="manual")
				{
					//aqui recorro primero los correos de la  copropiedad osea los de los grupos que guarde anteriormente
					// y envio el correo por la funcion que usted creo Ses_mail
					foreach ($correos as $mail) 
					{					
						$finalurlfinal=$urlfinal.base64_encode($mail->id_crm_persona);
						$template = str_replace("@@URL@@", $finalurlfinal, $template);					
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($mail->email, $subject, $template, implode("\r\n", $headers));
						$template = str_replace($finalurlfinal,"@@URL@@",$template);					
						// var_dump($resultado);
					}
					// si hay invitados externos tambien los recorro ya que vienen separados por coma si son varios y los envio
					if($invitados_externos!="")
					{
						$externos=explode(",", $invitados_externos);
						foreach ($externos as $correoInvitados) 
						{
							$finalurlfinal=$urlfinal.base64_encode($correoInvitados);	
							$template = str_replace("@@URL@@", $finalurlfinal, $template);			
							$resultado = array();
							$headers   = array();
							$headers[] = "MIME-Version: 1.0";
							$headers[] = "Content-type: text/html; charset=utf-8";
							$headers[] = "Subject: " . $subject;
							$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
							$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
							$template = str_replace($finalurlfinal,"@@URL@@",$template);					
						}
					}								
				}
				//este es el metodo si no escogieron nada de ningun grupo, osea si solo se mandaron para externos la logica
				//es la misma que la anterior
				else
				{
					$externos=explode(",", $invitados_externos);
					foreach ($externos as $correoInvitados) 
					{
						$finalurlfinal=$urlfinal.base64_encode($correoInvitados);
						$template = str_replace("@@URL@@", $finalurlfinal, $template);				
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
						$template = str_replace($finalurlfinal,"@@URL@@",$template);
					}
				}
				//y envio la respusta del envio y sale para pintura
				$resultado="ok";
				enviarRespuesta($app, true, $resultado, null);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

















//----- CONTAR INVITADOS ENCUESTA NO MAIL ----- OK
	$app->options("/mail/encuestas/contarInvitados/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/encuestas/contarInvitados/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta))));			
				foreach ($encuestas as $value) {	

					$urlfinal = $myString = $value->urlencuesta."index.php?stk=".$value->tokenencuesta."&usr=";
					$mensaje = $value->mensaje;
					$subject = $value->asunto;
					$invitados = $value->invitados;
					$invitados_externos = $value->invitados_externos;
					$id_copropiedad = $value->id_copropiedad;
				}
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
					if($invitados_externos!="")
					{
						$externos=explode(",", $invitados_externos);
						foreach ($externos as $correoInvitados) 
						{
							$cuentacorreos++;
						}	
					}
					
				}
				enviarRespuesta($app, true, $cuentacorreos, null);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});
//----- INFORME DIARIO TAREAS ----- OK
	$app->options("/mail/tareas/reporte/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/tareas/reporte/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/resumen-diario.html");
				$template = str_replace("@@NOMBRE@@", html_entity_decode($datos->body->nombre_admin,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$template = str_replace("@@SOLICITUDES@@", html_entity_decode($datos->body->solicitudes,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$template = str_replace("@@TAREASAVENCER@@", html_entity_decode($datos->body->tareashoy,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$template = str_replace("@@TAREASVENCIDAS@@", html_entity_decode($datos->body->tareasvencidas,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$template = str_replace("@@EVENTOS@@", html_entity_decode($datos->body->eventos,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$template = str_replace("@@ENCUESTAS@@", html_entity_decode($datos->body->encuestas,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$template = str_replace("@@VOTACIONES@@", html_entity_decode($datos->body->votaciones,ENT_COMPAT | ENT_HTML5,'UTF-8'), $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$subject = "Resumen diario de pendientes para la copropiedad " + $datos->body->nombre_copropiedad;

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- RECORDATORIO TAREA ----- OK
	$app->options("/mail/recordatorio/tarea/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/recordatorio/tarea/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/recordatorio-vencimiento.html");
				$template = str_replace("@@NOMBRE@@", $datos->body->nombre_remitente, $template);
				$template = str_replace("@@TAREA@@", $datos->body->nombre_tarea, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$subject = "Recordatorio de vencimiento de tarea en Copropiedad.co";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- RECORDATORIO EVENTO ----- OK
	$app->options("/mail/recordatorio/evento/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/recordatorio/evento/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/recordatorio-evento.html");
				$template = str_replace("@@NOMBREEVENTO@@", $datos->body->nombre_evento, $template);
				$template = str_replace("@@FECHA@@", $datos->body->fecha, $template);
				$template = str_replace("@@HORAINICIO@@", $datos->body->hora_inicio, $template);
				$template = str_replace("@@HORAFIN@@", $datos->body->hora_fin, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$subject = "Recordatorio Invitación " . $datos->body->nombre_evento . " el dia " . $datos->body->fecha . " a las " . $datos->body->hora_inicio . " en " . $datos->body->nombre_copropiedad;

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- EVENTO MODIFICADO ----- OK
	$app->options("/mail/evento/modificado/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/evento/modificado/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/modificacion-evento.html");
				$template = str_replace("@@NOMBREEVENTO@@", $datos->body->nombre_evento, $template);
				$template = str_replace("@@FECHA@@", $datos->body->fecha, $template);
				$template = str_replace("@@HORAINICIO@@", $datos->body->hora_inicio, $template);
				$template = str_replace("@@HORAFIN@@", $datos->body->hora_fin, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					
					$subject = "Invitacion al evento " . $datos->body->nombre_evento . " el dia " . $datos->body->fecha . " a las " . $datos->body->hora_inicio . " en " . $datos->body->nombre_copropiedad;

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- INVITACION EVENTO ----- OK
	$app->options("/mail/evento/invitar/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/evento/invitar/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/tareas_vencidas.html");
				$template = str_replace("@@NOMBREADMIN@@", $datos->body->nombre_remitente, $template);
				$template = str_replace("@@NOMBREEVENTO@@", $datos->body->nombre_evento, $template);
				$template = str_replace("@@FECHA@@", $datos->body->fecha, $template);
				$template = str_replace("@@HORAINICIO@@", $datos->body->hora_inicio, $template);
				$template = str_replace("@@HORAFIN@@", $datos->body->hora_fin, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@NAME@", $to_person->nombre, $template);
					$subject = $to_person->nombre . ", bienvenido a Copropiedad";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- ENVIO VOTACION ----- OK
	$app->options("/mail/votacion/invitar/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/votacion/invitar/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$encuestas = consultaColeccionRetorno($app, 'encuestaEnvio', array('id_encuesta' => $datos->body->id_encuesta));
				$encuestasCab = consultaColeccionRetorno($app, 'encuestaCabecera', array("_id"=>new MongoId($datos->body->id_encuesta)));
				foreach ($encuestas as $value) {
					$urlfinal = $myString = $value["urlencuesta"]."index.php?tp=4&stk=".$value["tokenencuesta"]."&usr=";
					$mensaje = $value["mensaje"];
					$subject = $value["asunto"];
					$invitados = $value["invitados"];
					$invitados_externos = $value["invitados_externos"];
					$id_copropiedad = $value["id_copropiedad"];
				}
				foreach ($encuestasCab as $enc) {
					$fechafin = $enc['fecha_fin'];
				}
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

				$template = file_get_contents("/datos/shared_resources/mail_templates/envio-votacion.html");
				$template = str_replace("@@MENSAJE@@", $mensaje, $template);
				$template = str_replace("@@FECHAFIN@@", $fechafin, $template);
				

				if($invitados!="manual")
				{
					foreach ($correos as $mail) 
					{					
						$finalurlfinal=$urlfinal.base64_encode($mail->id_crm_persona);
						$template = str_replace("@@URL@@", $finalurlfinal, $template);					
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($mail->email, $subject, $template, implode("\r\n", $headers));
						$template = str_replace($finalurlfinal,"@@URL@@", $template);					
						// var_dump($resultado);
					}
					if($invitados_externos!="")
					{
						$externos=explode(",", $invitados_externos);
						foreach ($externos as $correoInvitados) 
						{
							$finalurlfinal=$urlfinal.base64_encode($correoInvitados);
							$template = str_replace("@@URL@@", $finalurlfinal, $template);				
							$resultado = array();
							$headers   = array();
							$headers[] = "MIME-Version: 1.0";
							$headers[] = "Content-type: text/html; charset=utf-8";
							$headers[] = "Subject: " . $subject;
							$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
							$template = str_replace($finalurlfinal,"@@URL@@", $template);					
						}
					}								
				}
				else
				{
					$externos=explode(",", $invitados_externos);

					foreach ($externos as $correoInvitados) 
					{
						$finalurlfinal=$urlfinal.base64_encode($correoInvitados);
						$template = str_replace("@@URL@@", $finalurlfinal, $template);				
						$resultado = array();
						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";
						$resultado[] = ses_mail($correoInvitados, $subject, $template, implode("\r\n", $headers));
						$template = str_replace($finalurlfinal,"@@URL@@", $template);
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
//----- BIENVENIDA ADMIN ----- OK
	$app->options("/mail/registro/bienvenida/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/registro/bienvenida/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/bienvenida-admin.html");
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@@USERNAME@@", $to_person->user, $template);
					$template = str_replace("@@URL@@", htmlspecialchars($to_person->link), $template);
					$subject = "Bienvenido a copropiedad.co Tu cuenta ha sido verificada y activada.";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- BIENVENIDA RESIDENTE ----- OK
	$app->options("/mail/registro/bienvenida/residente/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/registro/bienvenida/residente/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/bienvenida-residente.html");
				$template = str_replace("@@USERNAME@@", $datos->body->user, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@@URL@@", htmlspecialchars($to_person->link), $template);
					$subject = "Bienvenido a copropiedad.co Tu cuenta ha sido creada.";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- RESERVA EXITOSA  ----- OK
	$app->options("/mail/reservas/exito/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/confirmacion-reserva.html");
				$template = str_replace("@@RECURSO@@", $datos->body->nombre_recurso, $template);
				$template = str_replace("@@FECHA@@", $datos->body->fecha, $template);
				$template = str_replace("@@HORAINICIO@@", $datos->body->hora_inicio, $template);
				$template = str_replace("@@HORAFIN@@", $datos->body->hora_fin, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$subject = "Confirmación de reserva de recursos";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- RESERVA CANCELADA ----- OK
	$app->options("/mail/reservas/eliminada/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/reservas/eliminada/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/eliminar-reserva.html");
				$template = str_replace("@@RECURSO@@", $datos->body->nombre_recurso, $template);
				$template = str_replace("@@FECHA@@", $datos->body->fecha, $template);
				$template = str_replace("@@HORAINICIO@@", $datos->body->hora_inicio, $template);
				$template = str_replace("@@HORAFIN@@", $datos->body->hora_fin, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$subject = "Cancelación de reserva de recursos.";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- EVENTO CANCELADO ----- OK
	$app->options("/mail/evento/cancelado/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/evento/cancelado/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/eliminar-evento.html");
				$template = str_replace("@@NOMBREEVENTO@@", $datos->body->nombre_evento, $template);
				$template = str_replace("@@FECHA@@", $datos->body->fecha, $template);
				$template = str_replace("@@HORAINICIO@@", $datos->body->hora_inicio, $template);
				$template = str_replace("@@HORAFIN@@", $datos->body->hora_fin, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					
					$subject = "Se ha cancelado el evento " . $datos->body->nombre_evento . ".";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- REGISTRO DE USUARIO ----- OK
	$app->options("/mail/registro/activacion/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/verificacion-administrador.html");
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$subject = "Bienvenido a copropiedad.co. Estamos verificando tu cuenta.";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- CAMBIO PASSWORD ----- OK
	$app->options("/mail/usuario/cambiopassword/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/restablecer-password.html");
				$subject = "Restablece tu contraseña en Copropiedad.co";
				$resultado = array();
				
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@@USERNAME@@", $to_person->email, $template);
					$template = str_replace("@@LINK@@", $to_person->link, $template);

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
				}
				enviarRespuesta($app, true, $resultado, null);
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
			//enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});
//----- CAMBIO PASS EXITOSO ----- OK
	$app->options("/mail/usuario/infoactualizada/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/cambio-password.html");
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@@USERNAME@@", $to_person->email, $template);
					$subject = "Tu contraseña en Copropiedad.co ha cambiado";
					
					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
//----- METODO DE MAILING GENERICO ----- OK
	$app->options("/mail/send/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/send/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/blank.html");
				$template = str_replace("@@DATOS@@", $datos->body->message, $template);
				$resultado = array();
				$subject = $datos->body->subject;
				$topeople = $datos->body->to;
				$toarray = explode(",",$topeople);
				$headers = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "Subject: " . $subject;
				$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

				foreach ($toarray as $idx => $destination) 
				{
					$resultado[] = array("email"=>trim($destination), "response" => json_encode(ses_mail(trim($destination), $subject, $template, implode("\r\n", $headers))));
				}

				enviarInformacion('mailerlog', $resultado, $app);
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

//----- METODO DE MAILING GENERICO TEMPLATE 2----- OK
	$app->options("/mail/send2/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/send2/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/blank2.html");
				$template = str_replace("@@DATOS@@", $datos->body->message, $template);
				$resultado = array();
				$subject = $datos->body->subject;
				$topeople = $datos->body->to;
				$toarray = explode(",",$topeople);
				$headers = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "Subject: " . $subject;
				$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

				foreach ($toarray as $idx => $destination) 
				{
					$resultado[] = array("email"=>trim($destination), "response" => json_encode(ses_mail(trim($destination), $subject, $template, implode("\r\n", $headers))));
				}

				enviarInformacion('mailerlog', $resultado, $app);
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
//----- METODO DE MAILING Instructivo AZ ----- 
	$app->options("/mail/send_sintemplate/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/send_sintemplate/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				date_default_timezone_set('America/Bogota');
				$timestamp = date("c");
				$template = file_get_contents("/datos/shared_resources/mail_templates/".$datos->body->template."");
				$template = str_replace("@@DATOS@@", $datos->body->message, $template);
				$resultado = array();
				$subject = $datos->body->subject;
				$topeople = $datos->body->to;
				$toarray = explode(",",$topeople);
				$headers = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "Subject: " . $subject;
				$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

				foreach ($toarray as $idx => $destination) 
				{
					$resultado[] = array("email"=>trim($destination), "timestamp" => $timestamp, "response" => json_encode(ses_mail(trim($destination), $subject, $template, implode("\r\n", $headers))));
				}

				enviarInformacion('mailerlog', $resultado, $app);
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
//----- METODO DE MAILING GENERICO ATTACHMENT ----- OK
	$app->options("/mail/attachment/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
	});

	$app->post("/mail/attachment/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			$tokenValidado = $token->SetToken($datos->token);
			if($tokenValidado)
			{
				$template = file_get_contents("/datos/shared_resources/mail_templates/blank2.html");
				$template = str_replace("@@DATOS@@", $datos->body->message, $template);
				$resultado = array();
				$subject = $datos->body->subject;
				$topeople = $datos->body->to;
				$toarray = explode(",",$topeople);
				$headers = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/html; charset=utf-8";
				$headers[] = "Subject: " . $subject;
				$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

				foreach ($toarray as $idx => $destination) 
				{
					$resultado[] = array("email"=>trim($destination), "response" => json_encode(ses_mail(trim($destination), $subject, $template, implode("\r\n", $headers))));
				}

				enviarInformacion('mailerlog', $resultado, $app);
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

/*------------- METODOS BACKEND --------------*/
	//----- TEST MAILER ----- OK
		$app->options("/mail/testmailer/", function() use($app)
		{
		  enviarRespuesta($app, true, "ok", "ok");
		});

		$app->post("/mail/testmailer/", function() use($app)
		{
			try
			{
				$requerimiento = $app::getInstance()->request();
				$datos = json_decode($requerimiento->getBody());
				$token = new Token;
				$tokenValidado = $token->SetToken($datos->token);
				if($tokenValidado)
				{
					$template = file_get_contents("/datos/shared_resources/mail_templates/blank.html");
					$template = str_replace("@@DATOS@@", "TEST", $template);
					$resultado = array();
					$subject = "TEST MAILER COPROPIEDAD.CO";
					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[] = array("email"=>$datos->body->email, "response" => json_encode(ses_mail($datos->body->email, $subject, $template, implode("\r\n", $headers))));
					enviarInformacion('mailerlog', $resultado, $app);
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
	//----- NOTIFICACION DE CREACION DE USUARIO ----- OK
		$app->options("/mail/registro/notificacion/", function() use($app)
		{
		  enviarRespuesta($app, true, "ok", "ok");
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
					$template = file_get_contents("/datos/shared_resources/mail_templates/blank.html");
					$data = json_encode($datos->body->destinatarios);
					$template = str_replace("@@DATOS@@", $data, $template);
					$resultado = array();
					$dest = explode(',',$datos->body->destinos);
					foreach ($dest as $to_person) 
					{
						$subject = "[REGISTRO USUARIOS] Nuevo usuario registrado en copropiedad.co";

						$headers   = array();
						$headers[] = "MIME-Version: 1.0";
						$headers[] = "Content-type: text/html; charset=utf-8";
						$headers[] = "Subject: " . $subject;
						$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

						$resultado[$to_person] = ses_mail($to_person, $subject, $template, implode("\r\n", $headers));
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

/* -- METODOS YA NO UTILIZADOS --
	$app->options("/mail/solicitudes/crear/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/solicitudes_crear.html");
				$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@NAME@", $to_person->nombre, $template);
					$subject = $to_person->nombre . ", bienvenido a Copropiedad";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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

	$app->options("/mail/solicitudes/respuesta/", function() use($app)
	{
	  enviarRespuesta($app, true, "ok", "ok");
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
				$template = file_get_contents("/datos/shared_resources/mail_templates/solicitudes_respuesta.html");
				$template = str_replace("@ADMINISTRATOR@", $datos->body->nombre_remitente, $template);
				$resultado = array();
				foreach ($datos->body->destinatarios as $to_person) 
				{
					$template = str_replace("@NAME@", $to_person->nombre, $template);
					$subject = $to_person->nombre . ", bienvenido a Copropiedad";

					$headers   = array();
					$headers[] = "MIME-Version: 1.0";
					$headers[] = "Content-type: text/html; charset=utf-8";
					$headers[] = "Subject: " . $subject;
					$headers[] = "From: Copropiedad.co  <no_responder@copropiedad.co>";

					$resultado[$to_person->email] = ses_mail($to_person->email, $subject, $template, implode("\r\n", $headers));
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
*/

/*************************************************************************
*****																******
*****				FUNCIONES AUXILIARES Y DE BI 					******
*****																******
*************************************************************************/

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