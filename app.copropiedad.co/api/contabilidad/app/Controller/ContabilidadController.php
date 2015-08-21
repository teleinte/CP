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

  //METODO CREAR REGISTRO DE BANCOS- OK - OK
    $app->options("/crearbancos/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/crearbancos/", function() use($app)
    {
     // try
     //  {
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
      // }
      // catch(Exception $e)
      // {
      //   enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      // }
    });

  //METODO OBTENER REGISTRO DE BANCOS - OK - OK
    $app->options("/obtener/bancos/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/obtener/bancos/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "banco", "estado"=>1));
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

  //METODO OBTENER BANCOS CON ID MONGO- OK - OK
    $app->options("/obtener/bancosid/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/obtener/bancosid/", function() use($app)
    {
     // try
     //  {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "banco","_id"=>new MongoId($datos->body->id)));
            // $idGuardado=$datos->body->id;
            // unset($datos->body->id);
            // $muestreo=array("_id"=>new MongoId($idGuardado));
            // $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
            // $array = json_decode(json_encode($datos), true);
            // $result=$dbdata->updateDocument($muestreo, $datos->body);
            // if ($result){enviarRespuesta($app, true, $result, "null");}
            // else {enviarRespuesta($app, true, null, null);}          
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      // }
      // catch(Exception $e)
      // {
      //   enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      // }
    });

  //METODO MODIFICAR BANCOS CON ID MONGO- OK - OK
    $app->options("/modificarbancos/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/modificarbancos/", function() use($app)
    {
     // try
     //  {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            //consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "banco","_id"=>new MongoId($datos->body->id)));
            $idGuardado=$datos->body->id;
            unset($datos->body->id);
            $muestreo=array("_id"=>new MongoId($idGuardado));
            $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
            $array = json_decode(json_encode($datos), true);
            $result=$dbdata->updateDocument($muestreo, $datos->body);
            if ($result){enviarRespuesta($app, true, $result, "null");}
            else {enviarRespuesta($app, true, null, null);}
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      // }
      // catch(Exception $e)
      // {
      //   enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      // }
    });

  //METODO CREAR REGISTRO DE CARGOS EXTRA- OK - OK
    $app->options("/crearcargos/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/crearcargos/", function() use($app)
    {
     // try
     //  {
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
      // }
      // catch(Exception $e)
      // {
      //   enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      // }
    });

  //METODO OBTENER REGISTRO DE CARGOS ACTIVOS - OK - OK
    $app->options("/obtener/cargos/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/obtener/cargos/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "cargos_".$datos->body->id_copropiedad, "estado"=>1));
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

  //METODO OBTENER BANCOS CON ID MONGO- OK - OK
    $app->options("/obtener/cargosid/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/obtener/cargosid/", function() use($app)
    {
     // try
     //  {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "cargos_".$datos->body->id_copropiedad,"_id"=>new MongoId($datos->body->id)));
                  
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      // }
      // catch(Exception $e)
      // {
      //   enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      // }
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

     //METODO OBTENER CONFIGURACION - OK - OK
    $app->options("/obtener/consecutivosFijos/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/obtener/consecutivosFijos/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;      
        if($token->SetToken($datos->token))
        {
          consultaColeccion($app,'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "consecutivosFijos"));
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
          $idGuardado=$datos->body->id;
          unset($datos->body->id);
          $muestreo=array("_id"=>new MongoId($idGuardado));
          $dbdata=new DBNosql('cont_'.$datos->body->id_copropiedad);
          $array = json_decode(json_encode($datos), true);        
          $result=$dbdata->updateDocument($muestreo,$datos->body);
          if ($result)
          {
              enviarRespuesta($app, true, $result, "null");
          }
          else {enviarRespuesta($app, true, null, null);}
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

    $app->put("/saldosiniciales/traer/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            consultaColeccion($app, 'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "saldosiniciales"));
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

    $app->options("/infoempresa/ver/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/infoempresa/ver/", function() use($app)
    {
     try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
          consultaColeccion($app, 'cont_'.$datos->body->id_copropiedad, array("tipo_documento" => "infoempresa"));
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
         // try
         //  {
            $requerimiento = $app::getInstance()->request();
            $datos = json_decode($requerimiento->getBody());
            $token = new Token;        
            if($token->SetToken($datos->token))
            {
              $alanterior="";
              $array = json_decode(json_encode($datos), true);
              $cuentanueva = $datos->body->cuenta;
              // echo "<br>esta es la llave".$cuentanueva;
              $alanterior = consultaColeccionRetorno($app,'cont_'.$datos->body->id_copropiedad, array('tipo_documento' =>'puc'));
              foreach ($alanterior as $key => $value) 
              { 
                if(is_array($value))
                {
                  foreach ($value as $llave => $valor) {
                    if($llave=="puc")
                    {
                      foreach ($valor as $llaves => $valores) 
                       {
                          if($cuentanueva==$valores["cuenta"])
                          {
                            enviarRespuesta($app, false, "la cuenta ya existe en el PUC", 'error');
                            $error=true;                        
                            break;
                          }
                          else
                          {
                            $error=false;
                          }
                       }
                       if ($error) {break;}
                    }
                  }
                }
                if ($error) {break;}
              }
              if(!$error)
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
            }
            else
            {
              enviarRespuesta($app, false, 'Token invalido', 'null');
            }
          // }
          // catch(Exception $e)
          // {
          // enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
          // }
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
     //try
     //{
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
          $id_copropiedad = $datos->body->id_copropiedad;
          if(isset($datos->body->tipo))
          {
            if($datos->body->tipo)
            {
              $month_inicio = $datos->body->mesinicio;
              $year_inicio = $datos->body->anoinicio;
              $month_fin = $datos->body->mesfin;
              $year_fin = $datos->body->anofin;
              $respuesta = balancePrueba($id_copropiedad, $app, $datos->body->tipo, $datos->body->mesinicio, $datos->body->anoinicio, $datos->body->mesfin, $datos->body->anofin);
            }
            else
            {
              $respuesta = balancePrueba($id_copropiedad, $app, false);
            }
          }
          else
          {
            $respuesta = balancePrueba($id_copropiedad, $app, false);
          }

          enviarRespuesta($app, true, $respuesta, "null");
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      //}
      //catch(Exception $e)
      //{
      //  enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      //}
    });

  //GENERAR EL BALANCE DE PRUEBA - OK - OK (NUEVO BALANCE - DROPOUT METODO ANTERIOR
    $app->options("/balance/pruebaintegrado/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/balance/pruebaintegrado/", function() use($app)
    {
      try
      {
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
          $id_copropiedad = $datos->body->id_copropiedad;
          if(isset($datos->body->tipo))
          {
            if($datos->body->tipo)
            {
              $month_inicio = $datos->body->mesinicio;
              $year_inicio = $datos->body->anoinicio;
              $month_fin = $datos->body->mesfin;
              $year_fin = $datos->body->anofin;
              $respuesta = balancePruebaIntegrado($id_copropiedad, $app, $datos->body->tipo, $datos->body->mesinicio, $datos->body->anoinicio, $datos->body->mesfin, $datos->body->anofin);
            }
            else
            {
              $respuesta = balancePruebaIntegrado($id_copropiedad, $app, false);
            }
          }
          else
          {
            $respuesta = balancePruebaIntegrado($id_copropiedad, $app, false);
          }

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

  //GENERAR EL BALANCE DE PRUEBA - OK - OK
    $app->options("/balance/auxiliar/", function() use($app)
    {
      enviarRespuesta($app, true, "ok", "ok");
    });

    $app->post("/balance/auxiliar/", function() use($app)
    {
      //try
      //{
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
          $id_copropiedad = $datos->body->id_copropiedad;
          if(isset($datos->body->tipo))
          {
            if($datos->body->tipo)
            {
              $month_inicio = $datos->body->mesinicio;
              $year_inicio = $datos->body->anoinicio;
              $month_fin = $datos->body->mesfin;
              $year_fin = $datos->body->anofin;
              $respuesta = libroAuxiliar($id_copropiedad, $app, $datos->body->tipo, $datos->body->mesinicio, $datos->body->anoinicio, $datos->body->mesfin, $datos->body->anofin);
            }
            else
            {
              $respuesta = libroAuxiliar($id_copropiedad, $app, false);
            }
          }
          else
          {
            $respuesta = libroAuxiliar($id_copropiedad, $app, false);
          }

          enviarRespuesta($app, true, $respuesta, "null");
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      /*}
      catch(Exception $e)
      {
        enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      }*/
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
      //try
      //{
        $requerimiento = $app::getInstance()->request();
        $datos = json_decode($requerimiento->getBody());
        $token = new Token;
        if($token->SetToken($datos->token))
        {
            $id_copropiedad = $datos->body->id_copropiedad;
            $respuesta = balancePrueba($id_copropiedad, $app);
            //$respuesta = balanceGeneral($respuesta);
            enviarRespuesta($app, true, $respuesta, "null");
        }
        else
        {
          enviarRespuesta($app, false, "Token invalido", "null");
        }
      /*}
      catch(Exception $e)
      {
        enviarRespuesta($app, false, "Error al obtener la información", $e->getMessage());
      }*/
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
            //$respuesta = estadoResultados($respuesta);
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

//METODOS PARA GENERAR CIERRES DE PERIODO

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
  function balancePrueba($idcopropiedad, $appl, $tipo, $month_inicio=null, $year_inicio=null, $month_fin=null, $year_fin=null)
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
    if(!$tipo)
    {
      $tipo1 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^1/")))));
      $tipo2 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^2/")))));
      $tipo3 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^3/")))));
      $tipo4 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^4/")))));
      $tipo5 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^5/")))));
      $tipo6 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^6/")))));
      $tipo7 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^7/")))));
      $tipo8 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^8/")))));
      $tipo9 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^9/")))));
    }
    else
    {
      //var_dump('a');
      //$di = date_create('2015-06-20');
      $di = date_create($year_inicio . '-' . $month_inicio . '-01');
      $di = date_format($di, 'c');
      if($month_fin == "12"){
        $month_fin = "01";
        $year_fin = (int)$year_fin + 1;
      }
      //var_dump($year_inicio . $month_inicio);
      //var_dump($di);

      //$de = date_create('2015-06-25');
      $de = date_create($year_fin . '-' . ((int)$month_fin + 1) . '-01');
      $de = date_format($de, 'c');
      //var_dump($year_fin . $month_fin);
      //var_dump($de);
      //var_dump(json_encode(array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^1/"),"fecha_creacion" => array('$gte' => $di, '$lte' => $de))));
      /*$tipo1 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^1/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo2 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^2/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo3 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^3/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo4 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^4/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo5 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^5/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo6 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^6/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo7 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^7/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo8 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^8/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));
      $tipo9 = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^9/"),"fecha_movimiento" => array('$gte' => $di, '$lte' => $de)))));*/
      $tipo1 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^1/"))))),$di,$de);
      $tipo2 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^2/"))))),$di,$de);
      $tipo3 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^3/"))))),$di,$de);
      $tipo4 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^4/"))))),$di,$de);
      $tipo5 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^5/"))))),$di,$de);
      $tipo6 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^6/"))))),$di,$de);
      $tipo7 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^7/"))))),$di,$de);
      $tipo8 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^8/"))))),$di,$de);
      $tipo9 = filtrarDocumentosPeriodo(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"registrocontable","cuenta_puc"=> new MongoRegex("/^9/"))))),$di,$de);
    }
    
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

  function filtrarDocumentosPeriodo($docs, $start, $end)
  {
    if(count($docs) > 0)
    {
      foreach ($docs as $key => $value) {
        var_dump($value);
        exit;
      }
    }
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
      if(array_key_exists($k,$totaltipo))
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
    //if($initial < 4)
    //var_dump($level[$initial]);
    //var_dump($offset);
    //var_dump($level);

    if(array_key_exists($initial, $level))
    {
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
    }
    else
    {
       $level[$initial] = array();

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

//FUNCIONES PARA BALANCE DE PRUEBA INTEGRADO
  function balancePruebaIntegrado($idcopropiedad, $appl, $tipo, $month_inicio=null, $year_inicio=null, $month_fin=null, $year_fin=null)
  {
    $rta = array();
    $ultAno = obtieneUltimoCierreAnual($appl, $idcopropiedad);
    $cierreano = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno))));
    $saldoinicial = integradoObtenerSaldosIniciales(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"saldosiniciales")))));
    //var_dump($saldoinicial);
    $puc = integradoObtenerPuc(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"puc")))));

    if(!$tipo)
    {
      $transacciones = integradoObtenerTransacciones(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"transaccion","anulado"=> "NO")))));
      $registros = integradoObtenerRegistros(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array('tipo_documento'=>"registrocontable",'id_transaccion'=> array('$in'=> $transacciones))))));
      $balanceMenores = integradoTotalizarCuentas($registros, $saldoinicial, $puc);
      $balanceMayores = integradoTotalizar($balanceMenores);
      $rta = integradoLimpiarBalance(integradoIntegrarTotales($balanceMayores, $balanceMenores, $puc));
      ksort($rta, SORT_STRING);
    }
    else
    {
      $transacciones = integradoObtenerTransaccionesFecha(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"transaccion","anulado"=> "NO")))),$month_inicio, $month_fin, $year_inicio, $year_fin);
      $transaccionesanteriores = integradoObtenerTransaccionesFechaAnterior(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"transaccion","anulado"=> "NO")))),$month_inicio, $month_fin, $year_inicio, $year_fin);
      //var_dump($transaccionesanteriores);
      $registros = integradoObtenerRegistros(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array('tipo_documento'=>"registrocontable",'id_transaccion'=> array('$in'=> $transacciones))))));
      $registrosanteriores = integradoObtenerRegistros(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array('tipo_documento'=>"registrocontable",'id_transaccion'=> array('$in'=> $transaccionesanteriores))))));
      //var_dump(json_encode(array('tipo_documento'=>"registrocontable",'id_transaccion'=> array('$in'=> $transacciones))));
      //var_dump($registrosanteriores);
      $balanceMenoresAnteriores = integradoTotalizarCuentas($registrosanteriores, $saldoinicial, $puc);
      //var_dump($balanceMenoresAnteriores);
      $balanceMenores = integradoTotalizarCuentas($registros, integradoObtenerInicial($balanceMenoresAnteriores), $puc);
      $balanceMayores = integradoTotalizar($balanceMenores);
      $rta = integradoLimpiarBalance(integradoIntegrarTotales($balanceMayores, $balanceMenores, $puc));
      $terceros = integradoObtenerTerceros(objectToArray(consultaColeccionRetorno($appl, 'usuariocp', array('id_copropiedad'=>$idcopropiedad))));
      //var_dump($terceros);
      $cuentasterceros = integradoTotalizarTerceros($registros, $registrosanteriores, $terceros);
      //var_dump($cuentasterceros);
      $rta = integradoAgregarTerceros($rta, $cuentasterceros);
      ksort($rta, SORT_STRING);
    }
    //exit;
    return $rta;
  }

