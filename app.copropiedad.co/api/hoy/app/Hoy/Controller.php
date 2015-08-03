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
$app->options("/obtener/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});
  
  $app->post("/obtener/", function() use($app)
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
          date_default_timezone_set('America/Bogota');
          $today = date("Y-m-d");
          $ninarray = array("completada", "eliminada"); 
          $filtrot = array("deadline" => array('$lte' => $today."COT23:59:59+00:00"),'id_copropiedad'=>$datos->body->id_copropiedad,'estado'=> array('$nin'=> $ninarray), 'tipo'=>"tarea");
          //$resultado_tareas = ordenarLista('tarea',consultaColeccionRespuesta($app, 'tarea', $filtrot));
          $resultado_tareas = consultaColeccionRespuesta($app, 'tarea', $filtrot);
          $filtros = array('id_copropiedad'=>$datos->body->id_copropiedad, 'estado' => "abierta");
          //$resultado_solicitudes = ordenarLista('solicitud',consultaColeccionRespuesta($app, 'solicitudes', $filtros));
          $resultado_solicitudes = consultaColeccionRespuesta($app, 'solicitudes', $filtros);
          /*$filtroin = array('id_copropiedad' => $datos->body->id_copropiedad);
          $filtror = array("fecha_inicio" => array('$lte' => $today."COT23:59:00+00:00", '$gte' => $today."COT00:00:00+00:00"),'id_copropiedad'=>$datos->body->id_copropiedad);
          $resultado_reservas = ordenarListaReservas('reserva',consultaColeccionRespuesta($app, 'reservas', $filtror),obtenerNombresInmuebles(consultaColeccionRespuesta($app, 'inmuebleReservas', $filtroin)));*/
          //enviarRespuesta($app, true, array_merge($resultado_tareas, $resultado_solicitudes, $resultado_reservas) , $filtrot);
          if(count($resultado_tareas) == 0)
            $resultado_tareas = array();
          if(count($resultado_solicitudes) == 0)
            $resultado_solicitudes = array();

          enviarRespuesta($app, true, array_merge($resultado_tareas, $resultado_solicitudes), 'null');
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

//METODO LISTAR NOTIFICACIONES DE SISTEMA PARA UN USUARIO  - OK
$app->options("/verificar/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});
  
  $app->post("/verificar/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        enviarRespuesta($app, true, "OK", "null");
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

function ordenarLista($tipo, $res)
{
  $res=json_decode(json_encode($res));
  switch ($tipo) {
    case 'tarea':
        $resultado = array();
        for ($i=0; $i < count($res); $i++)
        {
          $elem = array();
          foreach ($res[$i] as $key => $value) {
            if($key == "nombre")
              $elem['nombre'] = $value;
            if($key == "estado")
              $elem['estado'] = $value;
            if($key == "deadline")
              $elem['fecha'] = $value;
            if($key == "_id")
              $elem['id'] = $value;
            $elem['tipo'] = $tipo;
          }
          $resultado[] = $elem;
        }
        return $resultado;
      break;
    case 'solicitud':
      $resultado = array();
      for ($i=0; $i < count($res); $i++)
      {
        $elem = array();
        foreach ($res[$i] as $key => $value) {
          if($key == "solicitud")
            $elem['nombre'] = $value;
          if($key == "estado")
            $elem['estado'] = $value;
          if($key == "fecha_creacion")
            $elem['fecha'] = $value;
          $elem['tipo'] = $tipo;
        }
        $resultado[] = $elem;
      }
      return $resultado;
      break;  
  }
}

function ordenarListaReservas($tipo, $res, $inmuebles)
{
  $res=json_decode(json_encode($res));
  $resultado = array();
  for ($i=0; $i < count($res); $i++)
  {
    $elem = array();
    foreach ($res[$i] as $key => $value) {
      if($key == "id_inmueble")
        $elem['nombre'] = $inmuebles[$value];
      if($key == "estado")
        $elem['estado'] = $value;
      if($key == "fecha_inicio")
        $elem['fecha'] = $value;
      $elem['tipo'] = $tipo;
    }
    $resultado[] = $elem;
  }
  return $resultado;
}

function obtenerNombresInmuebles($inmarray)
{
  $res=json_decode(json_encode($inmarray));
  $resultado = array();
  for ($i=0; $i < count($res); $i++)
  {
    $elem = array();
    $id = "";
    $nombre = "";
    foreach ($res[$i] as $key => $value) {
      if($key == "id_inmueble")
        $id = $value;
      if($key == "nombre_despliegue")
        $nombre = $value;
    }
    $resultado[$id] = $nombre;
  }
  return $resultado;
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