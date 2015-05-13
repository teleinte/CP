<?php
require_once("/datos/app.copropiedad.co/api/admin/copropiedad/app/Model/config.php");
require_once("/datos/app.copropiedad.co/api/admin/copropiedad/app/Model/Token_model.php");
require_once("/datos/app.copropiedad.co/api/admin/copropiedad/app/Model/Log_model.php");
require_once("/datos/app.copropiedad.co/api/admin/copropiedad/app/Model/DBNosql_model.php");

/******************************************************************
**          WEB SERVICE ADMINISTRACIÓN DE COPROPIEDAD            **
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
/***************  METODOS DE COPROPIEDAD  ***************************/
  //METODO CREAR COPROPIEDAD - OK - OK
  $app->options("/copropiedad/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/copropiedad/", function() use($app)
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
          enviarInformacion('copropiedad', $datos->body, $app);
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

//MÉTODO LISTAR MODULOS - OK
  $app->options("/modulos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

    $app->post("/modulos/", function() use($app)
    {
     try
      {
        enviarRespuesta($app, true, __MODULOS, "Null");  
      }      
      catch(Exception $e)
      {
        enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      }
    });



    //MÉTODO BORRAR COPROPIEDAD - OK
    $app->delete("/copropiedad/", function() use($app)
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
            $dbdata=new DBNosql('copropiedad');
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

    //MÉTODO MODIFICAR COPROPIEDAD - OK
    $app->put("/copropiedad/", function() use($app)
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
            $dbdata=new DBNosql('copropiedad');
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

//METODO LISTAR COPROPIEDADES ASOCIADAS UN ID COPROPIEDAD - OK - OK
  $app->options("/copropiedad/getlistFilter/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/copropiedad/getlistFilter/", function() use($app)
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
          consultaColeccionFiltro($app, "copropiedad", array('_id'=> new MongoId($datos->body->_id)));
          //consultaColeccion($app, 'copropiedad', array('id_crm_persona' => $datos->body->id_crm_persona));
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

  $app->options("/copropiedad/usuarioCopropiedad/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
  $app->post("/copropiedad/usuarioCopropiedad/", function() use($app)
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
          consultaColeccion($app, 'copropiedad', array('id_crm_persona' => $datos->body->id_crm_persona,'estado' => 1));
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

$app->options("/copropiedad/usuarioCopropiedad/Login/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

 //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
  $app->post("/copropiedad/usuarioCopropiedad/Login/", function() use($app)
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
          $copropiedades = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_crm_persona' => $datos->body->id_crm_persona))));
          foreach ($copropiedades as $value) {
          $id_copropiedad = $value->id_copropiedad;
        }
          consultaColeccion($app, 'copropiedad', array("_id"=>new MongoId($id_copropiedad)));
          //var_dump($id_copropiedad);

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


$app->options("/unidad/nousuario/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});


  //METODO LISTAR UNIDADES SIN USUARIO ASOCIADAS A COPROPIEDAD - OK - OK
  $app->post("/unidad/nousuario/", function() use($app)
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
          consultaColeccion($app, 'unidad', array('id_copropiedad' => $datos->body->id_copropiedad, 'reservable' => false));
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
  
  
/***************  METODOS DE PERSONAS  ***************************/
  //METODO CREAR PERSONA - OK - OK

$app->options("/usuario/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});


  $app->post("/usuario/", function() use($app)
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
          enviarInformacion('usuariocp', $datos->body, $app);
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

$app->options("/usuario/personaid/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});



  //METODO BUSCAR PERSONA POR ID PERSONA - OK - OK
  $app->post("/usuario/personaid/", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array('_id' => new MongoId($datos->body->_id)));
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


  //METODO BUSCAR PERSONA POR ID PERSONA - OK - OK

  $app->options("/usuario/personacrm/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });


  $app->post("/usuario/personacrm/", function() use($app)
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
          consultaColeccion($app, 'rolcp', array('correo' => $datos->body->correo));
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

  //MÉTODO BORRAR PERSONA - OK
  $app->delete("/usuario/", function() use($app)
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
          $dbdata=new DBNosql('usuariocp');
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

  //MÉTODO MODIFICAR PERSONA - OK
  $app->put("/usuario/", function() use($app)
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
          $dbdata=new DBNosql('usuariocp');
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

  //MÉTODO LISTAR USUARIOS RELACIONADOS A USUARIO - OK - OK

$app->options("/usuario/usuario/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});



  $app->post("/usuario/usuario/", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array('creado_por' => $datos->body->id_crm_persona));
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
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }
  });

  //MÉTODO LISTAR USUARIOS RELACIONADOS A COPROPIEDAD - OK - OK

  $app->options("/usuario/copropiedad/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

  $app->post("/usuario/copropiedad/", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad,'estado' => 1));
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
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }
  });
  
  //MÉTODO LISTAR USUARIOS RELACIONADOS A Unidades o clientes - OK - OK

  $app->options("/usuario/unidad/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});


  $app->post("/usuario/unidad/", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array('unidad' => $datos->body->id_unidad,'estado' => 1));
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
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }
  });
  
  

  //MÉTODO LISTAR PROVEEDORES RELACIONADOS A COPROPIEDAD

  $app->options("/usuario/copropiedad/proveedores/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/usuario/copropiedad/proveedores/", function() use($app)
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
          //consultaColeccion($app, 'rolcp', array('id_copropiedad' => $datos->body->id_copropiedad, 'rol' => "proveedor"));
          consultaColeccion($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad));
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
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }
  });
/***************  METODOS DE ROLES  ***************************/
  //METODO CREAR ROL PERSONA - OK - OK

  $app->options("/rol/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/rol/", function() use($app)
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
          enviarInformacion('rolcp', $datos->body, $app);
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

  //MÉTODO BORRAR ROL PERSONA - OK
  /*$app->delete("/rol/", function() use($app)
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
          $dbdata=new DBNosql('rolcp');
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
  });*/

  //MÉTODO MODIFICAR ROL PERSONA - OK
  $app->put("/rol/", function() use($app)
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
          $dbdata=new DBNosql('rolcp');
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

$app->options("/copropiedad/usuarioCopropiedad/rol/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

 //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
  $app->post("/copropiedad/usuarioCopropiedad/rol/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      $resultado = Array();
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          $filter = array('id_crm_persona' => $datos->body->id_crm_persona, "rol" => "residente");
          $roles = objectToArray(consultaColeccionRetorno($app,'rolcp', $filter));
          foreach ($roles as $value) 
          {
            $filter2 = array("_id"=>new MongoId($value["id_copropiedad"]));
            $cp = objectToArray(consultaColeccionRetorno($app,'copropiedad', $filter2));
            $resultado[] = array('_id'=>array('$id' => $value["id_copropiedad"]), "nombre" => $value['nombre'], "color" => $cp[0]["color"], "direccion" => $cp[0]["direccion"]);
          }
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
    }
    catch(Exception $e)
    {
    enviarRespuesta($app, false, "Error", $e->getMessage());
    }
  });

$app->options("/copropiedad/usuarioCopropiedad/rol/modulos/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

 //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
  $app->post("/copropiedad/usuarioCopropiedad/rol/modulos/", function() use($app)
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
          $filter = array("_id"=>new MongoId($datos->body->id_copropiedad));
          $resultado = consultaColeccionRetorno($app, 'copropiedad', array("_id"=>new MongoId($datos->body->id_copropiedad)));
          var_dump($filter);
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
    enviarRespuesta($app, false, "Error", $e->getMessage());
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