<?php require_once('app/Model/config.php');
require_once('app/Model/Token_model.php');
require_once('app/Model/Log_model.php');
require_once('app/Model/DBNosql_model.php');

/******************************************************************
**                 WEB SERVICE PARA CARTERA                      **
**                   2014 - TELEINTE S.A.S.                      **
**                 AUTOR: GERMAN VELASQUEZ                       **
/*****************************************************************/
//GENERAR TOKEN - OK - OK
  $app->options("/token/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

    $app->post('/token/', function() use($app)
    {
      try
      {
        $requerimiento = $app::getInstance()->request();
          $datos = json_decode($requerimiento->getBody());
          $obj = array('autkey'=>$datos->body->autkey,'user'=>$datos->body->user);
        $token = new Token;
        $tokenEntregado = $token->GetToken($obj);
        enviarRespuesta($app, true, array('token'=>$tokenEntregado), 'null');
      }
      catch(Exception $e)
      {
        enviarRespuesta($app, false, 'Error Creando el Token', $e->getMessage());
      }
    });
//NUEVO GENERAR CUENTAS DE COBRO
  $app->options("/generar/cc/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post('/generar/cc/', function() use($app)
  {
    //try
    //{
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        //var_dump($datos->body);

        $conf['idcopropiedad'] = $datos->body->id_copropiedad;
        $conf['id_crm_persona'] = $datos->body->id_crm_persona;
        $conf['year'] = $datos->body->year;
        $conf['month'] = $datos->body->month;
        $conf['corte'] =  $datos->body->corte;
        $conf['interes_cuenta'] =  $datos->body->interes_cuenta;
        $conf['interes_contra'] =  $datos->body->interes_contra;
        $conf['interes'] =  $datos->body->interes;
        $conf['interes_redondeo'] =  $datos->body->interes_redondeo;
        $conf['descuento_admin'] =  $datos->body->descuento_admin;
        $conf['descuento_admin_dia'] =  $datos->body->descuento_admin_dia;
        $conf['descuento_redondeo'] =  $datos->body->descuento_redondeo;
        $conf['recargo'] =  $datos->body->recargo;
        $conf['recargo_dia'] =  $datos->body->recargo_dia;
        $conf['recargo_redondeo'] =  $datos->body->recargo_redondeo;
        $conf['anticipos_cuenta'] =  $datos->body->anticipos_cuenta;
        $conf['anticipos_descuentos'] =  $datos->body->anticipos_descuentos;
        $conf['sancion'] =  $datos->body->sancion;
        $conf['notas'] =  $datos->body->notas;
  
        //$filtro = array('tipo_documento'=>'configuracioncxcauto');
        //$configuracioncxcauto = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, $filtro));

        //if(count($configuracioncxcauto) > 0)
          //eliminaDocumento($configuracioncxcauto[0]["_id"]['$id'], 'cont_'.$idcopropiedad);

        //enviarInformacion('cont_'.$datos->body->id_copropiedad, $conf, $app);

        $filtro = array('tipo_documento'=>'inmueble');
        $facturablesdb = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, $filtro));

        $filtro = array('tipo_documento'=>'consecutivos');
        $consecutivos = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, $filtro));

        $filtro = array('_id' => new MongoId($datos->body->id_copropiedad));
        $copropiedad = objectToArray(consultaColeccionRespuesta($app, 'copropiedad', $filtro));
        
        //var_dump($facturablesdb);
        //var_dump($consecutivos);
        //var_dump($copropiedad);

        $recibos = generaRecibos($facturablesdb, $conf, $consecutivos[0], $copropiedad, $app);
        //exit;

        enviarRespuesta($app, true, $recibos , 'null');
      }
      else
      {
        enviarRespuesta($app, false, 'Token invalido', 'null');
      }
    /*}
    catch(Exception $e)
    {
      enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }*/
  });
//METODO ESTADO DE CUENTAS
  $app->options("/estado/cuenta/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post('/estado/cuenta/', function() use($app)
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
          $idcopropiedad = $datos->body->id_copropiedad;
          $filtror = array('tipo_documento'=>'configuracioncxcauto');
          $doccartera = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$idcopropiedad, $filtror));
          $this_cartera = obtenerCarteraDetallada(objectToArray($doccartera));

          if(count($this_cartera) > 0)
          {
            $respuesta = array('conceptos'=> $this_cartera);
          }
          else
          {
            $respuesta = array('conceptos'=> '0');
          }

          enviarRespuesta($app, true, $respuesta , 'null');
        }
        else
        {
          enviarRespuesta($app, false, 'Usuario sin privilegios', 'Usuario sin privilegios');
        }
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
//METODO OBTENER CONFIGURACION
  $app->options("/configuracion/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post('/configuracion/', function() use($app)
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
         enviarRespuesta($app, true,  consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, array('tipo_documento'=>'configuracioncxcauto')), 'null');
        }
        else
        {
          enviarRespuesta($app, false, 'Usuario sin privilegios', 'Usuario sin privilegios');
        }
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
//METODO CARTERA 
  $app->options("/estado/cartera/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post('/estado/cartera/', function() use($app)
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
          $idcopropiedad = $datos->body->id_copropiedad;
          $respuesta = array();

          $filtro = array('tipo_documento'=>'inmueble');
          $facturablesdb = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, $filtro));

          $filtro = array('_id' => new MongoId($datos->body->id_copropiedad));
          $copropiedad = objectToArray(consultaColeccionRespuesta($app, 'copropiedad', $filtro));

          $this_cartera = obtenerCarteraIntegrada($facturablesdb, $copropiedad, $datos->body->id_copropiedad, $app);

          if(count($this_cartera) > 0)
          {
            $respuesta = $this_cartera;
          }
          else
          {
            $respuesta = array('No hay copropietarios con cartera pendiente'=> '0');
          }

          enviarRespuesta($app, true, $respuesta , 'null');
        }
        else
        {
          enviarRespuesta($app, false, 'Usuario sin privilegios', 'Usuario sin privilegios');
        }
      }
      else
      {
        enviarRespuesta($app, false, 'Token invalido', 'null');
      }
    /*}
    catch(Exception $e)
    {
    enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }*/
  });
