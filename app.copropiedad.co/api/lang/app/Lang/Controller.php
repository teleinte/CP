<?php
require_once("app/Model/config.php");
require_once("app/Model/Token_model.php");
require_once("app/Model/Log_model.php");
require_once("app/Model/DBNosql_model.php");

/******************************************************************
**                    WEB SERVICE PARA HOY                       **
**                   2014 - TELEINTE S.A.S.                      **
**                 AUTOR: GERMAN VELASQUEZ                       **
/*****************************************************************/
//GENERAR TOKEN - OK - OK
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

//METODO LISTAR NOTIFICACIONES DE SISTEMA PARA UN USUARIO  - OK
  $app->options("/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->put("/", function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtrot = array("lang" => $datos->body->lang);
        consultaColeccion($app, 'languages', $filtrot);
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

  $app->post("/", function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtrot = array("lang" => $datos->body->lang);
        $resp = objectToArray(consultaColeccionRespuesta($app, 'languages', $filtrot))[0];
        enviarRespuesta($app, true, $resp["update_date"], null);
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
/**************************************************************************
**                                                                       **
**                        FUNCIONES AUXILIARES                           **
**                                                                       **
**************************************************************************/

//FUNCION PARA FORMATEAR LA RESPUESTA EN EL MODELO DE RESPUESTA ESTABLECIDO EN LA ARQUITECTURA
function enviarRespuesta($recurso, $estado, $mensaje, $error)
{ 
 $envio=array('status'=>$estado,'message'=>$mensaje,'error'=>$error);

 $recurso->response->headers->set("Content-type", "application/json");
 $recurso->response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
 $recurso->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
 $recurso->response->status(200);
 $recurso->response->body(json_encode($envio));
}

function consultaColeccion($app, $coleccion, $arreglo)
{
  $dbdata = new DBNosql($coleccion);  
  $resultado = $dbdata->selectDocument($arreglo); 
  if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
  else {enviarRespuesta($app, true, null, null);}
}

function consultaColeccionRespuesta($app, $coleccion, $arreglo)
{
  $dbdata = new DBNosql($coleccion);  
  $resultado = $dbdata->selectDocument($arreglo); 
  if ($resultado){return $resultado;}
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
function objectToArray( $object )
 {
     if( !is_object( $object ) && !is_array( $object ) )
         return $object;
     if( is_object( $object ) )
         $object = get_object_vars( $object );
     return array_map( 'objectToArray', $object );
 }