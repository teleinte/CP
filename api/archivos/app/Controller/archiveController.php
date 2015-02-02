<?php
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/Upload_Model.php");


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

$app->post("/archive/", function() use($app)
{
	 try
	 {
		$fecha = date('YmdHis');
		$requerimiento = $app::getInstance()->request();	    
	    
		$token = new Token;
		$tokenValidado = $token->SetToken($requerimiento->params('token'));
		if($tokenValidado)
		{
			$validateUsuario=validateRole();
			if ($validateUsuario)
			{
				if (__S3)
				{
					$resultadoEnviado=new uploadmodel("S3",$_FILES['archivo'], "ingreso", $requerimiento->params('id_copropiedad'));
					$cuerpo=array('id_copropiedad'=>$requerimiento->params('id_copropiedad'),'usuario'=>$requerimiento->params('usuario'),'tipo'=>$requerimiento->params('tipo'),'fecha'=>$fecha,'ruta'=>$resultadoEnviado->ResultadoGeneral,'estado'=>'1');
					enviarInformacion('archivos', ($cuerpo), $app, $resultadoEnviado);
				}
				else
				{
					$resultadoEnviado=new uploadmodel("LOCAL",$_FILES['archivo'], "ingreso", $requerimiento->params('id_copropiedad'));
					//echo "este es el resultado".var_dump($resultadoEnviado->ResultadoGeneral);
					if ($resultadoEnviado->ResultadoGeneral !='Error')
					{
						$cuerpo=array('body'=>array('id_copropiedad'=>$requerimiento->params('id_copropiedad'),'usuario'=>$requerimiento->params('usuario'),'tipo'=>$requerimiento->params('tipo'),'fecha'=>$fecha,'ruta'=>$resultadoEnviado->ResultadoGeneral));						
						enviarInformacion('archivos', ($cuerpo), $app, $resultadoEnviado);
					}
					else
					{
						enviarRespuesta($app, false, "No pudo guardar el archivo verifique la ruta", "No pudo guardar el archivo verifique la ruta");
					}
				}     
			}
			else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
		}
		else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
	 }
	 catch(Exception $e)
	 {
	 	enviarRespuesta($app, false, $_FILES['archivo']["tmp_name"], $e->getMessage());
	 }
});

$app->delete("/archive/", function() use($app)
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
				if (__S3)
				{
					$resultadoEnviado=new uploadmodel("S3",$datos->body->ruta, "salida",$datos->body->id_copropiedad);
					if($resultadoEnviado->ResultadoGeneral)
					{
						$idGuardado=$datos->body->id;
						unset($datos->body->id);
						$muestreo=array("_id"=>new MongoId($idGuardado));
						$dbdata=new DBNosql('archivos');
						$array = json_decode(json_encode($datos), true);						
						$result=$dbdata->updateDocument($muestreo, $datos->body);
						if ($result){enviarRespuesta($app, true, $result, "null");}
						else {enviarRespuesta($app, true, null, null);}
					}
					else
					{
						enviarRespuesta($app, false, "Archivo no borrado de S3", "Archivo no borrado de S3");
					}
				}
				else
				{
					$rutaPartida=split("/",$datos->body->ruta);
					$nombreArchivo = array_pop($rutaPartida);
					unlink(__ARCHIVEROUTE.$nombreArchivo);
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

function consultaColeccion($app, $coleccion, $arreglo)
{
	$dbdata = new DBNosql($coleccion);									
	$resultado = $dbdata->selectDocument($arreglo);
	if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
	else {enviarRespuesta($app, true, null, null);}
}

function enviarInformacion($lista,$data,$app,$path)
{
	$dbdata=new DBNosql($lista);
	$arreglo = json_decode(json_encode($data), true);
	$resultado=$dbdata->insertDocument($arreglo);
	$validador=get_object_vars($resultado);
	$validador=implode(",", $validador);
	if ($validador) {enviarRespuesta($app, true, $path, "null"); }
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
	$recurso->response->status(200);
	$recurso->response->body(json_encode($envio));
}