//METODO CARTERA POR CLIENTE
  $app->options("/estado/cuenta/cliente/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post('/estado/cuenta/cliente/', function() use($app)
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
          $idcopropiedad = $datos->body->id_copropiedad;
          $respuesta = array();
          
          $filtro = array('id_copropiedad'=>$idcopropiedad);
          $usuariosdb = objectToArray(consultaColeccionRespuesta($app, 'usuariocp', $filtro));
          $usuarios = obtenerUsuariosCRM($usuariosdb);

          $filtror = array('tipo_documento'=>'cartera','id_tercero'=>$datos->body->id_crm_persona);
          $doccartera = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$idcopropiedad, $filtror));
          $this_cartera = obtenerCarteraDetalladaTercero($doccartera, $usuarios);

          if(count($this_cartera) > 0)
          {
            $respuesta = $this_cartera;
          }
          else
          {
            $respuesta = array('No hay copropietarios con cartera pendiente'=> '0');
          }

          enviarRespuesta($app, true, $respuesta , 'null');
        }
        else
        {
          enviarRespuesta($app, false, 'Usuario sin privilegios', 'Usuario sin privilegios');
        }
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
//METODO PAGAR FACTURA
  $app->options("/pagar/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post('/pagar/', function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $idcopropiedad = $datos->body->id_copropiedad;
        $pago = $datos->body->firma;
        $respuesta = array();

        $filtror = array('tipo_documento'=>'cartera','doc'=>$datos->body->documento);
        $doccartera = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$idcopropiedad, $filtror));
        $this_cartera = obtenerCarteraDetalladaTercero($doccartera, $usuarios);

        if(count($this_cartera) > 0)
        {
          $respuesta = $this_cartera;
        }
        else
        {
          $respuesta = array('No hay copropietarios con cartera pendiente'=> '0');
        }

        enviarRespuesta($app, true, $respuesta , 'null');
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
//PAGAR POL
  $app->options("/pagarpol/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });
  
  $app->post('/pagarpol/', function() use($app)
  {
    try
    {
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      $requerimiento = $app::getInstance()->request();
      $rtapayu = $requerimiento->params();
      $today = date("c");
      $rtapayu["tipo_documento"] = "respuestapayu";
      $rtapayu["timestamprecibido"] = $today;
      $rta = guardarDato("pagosonline",$rtapayu,$app);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      //$log = "-----------RTAPAYU----------------\n" . json_encode($rtapayu). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      //$log = "-----------RTASAVEPAYU----------------\n" . json_encode($rta). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");

      $muestreo = array("referenceCode"=>$rtapayu["reference_sale"]);
      $pago = objectToArray(consultaColeccionRespuesta($app, "pagosonline", $muestreo))[0];
      //$log = "-----------PAGO----------------\n" . json_encode($pago). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");

      $muestreocont = array("tipo_documento"=>"cartera", "doc"=>$pago['doc']);
      $cartera = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$pago['id_copropiedad'], $muestreocont))[0];
      //$log = "-----------CARTERA----------------\n" . json_encode($cartera). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");

      $modificador=array('$set'=>array("estado"=>$rtapayu['response_code_pol']));
      $dbdata = new DBNosql('pagosonline');
      $resultpagos = $dbdata->updateDocument($muestreo,$modificador);
      //$log = "-----------MODIFICADOR----------------\n" . json_encode($modificador). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      //$log = "-----------RESULTPAGOS----------------\n" . json_encode($resultpagos). "-----------\n";
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);
      //$tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");

      if($rtapayu["response_code_pol"] == 1 || $rtapayu["response_code_pol"] == "1" )
      {
        $muestreocont = array("tipo_documento"=>"cartera", "doc"=>$pago["doc"], "saldo"=>explode(".",$rtapayu['value'])[0]);
        $dbdatacont = new DBNosql('cont_'.$pago['id_copropiedad']);
        $resultadoresta = $cartera["saldo"] - explode(".",$rtapayu['value'])[0];
        //$log = "-----------RESTA----------------\n" . $resultadoresta . "-----------\n";
        $modificador=array('$set'=>array("saldo"=>$resultadoresta));
        $resultcartera = $dbdatacont->updateDocument($muestreocont,$modificador);
        //$log = $log . "-----------muestrecont----------------\n" . json_encode($muestreocont). "-----------\n";
        //$log = $log . "-----------modificador----------------\n" . json_encode($modificador). "-----------\n";
        //$log = $log . "-----------resultcartera----------------\n" . json_encode($resultcartera). "-----------\n";
      }
      //file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . $log);

      enviarRespuesta($app, true, null, null);
    }
    catch(Exception $e)
    {
      $tst = file_get_contents("/datos/app.copropiedad.co/api/cartera/log.txt");
      file_put_contents("/datos/app.copropiedad.co/api/cartera/log.txt", $tst . "ERR: \n" . $e->getMessage() . "-----------\n\n");
    }
  });
//CREAR CARGOS PARA INMUEBLE
  $app->options("/inmueble/cargos/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post('/inmueble/cargos/', function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $inm = array();
        $inm['id_copropiedad'] = $datos->body->id_copropiedad;
        $inm['responsable'] = $datos->body->responsable;
        $inm['nombre_inmueble'] = $datos->body->nombre_inmueble;
        $inm['id_crm_persona'] = $datos->body->id_crm_persona;
        $inm['fecha_creacion'] = $datos->body->fecha_creacion;
        $inm['id_inmueble'] = $datos->body->id_inmueble;
        $inm['cargos'] = $datos->body->cargos;
        $inm['tipo_documento'] = "inmueble";

        enviarInformacion('cont_'. $datos->body->id_copropiedad, $inm, $app);
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });

  $app->put('/inmueble/cargos/', function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $inm = array();
        $inm['id_copropiedad'] = $datos->body->id_copropiedad;
        $inm['responsable'] = $datos->body->responsable;
        $inm['nombre_inmueble'] = $datos->body->nombre_inmueble;
        $inm['id_crm_persona'] = $datos->body->id_crm_persona;
        $inm['fecha_creacion'] = $datos->body->fecha_creacion;
        $inm['id_inmueble'] = $datos->body->id_inmueble;
        $inm['cargos'] = $datos->body->cargos;
        $inm['tipo_documento'] = "inmueble";
        $inm['id'] = $datos->body->id;

        enviarRespuesta($app, true, modificaDocumentoEspecifico($inm, array(), "cont_".$datos->body->id_copropiedad, true), "null");
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });
// IMPORTAR CARGOS DE INMUEBLE
  $app->options("/inmueble/cargos/importar/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post('/inmueble/cargos/importar/', function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $inm = array();
        $inm['id_copropiedad'] = $datos->body->id_copropiedad;
        $inm['responsable'] = $datos->body->responsable;
        $inm['nombre_inmueble'] = $datos->body->nombre_inmueble;
        $inm['id_crm_persona'] = $datos->body->id_crm_persona;
        $inm['fecha_creacion'] = $datos->body->fecha_creacion;
        $inm['id_inmueble'] = $datos->body->id_inmueble;
        $inm['cargos'] = $datos->body->cargos;
        $inm['tipo_documento'] = "inmueble";

        enviarInformacion('cont_'. $datos->body->id_copropiedad, $inm, $app);
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });

  $app->put('/inmueble/cargos/importar/', function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        //eliminaDocumento($id_doc,$coleccion);
        $filtrot = array("tipo_documento" => "inmueble");
        $inmuebles = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, $filtrot));
        $res = "";

        if(count($inmuebles) > 0)
        foreach ($inmuebles as $key => $value) 
        {
          $res = eliminaDocumento($value['_id']['$id'],'cont_'.$datos->body->id_copropiedad);
        }

        enviarRespuesta($app, true, $res, null);
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
    }
  });
