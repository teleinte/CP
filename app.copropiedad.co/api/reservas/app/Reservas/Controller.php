<?php
require_once("/datos/app.copropiedad.co/api/reservas/app/Model/config.php");
require_once("/datos/app.copropiedad.co/api/reservas/app/Model/Token_model.php");
require_once("/datos/app.copropiedad.co/api/reservas/app/Model/Log_model.php");
require_once("/datos/app.copropiedad.co/api/reservas/app/Model/DBNosql_model.php");

/******************************************************************
**                    WEB SERVICE RESERVAS                       **
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

//METODO CREAR RESERVA - OK - OK

  $app->options("/reserva/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reserva/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $datos->body->fecha_inicio = date($datos->body->fecha_inicio);
        $datos->body->fecha_fin = date($datos->body->fecha_fin);
        enviarInformacion('reservas', $datos->body, $app);
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

//MÉTODO BORRAR RESERVA - OK - OK
  $app->delete("/reserva/", function() use($app)
  {
    $aidi = "";
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $idGuardado=$datos->body->id;
        $aidi = $idGuardado;
        unset($datos->body->id);
        $muestreo=array("_id"=>new MongoId($idGuardado));
        $dbdata=new DBNosql('reservas');
        $array = json_decode(json_encode($datos), true);            
        $result=$dbdata->removeDocument($muestreo, true);
        if ($result){enviarRespuesta($app, true, $result, "null");}
        else {enviarRespuesta($app, true, null, null);}
      }
      else
      {
        enviarRespuesta($app, false, "Token invalido", "null");
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, "Error al obtener la información. "                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        , $e->getMessage());
    }
  });

//MÉTODO EDITAR RESERVA - OK - OK
  $app->put("/reserva/", function() use($app)
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
          $dbdata=new DBNosql('reservas');
          $array = json_decode(json_encode($datos), true);            
          $result=$dbdata->updateDocument($muestreo, $datos->body);
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

//METODO CREAR INMUEBLE RESERVABLE - OK - OK
  $app->options("/reserva/inmueble/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reserva/inmueble/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        enviarInformacion('inmuebleReservas', $datos->body, $app);
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

//METODO EDITAR INMUEBLE RESERVABLE - OK - OK
  $app->put("/reserva/inmueble/", function() use($app)
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
          $dbdata=new DBNosql('inmuebleReservas');
          $array = json_decode(json_encode($datos), true);            
          $result=$dbdata->updateDocument($muestreo, $datos->body);
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

//METODO BORRAR INMUEBLE RESERVABLE - OK - OK
  $app->delete("/reserva/inmueble/", function() use($app)
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
          $dbdata=new DBNosql('inmuebleReservas');
          $array = json_decode(json_encode($datos), true);            
          $result=$dbdata->removeDocument($muestreo, $datos->body);
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

//METODO LISTAR INMUEBLES RESERVABLES POR COPROPIEDAD - OK - OK
  $app->options("/reservas/copropiedad/inmuebles/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/copropiedad/inmuebles/", function() use($app)
  {
   // try
   //  {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array('id_copropiedad' => $datos->body->id_copropiedad, 'reservable' => true);
          $res = consultaColeccionRespuesta($app, 'unidad', $filtro);
          $filtro2 = array('id_copropiedad' => $datos->body->id_copropiedad);
          $res2 = consultaColeccionRespuesta($app, 'inmuebleReservas', $filtro2);
          $resultado = validarInmueblesSinConfiguracion($res, $res2);
          //enviarRespuesta($app, true, $res, "null");
          enviarRespuesta($app, true, $resultado, "null");
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
    // }
    // catch(Exception $e)
    // {
    // enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
    // }
  });

//METODO LISTAR CONDICIONES DE DESPLIEGUE INMUEBLES RESERVABLES POR COPROPIEDAD - OK - OK
  $app->options("/reservas/inmuebles/lista/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/inmuebles/lista/", function() use($app)
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
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array('id_copropiedad' => $datos->body->id_copropiedad);
          $res = consultaColeccionRespuesta($app, 'inmuebleReservas', $filtro);
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

//METODO LISTAR RESERVAS POR INMUEBLE - OK - OK
  $app->options("/reservas/listar/inmueble/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/listar/inmueble/", function() use($app)
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
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array('id_inmueble' => $datos->body->id_inmueble);
          $res = consultaColeccionRespuesta($app, 'reservas', $filtro);
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

//METODO LISTAR GRUPOS DISPONIBLES PARA RESERVAS - OK - OK
  $app->options("/reservas/listar/grupos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/listar/grupos/", function() use($app)
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
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array('id_copropiedad' => $datos->body->id_copropiedad);
          $res = consultaColeccionGrupos(consultaColeccionRespuesta($app, 'inmuebleReservas', $filtro));
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

//METODO LISTAR RESERVAS POR INMUEBLE POR FECHA - OK - OK
  $app->options("/reservas/listar/inmueble/fecha/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/listar/inmueble/fecha/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $id_inmueble = $datos->body->id_inmueble;
        if ($validateUsuario)
        {
          /*
{
    "fecha_inicio": {
        $gte: "2015-06-21COT00:00:01+00:00",
        $lte: "2015-06-21COT23:59:59+00:00" 
    }
}

          */
          $filtro = array("fecha_inicio" => array('$gte' => $datos->body->fecha_inicio."COT00:00:01+00:00", '$lte' => $datos->body->fecha_fin."COT23:59:59+00:00"), 'id_inmueble' => $id_inmueble);
          $res = consultaColeccionRespuesta($app, 'reservas', $filtro);
          enviarRespuesta($app, true, $res, $filtro);
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

