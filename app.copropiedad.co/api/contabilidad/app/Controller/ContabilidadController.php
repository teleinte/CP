<?php
require_once("app/Model/config.php");
require_once("app/Model/Token_Model.php");
require_once("app/Model/Log_Model.php");
require_once("app/Model/DBNosql_Model.php");

/**************************************************************************
**                          WEB SERVICE CONTABILIDAD                     **
**                           2014 - TELEINTE S.A.S.                      **
**                          AUTOR: GERMAN VELASQUEZ                      **
/*************************************************************************/

//METODOS DE AUTENTICACION

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

//METODOS DE INSERCION

  //METODO CREAR TRANSACCIÓN - OK - OK
  $app->options("/transaccion/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/transaccion/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        if (validarFechaActiva($datos->body->id_copropiedad, $app, $datos->body->year, $datos->body->mes))
          enviarInformacion('cont_'.$datos->body ->id_copropiedad, $datos->body, $app);
        else
          enviarRespuesta($app, false, "Periodo cerrado previamente", "null");
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

  //METODO CREAR TRANSACCIÓN - OK - OK
  $app->options("/obtener/transacciones/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/obtener/transacciones/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "transaccion"));
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
  
  //METODO MODIFICAR TRANSACCIÓN - VALIDAR
  $app->put("/transaccion/", function() use($app)
  {
   try
  	{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          if (validarFechaActiva($datos->body->id_copropiedad, $app, $datos->body->year, $datos->body->mes))
          {
              $idGuardado=$datos->body->id;
              unset($datos->body->id);
              $muestreo=array("_id"=>new MongoId($idGuardado));
              $dbdata=new DBNosql('cont_'.$datos->body->idcopropiedad);
              $array = json_decode(json_encode($datos), true);						
              $result=$dbdata->updateDocument($muestreo, $datos->body);
              if ($result){enviarRespuesta($app, true, $result, "null");}
              else {enviarRespuesta($app, true, null, null);}
          }
          else
            enviarRespuesta($app, false, "Periodo cerrado previamente", "null");
      }
      else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
  	}
  	catch(Exception $e)
  	{
  		//echo "Error: " . $e->getMessage();
  		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
  	}
  });

  //METODO MODIFICAR TRANSACCIÓN - VALIDAR
  $app->put("/anular/transaccion/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          if (validarFechaActiva($datos->body->id_copropiedad, $app, $datos->body->year, $datos->body->mes))
          {
            $idGuardado=$datos->body->mongoid;
            $aidi = $idGuardado;
            unset($datos->body->mongoid);
            $muestreo=array("_id"=>new MongoId($idGuardado));
            $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
            $array = json_decode(json_encode($datos), true);

            $modificador=array('$set'=>array("anulado"=>"SI"));
            
            $result=$dbdata->updateDocument($muestreo,$modificador);
            if ($result){enviarRespuesta($app, true, $result, 'null');}
            else {enviarRespuesta($app, true, null,"no result");}
          }
          else
            enviarRespuesta($app, false, "Periodo cerrado previamente", "null");
      }
      else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
    }
    catch(Exception $e)
    {
      //echo "Error: " . $e->getMessage();
      enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
    }
  });

  //METODO CREAR REGISTRO - OK - OK
  $app->options("/registro/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/registro/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        if (validarFechaActiva($datos->body->id_copropiedad, $app, $datos->body->year, $datos->body->month))
          {
            enviarInformacion('cont_'.$datos->body->id_copropiedad, $datos->body, $app);
            $today = date("Y/m/d");
            $tipo_doc = substr($datos->body->id_transaccion,0,2);
            $tipomov = $datos->body->tipo;
            if($tipomov == "D" && $tipo_doc=="CC")
              creaCargo($today, $datos->body->monto, $datos->body->id_tercero, $datos->body->concepto, $datos->body->id_transaccion, $app, $datos->body->id_copropiedad);
          }
        else
          enviarRespuesta($app, false, "Periodo cerrado previamente", "null");
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

  //METODO CREAR REGISTRO DE SERVICIO PUBLICOS- OK - OK
  $app->options("/serviciospublicos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/serviciospublicos/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        enviarInformacion('cont_'.$datos->body->id_copropiedad, $datos->body, $app);
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
  
  //METODO OBTENER REGISTRO DE SERVICIO PUBLICOS - OK - OK
  $app->options("/obtener/serviciospublicos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/obtener/serviciospublicos/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "serviciospublicos"));
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

  //METODO ELIMINAR REGISTRO - VALIDAR
  $app->delete("/registro/", function() use($app)
  {
   try
  	{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          if (validarFechaActiva($datos->body->id_copropiedad, $app, $datos->body->year, $datos->body->mes))
          {
            $result = eliminaDocumento();
            if ($result){enviarRespuesta($app, true, $result, "null");}
            else {enviarRespuesta($app, true, null, null);}
          }
          else
            enviarRespuesta($app, false, "Periodo cerrado previamente", "null");
      }
      else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
  	}
  	catch(Exception $e)
  	{
  		//echo "Error: " . $e->getMessage();
  		enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
  	}
  });

  //METODO CREAR TRANSACCIÓN - OK - OK
  $app->options("/obtener/registros/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/obtener/registros/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "registrocontable", "id_transaccion" => $datos->body->idtransaccion));
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

  //METODO CREAR CONFIGURACION - OK - OK
  $app->options("/configuracion/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/configuracion/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;      
      if($token->SetToken($datos->token))
      {
        enviarInformacion('cont_'.$datos->body->id_copropiedad, $datos->body, $app);
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

  //METODO OBTENER CONFIGURACION - OK - OK
  $app->options("/obtener/configuracion/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/obtener/configuracion/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;      
      if($token->SetToken($datos->token))
      {
        consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "configuracion"));
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

   //METODO OBTENER CONFIGURACION - OK - OK
  $app->options("/obtener/consecutivos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/obtener/consecutivos/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;      
      if($token->SetToken($datos->token))
      {
        consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "consecutivos"));
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

  //METODO MODIFICAR CONFIGURACION - OK - OK
  $app->put("/configuracion/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        enviarInformacion('cont_'.$datos->body->id_copropiedad, $datos->body, $app);
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

  //METODO CREAR SALDOS INICIALES - OK - OK
  $app->options("/saldosiniciales/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/saldosiniciales/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          enviarInformacion('cont_'.$datos->body ->id_copropiedad, $datos->body, $app);
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
  //METODO CREAR INFORMACION DE EMPRESA - OK - OK
  $app->options("/infoempresa/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/infoempresa/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        enviarInformacion('cont_'.$datos->body ->id_copropiedad, $datos->body, $app);
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
  
  //METODO MODIFICAR INFORMACION DE EMPRESA - VALIDAR
  $app->put("/infoempresa/edit/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
              $idGuardado=$datos->body->id;
              unset($datos->body->id);
              $muestreo=array("_id"=>new MongoId($idGuardado));
              $dbdata=new DBNosql('cont_'.$datos->body->idcopropiedad);
              $array = json_decode(json_encode($datos), true);            
              $result=$dbdata->updateDocument($muestreo, $datos->body);
              if ($result){enviarRespuesta($app, true, $result, "null");}
              else {enviarRespuesta($app, true, null, null);}
      }
      else{enviarRespuesta($app, false, "Token invalido", "Token invalidos");}
    }
    catch(Exception $e)
    {
      //echo "Error: " . $e->getMessage();
      enviarRespuesta($app, false, "Error Los Datos de la lista no concuerdan", $e->getMessage());
    }
  });

  //METODO CREAR PUC - OK - OK
  $app->options("/puc/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/puc/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;      
      if($token->SetToken($datos->token))
      {
        enviarInformacion('cont_'.$datos->body->id_copropiedad, $datos->body, $app);
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

  //METODO OBTENER PUC - OK - OK
  $app->options("/obtener/puc/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/obtener/puc/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;      
      if($token->SetToken($datos->token))
      {
        consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "puc"));
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

  //METODO ACTUALIZAR PUC  - OK
  $app->put('/puc/', function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $idGuardado=$datos->body->mongoid;
        $aidi = $idGuardado;
        unset($datos->body->mongoid);
        $muestreo=array("_id"=>new MongoId($idGuardado));
        $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
        $array = json_decode(json_encode($datos), true);

        $modificador=array('$set'=>array("puc.".$datos->body->base.".nombre"=>$datos->body->nombre));
        
        $result=$dbdata->updateDocument($muestreo,$modificador);
        if ($result){enviarRespuesta($app, true, $result, 'null');}
        else {enviarRespuesta($app, true, null,"no result");}
      }
      else
      {
        enviarRespuesta($app, false, 'Token invalido', 'null');
      }
    }
    catch(Exception $e)
    {
    enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });

  //METODO CREAR CUENTA PUC  - OK
  $app->put('/creaCuenta/', function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $idGuardado=$datos->body->mongoid;
        $aidi = $idGuardado;
        unset($datos->body->mongoid);
        $muestreo=array("_id"=>new MongoId($idGuardado));
        $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
        unset($datos->body->id_copropiedad);
        unset($datos->body->tipo_documento);
        $array = json_decode(json_encode($datos), true);            
        //$mierda=array('$set'=>array("puc.0.nombre"=>"Jairo"));
        $daticos=$datos->body;
        $modificador=array('$addToSet'=>array("puc"=>$daticos));
        //var_dump($mierda);
        $result=$dbdata->updateDocument($muestreo,$modificador);
        if ($result){enviarRespuesta($app, true, $result, 'null');}
        else {enviarRespuesta($app, true, null,"no result");}
      }
      else
      {
        enviarRespuesta($app, false, 'Token invalido', 'null');
      }
    }
    catch(Exception $e)
    {
    enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });

  //METODO ACTUALIZAR CONSECUTIVOS  - OK
  $app->put('/actualiza/consecutivo/', function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $consecutivos = objectToArray(json_decode(json_encode(consultaColeccionRetorno($app, 'cont_'.$datos->body->id_copropiedad, array("tipo_documento"=>"consecutivos"))))[0]);
        $consecutivos[$datos->body->tipodoc] = $consecutivos[$datos->body->tipodoc] + 1;
        $idGuardado=$consecutivos["_id"]['$id'];
        unset($consecutivos["_id"]);
        $muestreo=array("_id"=>new MongoId($idGuardado));
        $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
        $array = json_decode(json_encode($datos), true);
        $result=$dbdata->updateDocument($muestreo,$consecutivos);
        if ($result){enviarRespuesta($app, true, $result, 'null');}
        else {enviarRespuesta($app, true, null,"no result");}
      }
      else
      {
        enviarRespuesta($app, false, 'Token invalido', 'null');
      }
    }
    catch(Exception $e)
    {
    enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });

//METODOS PARA GENERAR BALANCES
  
//GENERAR EL BALANCE DE PRUEBA - OK - OK
  $app->options("/balance/prueba/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/balance/prueba/", function() use($app)
  {
   try
   {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $id_copropiedad = $datos->body->id_copropiedad;
        $respuesta = balancePrueba($id_copropiedad, $app);
        enviarRespuesta($app, true, $respuesta, "null");
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

  //GENERAR EL BALANCE DE PRUEBA POR PERIODOS- OK - OK
  $app->options("/balance/prueba/periodo/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/balance/prueba/periodo/", function() use($app)
  {
    /*
    {
      "token":"J2QK6Szd8yfjNCtzXGTnrG0NMdBKNp9dP7XMHZyOUUs=",
      "body":
        {
          "id_copropiedad":"54875d6e5255c8702f1d137d",
          "year":"2014",
          "month":"03"
        }
    }
    */
    try
    {
       $requerimiento = $app::getInstance()->request();
       $datos = json_decode($requerimiento->getBody());
       $token = new Token;
       if($token->SetToken($datos->token))
       {
         $id_copropiedad = $datos->body->id_copropiedad;
         $year = $datos->body->year;
         $month = $datos->body->month;
         //$respuesta = generaBalancePeriodo($id_copropiedad, $year, $month, $app);
         $respuesta = balancePruebaPeriodo($id_copropiedad, $year, $month, $app);
         enviarRespuesta($app, true, $respuesta, "null");
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

  //GENERAR EL BALANCE DE PRUEBA CON TERCEROS - OK - OK
  $app->options("/balance/prueba/terceros/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/balance/prueba/terceros/", function() use($app)
  {
    try
    {
       $requerimiento = $app::getInstance()->request();
       $datos = json_decode($requerimiento->getBody());
       $token = new Token;
       if($token->SetToken($datos->token))
       {
         $id_copropiedad = $datos->body->id_copropiedad;
         $bprueba = balancePrueba($id_copropiedad, $app);
         $bpruebat = balancePruebaTerceros($id_copropiedad, $app);
         //enviarRespuesta($app, false, $bpruebat, "null");
         $respuesta = unirBalances($bprueba, $bpruebat, true);
         enviarRespuesta($app, false, $respuesta, "null");
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

  //GENERAR EL BALANCE GENERAL - OK - OK
  $app->options("/balance/general/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/balance/general/", function() use($app)
  {
   try
   {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          $id_copropiedad = $datos->body->id_copropiedad;
          $respuesta = balancePrueba($id_copropiedad, $app);
          $respuesta = balanceGeneral($respuesta);
          enviarRespuesta($app, false, $respuesta, "null");
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

  //GENERAR EL ESTADO DE RESULTADOS - OK - OK
  $app->options("/estado/resultados/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/estado/resultados/", function() use($app)
  {
   try
   {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          $id_copropiedad = $datos->body->id_copropiedad;
          $respuesta = balancePrueba($id_copropiedad, $app);
          $respuesta = estadoResultados($respuesta);
          enviarRespuesta($app, false, $respuesta, "null");
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

// METODOS PARA GENERAR CIERRES DE PERIODO

  //GENERAR EL CIERRE DE PERIODO ANUAL - OK - OK - VALIDAR SI SERIA BUENO GENERAR BALANCES AL GUARDAR EL CIERRE
  $app->options("/cierre/periodo/anual/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/cierre/periodo/anual/", function() use($app)
  {
   try
   {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          $id_copropiedad = $datos->body->id_copropiedad;
          $this_year = $datos->body->year;
          $respuesta = organizaCierreAnual(generaAcumulado(balancePrueba($id_copropiedad, $app)));
          date_default_timezone_set('America/Bogota');
          $today = date("c");
          $data = array("fecha_cierre" => $today, "tipo_documento"=>"cierreanual", "periodo"=>$this_year, "cierre" => $respuesta);
          enviarInformacion('cont_'.$id_copropiedad, $data, $app);
          $adicionaCierre = agregaCierre($id_copropiedad, "anual", $datos->body->year, $app);
          $iniciaCierre = mueveDocumentos($datos->body->year, $id_copropiedad, $app);
          enviarRespuesta($app, true, "Periodo cerrado con exito", "null");
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

  //GENERAR EL CIERRE DE PERIODO MENSUAL - OK - OK
  $app->options("/cierre/periodo/mensual/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/cierre/periodo/mensual/", function() use($app)
  {
   try
   {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
          $id_copropiedad = $datos->body->id_copropiedad;
          $this_year = $datos->body->year;
          $this_month = $datos->body->month;
          $adicionaCierre = agregaCierre($id_copropiedad, "periodo", $month.",".$year, $app);
          enviarRespuesta($app, true, $respuesta, "null");
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

//METODOS PARA LOG
  
  //METODO CONSTRUIR LOG DE TRANSACCION NUEVA - OK - OK
  $app->options("/loggenerate/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post("/loggenerate/", function() use($app)
  {
   try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {        
          //primero traer los datos de la transaccion
          $transacciones= json_decode(json_encode(consultaColeccionRetorno($app, 'transaccion', array("_id"=>new MongoId($datos->body->id_transaccion)))));
          $cuentasclaras= json_decode(json_encode(consultaColeccionRetorno($app, 'cuenta', array("id_transaccion"=>$datos->body->id_transaccion))));
          $elem = array();
          date_default_timezone_set('America/Bogota');
          $today = date("c");
          foreach ($transacciones[0] as $key => $value) 
          {
            //echo "\n".$key;
            $elem['fecha_log']=$today;
            $elem['id_transaccion']=$datos->body->id_transaccion;
            if($key==="id_crm_persona") $elem['id_crm_persona']=$value;
            if($key==="idcopropiedad") $elem['idcopropiedad']=$value;
            if($key==="fecha_creacion") $elem['fecha_creacion']=$value;
            if($key==="fecha") $elem['fecha']=$value;
            if($key==="tipo") $elem['tipo']=$value;
            if($key==="nombre_tercero") $elem['nombre_tercero']=$value;
            if($key==="tipo_documento_tercero") $elem['tipo_documento_tercero']=$value;
            if($key==="código_tercero") $elem['código_tercero']=$value;
            if($key==="direccion_tercero") $elem['direccion_tercero']=$value;
            if($key==="telefono_tercero") $elem['telefono_tercero']=$value;
            if($key==="movil_tercero") $elem['movil_tercero']=$value;
            if($key==="ciudad_tercero") $elem['ciudad_tercero']=$value;            
            if($key==="email_tercero") $elem['email_tercero']=$value;
            if($key==="concepto_documento") $elem['concepto_documento']=$value;
            if($key==="moneda") $elem['moneda']=$value;
            if($key==="vendedor_fv") $elem['vendedor_fv']=$value;
            if($key==="forma_pago") $elem['forma_pago']=$value;
            if($key==="notas") $elem['notas']=$value;
            if($key==="anulado") $elem['anulado']=$value;
            $elem['cuentas']=$cuentasclaras;
          }
         enviarInformacion('logtransaccion', $elem, $app); 
          //$encuestas[0]['cuentas']=$otros;
          //array_push($encuestas, $otros);
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

//FUNCIONES PARA INTERACCION CON BASE DE DATOS Y ENVIO DE RESPUESTAS
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

  function consultaColeccionRetorno($app, $coleccion, $arreglo)
  {
    $dbdata = new DBNosql($coleccion);  
    $resultado = $dbdata->selectDocument($arreglo); 
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

  function eliminaDocumento($id_doc,$coleccion)
  {
    $dbdata=new DBNosql($coleccion);
    return $dbdata->removeDocumentByID($id_doc);
  }

  function modificaDocumento($doc, $fields, $coleccion, $completo = true)
  {
    $aidi = $doc["_id"]['$id'];

    if(!$completo)
      foreach ($fields as $k => $v) 
      {
        if(array_key_exists($k, $doc))
          $doc[$k] = $v;
      }

    unset($doc['_id']);
    $muestreo = array("_id"=>new MongoId($aidi));
    $dbdata = new DBNosql($coleccion);         
    $result = $dbdata->updateDocument($muestreo, $doc);

    return $result;
  }

//FUNCIONES DE VALIDACION
  function validarFechaActiva($id_copropiedad, $appl, $year, $month)
  {
    $cierres = obtieneCierres($appl, $id_copropiedad);
    //var_dump($cierres);
      if(count($cierres) > 0)
      {
        if(array_key_exists($year, $cierres['anual']))
          return false;
        elseif(array_key_exists($year.$month, $cierres['periodo']))
          return false;
        else
          return true;
      }
      else
        return true;
  }

//FUNCIONES AUXILIARES
  function convertMongoIds(array &$array)
  {
      foreach ($array as &$element){
          if (is_array($element)){
              convertMongoIds($element);
          }else if (is_object($element) && get_class($element) == "MongoId"){
              return (string) $element;
          }
      }
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

//FUNCIONES PARA LOGICA DE NEGOCIO
  function obtieneCierres($app, $id_copropiedad)
  {
    $res=json_decode(json_encode(consultaColeccionRespuesta($app, 'cont_'.$id_copropiedad, array('tipo_documento'=>'cierres'))));
    $result = array();
    for ($i=0; $i < count($res); $i++)
    {
      $obj = objectToArray($res[$i]);
      foreach ($obj as $key => $value) 
      {
        if($key == 'cierre_anual')
        {
          foreach ($value as $k => $val) 
          {
            $result['anual'][$val] = "OK"; 
          }
        }
        elseif($key == 'cierre_periodo')
        {
          foreach ($value as $k => $val) 
          {
            $result['periodo'][$val] = "OK"; 
          }
        }

      }
    }
    return $result;
  }

  function obtieneUltimoCierreAnual($app, $id_copropiedad)
  {
    $ultimoCierre = obtieneCierres($app, $id_copropiedad);
    $result = 0;
    if(count($ultimoCierre) > 0)
      foreach ($ultimoCierre as $key => $value) 
      {
        foreach ($value as $k => $item)
          if((double)$k > $result)
          {
            $result = (double)$k;
          }
      }
    return $result;
  }

  function filtraCierreAnual($cierre, $cuentainicial)
  {
    $out = array();

    $ctas = objectToArray($cierre)[0]["cierre"];

    if(count($cierre) > 0)
    foreach ($ctas as $cta)
    {
      if (0 === strpos((string)$cta["cuenta_puc"], (string)$cuentainicial))
      {
        $out[] = $cta;
      }
    } 

    return $out;
  }

  function filtraSaldos($saldos, $cuentainicial)
  {
    $out = array();

    $ctas = objectToArray($saldos)[0]["cuentas"];

    if(count($saldos) > 0)
    foreach ($ctas as $cta)
    {
      if (0 === strpos((string)$cta["cuenta_puc"], (string)$cuentainicial))
      {
        $out[] = $cta;
      }
    } 

    return $out;
  }

  function obtieneMeses($month)
  {
    $meses = array(1,2,3,4,5,6,7,8,9,10,11,12);
    $out = array();
    foreach ($meses as $key => $val) 
    {
      if($val <= $month)
        if($val < 10)
          $out[] = "0".(string)$val;
        else
          $out[] = (string)$val;
    }
    return $out;
  }

//FUNCIONES PARA BALANCE DE PRUEBA
  function balancePrueba($idcopropiedad, $appl)
  {
    $rta = array();
    $ultAno = obtieneUltimoCierreAnual($appl, $idcopropiedad);
    $cierreano = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno))));
    $saldoinicial = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"saldosiniciales"))));
    /*var_dump(count($cierreano));
    var_dump(count($saldoinicial));
    var_dump($ultAno);
    var_dump(array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno));
    exit;*/

    $tipo1 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^1/")))));
    $tipo2 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^2/")))));
    $tipo3 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^3/")))));
    $tipo4 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^4/")))));
    $tipo5 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^5/")))));
    $tipo6 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^6/")))));
    $tipo7 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^7/")))));
    $tipo8 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^8/")))));
    $tipo9 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^9/")))));

    for ($i=1; $i < 10; $i++) 
    { 
      $auxt="tipo".$i;
      $auxisi="tipo".$i."si";
      $auxsi="arrsi".$i;
      $auxd="arrd".$i;
      $auxc="arrc".$i;
      $cierrecop = filtraCierreAnual($cierreano, $i);
      $saldoinicop = filtraSaldos($saldoinicial, $i);


      if(count($cierrecop) > 0)
        $$auxsi = calcular($cierrecop,"CA");
      else
        $$auxsi = calcular($saldoinicop,"SI");

      //$$auxsi = calcular($$auxisi,"SI");
      $$auxd = calcular($$auxt,"D");
      $$auxc = calcular($$auxt,"C");

      if(count($$auxd) > 0)
      {
        if(count($cierrecop) > 0)
          $rta[$i]["SI"] = $$auxsi;
        else  
          $rta[$i]["SI"] = $$auxsi;
        $rta[$i]["C"] = $$auxc;
        $rta[$i]["D"] = $$auxd;
      }
    }

    return $rta;
  }

  function calcular($nivel_actual,$tipocuenta)
  {
    $niveles = array("8"=>"14","7"=>"12","6"=>"10","5" =>"8","4"=>"6","3"=>"4","2"=>"2","1"=>"1");
    //$niveles = array("5" =>"8","4"=>"6","3"=>"4","2"=>"2","1"=>"1");
    $rpuc=array();
    $totaltipo = array();
    $totaltipo2 = array();
    $retorno = array();
    $final = array();

    $niveles = ajustaNivel(objectToArray($nivel_actual), $niveles);

    foreach ($niveles as $nkey => $nvalue)
    {
        $arregloFinal = objectToArray($nivel_actual);
        if(count($arregloFinal) > 0)
          $cur_puc = array();

        if(count($arregloFinal) > 0)
        foreach ($arregloFinal as $value)
        {
          if (strlen($value['cuenta_puc'])==$nvalue)
          {
            $cur_puc[] = $value;
          }

          if(count($cur_puc) > 0)
          {
            $totaltipo[$nkey] = totalizaNivel($cur_puc,$tipocuenta);
          }
          elseif($nvalue < count($niveles))
          {
            $totaltipo[$nkey] = array();
          }
        }
    }

    if(count($arregloFinal) > 0)
    {
      $totaltipo[3] = rellenaNivel($totaltipo,3,4);
      $totaltipo[2] = rellenaNivel($totaltipo,2,4);
      $totaltipo[1] = rellenaNivel($totaltipo,1,4);
    }
    
    if(count($arregloFinal) > 0)
    for ($k=count($niveles); $k > 0 ; $k--) 
    { 
      if(count($totaltipo[$k]) > 0 && count($totaltipo) > 1)
      foreach ($totaltipo[$k] as $key => $value) 
      {
        if($k == count($niveles))
        {
          $final[$k] = $totaltipo[$k];
          break;
        }
        else
        {
          if($k == 1)
            $carry = preparaNivel($final[$k+1], -1); 
          else
            $carry = preparaNivel($final[$k+1], -2);

          $final[$k] = totalizaNivelCarry($totaltipo[$k], $carry);
        }
      }
    }
    return $final;
  }

  function totalizaNivel($current_accounts,$tipo_movimiento)
  {
    $this_level_total = array();
    foreach ($current_accounts as $value) 
    {
      if($value['tipo']===$tipo_movimiento)
      if(array_key_exists($value['cuenta_puc'], $this_level_total))
      {
        $this_level_total[$value['cuenta_puc']] = (double)$this_level_total[$value['cuenta_puc']] + (double)$value['monto'];
      }
      else
      {
        $this_level_total[$value['cuenta_puc']] = (double)$value['monto'];
      }
    }
    return $this_level_total;
  }

  function totalizaNivelCarry($current_accounts, $carry)
  {
    $this_level_total = array();
    foreach ($current_accounts as $key => $value) 
    {
      if(array_key_exists($key, $this_level_total))
      {
        $this_level_total[$key] = (double)$this_level_total[$key] + (double)$value;
      }
      else
      {
        $this_level_total[$key] = (double)$value;
      }
    }
    foreach ($carry as $keyc => $valuec) 
    {
      if(array_key_exists($keyc, $this_level_total))
      {
        $this_level_total[$keyc] = (double)$this_level_total[$keyc] + (double)$valuec;
      }
      else
      {
        $this_level_total[$keyc] = (double)$valuec;
      }
    }
    return $this_level_total;
  }

  function preparaNivel($level,$offset)
  {
    $level_total = array();
    foreach ($level as $key => $value) 
    {
      $next_level_account = substr($key,0,$offset);
      if(array_key_exists($next_level_account, $level_total))
      {
        $level_total[$next_level_account] = $level_total[$next_level_account] + $value;
      }
      else
      {
        $level_total[$next_level_account] = $value;
      }  
    }
    return $level_total;
  }

  function rellenaNivel($level, $offset, $initial)
  {
    $level_total = array();
    foreach ($level[$initial] as $key => $value) 
    {
      if($offset == 3)
        $next_level_account = substr($key,0,-2);
      if($offset == 2)
        $next_level_account = substr($key,0,-4);
      if($offset == 1)
        $next_level_account = substr($key,0,-5);

        $level_total[$next_level_account] = 0;
    }
    return $level_total;
  }

  function ajustaNivel($nivel_actual, $niveles)
  {
    $max_cuenta = 0;
    $salida = $niveles;
    //var_dump($nivel_actual);
    if(count($nivel_actual) > 0)
    {
      foreach ($nivel_actual as $keylen => $valuelen)
      {
        if (strlen($valuelen['cuenta_puc']) > $max_cuenta)
        {
          $max_cuenta = strlen($valuelen['cuenta_puc']);
        }
        //var_dump($valuelen);
      }
    }
    else
    {
      $max_cuenta = 1;
    }
    /*if($max_cuenta < 1)
      $max_cuenta = 5;*/
    //echo "</br>" . $max_cuenta . "</br>";
    
    foreach ($salida as $keylen => $vallen)
    {
      if ($vallen > $max_cuenta)
      {
        unset($salida[$keylen]);
      }
    }
    //var_dump($arregloFinal);
    return $salida;
  }

//FUNCIONES PARA BALANCE DE PRUEBA PARA UN PERIODO
  function balancePruebaPeriodo($idcopropiedad, $year, $month, $appl)
  {
    $rta = array();
    $meses = obtieneMeses($month);
    $ultAno = obtieneUltimoCierreAnual($appl, $idcopropiedad);
    $cierreano = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno))));
    $saldoinicial = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"saldosiniciales"))));

    $tipo1 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^1/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo2 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^2/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo3 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^3/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo4 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^4/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo5 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^5/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo6 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^6/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo7 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^7/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo8 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^8/"),"year" => $year,"month" => array('$in' => $meses)))));
    $tipo9 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^9/"),"year" => $year,"month" => array('$in' => $meses)))));

    /*var_dump(count($cierreano));
    var_dump(count($saldoinicial));
    var_dump($ultAno);
    var_dump(json_encode(array("tipo_documento"=>"registrocontable", "cuenta_puc"=> new MongoRegex("/^1/"),"year" => $year,"month" => array('$in' => $meses))));
    var_dump(count($tipo1));
    var_dump(count($tipo2));
    var_dump(count($tipo3));
    var_dump(count($tipo4));
    var_dump(count($tipo5));
    exit;*/

    for ($i=1; $i < 10; $i++) 
    { 
      $auxt="tipo".$i;
      $auxisi="tipo".$i."si";
      $auxsi="arrsi".$i;
      $auxd="arrd".$i;
      $auxc="arrc".$i;
      $cierrecop = filtraCierreAnual($cierreano, $i);
      $saldoinicop = filtraSaldos($saldoinicial, $i);

      if(count($cierrecop) > 0)
        $$auxsi = calcular($cierrecop,"CA");
      else
        $$auxsi = calcular($saldoinicop,"SI");

      $$auxd = calcular($$auxt,"D");
      $$auxc = calcular($$auxt,"C");

      if(count($$auxsi) > 0)
      {
        if(count($cierrecop) > 0)
          $rta[$i]["SI"] = $$auxsi;
        else  
          $rta[$i]["SI"] = $$auxsi;
        $rta[$i]["C"] = $$auxc;
        $rta[$i]["D"] = $$auxd;
      }
    }

    return $rta;
  }

//FUNCIONES PARA BALANCE DE PRUEBA CON TERCEROS
  function balancePruebaTerceros($idcopropiedad, $appl)
  {
    $rta = array();
    $ultAno = obtieneUltimoCierreAnual($appl, $idcopropiedad);
    $cierreano = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno))));
    $saldoinicial = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"saldosiniciales"))));

    /*var_dump(count($cierreano));
    var_dump(count($saldoinicial));
    var_dump($ultAno);
    var_dump(array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno));
    exit;*/

    $tipot1 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^1/")))));
    $tipot2 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^2/")))));
    $tipot3 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^3/")))));
    $tipot4 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^4/")))));
    $tipot5 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^5/")))));
    $tipot6 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^6/")))));
    $tipot7 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^7/")))));
    $tipot8 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^8/")))));
    $tipot9 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^9/")))));

    for ($i=1; $i < 10; $i++) 
    { 
      $auxt="tipot".$i;
      $auxisi="tipo".$i."si";
      $auxica="tipo".$i."ca";
      $auxsi="arrsi".$i;
      $auxd="arrd".$i;
      $auxc="arrc".$i;
      $auxte="arrte".$i;
      $cierrecop = filtraCierreAnual($cierreano, $i);
      $saldoinicop = filtraSaldos($saldoinicial, $i);

      if(count($cierrecop) > 0)
        $$auxsi = calcular($cierrecop,"CA");
      else
        $$auxsi = calcular($saldoinicop,"SI");

      //$$auxsi = calcularTerceros($$auxt,"SI");
      $$auxd = calcularTerceros($$auxt,"D");
      $$auxc = calcularTerceros($$auxt,"C");

      if(count($$auxsi) > 0)
      {
        if(count($cierrecop) > 0)
          $rta[$i]["SI"] = $$auxsi;
        else  
          $rta[$i]["SI"] = $$auxsi;
        $rta[$i]["C"] = $$auxc;
        $rta[$i]["D"] = $$auxd;
      }
    }
    return $rta;
  }

  function calcularTerceros($nivel_actual,$tipocuenta)
  {
    $niveles = array("8"=>"14","7"=>"12","6"=>"10","5" =>"8","4"=>"6","3"=>"4","2"=>"2","1"=>"1");
    //$niveles = array("5" =>"8","4"=>"6","3"=>"4","2"=>"2","1"=>"1");
    $rpuc=array();
    $totaltipo = array();
    $totaltipoterceros = array();
    $totaltipo2 = array();
    $retorno = array();
    $final = array();
    $terceros = array();

    $niveles = ajustaNivel(objectToArray($nivel_actual), $niveles);

    foreach ($niveles as $nkey => $nvalue)
    {
        $arregloFinal = objectToArray($nivel_actual);
        if(count($arregloFinal) > 0)
          $cur_puc = array();

        if(count($arregloFinal) > 0)
        foreach ($arregloFinal as $value)
        {
          if (strlen($value['cuenta_puc'])==$nvalue)
          {
            $cur_puc[] = $value;
          }

          if(count($cur_puc) > 0)
          {
            $totaltipoterceros[$nkey] = totalizaTercero($cur_puc,$tipocuenta);
          }
          elseif($nvalue < count($niveles))
          {
            $totaltipo[$nkey] = array();
          }
        }
    }
    return $totaltipoterceros;
  }

  function totalizaTercero($current_accounts,$tipo_movimiento)
  {
    $terceros = array();
    $salida = array();
    
    foreach ($current_accounts as $value) 
    {
      //var_dump($value['cuenta_puc']);
      if($value['tipo']===$tipo_movimiento)
      {
        if(array_key_exists($value['cuenta_puc'], $salida) && array_key_exists($value['id_tercero'], $salida[$value['cuenta_puc']]))
        {
          $salida[$value['cuenta_puc']][$value['id_tercero']] = (double)$salida[$value['cuenta_puc']][$value['id_tercero']] + (double)$value['monto'];
        }
        else
        {
          $salida[$value['cuenta_puc']][$value['id_tercero']] = (double)$value['monto'];
        }
      }
      //$salida[$value['cuenta_puc']] = $terceros;
    }

    return $salida; 
  }

  function unirBalances($prueba, $terceros, $ca = false)
  {
    $salida_final = array();

    for ($i=1; $i < 10; $i++) 
    { 
       if(array_key_exists($i, $prueba))
       {
          for ($j=4; $j < 9; $j++)     
          {
            if(array_key_exists($j, $prueba[$i]["SI"]))
            {
              $salida_final[$i]["SI"][$j]["montos"] = $prueba[$i]["SI"][$j];
              if($ca)
                $salida_final[$i]["SI"][$j]["terceros"] = array();
              else
                $salida_final[$i]["SI"][$j]["terceros"] = $terceros[$i]["SI"][$j];
            }
            if(array_key_exists($j, $prueba[$i]["D"]))
            {
              $salida_final[$i]["D"][$j]["montos"] = $prueba[$i]["D"][$j];
              $salida_final[$i]["D"][$j]["terceros"] = $terceros[$i]["D"][$j];
            }
            if(array_key_exists($j, $prueba[$i]["C"]))
            {
              $salida_final[$i]["C"][$j]["montos"] = $prueba[$i]["C"][$j];
              $salida_final[$i]["C"][$j]["terceros"] = $terceros[$i]["C"][$j];
            }  
          }

          $salida_final[$i]["SI"][3] = $prueba[$i]["SI"][3];
          $salida_final[$i]["SI"][2] = $prueba[$i]["SI"][2];
          $salida_final[$i]["SI"][1] = $prueba[$i]["SI"][1];
          $salida_final[$i]["D"][3] = $prueba[$i]["D"][3];
          $salida_final[$i]["D"][2] = $prueba[$i]["D"][2];
          $salida_final[$i]["D"][1] = $prueba[$i]["D"][1];
          $salida_final[$i]["C"][3] = $prueba[$i]["C"][3];
          $salida_final[$i]["C"][2] = $prueba[$i]["C"][2];
          $salida_final[$i]["C"][1] = $prueba[$i]["C"][1];
       }
     }
     

     return $salida_final;
  }

//FUNCIONES PARA GENERAR BALANCE GENERAL
  function balanceGeneral($balancePr)
  {
    $rta = array();

    for($j=1;$j < 8; $j++)
      if(array_key_exists($j, $balancePr))
      for($k=1;$k < 10; $k++)
        if(array_key_exists($j.$k, $balancePr[$j]["SI"][2]))
        for ($i=1; $i < 100; $i++) 
        { 
          $this_account = $i;
          if($this_account < 10)
            $this_account = "0".$i;

          if(array_key_exists($j.$k.$this_account, $balancePr[$j]["SI"][3]))
            {
              $si = $balancePr[$j]["SI"][3][$j.$k.$this_account];
              $c = $balancePr[$j]["C"][3][$j.$k.$this_account];
              $d = $balancePr[$j]["D"][3][$j.$k.$this_account];
                
              if($j == 2 || $j == 3 || $j == 4)
                $res = $si + $c - $d;
              else
                $res = $si + $d - $c;

              if($j.$k.$this_account == 3605)
                {
                  $res4 = 0;
                  $res5 = 0;
                  $res6 = 0;
                  $res7 = 0;

                  if(array_key_exists(4, $balancePr))
                    $res4 = ($balancePr[4]["SI"][1][4] + $balancePr[4]["C"][1][4] - $balancePr[4]["D"][1][4]);

                  if(array_key_exists(5, $balancePr))
                    $res5 = ($balancePr[5]["SI"][1][5] + $balancePr[5]["D"][1][5] - $balancePr[5]["C"][1][5]);

                  if(array_key_exists(6, $balancePr))
                    $res6 = ($balancePr[6]["SI"][1][6] + $balancePr[6]["D"][1][6] - $balancePr[6]["C"][1][6]);

                  if(array_key_exists(7, $balancePr))
                    $res7 = ($balancePr[7]["SI"][1][7] + $balancePr[7]["D"][1][7] - $balancePr[7]["C"][1][7]);

                  $rest = $res4 - $res5 - $res6 - $res7;

                  if($rest > 0)
                  {
                    $rta[$j][$j.$k]["3605"] = "4:" . $res4 . " - 5: " . $res5 . " - 6: " . $res6 . " - 7: " . $res7 . " = " . $rest;  
                    $rta[$j][$j.$k]["3610"] = "0";  
                  }
                  else
                  {
                   $rta[$j][$j.$k]["3610"] = "4:" . $res4 . " - 5: " . $res5 . " - 6: " . $res6 . " - 7: " . $res7 . " = " . $rest * -1;  
                   $rta[$j][$j.$k]["3605"] = "0";   
                  }

                  //$rta[$j][$j.$k][$j.$k.$this_account] = "4:" . $res4 . " - 5: " . $res5 . " - 6: " . $res6 . " - 7: " . $res7 . " = " . $rest;
                }
              else
                {
                  $rta[$j][$j.$k][$j.$k.$this_account] = "SI:" . $si . " + D: " . $balancePr[$j]["D"][3][$j.$k.$this_account] . " - C: " . $balancePr[$j]["C"][3][$j.$k.$this_account] . " = " . $res;
                }
            }

        }

    return $rta;
  }

//FUNCIONES PARA GENERAR ESTADO DE RESULTADOS
  function estadoResultados($balancePr)
  {
    $rta = array();

    for($j=4;$j < 8; $j++)
      if(array_key_exists($j, $balancePr))
      for($k=1;$k < 10; $k++)
        if(array_key_exists($j.$k, $balancePr[$j]["SI"][2]))
        for ($i=1; $i < 100; $i++) 
        { 
          $this_account = $i;
          if($this_account < 10)
            $this_account = "0".$i;

          if(array_key_exists($j.$k.$this_account, $balancePr[$j]["SI"][3]))
            {
              $c = $balancePr[$j]["C"][3][$j.$k.$this_account];
              $d = $balancePr[$j]["D"][3][$j.$k.$this_account];
                
              if($j == 4)
                $res = $c - $d;
              else
                $res = $d - $c;

              $rta[$j][$j.$k][$j.$k.$this_account] = " D: " . $balancePr[$j]["D"][3][$j.$k.$this_account] . " - C: " . $balancePr[$j]["C"][3][$j.$k.$this_account] . " = " . $res;
            }

        }

    return $rta;
  }

//FUNCIONES PARA CIERRE ANUAL
  function generaAcumulado($balanceP)
  {
    $salida = array();
    $total = array();
    for ($i=1; $i < 10; $i++) 
    { 
      if(array_key_exists($i, $balanceP))
        foreach ($balanceP[$i] as $keyt => $valuet) 
        {
          $arr = array();
          foreach ($valuet as $keyc => $valuec) 
          {
            foreach ($valuec as $keyf => $valuef) 
            {
              $salida[$keyt][$keyf]=$valuef;
            }
          }
        }
    }

    foreach ($salida["SI"] as $key => $value) 
    {
      if ((0 === strpos((string)$key, '2')) || (0 === strpos((string)$key, '3')) || (0 === strpos((string)$key, '4')))
        $total[$key] = $salida["SI"][$key] + $salida["C"][$key] - $salida["D"][$key];
      else  
        $total[$key] = $salida["SI"][$key] + $salida["D"][$key] - $salida["C"][$key];
    }

    return $total;
  }

  function organizaCierreAnual($cierre)
  {
    $out = array();
    foreach ($cierre as $cuenta => $monto) 
    {
      if(strlen($cuenta) > 4)
      {
        $cuenta_contable = array('cuenta_puc' => $cuenta, 'monto' => $monto, 'tipo' => "CA");
        $out[] = $cuenta_contable;
      }
    }
    return $out;
  }

  function mueveDocumentos($anio, $idcopropiedad, $appl)
  {
    $docs = objectToArray(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("year" => $anio, "tipo_documento" => 'registrocontable')))));

    if(count($docs) > 0)
      foreach ($docs as $key => $value) 
      {
        $vl = $value['_id']['$id'];
        unset($value['_id']);
        enviarInformacion('cont_'.$idcopropiedad.'_hist', $value, $appl);
        eliminaDocumento($vl, 'cont_'.$idcopropiedad);
      }

    $docsi = objectToArray(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento" => "saldosiniciales")))));

    if(count($docsi) > 0)
      foreach ($docs as $key => $value) 
      {
        $vl = $value['_id']['$id'];
        unset($value['_id']);
        enviarInformacion('cont_'.$idcopropiedad.'_hist', $value, $appl);
        eliminaDocumento($vl, 'cont_'.$idcopropiedad);
      }

    return true;
  }

  function agregaCierre($idcopropiedad, $tipo, $data, $appl)
  {
    $res=json_decode(json_encode(consultaColeccionRespuesta($appl, 'cont_'.$idcopropiedad, array('tipo_documento'=>'cierres'))));
    $obj = objectToArray($res);

    foreach ($obj as $key => $value) 
    {
      if($tipo == "anual")
        array_push($value['cierre_anual'],$data);
      elseif($tipo == "periodo")
        array_push($value['cierre_periodo'],$data);
    }

    return modificaDocumento($value, array(), 'cont_'.$idcopropiedad);
  }

  function creaCargo($corte, $monto, $tercero, $concepto, $doc_asoc, $appl, $idcopropiedad)
  {
    $today = date('c');
    $year = explode('/',$corte)[0];
    $month = explode('/',$corte)[1];
    $day = explode('/',$corte)[2];
    $cargosexistentes = consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cartera", "doc" => (string)$doc_asoc);
    if(count($cargosexistentes) > 0)
      $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>count($cargosexistentes) + 1);
    else
      $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>"1");
    return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
  }