//OBTENER INMUEBLES FACTURABLES
  $app->options("/obtener/inmuebles/", function() use($app)
  {
    enviarRespuesta($app, true, "ok", "ok");
  });

  $app->post('/obtener/inmuebles/', function() use($app)
  {
    try
    {
      $requerimiento = $app::getInstance()->request();
      $datos = json_decode($requerimiento->getBody());
      $token = new Token;
      if($token->SetToken($datos->token))
      {
        $filtro = array('tipo_documento'=>'inmueble');
        $facturablesdb = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$datos->body->id_copropiedad, $filtro));

        enviarRespuesta($app, true, $facturablesdb, null);
      }
    }
    catch(Exception $e)
    {
      enviarRespuesta($app, false, 'Error de autenticación', $e->getMessage());
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

   $recurso->response->headers->set('Content-type', 'application/json');
   $recurso->response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-authentication, X-client');
   $recurso->response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
   $recurso->response->status(200);
   $recurso->response->body(json_encode($envio));
  }

  function consultaColeccion($app, $coleccion, $arreglo)
  {
    $dbdata = new DBNosql($coleccion);  
    $resultado = $dbdata->selectDocument($arreglo); 
    if ($resultado){enviarRespuesta($app, true, $resultado, 'null');}
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

  function guardarDato($lista,$data,$app)
  {
    $dbdata=new DBNosql($lista);
    $arreglo = json_decode(json_encode($data), true);
    $resultado=$dbdata->insertDocument($arreglo);
    $validador=get_object_vars($resultado);
    $validador=implode(",", $validador);
    return $validador;
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

  function modificaDocumentoEspecifico($doc, $fields, $coleccion, $completo = true)
  {
    $aidi = $doc['id'];

    if(!$completo)
      foreach ($fields as $k => $v) 
      {
        if(array_key_exists($k, $doc))
          $doc[$k] = $v;
      }

    unset($doc['id']);
    $muestreo = array("_id"=>new MongoId($aidi));
    $dbdata = new DBNosql($coleccion);         
    $result = $dbdata->updateDocument($muestreo, $doc);

    return $result;
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


  function validateRole()
  {
    return true;
  }

//FUNCIONES PARA LOGICA DE NEGOCIO
  /*********   FUNCIONES PARA GENERAR RECIBOS ***********/
    function generaRecibos($clientes, $conf, $consecutivos, $copropiedad, $appl)
    {
      date_default_timezone_set('America/Bogota');
      $today = date('c');
      $consecutivo = $consecutivos['cc'];
      $nombre_copropiedad = $copropiedad[0]['nombre'];
      $recibos = array();
      $recargos_extra = array();
      $mes = obtenerMes($conf['month']);
      $corte = $conf['corte'];
      //var_dump($conf);
      //var_dump($clientes);
      $i = 0;
      $filtro = array('id_copropiedad' => $conf['idcopropiedad'], 'principal' => true, 'estado' => 1);
      $principales = obtenerPrincipales(objectToArray(consultaColeccionRespuesta($appl, 'usuariocp', $filtro)));
      //var_dump(json_encode($principales));
      
      if(count($clientes) > 0)
      foreach ($clientes as $key => $cliente)
      {
        $cliente['id_inmueble'] = preg_replace('/[^a-zA-Z0-9\']/', '', $cliente['id_inmueble']);
        if(array_key_exists($cliente['id_inmueble'],$principales))
        {
          $tercero = $principales[$cliente['id_inmueble']]["nombre"];
          $terceroe = $principales[$cliente['id_inmueble']];
          $identificador = $cliente['nombre_inmueble'];
          $id_crm_tercero = (string)$terceroe['id_crm_persona'];
          $concepto = 'Pago administración apartamento ' . $identificador . ' para el mes de ' . $mes . ' de ' . $conf['year'] . '.';
          $monto = $cliente['cargos'];
          //var_dump($cargoscartera);
          //$filtror = array('tipo_documento'=>'cartera','id_tercero'=> (string)$terceroe['id_crm_persona']);
          //$doccartera = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));

          $filtror = array('tipo_documento'=>'transaccion','id_crm_tercero'=> (string)$terceroe['id_crm_persona']);
          $transaccionescliente = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));
          $doctransaccionescliente = ObtenerTransacciones(objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror)));

          $cargoscartera = obtenerCuentasCartera(obtenerCargosFacturablesContables($monto));
          $filtror = array('tipo_documento'=>'registrocontable','tipo'=>'D','cuenta_puc'=> array('$in'=> $cargoscartera));
          $docscarteradebito = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));

          $filtror = array('tipo_documento'=>'registrocontable','tipo'=>'C','cuenta_puc'=> array('$in'=> $cargoscartera));
          $docscarteracredito = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));
          //var_dump($docscarteradebito);
          //var_dump($docscarteracredito);

          /*$filtror = array('tipo_documento'=>'registrocontable','tipo'=>'D','id_transaccion'=> array('$in'=> $doctransaccionescliente));
          $docdeudas = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));

          $filtror = array('tipo_documento'=>'registrocontable','tipo'=>'C','id_transaccion'=> array('$in'=> $doctransaccionescliente));
          $docpagos = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));*/

          $filtror = array('tipo_documento'=>'registrocontable','id_tercero'=> (string)$terceroe['id_crm_persona'], 'tipo'=>'C', 'cuenta_puc' => (string)$conf['anticipos_cuenta']);
          $docanticipos = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));

          $filtror = array('tipo_documento'=>'registrocontable','id_tercero'=> (string)$terceroe['id_crm_persona'], 'tipo'=>'D', 'cuenta_puc' => (string)$conf['anticipos_descuentos']);
          $docdescuentos = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));

          $filtror = array('tipo_documento'=>'registrocontable','id_tercero'=> (string)$terceroe['id_crm_persona'], 'cuenta_puc' => (string)obtenerCuentaCargo($monto, "Administracion"));
          $docpagosanteriorescuenta = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));

          $filtror = array('tipo_documento'=>'registrocontable','id_tercero'=> (string)$terceroe['id_crm_persona'], 'cuenta_puc' => (string)obtenerContraCargo($monto, "Administracion"));
          $docpagosanteriorescontra = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$conf['idcopropiedad'], $filtror));
          
          $recibo = array();
          $recibo["consecutivo"] = 'CC' . (string)((int)$consecutivo + $i);
          $recibo["nombre_copropiedad"] = $nombre_copropiedad;
          $recibo["concepto"] = $concepto;
          $recibo["tercero"] = $terceroe['nombre'];
          $recibo["inmueble"] = $identificador;
          $recibo["cargos"] = obtenerCargosFacturables($monto);
          //var_dump($recibo["consecutivo"]);
          //  $recibo["canonmensual"] = obtenerTotalPago($monto);
          //var_dump(obtenerCargosFacturablesContables($monto));
          $recibo["id_crm_tercero"] = $terceroe['id_crm_persona'];
          $recibo["notas"] = $conf["notas"];
          //$recibo["cartera"] = (int)totalizaCartera($doccartera) -  (int)totalizaPagosAnteriores($docpagosanteriores);
          $carteracalculada = obtenerNuevaCartera($docscarteradebito, $docscarteracredito, $conf['interes_redondeo'], $conf['interes'], $corte, $recibo["consecutivo"], $id_crm_tercero, $conf['idcopropiedad'], $conf['interes_cuenta'], $conf['interes_contra'], $appl);
          $recibo["cartera"] = $carteracalculada["total"];
          $recibo["mora"] = $carteracalculada["mora"];
          $recibo["thispago"] = redondear(totalPagoActual(obtenerCargosFacturablesContables($monto),$conf['corte'],$recibo["consecutivo"], $concepto, $id_crm_tercero, $conf['idcopropiedad'],$appl),$conf['descuento_redondeo']);
          $recibo["anticipos"] = totalizarAnticipos($docanticipos);
          $recibo["descuentos"] = totalizarDescuentos($docdescuentos);
          $recibo["totalapagar"] = $recibo["thispago"] + $recibo["cartera"] - $recibo["anticipos"] - $recibo["descuentos"];
          if($conf["sancion"] == "descuento")
          {
            $recibo["diaadmin"] = "Para pago antes del dia " . $conf["descuento_admin_dia"];
            $descadmon = descontar($recibo['cargos']['Administracion'],$conf["descuento_admin"]);
            $pagodes = $recibo["thispago"] - $descadmon;
            $recibo["descadmin"] = redondear($pagodes,$conf['descuento_redondeo']);
          }
          elseif($conf["recargo"])
          {
            $recibo["diarecargo"] = "Para pago después del dia " . $conf["recargo_dia"];
            $recadmon = recargar($recibo['cargos']['Administracion'],$conf["recargo"]);
            $pagorec = $recibo["thispago"] + $recadmon;
            $recibo["recargo"] = redondear($pagorec,$conf['recargo_redondeo']);
          }
          $recibos[] = $recibo;
          creaTransaccion($conf['idcopropiedad'], $conf['id_crm_persona'], $id_crm_tercero, $consecutivo + $i, $tercero, "", $concepto, $conf['notas'], $appl, $corte);
          $i++;
        }
      }

      actualizaConsecutivos($conf['idcopropiedad'], $i, "cc", $consecutivos);
      //var_dump($recibos);
      return $recibos;
    }

    function obtenerMes($mes)
    {
      $meses = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
      return $meses[(int)$mes];
    }

    function obtenerPrincipales($usuarios)
    {
      $principales = array();
      if(count($usuarios) > 0)
      foreach ($usuarios as $key => $value) 
      {
        $principales[$value['unidad']] = $value;
      }
      return $principales;
    }

    function ObtenerTransacciones($tx)
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

    function obtenerCargosFacturables($cargos)
    {
      $out = array();
      foreach (explode(',',$cargos) as $key => $value) 
      {
        $nombre_cargo = explode('|',$value)[1];
        $cuenta = explode('|',$value)[2];
        $contra = explode('|',$value)[3];
        $valor = explode('|',$value)[4];
        $out[$nombre_cargo] = $valor;
      }
      return $out;
    }

    function obtenerCargosFacturablesContables($cargos)
    {
      $out = array();
      foreach (explode(',',$cargos) as $key => $value) 
      {
        $nombre_cargo = explode('|',$value)[1];
        $cuenta = explode('|',$value)[2];
        $contra = explode('|',$value)[3];
        $valor = explode('|',$value)[4];
        $out[$nombre_cargo] = $valor . "|" . $cuenta . "|" . $contra . "|" . $nombre_cargo;
      }
      return $out;
    }

    function totalPagoActual($cargos, $corte, $idtransaccion, $concepto, $tercero, $idcopropiedad, $appl)
    { 
      //var_dump($idtransaccion);
      $acumulador = 0;
      if(count($cargos) > 0)
      foreach ($cargos as $key => $value) 
      {
        $acumulador = $acumulador + explode("|",$value)[0];
        creaRegistro($corte, $idtransaccion, explode("|",$value)[1], "C", explode("|",$value)[0], $concepto . " - " . explode("|",$value)[3], $tercero, $idcopropiedad, $appl);
        creaRegistro($corte, $idtransaccion, explode("|",$value)[2], "D", explode("|",$value)[0], $concepto . " - " . explode("|",$value)[3], $tercero, $idcopropiedad, $appl);
        //creaCargo($corte, explode("|",$value)[0], $tercero, $idtransaccion, $appl, $idcopropiedad, $concepto . " - " . explode("|",$value)[3]);
      }
      return $acumulador;
    }

    function redondear($valor, $redondeo)
    {
      if($redondeo == 0)
        return $valor;

      if($redondeo == 10)
        return round($valor, -1);

      if($redondeo == 100)
        return round($valor, -2);

      if($redondeo == 1000)
        return round($valor, -3);
    }

    function totalizarAnticipos($anticipos)
    {
      $out = 0;
      if(count($anticipos) > 0)
      foreach ($anticipos as $key => $value) 
      {
        $out = $out + $value['monto'];
      }
      return $out;
    }

    function totalizarDescuentos($descuentos)
    {
      $out = 0;
      if(count($descuentos) > 0)
      foreach ($descuentos as $key => $value) 
      {
        $out = $out + $value['monto'];
      }
      return $out;
    }

    function descontar($valor, $descuento)
    {
      if($descuento > 100)
      {
        return $descuento;
      }
      else
      {
        return ($valor * ($descuento)/100);
      }
    }

    function recargar($valor, $recargo)
    {
      if($recargo > 100)
      {
        return $recargo;
      }
      else
      {
        return ($valor * ($recargo)/100);
      }
    }

    function creaTransaccion($idcopropiedad, $id_crm_persona, $id_crm_tercero, $consecutivo, $tercero, $email_tercero, $concepto, $notas, $appl, $corte)
    {
      $today = date('c');
      $year = explode('-',$corte)[0];
      $month = explode('-',$corte)[1];
      $day = explode('-',$corte)[2];

      $arr = array('id_crm_persona' => $id_crm_persona, 'fecha_creacion' => $today, 'year' => $year, 'mes' => $month, 'day' => $day, 'tipo' => 'CC', 'idtransaccion' => 'CC'.$consecutivo, 'nombre_tercero' => $tercero, 'email_tercero' => $email_tercero, 'id_crm_tercero' => $id_crm_tercero,'concepto_documento' => $concepto, 'moneda' => 'COP', 'vendedor_fv' => '', 'forma_pago' => '', 'notas' => $notas, 'anulado' => 'NO', 'tipo_documento' => 'transaccion', 'conciliado' => false);
      return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
    }

    function creaCargo($corte, $monto, $tercero, $doc_asoc, $appl, $idcopropiedad, $concepto)
    {
      $today = date('c');
      $year = explode('-',$corte)[0];
      $month = explode('-',$corte)[1];
      $day = explode('-',$corte)[2];
      $cargosexistentes = consultaColeccionRespuesta($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cartera", "doc" => (string)$doc_asoc));
      if(count($cargosexistentes) > 0)
          $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>count($cargosexistentes) + 1);
        else
          $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>"1");
      return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
    }

    function actualizaConsecutivos($idcopropiedad, $incremento, $tipo, $consecutivos)
    {
      $consecutivos[$tipo] = $consecutivos[$tipo] + $incremento;
      return modificaDocumento($consecutivos, array(), "cont_".$idcopropiedad, true);
    }

    function creaRegistro($corte, $idtransaccion, $cuenta, $tipo, $monto, $concepto, $tercero, $idcopropiedad, $appl)
    {
      $today = date('c');
      $year = explode('-',$corte)[0];
      $month = explode('-',$corte)[1];
      $day = explode('-',$corte)[2];

      $arr = array("fecha_movimiento" => $today, "id_transaccion"=>$idtransaccion, "cuenta_puc" => $cuenta, "tipo" => $tipo, "monto" => $monto, "concepto" => $concepto, "id_tercero" => $tercero, "year" => $year, "month" => $month, "day" => $day, "estado" => "A", "tipo_documento" => "registrocontable");
      return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
    }

    function obtenerIntereses($inicio, $corte, $monto, $interes, $idtransaccion, $tercero, $idcopropiedad, $cuenta, $contra, $appl, $redondeo)
    {
      $meses = calcularMesesMora($inicio, $corte);
      $mora = $meses * ($monto * ($interes)/100);
      $mora = redondear($mora,$redondeo);
      creaRegistro($corte, $idtransaccion, $contra, "C", $mora, "Intereses " . $idtransaccion, $tercero, $idcopropiedad, $appl);
      creaRegistro($corte, $idtransaccion, $cuenta, "D", $mora, "Intereses " . $idtransaccion, $tercero, $idcopropiedad, $appl);
      //creaCargo($corte, explode("|",$value)[0], $tercero, $idtransaccion, $appl, $idcopropiedad, $concepto . " - " . explode("|",$value)[3]);
      return $mora;
    }

    function calcularMesesMora($start, $corte)
    {
      $d1 = new DateTime($start);
      $d2 = new DateTime($corte);

      $min_dif = $d1->diff($d2)->m;
      $max_dif = ($d1->diff($d2)->m) + ($d1->diff($d2)->y*12);

      if($min_dif > $max_dif)
        return $min_dif;
      elseif($min_dif <= $max_dif)
        return $max_dif;
    }

    function obtenerCuentaCargo($cargos, $nombre_cargo_solicitado)
    {
      $out = "0";
      foreach (explode(',',$cargos) as $key => $value) 
      {
        $nombre_cargo = explode('|',$value)[1];
        $cuenta = explode('|',$value)[2];
        $contra = explode('|',$value)[3];
        $valor = explode('|',$value)[4];
        if($nombre_cargo == $nombre_cargo_solicitado)
          $out = $cuenta;
      }
      return $out;
    }

    function obtenerContraCargo($cargos, $nombre_cargo_solicitado)
    {
      $out = "0";
      foreach (explode(',',$cargos) as $key => $value) 
      {
        $nombre_cargo = explode('|',$value)[1];
        $cuenta = explode('|',$value)[2];
        $contra = explode('|',$value)[3];
        $valor = explode('|',$value)[4];
        if($nombre_cargo == $nombre_cargo_solicitado)
          $out = $contra;
      }
      return $out;
    }

    function obtenerCuentasCartera($cuentas)
    {
      $out = array();
      if(count($cuentas) > 0)
        foreach ($cuentas as $key => $value) 
        {
          $out[] = explode('|',$value)[2];
        }
      return $out;
    }
  /*******************************/

  /************  FUNCIONES CARTERA ***********/
    function obtenerCarteraDetallada($docs)
    {
      $out = array();

      for ($i=0; $i < count($docs); $i++)
      { 
        switch ($docs[$i]['tipo_mov']) 
        {
          case 'cargo':
            $out[$docs[$i]['concepto']] = $docs[$i]['saldo'];
          break;

          case 'interes':
            if(array_key_exists('interes', $out))
              $out['interes'] = $out['interes'] + $docs[$i]['monto'];
            else
              $out['interes'] = $docs[$i]['monto'];
          break;

          case 'sancion':
            if(array_key_exists('sanciones', $out))
              $out['sancion'] = $out['sancion'] + $docs[$i]['monto'];
            else
              $out['sancion'] = $docs[$i]['monto'];
          break;
          
          default:
            break;
        }
        //$acum = $acum + $docs[$i]['saldo'];
      }

      return $out;
    }

    function obtenerCarteraDetalladaTercero($docs,$terceros)
    {
      $out = array();

      for ($i=0; $i < count($docs); $i++)
      { 
        if($docs[$i]['saldo'] > 0)
        switch ($docs[$i]['tipo_mov']) 
        {
          case 'cargo':
              $out[] = array("concepto" => $docs[$i]['concepto'], "monto" => $docs[$i]['saldo'], "documento" => $docs[$i]['doc']);
          break;

          case 'interes':
            if(array_key_exists('interes', $out[$docs[$i]['id_tercero']]))
              $out[$terceros[$docs[$i]['id_tercero']]]['interes'] = $out[$terceros[$docs[$i]['id_tercero']]]['interes']  + $docs[$i]['monto'];
            else
              $out[$terceros[$docs[$i]['id_tercero']]]['interes'] = $docs[$i]['monto'];
          break;

          case 'sancion':
            if(array_key_exists('sanciones', $out[$docs[$i]['id_tercero']]))
              $out[$terceros[$docs[$i]['id_tercero']]]['sancion'] = $out[$terceros[$docs[$i]['id_tercero']]]['sancion'] + $docs[$i]['monto'];
            else
              $out[$terceros[$docs[$i]['id_tercero']]]['sancion'] = $docs[$i]['monto'];
          break;
          
          default:
            break;
        }
        //$acum = $acum + $docs[$i]['saldo'];
      }

      return $out;
    }

    function obtenerUsuariosCRM($usuarios)
    {
      $users = array();
      if(count($usuarios) > 0)
      foreach ($usuarios as $key => $value) 
      {
        $users[$value['id_crm_persona']] = $value['nombre'];
      }
      return $users;
    }

    function obtenerCarteraIntegrada($clientes, $copropiedad, $id_copropiedad, $appl)
    {
      $out = array();
      $filtro = array('id_copropiedad' => $id_copropiedad, 'principal' => true, 'estado' => 1);
      $principales = obtenerPrincipales(objectToArray(consultaColeccionRespuesta($appl, 'usuariocp', $filtro)));

      //var_dump($principales);

      if(count($clientes) > 0)
      foreach ($clientes as $key => $cliente)
      {
        $cliente['id_inmueble'] = preg_replace('/[^a-zA-Z0-9\']/', '', $cliente['id_inmueble']);
        if(array_key_exists($cliente['id_inmueble'],$principales))
        {
          //var_dump($cliente);
          $tercero = $principales[$cliente['id_inmueble']]["nombre"];
          $terceroe = $principales[$cliente['id_inmueble']];
          $identificador = $cliente['nombre_inmueble'];
          $id_crm_tercero = (string)$terceroe['id_crm_persona'];
          //var_dump($id_crm_tercero);

          $filtror = array('tipo_documento'=>'transaccion','id_crm_tercero'=> (string)$terceroe['id_crm_persona']);
          $transaccionescliente = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror));
          $doctransaccionescliente = ObtenerTransacciones(objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror)));

          $cargoscartera = obtenerCuentasCartera(obtenerCargosFacturablesContables($cliente['cargos']));
          $filtror = array('tipo_documento'=>'registrocontable','tipo'=>'D','cuenta_puc'=> array('$in'=> $cargoscartera));
          $docscarteradebito = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror));

          $filtror = array('tipo_documento'=>'registrocontable','tipo'=>'C','cuenta_puc'=> array('$in'=> $cargoscartera));
          $docscarteracredito = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror));
          /*$acum2 = 0;
          foreach ($docpagos as $key => $value) 
          {
            $acum2 = $acum2 + $value['monto'];
          }
          var_dump($acum1, $acum2, $acum2 - $acum1);*/
          //exit;

          $carteraelem = array();
          $carteraelem['nombre'] = $cliente["responsable"];
          $carteraelem['inmueble'] = $cliente["nombre_inmueble"];
          $carteraelem['cartera'] = limpiarCartera(obtenerNuevaCarteraCuenta($docscarteradebito, $docscarteracredito, '0', '0'));
          //var_dump($tercero, $carteraelem);
          
          $out[] = $carteraelem;
        }
      }
      //var_dump($out);
      return organizarCartera($out);
    }

    function limpiarCartera($cartera)
    { 
      $out = array();
      if(count($cartera) > 0)
        foreach ($cartera["deudas"] as $key => $value) 
        {
          if((int)$value > 0)
            $out[$key] = $value;
        }
      $cartera["deudas"] = $out;
      return $cartera;  
    }

    function organizarCartera($cartera)
    {
      $out = array();
      if(count($cartera) > 0)
        foreach ($cartera as $k => $v) 
        {
          //var_dump($v['cartera']);
          foreach ($v["cartera"]["deudas"] as $key => $value) 
          {
            $elem = array();
            $elem["copropietario"] = $v["nombre"];
            $elem["inmueble"] = $v["inmueble"];
            $elem["documento"] = $key;
            $elem["valor"] = $value;
            $elem["total"] = $v["cartera"]["total"];
            $out[] = $elem;
          }
        }
      return $out;
    }

    function obtenerInteresesCartera($inicio, $corte, $monto, $interes)
    {
      $meses = calcularMesesMora($inicio, $corte);
      $mora = $meses * ($monto * ($interes)/100);
      $mora = redondear($mora,0);
      return $mora;
    }

    function obtenerNuevaCartera($debito, $credito, $intredondeo, $interes, $corte, $idtransaccion, $tercero, $idcopropiedad, $cuenta, $contra, $appl)
    {
      $acumulador = 0;
      $deudas = array();
      $pagos = array();
      $fechas = array();
      $deudasacumuladas = 0;
      $mora = 0;

      if(count($debito) > 0)
        foreach ($debito as $key => $value) 
        {
          //var_dump($value);
          if(array_key_exists($value['id_transaccion'],$deudas))
            $deudas[$value['id_transaccion']] = (int)$deudas[$value['id_transaccion']] + (int)$value['monto'];
          else
            $deudas[$value['id_transaccion']] = (int)$value['monto'];

          $fechas[$value['id_transaccion']] = (string)$value['year'] . '/' . (string)$value['month'] . '/' . (string)$value['day'];
        }
      //var_dump($deudas);

      if(count($credito) > 0)
        foreach ($credito as $key => $value) 
        {
          //var_dump($value);
          if(array_key_exists($value['id_transaccion'],$pagos))
            $pagos[$value['id_transaccion']] = (int)$pagos[$value['id_transaccion']] + (int)$value['monto'];
          else
            $pagos[$value['id_transaccion']] = (int)$value['monto'];

          $acumulador = $acumulador + $value['monto'];
        }
      //var_dump($pagos);
      //var_dump($fechas);
      //var_dump($acumulador);

      if (count($deudas) > 0)
      {
          foreach ($deudas as $key => $value) 
          {
            $resultado = $acumulador - $value;
            if($value < $acumulador)
            {
              $acumulador = $acumulador - $value;
              $deudas[$key] = 0;
            }
            else if($value > $acumulador)
            {
              $deudas[$key] = ($acumulador - $value) * -1;
              $acumulador =  0;
            }
            else if($value == $acumulador)
            {
              $deudas[$key] = 0;
              $acumulador = $acumulador - $value;
            }
          }
          //var_dump($deudas);
        
        foreach ($deudas as $key => $value) 
        {
          //var_dump($txordenadas[$key]);
          $interesmora = obtenerIntereses($fechas[$key], $corte, $value, $interes, $idtransaccion, $tercero, $idcopropiedad, $cuenta, $contra, $appl, $intredondeo);
          //var_dump($interesmora);
          $deudasacumuladas = $deudasacumuladas + $value;
          $mora = $interesmora + $mora;
        }

      }

      $out['total'] = $deudasacumuladas + $mora;
      $out['deudas'] = $deudas;
      $out['mora'] = $mora;
      //var_dump($out);
      //exit;
      return $out;
    }

    function obtenerNuevaCarteraCuenta($debito, $credito, $intredondeo, $interes)
    {
      $acumulador = 0;
      $deudas = array();
      $pagos = array();
      $fechas = array();
      $deudasacumuladas = 0;
      $mora = 0;
      $corte = date('Y-m-d'); 

      if(count($debito) > 0)
        foreach ($debito as $key => $value) 
        {
          //var_dump($value);
          if(array_key_exists($value['id_transaccion'],$deudas))
            $deudas[$value['id_transaccion']] = (int)$deudas[$value['id_transaccion']] + (int)$value['monto'];
          else
            $deudas[$value['id_transaccion']] = (int)$value['monto'];

          $fechas[$value['id_transaccion']] = (string)$value['year'] . '-' . (string)$value['month'] . '-' . (string)$value['day'];
        }
      //var_dump($deudas);

      if(count($credito) > 0)
        foreach ($credito as $key => $value) 
        {
          //var_dump($value);
          if(array_key_exists($value['id_transaccion'],$pagos))
            $pagos[$value['id_transaccion']] = (int)$pagos[$value['id_transaccion']] + (int)$value['monto'];
          else
            $pagos[$value['id_transaccion']] = (int)$value['monto'];

          $acumulador = $acumulador + $value['monto'];
        }
      //var_dump($pagos);
      //var_dump($fechas);
      //var_dump($acumulador);

      if (count($deudas) > 0)
      {
          foreach ($deudas as $key => $value) 
          {
            $resultado = $acumulador - $value;
            if($value < $acumulador)
            {
              $acumulador = $acumulador - $value;
              $deudas[$key] = 0;
            }
            else if($value > $acumulador)
            {
              $deudas[$key] = ($acumulador - $value) * -1;
              $acumulador =  0;
            }
            else if($value == $acumulador)
            {
              $deudas[$key] = 0;
              $acumulador = $acumulador - $value;
            }
          }
          //var_dump($deudas);
        
        foreach ($deudas as $key => $value) 
        {
          //var_dump($txordenadas[$key]);
          $interesmora = obtenerInteresesCartera($fechas[$key], $corte, $value, $interes);
          //var_dump($interesmora);
          $deudasacumuladas = $deudasacumuladas + $value;
          $mora = $interesmora + $mora;
        }
      }

      $out['total'] = $deudasacumuladas + $mora;
      $out['deudas'] = $deudas;
      $out['mora'] = $mora;
      //var_dump($out);
      //exit;
      return $out;
    }
  /*******************************/