//FUNCIONES PARA GENERAR BALANCE GENERAL
  function balanceGeneral($balancePr)
  {
    /*$rta = array();
    //var_dump(json_encode($balancePr));
    for($j=1;$j < 8; $j++)
    {
      var_dump("J:" . $j);
      if(array_key_exists($j,$balancePr))
      {
        for ($k=1; $k < 5; $k++) 
        {
          var_dump("K:" . $k); 
          if(array_key_exists($k,$balancePr[$j]["SI"]))
          {
            var_dump("switch K");
            var_dump($balancePr[$j]["SI"][$k]);
            switch ($k) {
              case 5:
                foreach ($balancePr[$j]["SI"][$k] as $key => $value) 
                {
                  var_dump($key . ":" . $value);
                }
                break;
              /*case 4:
                # code...
                break;
              case 3:
                # code...
                break;
              case 2:
                # code...
                break;
              case 1:
                # code...
                break;
            }
          }
          else
          {
            var_dump("switch K");
            
            if(!array_key_exists($k,$balancePr[$j]["C"]))
              $balancePr[$j]["C"][$k] = 0;
            
            if(!array_key_exists($k,$balancePr[$j]["D"]))
              $balancePr[$j]["D"][$k] = 0;

            var_dump($balancePr[$j]["C"][$k]);
            switch ($k) {
              case 5:
                foreach ($balancePr[$j]["C"][$k] as $key => $value) 
                {
                  var_dump($key . ":" . $value);
                }
                break;
              /*case 4:
                # code...
                break;
              case 3:
                # code...
                break;
              case 2:
                # code...
                break;
              case 1:
                # code...
                break;
            }
          }
        }
      }
    }*/

    return $balancePr;
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

//FUNCIONES AUXILIARES DE CARGOS Y BALANCES
  function creaCargo($corte, $monto, $tercero, $concepto, $doc_asoc, $appl, $idcopropiedad)
  {
    $today = date('c');
    $corte = str_replace("/", "-", $corte);
    $year = explode('-',$corte)[0];
    $month = explode('-',$corte)[1];
    $day = explode('-',$corte)[2];
    $cargosexistentes = consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cartera", "doc" => (string)$doc_asoc));
    if(count($cargosexistentes) > 0)
      $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>count($cargosexistentes) + 1);
    else
      $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>"1");
    return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
  }

  function popularNivelVacio($bPrueba)
  {
    foreach ($bPrueba as $key => $value) 
    {
      if(array_key_exists(["SI"], $value))
        if(count($value["SI"]) < 1)
        {
          for ($i=1; $i < 10; $i++) 
          { 
            $value["SI"][$i]= Array();
            for ($j=1; $j < 100; $j++)
            {
              if($j < 10)
                str_pad($value, $j, '0', STR_PAD_LEFT);

              $value["SI"][$i][$j] = 0;
            }
          }
        }

      if(array_key_exists(["C"], $value))
        if(count($value["C"]) < 1)
        {
          for ($i=1; $i < 10; $i++) 
          { 
            $value["C"][$i]= Array();
            for ($j=1; $j < 100; $j++)
            {
              if($j < 10)
                str_pad($value, $j, '0', STR_PAD_LEFT);

              $value["C"][$i][$j] = 0;
            }
          }
        }

      if(array_key_exists(["D"], $value))
        if(count($value["D"]) < 1)
        {
          $value["D"][$i]= Array();
            for ($j=1; $j < 100; $j++)
            {
              if($j < 10)
                str_pad($value, $j, '0', STR_PAD_LEFT);

              $value["D"][$i][$j] = 0;
            }
        }
    }
  }

