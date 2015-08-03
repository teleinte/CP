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

//METODO OPTION PARA VALIDACION DE NAVEGADORES
$app->options("/test/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});
// FIN DEL METODO OPTION

// METODO POST PARA CREACION DE TOKEN, RECIBE COMO PARAMETROS
// autkey = CODIGO DE AUTORIZACION STRING
// user = CORREO ELECTRONICO DEL USUARIO QUE SOLICITA EL TOKEN
$app->put("/", function() use($app)
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

// METODO PARA VALIDACION DE USERFLOW
// id_crm_persona = Id crm del usuario
// token = token de autenticacion
$app->post("/", function() use($app)
{
	try
	{
		$requerimiento = $app::getInstance()->request();
		$datos = json_decode($requerimiento->getBody());
		$token = new Token;
		if($token->SetToken($datos->token))
		{
			if(!isset($datos->body->mi))
				enviarRespuesta($app,true,validarUserFlow($app, $datos->body->id_crm, $datos->body->id_copropiedad),null);
			else
				enviarRespuesta($app,true,validarUserFlowMi($app, $datos->body->id_copropiedad),null);
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	}
	catch(Exception $e)
	{
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});
//********** FUNCIONES AUXILIARES **************
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

	function enviarRespuesta($recurso, $estado, $mensaje, $error)
	{	
		$envio=array('status'=>$estado,'message'=>$mensaje,'error'=>$error);

		$recurso->response->headers->set("Content-type", "application/json");
		$recurso->response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
		$recurso->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
		$recurso->response->status(200);
		$recurso->response->body(json_encode($envio));
	}

	function validarUserFlow($app, $id_crm, $cp)
	{
		$userflow = 0;
		$filtro = array("id_crm_persona" => $id_crm);
		$r1 = objectToArray(consultaColeccionRespuesta($app,'copropiedad',$filtro));
		if(count($r1))
		{
			$userflow = "1";
			$filtro = array("id_copropiedad" => $cp, "tipo_documento" => "inmueble", "estado"=>1);
			$r2 = objectToArray(consultaColeccionRespuesta($app,'unidad',$filtro));
			if(count($r2))
			{
				$userflow = "2";
				$filtro = array("id_copropiedad" => $cp, "tipo_documento" => "proveedor", "estado"=>1);
				$r3 = objectToArray(consultaColeccionRespuesta($app,'unidad',$filtro));
				if(count($r3))
				{
					$userflow .= "1";
				}
				$filtro = array("id_copropiedad" => $cp);
				$r3 = objectToArray(consultaColeccionRespuesta($app,'copropiedad_payu_admin',$filtro));
				if(count($r3))
				{
					$userflow .= "2";
				}
				$filtro = array("id_copropiedad" => $cp);
				$r3 = objectToArray(consultaColeccionRespuesta($app,'inmuebleReservas',$filtro));
				if(count($r3))
				{
					$userflow .= "3";
				}
			}
		}

		return trim($userflow,",");
	}

	function validarUserFlowMi($app, $cp)
	{
		$userflow = 0;
		$r1 = objectToArray(consultaColeccionRespuesta($app,"copropiedad",array('_id'=> new MongoId($cp))));
			if((boolean)$r1[0]["pagosonline"] == "false")
				$userflow = 10;
		//var_dump($r1);
		//var_dump($userflow);

		$r2 = objectToArray(consultaColeccionRespuesta($app,"inmuebleReservas",array("id_copropiedad" => $cp)));
			if(count($r2) > 0)
				if($userflow == 10)
					$userflow = 11;
				else
					$userflow = 1;

		//var_dump($r2);
		//var_dump($userflow);

		return $userflow;
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
	      // Return array
	      return $d;
	  }
	}