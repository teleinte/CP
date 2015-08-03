<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

if(!defined("SPECIALCONSTANT")) die("Acceso denegado");

/******************************************************************
**            WEB SERVICE ADMINISTRACIÓN DE TAREAS               **
**                   2014 - TELEINTE S.A.S.                      **
**                  AUTOR: JAIRO GIL VILLAMARIN                  **
/*****************************************************************/

//GENERAR TOKEN - OK - OK
//FUNCION PARA VALIDAR Y CREAR TOKEN
// METODO OPTION PARA VALIDACION DE NAVEGADORES

$app->options("/token/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});
// FIN DEL METODO OPTION

// METODO POST PARA CREACION DE TOKEN, RECIBE COMO PARAMETROS
// autkey = CODIGO DE AUTORIZACION STRING
// user = CORREO ELECTRONICO DEL USUARIO QUE SOLICITA EL TOKEN

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
// FIN DE LA RUTA TOKEN PARA EL METODO POST
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// METODO OPTION PARA VALIDACION DE NAVEGADORES PARA LA RUTA LISTAR TAREAS
$app->options("/list/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});
// FIN DEL METODO OPTIONS



// METODO POST PARA LA CREACION DE TAREAS, RECIBE COMO PARAMETROS
// token = TOKEN CREADO A SER VALIDADO TIPO STRING
// body = CUERPO DE LA TAREA, VER DOCUMENTACION DE ARQUITECTURA PARA DEFINIR LOS CAMPOS
// tipo = CAMPO QUE AYDA A DETERMINAR SI ES UNA TAREA, UN DATO DE CARTELERA O DE VENTA, ESTA INCLUIDO DENTRO DEL body
$app->post("/list/", function() use($app)
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
				switch ($datos->body->tipo)
				{
					case 'tarea':
						date_default_timezone_set('America/Bogota');
						$today = date("c",strtotime($datos->body->deadline));
						$today = str_replace("T00:00:00-05:00", "COT23:59:59+00:00", $today);
						$datos->body->deadline = $today; 
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
	// }
	// catch(Exception $e)
	// {
	// 	enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	// }
});
// FIN DE LA RUTA LIST


// METODO OPTION PARA VALIDACION DE NAVEGADORES PARA LA RUTA getlist QUE PERMITE OPTENER TAREAS
$app->options("/getlist/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});
// FIN DEL METODO OPTION PARA LA RUTA getlist QUE PERMITE OPTENER TAREAS



// METODO POST PARA LISTAR LA TAREAS, RECIBE COMO PARAMETROS
// token = TOKEN CREADO A SER VALIDADO TIPO STRING
// body = CUERPO DE LA TAREA, VER DOCUMENTACION DE ARQUITECTURA PARA DEFINIR LOS CAMPOS
// id_copropiedad = CAMPO OBLIGATORIO PARA SABER DE QUE COPROPIEDAD SE LISTAN LOS DATOS ESTA EN EL body
// estado = CAMPO OBLIGATORIO PARA PROBAR QUE LA TAREA NO ESTE CERRADA O COMPLETADA
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
						$ninarray = array("eliminada", "completada");															
					    consultaColeccion($app, "tarea", array('id_copropiedad'=>$datos->body->id_copropiedad,'estado'=> array('$nin'=> $ninarray), 'tipo'=>"tarea"));
						break;	
					case 'cartelera':
						date_default_timezone_set('America/Bogota');
                        $fecha = date('c');
                        $nuevafecha = strtotime ( '-1 day' , strtotime ( $fecha ) ) ;
                        $today = date ( 'c' , $nuevafecha );
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
		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
	}
});
// FIN DEl METODO POST PARA LA RUTA getlist


// METODO OPTION PARA VALIDACION DE NAVEGADORES PARA LA RUTA getlistFilter QUE PERMITE OPTENER TAREAS
$app->options("/getlistFilter/", function() use($app)
{
	enviarRespuesta($app, true, "ok", "ok");
});
// FIN DEL METODO OPTION PARA LA RUTA getlist QUE PERMITE OBTENER TAREAS


// METODO POST PARA LISTAR LA TAREAS POR UN ID TAREA ESPECIFICO, RECIBE COMO PARAMETROS
// token = TOKEN CREADO A SER VALIDADO TIPO STRING
// body = CUERPO DE LA TAREA, VER DOCUMENTACION DE ARQUITECTURA PARA DEFINIR LOS CAMPOS
// _id = CAMPO OBLIGATORIO PARA SABER QUE TAREA SE QUIERE LISTAR ESTA EN EL body
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
// FIN DEl METODO POST PARA LA RUTA getlistFilter


// METODO PUT PARA ACTUALIZAR LA TAREAS POR UN ID TAREA ESPECIFICO, RECIBE COMO PARAMETROS
// token = TOKEN CREADO A SER VALIDADO TIPO STRING
// body = CUERPO DE LA TAREA, VER DOCUMENTACION DE ARQUITECTURA PARA DEFINIR LOS CAMPOS
// _id = CAMPO OBLIGATORIO PARA SABER QUE TAREA SE QUIERE MODIFICAR ESTA EN EL body

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
                                        case 'venta':
						$idGuardado=$datos->body->id;
						unset($datos->body->id);
						$muestreo=array("_id"=>new MongoId($idGuardado));
						$dbdata=new DBNosql('cartelera');
						$array = json_decode(json_encode($datos), true);						
						$result=$dbdata->updateDocument($muestreo, $datos->body);
						if ($result){enviarRespuesta($app, true, $result, "null");}
						else {enviarRespuesta($app, true, null, null);}
						break;
                                        case 'cartelera':
						$idGuardado=$datos->body->id;
						unset($datos->body->id);
						$muestreo=array("_id"=>new MongoId($idGuardado));
						$dbdata=new DBNosql('cartelera');
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
// FIN DEL METODO PUT PARA ACTUALIZAR LA TAREAS


// METODO DELETE PARA ACTUALIZAR LA TAREAS POR UN ID TAREA ESPECIFICO, RECIBE COMO PARAMETROS
// token = TOKEN CREADO A SER VALIDADO TIPO STRING
// body = CUERPO DE LA TAREA, VER DOCUMENTACION DE ARQUITECTURA PARA DEFINIR LOS CAMPOS
// _id = CAMPO OBLIGATORIO PARA SABER QUE TAREA SE QUIERE ELIMINAR ESTA EN EL body
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
				$idGuardado=$datos->body->id;
				unset($datos->body->id);
				$muestreo=array("_id"=>new MongoId($idGuardado));
				$dbdata=new DBNosql('tarea');
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
// FIN DEL METODO DELETE PARA ACTUALIZAR LA TAREAS POR UN ID TAREA ESPECIFICO, RECIBE COMO PARAMETROS





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
				        if ($result){enviarRespuesta($app, true, $result, "null");}
				        else {enviarRespuesta($app, true, null, null);}
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