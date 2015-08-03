<?php
require_once("/datos/app.copropiedad.co/api/managercp/app/Model/config.php");
require_once("/datos/app.copropiedad.co/api/managercp/app/Model/Token_model.php");
require_once("/datos/app.copropiedad.co/api/managercp/app/Model/Log_model.php");
require_once("/datos/app.copropiedad.co/api/managercp/app/Model/DBNosql_model.php");

/******************************************************************
**          WEB SERVICE ADMINISTRACIÓN DE COPROPIEDAD            **
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
/***************  METODOS DE COPROPIEDAD  ***************************/
  //METODO CREAR COPROPIEDAD - OK - OK
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

  //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
  $app->options("/copropiedad/usuarioCopropiedad/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
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

  //METODO LISTAR TODAS LAS COPROPIEDADES DE TODOS LOS USUARIOS - OK - OK

  $app->options("/copropiedad/usuariosCopropiedad/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/copropiedad/usuariosCopropiedad/", function() use($app)
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
          consultaColeccion($app, 'copropiedad', array('estado' => 1));
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

 //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
  $app->post("/copropiedad/usuarioCopropiedad/Login", function() use($app)
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
          $encuestas = json_decode(json_encode(consultaColeccionRetorno($app, 'usuariocp', array('id_crm_persona' => $datos->body->id_crm_persona))));
          foreach ($encuestas as $value) {
          $id_copropiedad = $value->id_copropiedad;
        }
          consultaColeccion($app, 'copropiedad', array("_id"=>new MongoId($id_copropiedad)));
          var_dump($id_copropiedad);

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

    //MÉTODO LISTAR TODOS LOS USUARIOS DE COPROPIEDAD - OK - OK
  $app->options("/usuarios/copropiedad/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/usuarios/copropiedad/", function() use($app)
  {
   //try
    //{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      $copropiedades_arr = array();
      $usuario_arr = array();
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          $usuarios = consultaColeccionRetorno($app, 'usuariocp', array());
          $copropiedades = consultaColeccionRetorno($app, 'copropiedad', array());
          $new_usuarios = array();
          foreach ($copropiedades as $key => $value) 
          {
            $copropiedades_arr[objectToArray($value)['_id']['$id']] = $value['nombre'];
            //var_dump($copropiedades_arr);
          }
          foreach ($usuarios as $key => $value) 
          {
            $value['id_copropiedad'] = $copropiedades_arr[$value['id_copropiedad']];
            if ($value['estado'] == "1") 
            $value['estado'] = "Activo";
          else
            $value['estado'] = "Inactivo";
            $new_usuarios[] = $value; 
          }
          //var_dump($new_usuarios);
          enviarRespuesta($app, true, $new_usuarios, "null");
          //enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios")
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
    /*}
    catch(Exception $e)
    {
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }*/
  });

  //MÉTODO LISTAR USUARIOS RELACIONADOS A COPROPIEDAD - OK - OK
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

/******************************METODOS PARA REFERENCIAS********************************/
 //METODO CREAR REFERENCIA - OK - OK
  $app->options("/referencias/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/referencias/", function() use($app)
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
          enviarInformacion('referencias', $datos->body, $app);
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

  //MÉTODO BORRAR REFERENCIA - OK
  $app->delete("/referencias/", function() use($app)
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
          $dbdata=new DBNosql('referencias');
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

  //MÉTODO MODIFICAR REFERENCIA - OK
  $app->put("/referencias/", function() use($app)
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
          $dbdata=new DBNosql('referencias');
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

//METODO LISTAR TODAS LAS REFERENCIAS ACTIVAS - OK - OK
  $app->options("/referencias/getlist/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/referencias/getlist/", function() use($app)
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
          consultaColeccion($app, 'referencias', array('estado' => '1', 'online' => "true"));
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

//METODO LISTAR UNA REFERENCIA ESPECIFICA - OK - OK
  $app->options("/referencias/getlist/edit", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/referencias/getlist/edit", function() use($app)
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
          $muestreo=array("_id"=>new MongoId($idGuardado));
          consultaColeccion($app, 'referencias', $muestreo);
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

/******************************METODOS PARA CLIENTES********************************/
 //METODO CREAR CLIENTE - OK - OK
  $app->options("/clientes/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/clientes/", function() use($app)
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
          enviarInformacion('clientes', $datos->body, $app);
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

  //MÉTODO BORRAR CLIENTE - OK
  $app->delete("/clientes/", function() use($app)
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
          $dbdata=new DBNosql('clientes');
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

  //MÉTODO MODIFICAR CLIENTE - OK
  $app->put("/clientes/", function() use($app)
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
          $dbdata=new DBNosql('clientes');
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

//METODO LISTAR TODAS LOS CLIENTES ACTIVOS - OK - OK
  $app->options("/clientes/getlist/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/clientes/getlist/", function() use($app)
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
          consultaColeccion($app, 'clientes', array('estado' => '1'));
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

//METODO LISTAR UN CLIENTE ESPECIFICA EN EDITAR - OK - OK
  $app->options("/clientes/getlist/edit", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/clientes/getlist/edit", function() use($app)
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
          $muestreo=array("_id"=>new MongoId($idGuardado));
          consultaColeccion($app, 'clientes', $muestreo);
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

  /*********************** METODOS PARA CREAR POSIBLES CLIENTES *************************/
 //METODO CREAR POSIBLE CLIENTE - OK - OK
  $app->options("/clientes/preregistro/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/clientes/preregistro/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      /*$token = new Token;
      if($token->SetToken($datos->token))
      {*/
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          enviarInformacion('preregistro', $datos->body, $app);
        }
        else
        {
          enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");
        }
      /*}
      else
      {
        enviarRespuesta($app, false, "Token invalido", "null");
      }*/
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
    }
  });

/********************************** USUARIOS DEMO ******************************************/
  //METODO CREAR USUARIOS DEMO EN TODO COPROPIEDAD - OK - OK
  $app->options("/usuarios_demo/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/usuarios_demo/", function() use($app)
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
          enviarInformacion('usuarios_demo', $datos->body, $app);
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

  //MÉTODO BORRAR USUARIOS DEMO - OK
  $app->delete("/usuarios_demo/", function() use($app)
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
          $dbdata=new DBNosql('usuarios_demo');
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

  //MÉTODO MODIFICAR USUARIOS DEMO - OK
  $app->put("/usuarios_demo/", function() use($app)
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
          $dbdata=new DBNosql('usuarios_demo');
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

//METODO LISTAR TODAS LOS USUARIOS DEMO - OK - OK
  $app->options("/usuarios_demo/getlist/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/usuarios_demo/getlist/", function() use($app)
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
          consultaColeccion($app, 'usuarios_demo', array('estado' => '1'));
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

//METODO LISTAR UN USUARIOS DEMO ESPECIFICA EN EDITAR - OK - OK
/*  $app->options("/usuarios_demo/getlist/edit", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/usuarios_demo/getlist/edit", function() use($app)
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
          $muestreo=array("_id"=>new MongoId($idGuardado));
          consultaColeccion($app, 'usuarios_demo', $muestreo);
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
  });*/

/******************************METODOS PARA VIGENCIA********************************/

  // METODO PARA CREAR OBJETO PAGO - OK - OK
  $app->options("/pagosteleinte/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/pagosteleinte/", function() use($app)
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
            enviarInformacion('pagosteleinte_manager', $datos->body, $app);
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

  //MÉTODO BORRAR OBJETO PAGO - OK
  $app->delete("/pagosteleinte/", function() use($app)
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
          $dbdata=new DBNosql('pagosteleinte_manager');
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

  //MÉTODO MODIFICAR OBJETO PAGO - OK
  $app->put("/pagosteleinte/", function() use($app)
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
          $dbdata=new DBNosql('pagosteleinte_manager');
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

//METODO LISTAR TODOS LOS OBJETOS PAGO - OK - OK
  $app->options("/pagosteleinte/getlist/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/pagosteleinte/getlist/", function() use($app)
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
          consultaColeccion($app, 'pagosteleinte_manager', array('cruzado' => '0'));//'estado' => '1'));
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

//METODO LISTAR OBJETOS PAGO POR COPROPIEDAD- OK - OK
  $app->options("/pagosteleinte/getlist/copropiedad", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/pagosteleinte/getlist/copropiedad", function() use($app)
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
          consultaColeccion($app, 'pagosteleinte_manager', array('id_copropiedad' => $datos->body->id_copropiedad, 'referenceCode' => $datos->body->referenceCode, 'cruzado' => '0' ));//'estado' => '1'));
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

  //MÉTODO PARA DRA VIGENCIA A COPROPIEDAD - OK - OK
  $app->options("/dar_vigencia/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  $app->post("/dar_vigencia/", function() use($app)
  {
   //try
    //{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      $copropiedades_arr = array();
      $usuario_arr = array();
      $today = date("Y-m-d");
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          $pago = objectToArray(consultaColeccionRespuesta($app, 'pagosteleinte_manager',  array('id_copropiedad' => $datos->body->id_copropiedad, 'referenceCode' => $datos->body->referenceCode, 'cruzado' => '0' )))[0];
          //var_dump($pago);
          $referencias= objectToArray(consultaColeccionRespuesta($app, 'referencias',  array('id_ref' => $pago['referencia_activa'])))[0];
          //var_dump($referencias);
          $tiempo= '+'.$referencias['time_ref'].' month';
          $copropiedades = consultaColeccionRespuesta($app, "copropiedad", array('_id'=> new MongoId($datos->body->id_copropiedad)))[0];
          $fecha_fin= (date('Y-m-d', strtotime ($tiempo , strtotime ($copropiedades['vigencia']))));

          $filtro=array('_id'=> new MongoId($datos->body->id_copropiedad));
          $modificador=array('$set'=>array("vigencia"=>$fecha_fin, "referencia"=>$referencias['id_ref']));
          
          $dbdata = new DBNosql('copropiedad');
          $resultpagos = $dbdata->updateDocument($filtro,$modificador);

          $filtro2=array('referenceCode'=> $datos->body->referenceCode, "id_copropiedad"=>$datos->body->id_copropiedad);
          $modificador2=array('$set'=>array("cruzado"=>"1", "referencia_activa"=>$referencias['id_ref']));
          $dbdata2 = new DBNosql('pagosteleinte_manager');
          $resultpagos2 = $dbdata2->updateDocument($filtro2,$modificador2);
          if ($resultpagos2 && $resultpagos){enviarRespuesta($app, true, $resultpagos2, "null");}
          else {enviarRespuesta($app, true, null, null);}
          //var_dump($resultpagos2);
          //var_dump($modificador);
          //var_dump($modificador2);
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
    /*}
    catch(Exception $e)
    {
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }*/
  });

  //MÉTODO LISTAR COPROPIEDADES RELACIONADAS A USUARIO - OK - OK
  $app->post("//", function() use($app)
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
    enviarRespuesta($app, false, "Error en el sistema de autenticación", $e->getMessage());
    }
  });
  /*********************** MÉTODOS PARA SOPORTE ***************************/
  $app->options("/casos/insertar", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

/*$app->post("/casos/insertar", function() use($app)
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
        date_default_timezone_set('America/Bogota');
        $today = date("c");
        $datos->body->fecha_creacion = $today; 
        $datos->body->estado = "Abierto"; 
        switch ($datos->body->item_type)
        {
          case 'casos-soporte':
            enviarInformacion('casos-soporte', $datos->body, $app);
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
});*/

// MÉTODO PARA LISTAR TODOS LOS CASOS DE SOPORTE EN MANAGER
$app->options("/casos/listar", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/casos/listar", function() use($app)
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
        switch ($datos->body->item_type)
        {
          case 'casos-soporte':         
              consultaColeccion($app, 'casos-soporte', array());
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

//MÉTODO PARA LISTAR CASO DE PORTE POR ID -* NO TOCAR
$app->options("/casos/getlist/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

$app->post("/casos/getlist/", function() use($app)
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
        switch ($datos->body->item_type)
        {
          case 'casos-soporte':         
              consultaColeccionFiltro($app, "casos-soporte", array('_id'=> new MongoId($datos->body->_id)));
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

//MÉTODO PARA COMPLETAR EL CASO DE MANAGER
$app->put("/casos/listar", function() use($app)
{
  try
  {
    date_default_timezone_set('America/Bogota');
    $today = date("c");
    $requerimiento = $app::getInstance()->request();
    $datos = json_decode($requerimiento->getBody());    
    $datos->body->fecha_cierre = $today; 
    $token = new Token;
    $tokenValidado = $token->SetToken($datos->token);
    //var_dump($tokenValidado);
    if($tokenValidado)
    {
      $validateUsuario=validateRole();
      if ($validateUsuario)
      {
        switch ($datos->body->item_type)
        {
          case 'casos-soporte':
            $idGuardado=$datos->body->id;
            unset($datos->body->id);
            $muestreo=array("_id"=>new MongoId($idGuardado));
            $dbdata=new DBNosql('casos-soporte');
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

$app->delete("/casos/listar", function() use($app)
{
  try
  {
    $requerimiento = $app::getInstance()->request();
    $datos = json_decode($requerimiento->getBody());
    $token = new Token;
    $tokenValidado = $token->SetToken($datos->token);
    $result = "";
    if($tokenValidado)
    {
      $validateUsuario=validateRole();
      if ($validateUsuario)
      {
        $dbdata = new DBNosql('casos-soporte');
        $modificador=array('$set'=>array("estado"=>"Cerrado"));
        $muestreo = array("_id"=>new MongoId($datos->body->id));
        $result = $dbdata->updateDocument($muestreo,$modificador);
        if ($result){enviarRespuesta($app, true, $modificador, $datos->body->id);}
        else {enviarRespuesta($app, true, null, null);}
      }
      else{enviarRespuesta($app, false, "Usuario sin privilegios", "Usuario sin privilegios");}
    }
    else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
  }
  catch(Exception $e)
  {
    echo "Error: " . $e->getMessage();
    enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
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

function consultaColeccionRespuesta($app, $coleccion, $arreglo)
{
  $dbdata = new DBNosql($coleccion);  
  $resultado = $dbdata->selectDocument($arreglo); 
  if ($resultado){return $resultado;}
  else {enviarRespuesta($app, true, null, null);}
}