//FUNCIONES PARA BALANCE DE PRUEBA INTEGRADO
  function integradoObtenerPuc($docpuc)
  {
    $out = array();
    $mova = array();
    $mova['si'] = 0;
    $mova['c'] = 0;
    $mova['d'] = 0;
    if(count($docpuc) > 0)
    {
      $doc = objectToArray($docpuc)[0];

      foreach ($doc["puc"] as $key => $value) 
      {
        $value = objectToArray($value);
        $elem = array();
        $elem['nombre'] = $value['nombre'];
        $elem['terceros'] = array();
        $elem['mov'] = $mova;
        $out[$value['cuenta']] = $elem;
      }
    }

    return $out;
  }

  function integradoObtenerSaldosIniciales($docsi)
  {
    $out = array();
    if(count($docsi)>0)
    {
      $doc = objectToArray($docsi)[0];

      foreach ($doc["cuentas"] as $key => $value) 
      {
        $value = objectToArray($value);
        $elem = array();
        $elem['cuenta'] = $value['cuenta_puc'];
        $elem['monto'] = (int)$value['monto'];
        $elem['tipo'] = "SI";
        $elem['tercero'] = "Saldo Inicial";
        $elem['idtransaccion'] = "SI";
        $elem['concepto'] = "Saldo Inicial";
        $out[$value['cuenta_puc']] = $elem;
      }
    }
    return $out;
  }

  function integradoObtenerTransacciones($tx)
  {
    $out = array();
    if(count($tx)>0)
    {
      $doc = objectToArray($tx);

      foreach ($doc as $key => $value) 
      {
        $out[] = $value['idtransaccion'];
      }
    }

    return $out;
  }

  function integradoObtenerTransaccionesFecha($tx, $mes_inicio, $mes_fin, $year_inicio, $year_fin)
  {
    $out = array();
    //var_dump($mes_inicio, $mes_fin, $year_inicio, $year_fin);
    if($mes_fin == "12"){
      $mes_fin = "01";
      $year_fin = (int)$year_fin + 1;
    }
    $di = date_create($year_inicio . '-' . $mes_inicio . '-01');
    $di = date_format($di, 'c');
    //var_dump($di);
    $de = date_create($year_fin . '-' . ((int)$mes_fin + 1) . '-01');
    //var_dump($de);
    $de = date_format($de, 'c');

    if(count($tx)>0)
    {
      //var_dump($di);
      //var_dump($de);
      $doc = objectToArray($tx);

      foreach ($doc as $key => $value) 
      {
        //var_dump($value);
        if(array_key_exists("month",$value))
          $d = date_create($value['year'] . '-' . $value['month'] . '-' . $value['day']);
        else
          $d = date_create($value['year'] . '-' . $value['mes'] . '-' . $value['day']);
        $d = date_format($d, 'c');
        //var_dump($d);
        
        if($d >= $di && $d <= $de)
          $out[] = $value['idtransaccion'];
      }
    }
    //var_dump($tx);
    return $out;
  }

  function integradoObtenerTransaccionesFechaAnterior($tx, $mes_inicio, $mes_fin, $year_inicio, $year_fin)
  {
    $out = array();
    $di = date_create('2015-01-01');
    $di = date_format($di, 'c');
    $de = date_create($year_fin . '-' . $mes_inicio . '-01');
    $de = date_format($de, 'c');

    if(count($tx)>0)
    {
      //var_dump($di);
      //var_dump($de);
      $doc = objectToArray($tx);

      foreach ($doc as $key => $value) 
      {
        if(array_key_exists("month",$value))
          $d = date_create($value['year'] . '-' . $value['month'] . '-' . $value['day']);
        else
          $d = date_create($value['year'] . '-' . $value['mes'] . '-' . $value['day']);
        $d = date_format($d, 'c');
        //var_dump($d);
        
        if($d >= $di && $d <= $de)
          $out[] = $value['idtransaccion'];
      }
    }

    return $out;
  }

  function integradoObtenerRegistros($regs)
  {
    $out = array();
    if(count($regs)>0)
    {
      $doc = objectToArray($regs);
      foreach ($doc as $key => $value) 
      {
        $value = objectToArray($value);
        $elem = array();
        $elem['cuenta'] = $value['cuenta_puc'];
        $elem['monto'] = (int)$value['monto'];
        $elem['tipo'] = $value['tipo'];
        $elem['tercero'] = $value['id_tercero'];
        $elem['idtransaccion'] = $value['id_transaccion'];
        $elem['concepto'] = $value['concepto'];
        if(array_key_exists($value['cuenta_puc'],$out))
        {
          $out[$value['cuenta_puc']][] = $elem;
        }
        else
        {
          $out[$value['cuenta_puc']] = array();
          $out[$value['cuenta_puc']][] = $elem;
        }
      }
    }
    //var_dump($out);
    //exit;
    return $out;
  }

  function integradoTotalizarCuentas($registros, $saldoinicial, $puc)
  {
    //var_dump($puc);
    if(count($registros)>0)
      foreach ($registros as $kr => $vr)
        foreach ($vr as $key => $value) 
        {
          if(strlen($value['cuenta']) > 4)
          {
            if(array_key_exists($value['cuenta'], $puc))
            {
              if($value['tipo'] == "D")
              {
                $puc[$value['cuenta']]["mov"]["d"] = $puc[$value['cuenta']]["mov"]["d"] + $value['monto'];
              }

              if($value['tipo'] == "C")
              {
                $puc[$value['cuenta']]["mov"]["c"] = $puc[$value['cuenta']]["mov"]["c"] + $value['monto'];
              }
            }
            else
            {
              $mova = array();
              $mova['si'] = 0;
              $mova['c'] = 0;
              $mova['d'] = 0;

              $elem = array();
              $elem['nombre'] = 'No existe la cuenta';
              $elem['terceros'] = array();
              $elem['mov'] = $mova;
              $puc[$value['cuenta']] = $elem;

              if($value['tipo'] == "D")
              {
                //var_dump($puc[$value['cuenta']]["mov"]);
                $puc[$value['cuenta']]["mov"]["d"] = $puc[$value['cuenta']]["mov"]["d"] + $value['monto'];
              }

              if($value['tipo'] == "C")
              {
                $puc[$value['cuenta']]["mov"]["c"] = $puc[$value['cuenta']]["mov"]["c"] + $value['monto'];
              }
            }
          }
        }

    if(count($saldoinicial)>0)
      foreach ($saldoinicial as $key => $value) 
      {
        if(strlen($value['cuenta']) > 4)
        {
          if(array_key_exists($value['cuenta'], $puc))
          {
            $puc[$value['cuenta']]["mov"]["si"] =  $value['monto'];
          }
          else
          {
            $mova = array();
            $mova['si'] = 0;
            $mova['c'] = 0;
            $mova['d'] = 0;

            $elem = array();
            $elem['nombre'] = 'No existe la cuenta';
            $elem['terceros'] = array();
            $elem['mov'] = $mova;
            $puc[$value['cuenta']] = $elem;

            $puc[$value['cuenta']]["mov"]["si"] = $puc[$value['cuenta']]["mov"]["si"] + $value['monto'];
          }
        }
      }

    /*foreach ($puc as $key => $value) 
    {
      if(strlen($key) > 4)
      {
        $actualkey = substr($key,0,1);
        if($actualkey == 3 || $actualkey == 4 || $actualkey == 5)
          $puc[$key]["mov"]["t"] = $puc[$key]["mov"]["si"] + $puc[$key]["mov"]["c"] - $puc[$key]["mov"]["d"];
        if($actualkey == 1 || $actualkey == 2)
          $puc[$key]["mov"]["t"] = $puc[$key]["mov"]["si"] + $puc[$key]["mov"]["d"] - $puc[$key]["mov"]["c"];
      }
    }*/

    return $puc;
  }

  function integradoTotalizar($puc)
  {
    $nivel3 = array();
    $nivel2 = array();
    $nivel1 = array();
    $niveles = array();
    $mova = array();
    $mova['si'] = 0;
    $mova['c'] = 0;
    $mova['d'] = 0;

    if(count($puc)>0)
    {
      foreach ($puc as $k => $v) 
      {
        if(strlen((string)$k) > 4)
        {
          $actualkey3 = substr($k,0,4);
          if(!array_key_exists($actualkey3, $nivel3))
            $nivel3[$actualkey3] = $mova;
          
          //var_dump($v);
          $nivel3[$actualkey3]['si'] = $nivel3[$actualkey3]['si'] + $v['mov']['si'];
          $nivel3[$actualkey3]['d'] = $nivel3[$actualkey3]['d'] + $v['mov']['d'];
          $nivel3[$actualkey3]['c'] = $nivel3[$actualkey3]['c'] + $v['mov']['c'];
        }
      }

      foreach ($nivel3 as $x => $y) 
      {
        $actualkey2 = substr($x,0,2);
        if(!array_key_exists($actualkey2, $nivel2))
          $nivel2[$actualkey2] = $mova;

        $nivel2[$actualkey2]['si'] = $nivel2[$actualkey2]['si'] + $y['si'];
        $nivel2[$actualkey2]['d'] = $nivel2[$actualkey2]['d'] + $y['d'];
        $nivel2[$actualkey2]['c'] = $nivel2[$actualkey2]['c'] + $y['c'];
      }

      foreach ($nivel2 as $a => $b) 
      {
        $actualkey1 = substr($a,0,1);
        if(!array_key_exists($actualkey1, $nivel1))
          $nivel1[$actualkey1] = $mova;

        $nivel1[$actualkey1]['si'] = $nivel1[$actualkey1]['si'] + $b['si'];
        $nivel1[$actualkey1]['d'] = $nivel1[$actualkey1]['d'] + $b['d'];
        $nivel1[$actualkey1]['c'] = $nivel1[$actualkey1]['c'] + $b['c'];
      }

      $niveles[1] = $nivel1;
      $niveles[2] = $nivel2;
      $niveles[3] = $nivel3;
    }

    return $niveles;
  }

  function integradoIntegrarTotales($balanceMayores, $balanceMenores, $puc)
  {
    $nombres = array();
    //var_dump($puc);
    foreach ($puc as $key => $value) 
    {
      $nombres[$key] = $value['nombre'];
      //var_dump($value['nombre']);
    }
    //var_dump($nombres);
    //exit;
    if(count($balanceMayores)>0)
    foreach ($balanceMayores as $key => $value) 
    {
      foreach ($value as $k => $v) 
      {
        if(array_key_exists($k,$nombres))
          $balanceMenores[$k]["nombre"] = $nombres[$k];
        else
          $balanceMenores[$k]["nombre"] = 'No existe la cuenta';

        $balanceMenores[$k]["terceros"] = array();
        $balanceMenores[$k]["mov"]["c"] = $v["c"];
        $balanceMenores[$k]["mov"]["si"] = $v["si"];
        $balanceMenores[$k]["mov"]["d"] = $v["d"];
      }
    }
    return $balanceMenores;
  }

  function integradoObtenerInicial($balanceMenoresAnteriores)
  {
    $out = array();
    if(count($balanceMenoresAnteriores)>0)
      foreach ($balanceMenoresAnteriores as $key => $value) 
      {
        if(strlen($key) > 4)
        {
          $elem = array();
          $elem['cuenta'] = $key;
          $elem['monto'] = 0;
          $elem['tipo'] = "SI";
          $actualkey = substr((string)$key,0,1);

          if($actualkey == "2" || $actualkey == "3" || $actualkey == "4")
          {
            $elem['monto'] = $value["mov"]["si"] + $value["mov"]["c"] - $value["mov"]["d"];
          }

          if($actualkey == "1" || $actualkey == "5" || $actualkey == "6" || $actualkey == "7")
          {
            $elem['monto'] = $value["mov"]["si"] + $value["mov"]["d"] - $value["mov"]["c"];
          }
          //var_dump($elem);
          $out[$key] = $elem;
        }
      }
      //var_dump($out);
    return $out;
  }

  function integradoLimpiarBalance($balance)
  {
    $salida = array();
    if(count($balance) > 0)
      foreach ($balance as $key => $value) 
      {
        if($value['mov']['si'] != 0 || $value['mov']['d'] != 0  || $value['mov']['c'] != 0 )
          $salida[$key] = $value;
      }
    return $salida;
  }

  function integradoObtenerTerceros($personas)
  {
    $out = array();
    if(count($personas) > 0)
      foreach ($personas as $key => $value) 
      {
        $out[$value['id_crm_persona']] = $value['nombre'];
      }
    return $out;
  }

  function integradoTotalizarTerceros($registros, $registrosanteriores, $terceros)
  {
    $out = array();
    //var_dump($registros);
    //var_dump($registrosanteriores);
    //if(array_key_exists($terceros[$value["tercero"]],$out[$value["cuenta"]]))
    if(count($registros) > 0)
      foreach ($registros as $k => $v)
        foreach ($v as $key => $value)
        {
          //var_dump($value);
          if(array_key_exists($value["cuenta"],$out))
          {
            if(array_key_exists($terceros[$value["tercero"]],$out[$value["cuenta"]]))
            {
              if(array_key_exists(strtolower ($value["tipo"]),$out[$value["cuenta"]][$terceros[$value["tercero"]]]))
              {
                $out[$value["cuenta"]][$terceros[$value["tercero"]]][strtolower($value["tipo"])] = $out[$value["cuenta"]][$terceros[$value["tercero"]]][strtolower ($value["tipo"])] + $value["monto"];
              }
              else
              {
                $out[$value["cuenta"]][$terceros[$value["tercero"]]][strtolower ($value["tipo"])] = $value["monto"];
              }
            }
            else
            {
              $out[$value["cuenta"]][$terceros[$value["tercero"]]][strtolower ($value["tipo"])] = $value["monto"];
            }
          }
          else
          {
            $out[$value["cuenta"]][$terceros[$value["tercero"]]][strtolower ($value["tipo"])] = $value["monto"];
          }
          /*if(array_key_exists($value["cuenta"],$out))
          {
            if(array_key_exists($value["tercero"],$out[$value["cuenta"]]))
            {
              if(array_key_exists($value["tipo"],$out[$value["cuenta"]][$value["tercero"]]))
              {
                $out[$value["cuenta"]][$value["tercero"]][$value["tipo"]] = $value["monto"];
              }
              else
              {
                $out[$value["cuenta"]][$value["tercero"]][$value["tipo"]] = $value["monto"];
              }
            }
            else
            {
              $out[$value["cuenta"]][$value["tercero"]][$value["tipo"]] = $value["monto"];
            }
          }
          else
          {
            $out[$value["cuenta"]][$value["tercero"]][$value["tipo"]] = $value["monto"];
          }*/
        }
    return $out;
  }

  function integradoAgregarTerceros($balance, $terceros)
  {
    $out= array();
    if(count($balance) > 0)
      foreach ($balance as $key => $value) 
      {
        if(array_key_exists($key, $terceros))
          $value["terceros"] = $terceros[$key];

        $out[$key] = $value;
      }
    return $out;
  }