/******* DEPRECATED *******/
  /*function obtenerCartera($docs)
  {
    $out = array();
    $acum = 0;
    $interes = 0;
    $sancion = 0;

    for ($i=0; $i < count($docs); $i++)
    { 
      switch ($docs[$i]['tipo_mov']) 
      {
        case 'cargo':
          if(array_key_exists('ttal', $out))
            $acum = $acum + $docs[$i]['saldo'];
          else
            $acum = $docs[$i]['saldo'];
        break;

        case 'interes':
          if(array_key_exists('interes', $out))
            $interes = $interes + $docs[$i]['monto'];
          else
            $interes = $docs[$i]['monto'];
        break;

        case 'sancion':
          if(array_key_exists('sanciones', $out))
            $sancion = $sancion + $docs[$i]['monto'];
          else
            $sancion = $docs[$i]['monto'];
        break;
        
        default:
          break;
      }
      //$acum = $acum + $docs[$i]['saldo'];
    }

    return $acum . "," . $interes . "," . $sancion;
  }*/

  /*function obtenerCarteraDetalladaTerceros($usuarios,$terceros, $unidades)
  {
    $out = array();
    $docs = $usuarios;
    //var_dump($terceros);
    //exit;
    for ($i=0; $i < count($docs); $i++)
    { 
      if($docs[$i]['saldo'] > 0)
      switch ($docs[$i]['tipo_mov']) 
      {
        case 'cargo':
          if(array_key_exists($docs[$i]['id_tercero'], $out))
            $out[$docs[$i]['id_tercero']] = $out[$docs[$i]['id_tercero']] + $docs[$i]['saldo'];
          else
            $out[$docs[$i]['id_tercero']] = $docs[$i]['saldo'];
          //var_dump($out);
        break;

        case 'interes':
          if(array_key_exists('interes', $out[$docs[$i]['id_tercero']]))
            $out[$docs[$i]['id_tercero']]['interes'] = $out[$terceros[$docs[$i]['id_tercero']]]['interes']  + $docs[$i]['monto'];
          else
            $out[$docs[$i]['id_tercero']]['interes'] = $docs[$i]['monto'];
        break;

        case 'sancion':
          if(array_key_exists('sanciones', $out[$docs[$i]['id_tercero']]))
            $out[$docs[$i]['id_tercero']]['sancion'] = $out[$terceros[$docs[$i]['id_tercero']]]['sancion'] + $docs[$i]['monto'];
          else
            $out[$docs[$i]['id_tercero']]['sancion'] = $docs[$i]['monto'];
        break;
        
        default:
          break;
      }
      //$acum = $acum + $docs[$i]['saldo'];
    }

    //$salida = array();
    //foreach ($out as $key => $value) 
    //{
    //  $salida[$key . "|" . $unidades[$key]]
    //}
    return $out;
  }*/

  /*function calculaMesesMora($start, $end)
  {
    $d1 = new DateTime($start);
    $d2 = new DateTime($end);

    $min_dif = $d1->diff($d2)->m;
    $max_dif = ($d1->diff($d2)->m) + ($d1->diff($d2)->y*12);

    if($min_dif > $max_dif)
      return $min_dif;
    elseif($min_dif <= $max_dif)
      return $max_dif;
  }*/

  /*function calculaRecargo($monto, $interes)
  {
    $tasa = $interes / 100;
    return $monto * $tasa;
  }*/

  /*function totalizaPago($cargos, $apagar, $corte, $idtransaccion, $concepto, $tercero, $idcopropiedad, $appl)
  {
    $resultado = array();
    $cargos = explode(',',$cargos);
    $acum = 0;
    for ($i=0; $i < 30; $i++) 
    { 
      foreach (explode(',',$apagar) as $key => $value) 
      {
        $id = explode('|',$value)[0];
        if($id == $i)
        {
          $nombre_cargo = explode('|',$value)[1];
          $cuenta = explode('|',$value)[2];
          $contra = explode('|',$value)[3];
          $valor = explode('|',$value)[4];
          $acum = $acum + $valor;
          creaRegistro($corte, $idtransaccion, $cuenta, "C", $valor, $concepto . " - " . $nombre_cargo, $tercero, $idcopropiedad, $appl);
          creaRegistro($corte, $idtransaccion, $contra, "D", $valor, $concepto . " - " . $nombre_cargo, $tercero, $idcopropiedad, $appl);
          creaCargo($corte, $valor, $tercero, $idtransaccion, $appl, $idcopropiedad, $concepto . " - " . $nombre_cargo);
        }
      }
    }
    return $acum;
  }*/

  /*function obtenerUnidadNombre($unidad)
  {
    $unidades = array();
    if(count($unidad) > 0)
    foreach ($unidad as $key => $value) 
    {
      $unidades[$value['_id']['$id']] = $value['nombre_inmueble'];
    }
    return $unidades;
  }*/

  /*function obtenerUsuarioPorId($usuarios)
  {
    $users = array();
    if(count($usuarios) > 0)
    foreach ($usuarios as $key => $value) 
    {
      $users[$value['_id']['$id']] = $value['nombre'];
    }
    return $users;
  }*/

  /*function obtenerUsuarioPorUnidad($usuarios)
  {
    $users = array();
    if(count($usuarios) > 0)
    foreach ($usuarios as $key => $value) 
    {
      $users[$value['id_crm_persona']] = $value['unidad'];
    }
    return $users;
  }*/

  /*function detallarCarteraPorInmueble($cartera, $unidades, $usuarios, $usuarioscrm)
  {
    $out = array();
    if(count($cartera) > 0)
    foreach ($cartera as $key => $value) 
    {
        if(array_key_exists($key,$usuarioscrm))
          $out[] = array('copropietario' => $usuarioscrm[$key], 'cartera' => $value, 'id_crm' => $key);
        //if(array_key_exists($usuarioscrm[$key],$unidades))
        //  var_dump($unidades[$usuarioscrm[$key]]);
    }
    return $out;
  }*/

  /*function totalizaCartera($cartera)
  {
    $acum = 0;
    if(count($cartera) > 0)
      foreach ($cartera as $key => $value) 
      {
        $acum = $acum + $value['saldo'];
      }
    return $acum;
  }*/

  /*function totalizaPagosAnteriores($docpagosanteriores)
  {
    $acum = 0;
    if(count($docpagosanteriores) > 0)
      foreach ($docpagosanteriores as $key => $value) 
      {
        if($value['tipo'] == 'D')
          $acum = $acum + $value['monto'];
      }
    var_dump($acum);
    return $acum;
  }*/

  /*function obtenerInmuebles($cartera, $unidades, $usuarios)
  {
    $salida = array();
    //var_dump($unidades);
    //var_dump($usuarios);
    if(count($cartera) > 0)
        foreach ($cartera as $key => $value) 
        {
          if(array_key_exists($usuarios[$value['id_crm']],$unidades))
          {
            $out = array();
            $out["inmueble"] = $unidades[$usuarios[$value['id_crm']]];
            $out["copropietario"] = $value['copropietario'];
            $out["id_crm"] = $value['id_crm'];
            $out["cartera"] = $value["cartera"];
            $salida[] = $out;
          }
        }
    return $salida;
  }*/

  /*function obtenerTotalPago($cargos)
  {
    $out = 0;
    foreach (explode(',',$cargos) as $key => $value) 
    {
      $valor = explode('|',$value)[4];
      $out = $out + $valor;
    }
    return $out;
  }*/

  /*function obtenerUsuarios($usuarios)
  {
    $users = array();
    foreach ($usuarios as $key => $value) 
    {
      $users[$value['_id']['$id']] = $value['id_crm_persona'];
    }
    return $users;
  }

  function obtenerUnidades($unidades)
  {
    $unidad = array();
    foreach ($unidades as $key => $value) 
    {
        $unidad[$value['_id']['$id']] = $value;
    }
    //var_dump($unidad);
    return $unidad;
  }*/


  /*function obtenerCarteraActual($transaccionescliente, $docdeudas, $docpagos, $intredondeo, $interes)
  {
    $out = array();
    $asociados = array();
    $deudas = array();
    $pagos = array();
    $acumulador = 0;
    $deudasacumuladas = 0;
    $mora = 0;
    $txordenadas = array();
    //var_dump("usuario nuevo ----------");
    //var_dump($docpagos);

    if(count($transaccionescliente) > 0)
      foreach ($transaccionescliente as $k => $v) 
      {
        if($v['tipo'] == 'RC' || $v['tipo'] == 'NC') 
        {
          foreach ($transaccionescliente as $key => $value) 
          {
            if($value['idtransaccion'] == $v['docrelacionado'])
            {
              $elem = array();
              $elem['docrelacionado'] = $v['idtransaccion'];
              $elem['tx'] =$v['docrelacionado'];
              $elem['year'] = $v['year'];
              $elem['mes'] = $v['mes'];
              $elem['idtercero'] = $v['id_crm_tercero'];
              $asociados[$v['idtransaccion']] = $elem;
            }
          }
        }

        $txordenadas[$v['idtransaccion']] = $v;
      }
      //var_dump($asociados);
    if(count($docdeudas) > 0)
      foreach ($docdeudas as $key => $value) 
      {
        //var_dump($value);
        if(array_key_exists($value['id_transaccion'],$deudas))
          $deudas[$value['id_transaccion']] = (int)$deudas[$value['id_transaccion']] + (int)$value['monto'];
        else
          $deudas[$value['id_transaccion']] = (int)$value['monto'];
      }
    //var_dump($deudas);

    if(count($docpagos) > 0)
      foreach ($docpagos as $key => $value) 
      {
        if(array_key_exists($value['id_transaccion'],$pagos))
          $pagos[$value['id_transaccion']] = (int)$pagos[$value['id_transaccion']] + (int)$value['monto'];
        else
          $pagos[$value['id_transaccion']] = (int)$value['monto'];

        $acumulador = $acumulador + $value['monto'];
      }
    //var_dump($pagos);

    if (count($deudas) > 0)
    {
        foreach ($deudas as $key => $value) 
        {
          $resultado = $acumulador - $value;
          if($value < $acumulador)
          {
            $acumulador = $acumulador - $value;
            $deudas[$key] = 0;
          }
          else if($value > $acumulador)
          {
          //var_dump($acumulador);
            $deudas[$key] = ($acumulador - $value) * -1;
            $acumulador =  0;
          }
          else if($value == $acumulador)
          {
            $deudas[$key] = 0;
            $acumulador = $acumulador - $value;
          }
        }
      
      foreach ($deudas as $key => $value) 
      {
        //var_dump($txordenadas[$key]);
        $intereses = redondear(obtenerIntereses($txordenadas[$key], $value, $interes),$intredondeo);
        $deudasacumuladas = $deudasacumuladas + $value;
        $mora = $intereses + $mora;
      }

    }

    $out['total'] = $deudasacumuladas;
    $out['deudas'] = $deudas;
    $out['mora'] = $mora;
    //var_dump($out);
    //exit;
    return $out;
  }*/


  /*function obtenerCarteraIntegrada($clientes, $copropiedad, $id_copropiedad, $appl)
  {
    $out = array();
    $filtro = array('id_copropiedad' => $id_copropiedad, 'principal' => true, 'estado' => 1);
    $principales = obtenerPrincipales(objectToArray(consultaColeccionRespuesta($appl, 'usuariocp', $filtro)));

    //var_dump($principales);

    if(count($clientes) > 0)
    foreach ($clientes as $key => $cliente)
    {
      $cliente['id_inmueble'] = preg_replace('/[^a-zA-Z0-9\']/', '', $cliente['id_inmueble']);
      if(array_key_exists($cliente['id_inmueble'],$principales))
      {
        $tercero = $principales[$cliente['id_inmueble']]["nombre"];
        $terceroe = $principales[$cliente['id_inmueble']];
        $identificador = $cliente['nombre_inmueble'];
        $id_crm_tercero = (string)$terceroe['id_crm_persona'];
        //var_dump($id_crm_tercero);

        $filtror = array('tipo_documento'=>'transaccion','id_crm_tercero'=> (string)$terceroe['id_crm_persona']);
        $transaccionescliente = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror));
        $doctransaccionescliente = ObtenerTransacciones(objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror)));
        
        $filtror = array('tipo_documento'=>"registrocontable",'tipo'=>'D','id_transaccion'=> array('$in'=> $doctransaccionescliente));
        $docdeudas = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror));

        $filtror = array('tipo_documento'=>"registrocontable",'tipo'=>'C','id_transaccion'=> array('$in'=> $doctransaccionescliente));
        $docpagos = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$id_copropiedad, $filtror));
        $acum2 = 0;
        foreach ($docpagos as $key => $value) 
        {
          $acum2 = $acum2 + $value['monto'];
        }
        var_dump($acum1, $acum2, $acum2 - $acum1);
        //exit;

        $carteraelem = array();
        $carteraelem['nombre'] = $cliente["responsable"];
        $carteraelem['inmueble'] = $cliente["nombre_inmueble"];
        $carteraelem['cartera'] = limpiarCartera(obtenerCarteraActual($transaccionescliente, $docdeudas, $docpagos, '0', '0'));
        //var_dump($tercero, $carteraelem);
        
        $out[] = $carteraelem;
      }
    }
    //var_dump($out);
    return organizarCartera($out);
  }*/
/****************************/