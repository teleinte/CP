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

//METODO SUBIR IMAGEN PARA UN USUARIO  - OK
  $app->options("/imagen/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post("/imagen/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtro = array("id_crm_persona" => $datos->body->id_crm);
        $dbdata=new DBNosql('rolcp');
        $array = json_decode(json_encode($datos), true);
        $modificador=array('$set'=>array("imagen"=>$datos->body->imagen));
        
        $result=$dbdata->updateDocument($filtro,$modificador,true);
        if ($result){enviarRespuesta($app, true, $result, 'null');}
        else {enviarRespuesta($app, true, null,"no result");}
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

//METODO PARA OBTENER INFORMACION DE CP DE USUARIO
  $app->options("/info/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post("/info/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtro = array("id_crm_persona" => $datos->body->id_crm);
        consultaColeccion($app,'rolcp',$filtro);
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

//METODO PARA OBTENER INFORMACION DE CP DE USUARIO
  $app->options("/infocp/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post("/infocp/", function() use($app)
  {
   //try
    //{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $respuesta = Array();
        $filtro = array("id_crm_persona" => $datos->body->id_crm);
        $copropiedades = consultaColeccionRespuesta($app,'rolcp',$filtro);
        foreach ($copropiedades as $key => $value)    
        {
          $filtro = array("_id" => new MongoId($value['id_copropiedad']));
          $rta = consultaColeccionRespuesta($app,'copropiedad',$filtro)[0];
          $cp[] = array("nombre" => $value['nombre'], "id_copropiedad" => $value['id_copropiedad'], "vencimiento" => $rta['vigencia'], "rol" => $value['rol']);
        }
        enviarRespuesta($app, true, $cp, null);
      }
      else
      {
        enviarRespuesta($app, false, "Token invalido", "null");
      }
    //}
    //catch(Exception $e)
    //{
    //  enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
    //}
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