//METODO LISTAR RESERVAS POR GRUPO POR FECHA - OK - OK
  $app->options("/reservas/listar/grupo/fecha/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/listar/grupo/fecha/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $today = $datos->body->fecha_inicio;
        $end = $datos->body->fecha_fin;
        $grupo = $datos->body->grupo;
        if ($validateUsuario)
        {
          $filtro = array("fecha_inicio" => array('$lte' => $end."COT23:59:00+00:00", '$gte' => $today."COT00:00:00+00:00"), 'grupo' => $grupo);
          $res = consultaColeccionRespuesta($app, 'reservas', $filtro);
          enviarRespuesta($app, true, $res, $datos->body->fecha_inicio . " @@@@@@@ " . $datos->body->fecha_fin);
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

//METODO TOTALIZAR RESERVAS PARA INMUEBLE CON FILTRO DE TIEMPO - OK - OK
  $app->options("/reservas/totalizar/inmueble/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/totalizar/inmueble/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $start = $datos->body->fecha_inicio;
        $end = $datos->body->fecha_fin;
        $id_inmueble = $datos->body->id_inmueble;
        if ($validateUsuario)
        {
          $filtro = array("fecha_inicio" => array('$lte' => $end."COT23:59:00+00:00", '$gte' => $start."COT00:00:00+00:00"), 'id_inmueble' => $id_inmueble);
          $res = consultaColeccionRespuesta($app, 'reservas', $filtro);
          enviarRespuesta($app, true, count($res), "null");
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

//METODO TOTALIZAR RESERVAS PARA GRUPO DE INMUEBLES CON FILTRO DE TIEMPO - OK - OK
  $app->options("/reservas/totalizar/grupos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/totalizar/grupos/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $start = $datos->body->fecha_inicio;
        $end = $datos->body->fecha_fin;
        $id_copropiedad = $datos->body->id_copropiedad;
        //$start = date('d-m-Y',strtotime('01-12-2014'));
        if ($validateUsuario)
        {
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array("fecha_inicio" => array('$lte' => $end."COT23:59:00+00:00", '$gte' => $start."COT00:00:00+00:00"),'id_copropiedad' => $id_copropiedad);
          $res = totalizarGrupos(consultaColeccionRespuesta($app, 'reservas', $filtro));
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

//METODO TOTALIZAR RESERVAS PARA COPROPIEDAD CON FILTRO DE TIEMPO - OK - OK
  $app->options("/reservas/totalizar/copropiedad/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/reservas/totalizar/copropiedad/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        $start = $datos->body->fecha_inicio;
        $end = $datos->body->fecha_fin;
        $id_copropiedad = $datos->body->id_copropiedad;
        //$start = date('d-m-Y',strtotime('01-12-2014'));
        if ($validateUsuario)
        {
          //$filtro = array("fecha_despliegue" => array('$lte' => $today, '$gte' => $start));
          $filtro = array("fecha_inicio" => array('$lte' => $end."COT23:59:00+00:00", '$gte' => $start."COT00:00:00+00:00"),'id_copropiedad' => $id_copropiedad);
          $res = consultaColeccionRespuesta($app, 'reservas', $filtro);
          enviarRespuesta($app, true, count($res), "null");
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

function consultaColeccionGrupos($inmueble_arr)
{
  $resp = array();
  foreach ($inmueble_arr as $value) {
    $resp[] = $value["grupo"];
  }
  return $resp;
}

function totalizarGrupos($inmueble_arr)
{
  $resp = array();
  if(count($inmueble_arr) > 0)
  {
    foreach ($inmueble_arr as $value) {
      if(array_key_exists($value["grupo"], $resp))
        {$resp[$value["grupo"]] = $resp[$value["grupo"]] + 1;}
      else
        $resp[$value["grupo"]] = 1;
    }
  }
  return $resp;
}

function validarInmueblesSinConfiguracion($inmueblesreservables, $inmueblesconfigurados)
{
  $resp = array();
  if(count($inmueblesreservables) > 0)
  {
    foreach ($inmueblesreservables as $value) 
    {
      if(count($inmueblesconfigurados) > 0)
      {
          foreach ($inmueblesconfigurados as $value2)
          {
            if($value2['id_inmueble'] == (string)$value['_id'])
              array_push($resp,$value);
          } 
      }      
    }
  }

  return array_udiff($inmueblesreservables, $resp, function ($obj_a, $obj_b) {return strcmp((string)$obj_a['_id'], (string)$obj_b['_id']);});
}

function convertMongoIds(array &$array){
    foreach ($array as &$element){
        if (is_array($element)){
            convertMongoIds($element);
        }else if (is_object($element) && get_class($element) == "MongoId"){
            return (string) $element;
        }
    }
}