<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");
/******************************************************************
**        WEB SERVICE ADMINISTRACIÓN DE PAGOS - PAYU             **
**                   2015 - TELEINTE S.A.S.                      **
**                  AUTOR: ANGIE CASTAÑEDA GOMEZ                 **
/*****************************************************************/

//SOLICITAR TOKEN - OK - OK
// Función para validar y crear Token
// Metodo Options para validacion de navegadores
	$app->options("/token/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO POST PARA CREACION DE TOKEN: Recibe como parametros:
// autkey = Código de autorización String
// user = Correo electrónico del usuario que solicita el Token
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
// Fin de la ruta /token/ para el método 'POST'
/////////////////////////////////////////////////////////////////////////////////////

//CREAR DATOS COPROPIEDAD- PAYU
// Función para crear datos de una copropiedad cliente de PayU
// Metodo Options para validacion de navegadores
	$app->options("/copropiedad/pagosonline/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO POST PARA LA CREACION DE DATOS COPROPIEDAD- PAYU, recibe como parametros
// token = Token creado para ser validado
// body = datos con los que se crea el objeto, ver documentación de arquitectura para definir los campos
	$app->post("/copropiedad/pagosonline/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			if($token->SetToken($datos->token))
			{
				$validateUsuario=validateRole();
				if ($validateUsuario)
				{	
					$validar = false;
					//var_dump("acc");
					$filtro = array('nombre' => $datos->body->nombre);
					$verificar = objectToArray(consultaColeccionRespuesta($app, 'copropiedad_payu_admin', $filtro));
					if(count($verificar)>0)
						$validar = true;

					$filtro = array('apikey' => $datos->body->apikey);
					$verificar = objectToArray(consultaColeccionRespuesta($app, 'copropiedad_payu_admin', $filtro));
					if(count($verificar)>0)
						$validar = true;

					$filtro = array('apikey_login' => $datos->body->apikey_login);
					$verificar = objectToArray(consultaColeccionRespuesta($app, 'copropiedad_payu_admin', $filtro));
					if(count($verificar)>0)
						$validar = true;

					$filtro = array('llave_publica' => $datos->body->llave_publica);
					$verificar = objectToArray(consultaColeccionRespuesta($app, 'copropiedad_payu_admin', $filtro));
					if(count($verificar)>0)
						$validar = true;

					$filtro = array('merchantId' => $datos->body->merchantId);
					$verificar = objectToArray(consultaColeccionRespuesta($app, 'copropiedad_payu_admin', $filtro));
					if(count($verificar)>0)
						$validar = true;

					$filtro = array('accountId' => $datos->body->accountId);
					$verificar = objectToArray(consultaColeccionRespuesta($app, 'copropiedad_payu_admin', $filtro));
					if(count($verificar)>0)
						$validar = true;

					if($validar)
					{
						enviarRespuesta($app, false, "ingresadas", null);
					}
					else
					{
						enviarInformacion('copropiedad_payu_admin', $datos->body, $app);
					}

				}
				else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalido");}
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});
// Fin de la ruta '/copropiedad/pagosonline' para el método 'POST'
/////////////////////////////////////////////////////////////////////////////////////

//EDITAR DATOS COPROPIEDAD- PAYU
// Función para editar datos de una copropiedad cliente de PayU
// Metodo Options para validacion de navegadores
	$app->options("/copropiedad/pagosonline", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO PUT PARA ACTUALIZAR LOS DATOS COPROPIEDAD- PAYU para una copropiedad en especifico
// Recibe como parametros:
// token = Token creado para ser validado
// body = cuerpo del objeto, ver documentación de arquitectura para definir los campos
// id_copropiedad = Campo obligatorio para identificar la copropiedad consultada, esta en el body
	$app->put("/copropiedad/pagosonline", function() use($app)
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
					$idGuardado=$datos->body->id_copropiedad;
					$muestreo=array("id_copropiedad"=>$idGuardado);
					$dbdata=new DBNosql('copropiedad_payu_admin');
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
// Fin de la ruta '/copropiedad/pagosonline' para el método 'PUT'
/////////////////////////////////////////////////////////////////////////////////////

//TRAE DATOS COPROPIEDAD- PAYU
// Función para visualizar datos de una copropiedad cliente de PayU en el formulario
// Metodo Options para validacion de navegadores
	$app->options("/consulta/copropiedad/pagosonline/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO POST PARA visualizar los datos Copropiedad- PayU de la copropiedad consultada, 
// Recibe como parametros:
// token = Token creado para ser validado
// body = cuerpo del objeto, ver documentación de arquitectura para definir los campos
// id_copropiedad = Campo obligatorio para identificar la copropiedad consultada, esta en el body
	$app->post("/consulta/copropiedad/pagosonline/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			if($token->SetToken($datos->token))
			{
				$validateUsuario=validateRole();
				if ($validateUsuario)
				{
					consultaColeccionFiltro($app, 'copropiedad_payu_admin', array('id_copropiedad'=>$datos->body->id_copropiedad));
				}
				else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalido");}
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});
// Fin de la ruta '/consulta/copropiedad/pagosonline' para el método 'POST'
/////////////////////////////////////////////////////////////////////////////////////

//CREAR PAGO EN BD
// Función para crear una transaccion que queda pendiente en BD cuando sale para PayU
// Metodo Options para validacion de navegadores
	$app->options("/pagar/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO POST PARA crear una transacción antes de pasar a la pasarela PayU, 
// Recibe como parametros:
// token = Token creado para ser validado
// body = cuerpo del objeto, ver documentación de arquitectura para definir los campos
	$app->post("/pagar/", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			if($token->SetToken($datos->token))
			{
				$validateUsuario=validateRole();
				if ($validateUsuario)
				{
					enviarInformacion('pagosonline', $datos->body, $app);
				}
				else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalido");}
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});
// Fin de la ruta '/pagar/' para el método 'POST'
/////////////////////////////////////////////////////////////////////////////////////

//RUTA ESPECIFICADA PARA NO REALIZAR PAGOS
// Función para crear una transaccion rechazada
// Metodo Options para validacion de navegadores
	$app->options("/nopagar/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO POST PARA crear una transacción rechazada antes de pasar a la pasarela PayU, 
// Recibe como parametros:
// token = Token creado para ser validado
// body = cuerpo del objeto, ver documentación de arquitectura para definir los campos
	$app->post("/nopagar/", function() use($app)
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
					enviarRespuesta($app, false, "Error de ejemplo", "controlado");	
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
// Fin de la ruta '/pagar/' para el método 'POST'
/////////////////////////////////////////////////////////////////////////////////////

//ACTUALIZAR PAGO DE PayU EN BD
// Función para crear una transaccion que queda pendiente en BD cuando sale para PayU
// Metodo Options para validacion de navegadores
	$app->options("/actualizarinfo/", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options

// METODO POST para modificar una transacción guardada en BD con la respuesta de PayU, 
// Recibe como parametros:
// token = Token creado para ser validado
// body = cuerpo del objeto, ver documentación de arquitectura para definir los campos
// estado = pasa de Pending a otra bandera, dependiendo de la respuesta de PayU
// respuesta = puede ser APPROVED, DECLINADA, entre otras.
// fecha_transaccion = fecha y hora en la que se realizo el pago.
	$app->post("/actualizarinfo/", function() use($app)
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
					$estadoGuardado=$datos->body->estado;
					$respuestaGuardada=$datos->body->respuesta;
					$fechaGuardada=$datos->body->fecha_transaccion;

					$informacion_final=array();
					$informacion = json_decode(json_encode(consultaColeccionRetorno($app, 'pagosonline', array('referenceCode' => $datos->body->referenceCode))));
					foreach ($informacion as $llave => $valor) {
					    foreach ($valor as $key => $value) 
					    {
					    	if(is_object($value))
					    	{
					    		$vars=get_object_vars($value);
								$idMongoo= $vars['$id'];
					    		
					    	}
					    	
					    }

					}
					
					$idMongo=array("_id"=>new MongoId($idMongoo));
					$informacion_final["fecha_creacion"] = $informacion[0]->fecha_creacion;			    	
				    $informacion_final["id_copropiedad"] = $informacion[0]->id_copropiedad;
				    $informacion_final["id_crm_persona"] = $informacion[0]->id_crm_persona;
				    $informacion_final["merchantId"] = $informacion[0]->merchantId;
				    $informacion_final["apikey"] = $informacion[0]->apikey;
				    $informacion_final["accountId"] = $informacion[0]->accountId;
				    $informacion_final["amount"] = $informacion[0]->amount;
				    $informacion_final["buyerEmail"] = $informacion[0]->buyerEmail;
				    $informacion_final["referenceCode"] = $informacion[0]->referenceCode;
				    $informacion_final["description"] = $informacion[0]->description;
				    $informacion_final["tax"] = $informacion[0]->tax;
				    $informacion_final["signature"] = $informacion[0]->signature;
				    $informacion_final["currency"] = $informacion[0]->currency;
				    $informacion_final["test"] = $informacion[0]->test;
				    $informacion_final["ing"] = $informacion[0]->ing;
				    $informacion_final["responseUrl"] = $informacion[0]->responseUrl;
				    $informacion_final["confirmationUrl"] = $informacion[0]->confirmationUrl;
					$informacion_final["estado"] = $estadoGuardado;
					$informacion_final["respuesta"] = $respuestaGuardada;
					$informacion_final["fecha_transaccion"] = $fechaGuardada;
					$dbdata=new DBNosql('pagosonline');
					$array = json_decode(json_encode($informacion_final), true);						
					$result=$dbdata->updateDocument($idMongo, $array);
					//var_dump($result);
					//var_dump($array);
					//var_dump($informacion_final);
					//var_dump($idGuardado);

					if ($result){enviarRespuesta($app, true, $result, "null");}
					else {enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());}
					                    				
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
// Fin de la ruta '/pagar/' para el método 'POST'
/////////////////////////////////////////////////////////////////////////////////////

//METODO LISTAR TODOS LOS OBJETOS PAGO - OK - OK
  $app->options("/pagosonline/getlist/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/pagosonline/getlist/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {	//var_dump($datos->body->id_copropiedad);
          consultaColeccion($app, 'pagosonline', array('id_copropiedad' => $datos->body->id_copropiedad));
        }
        else
        {
          enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");
        }
      }
      else
      {
        enviarRespuesta($app, false, "Token invalido", "null");
      }
    }
    catch(Exception $e)
    {
    enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
    }
  });

  //METODO LISTAR TODOS LOS OBJETOS PAGO - OK - OK
    $app->options("/pagosonline/listar/pago_nuevo/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/pagosonline/listar/pago_nuevo/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
          $validateUsuario=validateRole();
          if ($validateUsuario)
          {	
          	$idGuardado=$datos->body->id_copropiedad;
			$muestreo=array("_id"=>new MongoId($idGuardado));
            $consulta=objectToArray(consultaColeccionRetorno($app, 'copropiedad', $muestreo))[0]['pagosonline'];
            enviarRespuesta($app, true, $consulta, null);
          }
          else
          {
            enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");
          }
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      }
      catch(Exception $e)
      {
      enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
      }
    });

/*********************** METODO PARA PAGAR PAGOS ONLINE (GERMAN)***************************/
	//PAGAR POL
  $app->options("/pagarpol/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post('/pagarpol/', function() use($app)
  {
    /*try
    {*/
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");
      $requerimiento = $app::getInstance()->request();
      $rtapayu = $requerimiento->params();
      $today = date("c");
      $rtapayu["tipo_documento"] = "respuestapayu";
      $rtapayu["timestamprecibido"] = $today;
      $rta = guardarDato("pagosonline",$rtapayu,$app);
      var_dump($rta);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");
      //$log = "-----------RTAPAYU----------------\n" . json_encode($rtapayu). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");
      //$log = "-----------RTASAVEPAYU----------------\n" . json_encode($rta). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");

      $muestreo = array("referenceCode"=>$rtapayu["reference_sale"]);
      $pago = objectToArray(consultaColeccionRespuesta($app, "pagosonline", $muestreo))[0];
      
      //$log = "-----------PAGO----------------\n" . json_encode($pago). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");

      /*--->$muestreocont = array("tipo_documento"=>"cartera", "doc"=>$pago['doc']);
      $cartera = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$pago['id_copropiedad'], $muestreocont))[0];*/
      //$log = "-----------CARTERA----------------\n" . json_encode($cartera). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");

      $modificador=array('$set'=>array("estado"=>$rtapayu['response_message_pol']));
      $dbdata = new DBNosql('pagosonline');
      $resultpagos = $dbdata->updateDocument($muestreo,$modificador);
      //$log = "-----------MODIFICADOR----------------\n" . json_encode($modificador). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");
      //$log = "-----------RESULTPAGOS----------------\n" . json_encode($resultpagos). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");

      /*if($rtapayu["response_code_pol"] == 1 || $rtapayu["response_code_pol"] == "1" )
      {
        $muestreocont = array("tipo_documento"=>"cartera", "doc"=>$pago["doc"], "saldo"=>explode(".",$rtapayu['value'])[0]);
        $dbdatacont = new DBNosql('cont_'.$pago['id_copropiedad']);
        $resultadoresta = $cartera["saldo"] - explode(".",$rtapayu['value'])[0];
        //$log = "-----------RESTA----------------\n" . $resultadoresta . "-----------\n";
        $modificador=array('$set'=>array("saldo"=>$resultadoresta));
        $resultcartera = $dbdatacont->updateDocument($muestreocont,$modificador);
        //$log = $log . "-----------muestrecont----------------\n" . json_encode($muestreocont). "-----------\n";
        //$log = $log . "-----------modificador----------------\n" . json_encode($modificador). "-----------\n";
        //$log = $log . "-----------resultcartera----------------\n" . json_encode($resultcartera). "-----------\n";
      }*/
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . $log);

      enviarRespuesta($app, true, null, null);
    /*}
    catch(Exception $e)
    {
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/payu/log.txt");
      //file_put_contents("/datos/app.copropiedad.co/api/payu/log.txt", $tst . "ERR: \n" . $e->getMessage() . "-----------\n\n");
    	var_dump($e)
    	enviarRespuesta($app, false, null, null);
    }*/
  });

/*********************** METODO PARA PAGAR PAGOS ONLINE TELEINTE (GERMAN)***************************/
	//PAGAR POL
  $app->options("/teleinte/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post('/teleinte/', function() use($app)
  {
    try
    {
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      $requerimiento = $app::getInstance()->request();
      $rtapayu = $requerimiento->params();
      $today = date("c");
      $rtapayu["tipo_documento"] = "respuestapayu";
      $rtapayu["timestamprecibido"] = $today;
      $rta = guardarDato("pagosteleinte_manager",$rtapayu,$app);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      //$log = "-----------RTAPAYU----------------\n" . json_encode($rtapayu). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      //$log = "-----------RTASAVEPAYU----------------\n" . json_encode($rta). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");

      $muestreo = array("referenceCode"=>$rtapayu["reference_sale"]);
      $pago = objectToArray(consultaColeccionRespuesta($app, "pagosteleinte_manager", $muestreo));
      foreach ($pago as $key => $value) 
      {
      	$modificador=array('$set'=>array("estado"=>$rtapayu['response_message_pol'], "fecha_confirmacion" => $rtapayu["timestamprecibido"]));
      	$dbdata = new DBNosql('pagosteleinte_manager');
      	$resultpagos = $dbdata->updateMDocument($muestreo,$modificador);
      }
      
      //$log = "-----------PAGO----------------\n" . json_encode($pago). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");

    }
    catch(Exception $e)
    {
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . "ERR: \n" . $e->getMessage() . "-----------\n\n");
      enviarRespuesta($app, false, null, null);
    }
  });
//CREAR PAGO EN BD PARA TELEINTE (ANGIE)
// Función para crear una transaccion que queda pendiente en BD cuando sale para PayU
// Metodo Options para validacion de navegadores
	$app->options("/pagar/teleinte", function() use($app)
	{
		enviarRespuesta($app, true, "ok", "ok");
	});
// Fin del metódo Options
// METODO POST PARA crear una transacción antes de pasar a la pasarela PayU, 
// Recibe como parametros:
// token = Token creado para ser validado
// body = cuerpo del objeto, ver documentación de arquitectura para definir los campos	
$app->post("/pagar/teleinte", function() use($app)
	{
		try
		{
			$requerimiento = $app::getInstance()->request();
			$datos = json_decode($requerimiento->getBody());
			$token = new Token;
			if($token->SetToken($datos->token))
			{
				$validateUsuario=validateRole();
				if ($validateUsuario)
				{
					enviarInformacion('pagosteleinte_manager', $datos->body, $app);
				}
				else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
			}
			else{enviarRespuesta($app, false, "Token invalido", "Token invalido");}
		}
		catch(Exception $e)
		{
			//echo "Error: " . $e->getMessage();
			enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
		}
	});

/************** FUNCIONES AUXILIARES *****************/
	function consultaColeccionFiltro($app, $coleccion, $arreglo)
	{
		//var_dump($arreglo);
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

	function guardarDato($lista,$data,$app)
	{
	  $dbdata=new DBNosql($lista);
	  $arreglo = json_decode(json_encode($data), true);
	  $resultado=$dbdata->insertDocument($arreglo);
	  $validador=get_object_vars($resultado);
	  $validador=implode(",", $validador);
	  return $validador;
	}

	function consultaColeccionRespuesta($app, $coleccion, $arreglo)
	{
	  $dbdata = new DBNosql($coleccion);  
	  $resultado = $dbdata->selectDocument($arreglo); 
	  if ($resultado){return $resultado;}
	  else {enviarRespuesta($app, true, null, null);}
	}