//FUNCIONES PARA LIBRO AUXILIAR
  function libroAuxiliar($idcopropiedad, $appl, $tipo, $month_inicio=null, $year_inicio=null, $month_fin=null, $year_fin=null)
  {
    $rta = array();
    $ultAno = obtieneUltimoCierreAnual($appl, $idcopropiedad);
    $cierreano = json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cierreanual", "periodo" => (string)$ultAno))));
    $saldoinicial = integradoObtenerSaldosIniciales(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"saldosiniciales")))));
    //var_dump($saldoinicial);
    $puc = integradoObtenerPuc(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"puc")))));
    $transacciones = auxiliarObtenerTransaccionesFecha(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"transaccion","anulado"=> "NO")))),$month_inicio, $month_fin, $year_inicio, $year_fin);
    $transaccionesanteriores = auxiliarObtenerTransaccionesFechaAnterior(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"transaccion","anulado"=> "NO")))),$month_inicio, $month_fin, $year_inicio, $year_fin);
    $transacc = auxiliarObtenerTransacciones($transacciones);
    $transaccAnt = auxiliarObtenerTransacciones($transaccionesanteriores);
    //var_dump($transaccionesanteriores);
    $registros = integradoObtenerRegistros(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array('tipo_documento'=>"registrocontable",'id_transaccion'=> array('$in'=> $transacc))))));
    $registrosanteriores = integradoObtenerRegistros(json_decode(json_encode(consultaColeccionRetorno($appl, 'cont_'.$idcopropiedad, array('tipo_documento'=>"registrocontable",'id_transaccion'=> array('$in'=> $transaccAnt))))));
    $transaccionescompletas = auxiliarTransaccionesCompletas($transacciones, $transaccionesanteriores, $registros, $registrosanteriores);
    //var_dump($registros);
    //var_dump($registrosanteriores);
    //var_dump($transaccionescompletas);
    $terceros = integradoObtenerTerceros(objectToArray(consultaColeccionRetorno($appl, 'usuariocp', array('id_copropiedad'=>$idcopropiedad))));
    $informe = auxiliarOrganizarInforme($saldoinicial, $registros, $registrosanteriores, $transaccionescompletas, $terceros);
    $informe = auxiliarTotalizarInforme($puc, $informe);
    /*var_dump($transacciones);
    var_dump($transaccionesanteriores);
    var_dump($transacc);
    var_dump($transaccAnt);*/

    ksort($informe, SORT_STRING);

    return $informe;
  }

  function auxiliarObtenerTransaccionesFecha($tx, $mes_inicio, $mes_fin, $year_inicio, $year_fin)
  {
    $out = array();
    //var_dump($mes_inicio, $mes_fin, $year_inicio, $year_fin);
    if($mes_fin == "12"){
      $mes_fin = "01";
      $year_fin = (int)$year_fin + 1;
    }
    $di = date_create($year_inicio . '-' . $mes_inicio . '-01');
    $di = date_format($di, 'c');
    //var_dump($di);
    $de = date_create($year_fin . '-' . ((int)$mes_fin + 1) . '-01');
    //var_dump($de);
    $de = date_format($de, 'c');

    if(count($tx)>0)
    {
      //var_dump($di);
      //var_dump($de);
      $doc = objectToArray($tx);

      foreach ($doc as $key => $value) 
      {
        //var_dump($value);
        if(array_key_exists("month",$value))
          $d = date_create($value['year'] . '-' . $value['month'] . '-' . $value['day']);
        else
          $d = date_create($value['year'] . '-' . $value['mes'] . '-' . $value['day']);
        $d = date_format($d, 'c');
        //var_dump($d);
        
        if($d >= $di && $d <= $de)
        {
          $elem = array();
          $elem["id_transaccion"] = $value['idtransaccion'];
          $elem["fecha"] = explode("T",$d)[0];
          $elem["tercero"] = $value['nombre_tercero'];
          $elem["idtercero"] = $value['id_crm_tercero'];
          $elem["concepto"] = $value['concepto_documento'];
          $out[$value['idtransaccion']] = $elem;
        }
      }
    }
    //var_dump($tx);
    return $out;
  }

  function auxiliarObtenerTransaccionesFechaAnterior($tx, $mes_inicio, $mes_fin, $year_inicio, $year_fin)
  {
    $out = array();
    $di = date_create('2015-01-01');
    $di = date_format($di, 'c');
    $de = date_create($year_fin . '-' . $mes_inicio . '-01');
    $de = date_format($de, 'c');

    if(count($tx)>0)
    {
      //var_dump($di);
      //var_dump($de);
      $doc = objectToArray($tx);

      foreach ($doc as $key => $value) 
      {
        if(array_key_exists("month",$value))
          $d = date_create($value['year'] . '-' . $value['month'] . '-' . $value['day']);
        else
          $d = date_create($value['year'] . '-' . $value['mes'] . '-' . $value['day']);
        $d = date_format($d, 'c');
        //var_dump($d);
        
        if($d >= $di && $d <= $de)
        {
          $elem = array();
          $elem["id_transaccion"] = $value['idtransaccion'];
          $elem["fecha"] = $d;
          $elem["tercero"] = $value['nombre_tercero'];
          $elem["idtercero"] = $value['id_crm_tercero'];
          $elem["concepto"] = $value['concepto_documento'];
          $out[$value['idtransaccion']] = $elem;
        }
      }
    }

    return $out;
  }

  function auxiliarObtenerTransacciones($transacc)
  {
    $out = array();
    if(count($transacc) > 0)
      foreach ($transacc as $key => $value) {
        $out[] = $value['id_transaccion'];
      }
    return $out;
  }

  function auxiliarTransaccionesCompletas($transacciones, $transaccionesanteriores, $registros, $registrosanteriores)
  {
    $out = array();
    foreach ($transacciones as $key => $value) 
    {
      $elem = array();
      $tran = $value;
      foreach ($registros as $x => $y) 
      foreach ($y as $k => $v) 
      {
        if($v["idtransaccion"] == $key)
        {
          $elem[] = $v;
        }
      }
      $tran["registros"] = $elem;
      $out[$key] = $tran;
    }
    return $out;
  }

  function auxiliarOrganizarInforme($saldosiniciales, $registros, $registrosanteriores, $transacciones, $terceros)
  {
    $out = array();
    if(count($transacciones) > 0)
    {
      if(count($registros) > 0)
      {
        foreach ($registros as $x => $y) 
        foreach ($y as $key => $value) 
        {
          //var_dump($value);
          $elem = array();
          $elem["idtransaccion"] = $value["idtransaccion"];
          $elem["tercero"] = $terceros[$value["tercero"]];
          $elem["monto"] = $value["monto"];
          $elem["concepto"] = $value["concepto"];
          $elem["tipo"] = $value["tipo"];
          $elem["fecha"] = $transacciones[$value["idtransaccion"]]["fecha"];
          $out[$value["cuenta"]]["registros"][] = $elem;
        }
      }

      if(count($registrosanteriores) > 0)
      {
        foreach ($registros as $x => $y) 
        foreach ($y as $key => $value) 
        {
          $elem = array();
          $elem["idtransaccion"] = $value["idtransaccion"];
          $elem["tercero"] = $terceros[$value["tercero"]];
          $elem["monto"] = $value["monto"];
          $elem["concepto"] = $value["concepto"];
          $elem["tipo"] = $value["tipo"];
          $elem["fecha"] = $transacciones[$value["idtransaccion"]]["fecha"];
          $out[$value["cuenta"]]["registros"][] = $elem;
        }
      }

      if(count($saldosiniciales) > 0)
      {
        foreach ($registros as $x => $y) 
        foreach ($y as $key => $value) 
        {
          $elem = array();
          $elem["idtransaccion"] = $value["idtransaccion"];
          $elem["tercero"] = $terceros[$value["tercero"]];
          $elem["monto"] = $value["monto"];
          $elem["concepto"] = $value["concepto"];
          $elem["tipo"] = $value["tipo"];
          $elem["fecha"] = $transacciones[$value["idtransaccion"]]["fecha"];
          $out[$value["cuenta"]]["registros"][] = $elem;
        }
      }
    }
    return $out;
  }

  function auxiliarTotalizarInforme($puc, $informe)
  {
    $out = array();
    if(count($informe) > 0)
    {
      foreach ($informe as $key => $value) 
      {
      //var_dump($informe);
        $elem = $value;
        $elem["nombre"] = $puc[$key]["nombre"];
        /*$total = 0;
        foreach ($value["registros"] as $k => $v) 
        {
          $total = $total + $v['monto'];
        }
        $elem["total"] = $total;*/
        $out[$key] = $elem;
      }
    }
    return $out;
  }