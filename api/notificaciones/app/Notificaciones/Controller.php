<?php
require_once("/var/www/html/api/notificaciones/app/Model/config.php");
require_once("/var/www/html/api/notificaciones/app/Model/Token_model.php");
require_once("/var/www/html/api/notificaciones/app/Model/Log_model.php");
require_once("/var/www/html/api/notificaciones/app/Model/DBNosql_model.php");

/******************************************************************
**                 WEB SERVICE NOTIFICACIONES                    **
**                   2014 - TELEINTE S.A.S.                      **
**                 AUTOR: GERMAN VELASQUEZ                       **
/*****************************************************************/
//GENERAR TOKEN - OK - OK
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

//METODO CREAR NOTIFICACION - OK
  $app->post("/notificaciones/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $datos->body->fecha_despliegue = date($datos->body->fecha_despliegue);
        enviarInformacion('notificaciones', $datos->body, $app);
      }
      else
      {
        enviarRespuesta($app, false, "Token invalido", "null");
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
    }
  });

//MÉTODO BORRAR NOTIFICACION
  $app->delete("/notificaciones/", function() use($app)
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
          $idGuardado=$datos->body->id;
          unset($datos->body->id);
          $muestreo=array("_id"=>new MongoId($idGuardado));
          $dbdata=new DBNosql('notificaciones');
          $array = json_decode(json_encode($datos), true);            
          $result=$dbdata->removeDocument(array('_id' => new MongoId($muestreo)), true);
          if ($result){enviarRespuesta($app, true, $result, "null");}
          else {enviarRespuesta($app, true, null, null);}
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
      enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
    }
  });

//METODO LISTAR NOTIFICACIONES DE SISTEMA PARA UN USUARIO  - OK
  $app->post("/notificaciones/usuario/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $today = date('d-m-Y');
        //$start = date('d-m-Y',strtotime('01-12-2014'));
        if ($validateUsuario)
        {
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array("fecha_despliegue" => array('$lte' => $today), 'id_crm_persona' => $datos->body->id_crm_persona);
          $res = consultaColeccionRespuesta($app, 'notificaciones', $filtro);
          enviarRespuesta($app, true, $res, "null");
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

//METODO LISTAR NOTIFICACIONES DE SISTEMA PARA TODOS LOS USUARIOS  - OK
  $app->post("/notificaciones/todos/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $today = date('d-m-Y');
        //$start = date('d-m-Y',strtotime('01-12-2014'));
        if ($validateUsuario)
        {
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array("fecha_despliegue" => array('$lte' => $today), 'id_crm_persona' => "todos");
          $res = consultaColeccionRespuesta($app, 'notificaciones', $filtro);
          enviarRespuesta($app, true, $res, "null");
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

function validateRole()
{
  return true;
}