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
          $admins = objectToArray(consultaColeccionRespuesta($app, 'superadmin', array('id_crm_persona' => (int)$datos->body->id_crm_persona)))[0];
          //var_dump($admins);
          if(count($admins) == 4)
          {
            $adminscp = explode(",",$admins["ids"]);
            //var_dump($adminscp);
            consultaColeccion($app, 'copropiedad', array('id_crm_persona' => array('$in' => $adminscp),'estado' => 1));
          }
          else
          {
            consultaColeccion($app, 'copropiedad', array('id_crm_persona' => $datos->body->id_crm_persona,'estado' => 1));
          }
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

  $app->options("/copropiedad/usuarioCopropiedad/vigencias/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

    //METODO LISTAR COPROPIEDADES ASOCIADAS A USUARIO - OK - OK
    $app->post("/copropiedad/usuarioCopropiedad/vigencias/", function() use($app)
    {
      try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
          $_idssearch = $datos->body->cp;
          foreach($_idssearch as $separateIds){
              $_ids[] = new MongoId($separateIds);
          }
          date_default_timezone_set('America/Bogota');
          $today = date("Y-m-d");
          $today = strtotime($today . ' -1 day');
          consultaColeccion($app, 'copropiedad', array("_id" => array('$in' => $_ids),'estado' => 1,'vigencia'=>array('$gte' => $today)));
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

  $app->options("/usuario/grupo/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });


    $app->post("/usuario/grupo/", function() use($app)
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
            consultaColeccion($app, 'usuariocp', array('grupo' => $datos->body->grupo, 'id_copropiedad' => $datos->body->idcopropiedad));
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
   //try
    //{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          $roles = objectToArray(consultaColeccionRespuesta($app, 'rolcp', array('correo' => $datos->body->correo)));
          $userroles = obtenerIdCP($roles);

          $ids = array();
          foreach($userroles as $separateIds){
              $ids[] = new MongoId($separateIds);
          }

          $cps = agregaRoles(filtrarVigencia(objectToArray(consultaColeccionRespuesta($app, 'copropiedad', array("_id" => array('$in' => $ids),'estado' => 1)))),$roles);
          //var_dump($cps);
          enviarRespuesta($app, true, $cps, null);
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
      enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
    }*/
  });

//METODO BUSCAR PERSONA POR ID PERSONA - OK - OK
  $app->options("/usuario/personacrm/eliminar/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->put("/usuario/personacrm/eliminar/", function() use($app)
  {
    try
     {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtror = array('id_crm_persona'=> array('$in'=> $datos->body->personas));
        // $prueba=consultaColeccionRetorno($app,"rolcp",$filtror);
        // var_dump($prueba);
        // var_dump(json_encode($filtror));
        // exit;
        $modificador=array('$set'=>array("estado"=>"2"));
        $dbdata = new DBNosql('rolcp');
        $result = $dbdata->updateDocumentEspecial($filtror,$modificador);
        if ($result){enviarRespuesta($app, true, $result, "null");}
        else {enviarRespuesta($app, true, null, null);}
      }
     }
     catch(Exception $e)
     {
     enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
     }
  });

$app->options("/usuario/personamasa/eliminar/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->put("/usuario/personamasa/eliminar/", function() use($app)
  {
    try
     {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtror = array('id_crm_persona'=>(int)$datos->body->personas,'unidad'=>$datos->body->id_unidad);
        $modificador=array('$set'=>array('estado'=>2));
        $dbdata = new DBNosql('usuariocp');
        $result = $dbdata->updateDocumentEspecial($filtror,$modificador);
        if ($result){enviarRespuesta($app, true, $result, "null");}
        else {enviarRespuesta($app, true, null, null);}
      }
     }
     catch(Exception $e)
     {
     enviarRespuesta($app, false, "Error de autenticación", $e->getMessage());
     }
  });

$app->options("/usuario/persona/eliminar/", function() use($app)
{
  enviarRespuesta($app, true, "ok", "ok");
});

$app->delete("/usuario/persona/eliminar", function() use($app)
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
        $muestreo=array("id_crm_persona"=>(int)$datos->body->id_crm_persona,"id_unidad"=>$datos->body->id_unidad);
        $dbdata=new DBNosql('rolcp');                    
        $result=$dbdata->removeDocument($muestreo);
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

//MÉTODO LISTAR USUARIOS ENCARGADOS RELACIONADOS A Unidades- OK - OK
  $app->options("/usuario/copropiedad/encargado/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });


  $app->post("/usuario/copropiedad/encargado/", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array("unidad"=>$datos->body->unidad,'estado' => 1,'principal'=>true));
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
    enviarRespuesta($app, false, "Error en el sistema usuarios", $e->getMessage());
    }
  });


