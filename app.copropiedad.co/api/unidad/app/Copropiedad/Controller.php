<?php
require_once("/datos/app.copropiedad.co/api/unidad/app/Model/config.php");
require_once("/datos/app.copropiedad.co/api/unidad/app/Model/Token_model.php");
require_once("/datos/app.copropiedad.co/api/unidad/app/Model/Log_model.php");
require_once("/datos/app.copropiedad.co/api/unidad/app/Model/DBNosql_model.php");

/******************************************************************
**          WEB SERVICE ADMINISTRACIÓN DE COPROPIEDAD            **
**                   2015 - TELEINTE S.A.S.                      **
**                 AUTOR: JAIRO GIL VILLAMARIN                   **
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

/***************  METODOS DE UNIDAD  ***************************/
  //METODO CREAR UNIDAD - OK - OK

$app->options("/unidad/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->post("/unidad/", function() use($app)
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
          enviarInformacion('unidad', $datos->body, $app);
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
  
  
  //CREAR ENCARGADO UNIDAD- OK - OK

$app->options("/unidadEncargado/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->post("/unidadEncargado/", function() use($app)
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
          enviarInformacion('contabilidadUnidad', $datos->body, $app);
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
  
  
  
  //MÉTODO MODIFICAR UNIDAD - OK

$app->options("/unidadEncargado/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->put("/unidadEncargado/", function() use($app)
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
          $dbdata=new DBNosql('contabilidadUnidad');
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
  
  
  

  //MÉTODO BORRAR UNIDAD - OK
  $app->delete("/unidad/", function() use($app)
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
          $dbdata=new DBNosql('unidad');
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

  //MÉTODO MODIFICAR UNIDAD - OK
  $app->put("/unidad/", function() use($app)
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
          $dbdata=new DBNosql('unidad');
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

//METODO LISTAR UNIDADES POR COPROPIEDAD - OK - OK

$app->options("/unidad/copropiedad/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/unidad/copropiedad/", function() use($app)
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
        consultaColeccion($app, 'unidad', array('id_copropiedad' => $datos->body->id_copropiedad,'estado'=> array('$ne'=>(int)4),'tipo_documento' => 'inmueble','estado'=> array('$ne'=>"2")));
        /*$unidades = cruzaUnidades(consultaColeccionRetorno($app, 'unidad', array('id_copropiedad' => $datos->body->id_copropiedad,'estado'=> array('$ne'=>(int)4))), obtieneResponsables(consultaColeccionRetorno($app, 'cont_' . $datos->body->id_copropiedad, array('id_copropiedad' => $datos->body->id_copropiedad)));
        consultaColeccion($app, 'unidad', array('id_copropiedad' => $datos->body->id_copropiedad,'estado'=> array('$ne'=>(int)4)));*/
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


//METODO LISTAR PROVEEDORES POR COPROPIEDAD - OK - OK

$app->options("/unidad/copropiedad/proveedor", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->post("/unidad/copropiedad/proveedor", function() use($app)
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
          consultaColeccion($app, 'unidad', array('id_copropiedad' => $datos->body->id_copropiedad,'estado'=> 1,'tipo_documento'=>'proveedor'));
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

  //METODO LISTAR UNIDADES POR ID_UNIDAD - OK - OK

$app->options("/unidad/copropiedadid/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->post("/unidad/copropiedadid/", function() use($app)
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
          consultaColeccion($app, 'unidad', array('estado'=> array('$ne'=>(int)'4'),'_id' => new MongoId($datos->body->_id)));
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


  
// BORRAR ENCARGADO DE UNIDAD PARA CONTABILIDAD

$app->options("/unidad/borrarencargado/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});
  
$app->delete("/unidad/borrarencargado/", function() use($app)
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
				$idGuardado=$datos->body->unidad;
				unset($datos->body->unidad);
				
				$dbdata=new DBNosql('contabilidadUnidad');
				$array = json_decode(json_encode($datos), true);
				$result=$dbdata->removeDocument(array('unidad' => $idGuardado), array("justOne" => true));
				
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
  
  
  
  

  //METODO LISTAR UNIDADES POR ID_UNIDAD - OK - OK

$app->options("/unidad/extras/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->post("/unidad/extras/", function() use($app)
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
          //consultaColeccion($app, 'contabilidadUnidad', array('unidad' =>$datos->body->id_unidad));
          consultaColeccion($app, 'contabilidadUnidad', array('estado'=> array('$ne'=>(int)'4'),'unidad' => $datos->body->id_unidad));
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
  
  

  //METODO LISTAR UNIDADES POR USUARIO - OK - OK

$app->options("/unidad/usuario/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});
  
  $app->post("/unidad/usuario/", function() use($app)
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
          consultaColeccion($app, 'unidad', array('id_crm_persona' => $datos->body->id_crm_persona));
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

function consultaColeccionFiltro($app, $coleccion, $arreglo)
{
  //var_dump($arreglo);
  $dbdata = new DBNosql($coleccion);  
  $resultado = $dbdata->selectDocument($arreglo);   
  if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
  else {enviarRespuesta($app, true, null, null);}
  
}


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

function consultaColeccionRetorno($app, $coleccion, $arreglo)
{
  $dbdata = new DBNosql($coleccion);  
  $resultado = $dbdata->selectDocument($arreglo); 
  return $resultado;
}

function consultaColeccion($app, $coleccion, $arreglo)
{
  $dbdata = new DBNosql($coleccion);  
  $resultado = $dbdata->selectDocument($arreglo); 
  if ($resultado){enviarRespuesta($app, true, $resultado, "null");}
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