//MÉTODO MODIFICAR USUARIOS ENCARGADOS OK- OK
  $app->options("/usuario/copropiedad/encargadomodificar/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });


  $app->post("/usuario/copropiedad/encargadomodificar/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $muestreo=array("_id"=>new MongoId($datos->body->mongoid));
        $dbdata=new DBNosql('usuariocp');
        $modificador=array('$set'=>array("principal"=>$datos->body->principal));
        
        $result=$dbdata->updateDocument($muestreo,$modificador);
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
    enviarRespuesta($app, false, "Error en el sistema usuarios", $e->getMessage());
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
  
 //MÉTODO LISTAR USUARIOS PRINCIPALES RELACIONADOS A COPROPIEDAD A - OK - OK
  $app->options("/usuario/copropiedad/principal", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/usuario/copropiedad/principal", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad,'unidad'=>$datos->body->unidad,'estado' => 1, 'principal'=>true));
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

  $app->options("/usuario/copropiedad/principales/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/usuario/copropiedad/principales/", function() use($app)
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
          consultaColeccion($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad,'estado' => 1, 'principal'=>true));
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


  //MÉTODO LISTAR USUARIOS RELACIONADOS A COPROPIEDADES - OK - OK
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
  
  
//MÉTODO LISTAR USUARIOS RESIDENTE EN COPROPIEDADES (DIRECTORIO)- OK - OK
  $app->options("/usuario/residente/directorio/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });


  $app->post("/usuario/residente/directorio/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      $respuesta = array();
      if($token->SetToken($datos->token))
      {
        $validateUsuario=validateRole();
        if ($validateUsuario)
        {
          $usuarios = consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad,'estado' => 1, 'tipo'=>'residente'));
          foreach ($usuarios as $key => $value) 
          {
            $idGuardado = $value['unidad'];
            $muestreo = array("_id"=>new MongoId($idGuardado));
            $unidad = objectToArray(consultaColeccionRetorno($app, 'unidad', $muestreo));
            $value['unidad'] = $unidad[0]['nombre_inmueble'];
            $respuesta[]= $value;
          }
          enviarRespuesta($app, true, $respuesta, null); 
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
  
  //MÉTODO LISTAR PROVEEDORES EN COPROPIEDADES (DIRECTORIO)- OK - OK
    $app->options("/usuario/proveedor/directorio/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });


    $app->post("/usuario/proveedor/directorio/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        $respuesta = array();
        if($token->SetToken($datos->token))
        {
          $validateUsuario=validateRole();
          if ($validateUsuario)
          {
            $usuarios = consultaColeccionRetorno($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad,'estado' => 1, 'tipo'=>'proveedor'));
            foreach ($usuarios as $key => $value) 
            {
              $idGuardado = $value['unidad'];
              $muestreo = array("_id"=>new MongoId($idGuardado));
              $unidad = objectToArray(consultaColeccionRetorno($app, 'unidad', $muestreo));
              $value['unidad'] = $unidad[0]['nombre_inmueble'];
              $respuesta[]= $value;
            }
            enviarRespuesta($app, true, $respuesta, null); 
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
      enviarRespuesta($app, false, "Error en el sistema de autenticacion", $e->getMessage());
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
          consultaColeccion($app, 'usuariocp', array('id_copropiedad' => $datos->body->id_copropiedad,"estado" => 1));
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

  $app->put("/usuario/copropiedad/proveedores/", function() use($app)
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

// METODO RETORNA DIAS VIGENCIA  
  $app->options("/diasvigencia/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/diasvigencia/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $dias = 7;
        $cps = objectToArray(consultaColeccionRespuesta($app, 'copropiedad', array("id_crm_persona"=>(String)$datos->body->id_crm_persona)));
        $estado = objectToArray(consultaColeccionRespuesta($app, 'estadocp', array("id_crm_persona"=>(int)$datos->body->id_crm_persona)))[0];
        if($estado["estado"] == 2 || $estado["estado"] == 1)
          if(count($cps) == 0)
          {
            $dias = 45;
            $ispre = objectToArray(consultaColeccionRespuesta($app, 'preregistro', array("email"=>$datos->body->email)));
            if(count($ispre) != 0)
            {
              $dias = 90;
            }
          }
        enviarRespuesta($app, true, $dias, "null");
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

function obtenerIdCP($cps)
{
  $out = array();
  if(count($cps) > 0)
  foreach ($cps as $key => $value) 
  {
    $out[] = $value['id_copropiedad'];
  }
  return $out;
}

function filtrarVigencia($cps)
{
  date_default_timezone_set('America/Bogota');
  $first_date = strtotime(date("c"));
  $today = strtotime('-1 day', $first_date);
  $today = date("c",$today);
  $out = array();
  $out["activas"] = array();
  $out["vencidas"] = array();

  if(count($cps) > 0)
  foreach ($cps as $key => $value) 
  {
    if(date($value["vigencia"]) > $today)
    {
      $out['activas'][] = $value;
    }
    else
    {
      $out['vencidas'][] = $value;
    }
  }

  return $out;
}

function agregaRoles($cps,$roles)
{ 
  $out = array();
  $out["activas"] = array();
  $out["vencidas"] = array();

  if(count($cps) > 0)
  foreach ($cps as $x => $y) 
  {
    foreach ($y as $key => $value) 
    {
      $elem = $value;
      $elid = $value['_id']['$id'];
      $thisid = $elid;
      foreach ($roles as $k => $v) 
      {
        if($v['id_copropiedad'] == $thisid)
        {
          $elem['rol'] = $v['rol'];
          $out[$x][] = $elem;
        }
      }
    }
  }

  return $out;
}