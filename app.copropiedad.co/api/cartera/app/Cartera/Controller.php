<?php
require_once('app/Model/config.php');
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
          $year = $datos->body->year;
          $month = $datos->body->month;
          $conf['cargos'] =  $datos->body->cargos;
          $conf['interes_incluir'] =  $datos->body->interes_incluir;
          $conf['interes_cuenta'] =  $datos->body->interes_cuenta;
          $conf['interes_contra'] =  $datos->body->interes_contra;
          $conf['interes_porcentaje'] =  $datos->body->interes_porcentaje;
          $conf['interes_redondeo'] =  $datos->body->interes_redondeo;
          $conf['descuento_admin_incluir'] =  $datos->body->descuento_admin_incluir;
          $conf['descuento_admin_porcentaje'] =  $datos->body->descuento_admin_porcentaje;
          $conf['descuento_admin_monto'] =  $datos->body->descuento_admin_monto;
          $conf['descuento_admin_dia'] =  $datos->body->descuento_admin_dia;
          $conf['descuento_parqueadero_incluir'] =  $datos->body->descuento_parqueadero_incluir;
          $conf['descuento_parqueadero_porcentaje'] =  $datos->body->descuento_parqueadero_porcentaje;
          $conf['descuento_parqueadero_monto'] =  $datos->body->descuento_parqueadero_monto;
          $conf['descuento_parqueadero_dia'] =  $datos->body->descuento_parqueadero_dia;
          $conf['descuento_redondeo'] =  $datos->body->descuento_redondeo;
          $conf['recargo_incluir'] =  $datos->body->recargo_incluir;
          $conf['recargo_porcentaje'] =  $datos->body->recargo_porcentaje;
          $conf['recargo_monto'] =  $datos->body->recargo_monto;
          $conf['recargo_dia'] =  $datos->body->recargo_dia;
          $conf['anticipos_trasladar'] =  $datos->body->anticipos_trasladar;
          $conf['anticipos_cuenta'] =  $datos->body->anticipos_cuenta;
          $conf['anticipos_cuentasxcobrar'] =  $datos->body->anticipos_cuentasxcobrar; 
          $conf['anticipos_descuentos'] =  $datos->body->anticipos_descuentos;
          $conf['notas'] =  $datos->body->notas;
          $conf['corte'] =  $datos->body->corte;

          $filtro = array('tipo_documento'=>'configuracioncxcauto');
          $configuracioncxcauto = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$idcopropiedad, $filtro));

          if(count($configuracioncxcauto) > 0)
            eliminaDocumento($configuracioncxcauto[0]["_id"]['$id'], 'cont_'.$idcopropiedad);

          enviarInformacion('cont_'.$idcopropiedad, $conf, $app);

          $filtro = array('id_copropiedad'=>$idcopropiedad,'proveedor'=>false);
          $facturablesdb = objectToArray(consultaColeccionRespuesta($app, 'contabilidadUnidad', $filtro));
          $facturables = obtenerFacturables($facturablesdb);

          $filtro = array('id_copropiedad'=>$idcopropiedad);
          $usuariosdb = objectToArray(consultaColeccionRespuesta($app, 'usuariocp', $filtro));
          $usuarios = obtenerUsuarios($usuariosdb);
          
          $filtro = array('id_copropiedad'=>$idcopropiedad);
          $unidaddb = objectToArray(consultaColeccionRespuesta($app, 'unidad', $filtro));
          $unidad = obtenerUnidades($unidaddb);

          $filtro = array('tipo_documento'=>'consecutivos');
          $consecutivos = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$idcopropiedad, $filtro));

          $filtro = array('_id' => new MongoId($idcopropiedad));
          $copropiedad = objectToArray(consultaColeccionRespuesta($app, 'copropiedad', $filtro));

          $recibos = generaRecibos($year, $month, $facturables, $conf, $consecutivos[0], $copropiedad, $usuarios, $unidad, $app, $idcopropiedad);

          enviarRespuesta($app, true, $recibos , 'null');
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

          $filtror = array('tipo_documento'=>'cartera','saldo'=> array('$gte' => 0));
          $doccartera = objectToArray(consultaColeccionRespuesta($app, 'cont_'.$idcopropiedad, $filtror));
          $this_cartera = obtenerCarteraDetalladaTerceros(objectToArray($doccartera), $usuarios);

          if(count($this_cartera) > 0)
          {
            $respuesta = $cartera;
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
  function obtenerFacturables($inmuebles)
  {
    $out = array();
    foreach ($inmuebles as $key => $value) 
    {
      if($value['canon'] > 0)
        $out[] = $value;
    }
    return $out;
  }

  function obtenerUsuarios($usuarios)
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
  }

  function obtenerMes($mes)
  {
    $meses = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
    return $meses[(int)$mes];
  }

  function generaRecibos($year, $month, $clientes, $conf, $consecutivos, $copropiedad, $usuarios, $unidades, $appl, $idcopropiedad)
  {
    date_default_timezone_set('America/Bogota');
    $today = date('c');
    $consecutivo = $consecutivos['cc'];
    $nombre_copropiedad = $copropiedad[0]['nombre'];
    $recibos = array();
    $recargos_extra = array();
    $mes = obtenerMes($month);
    $corte = $conf['corte'];
    $i = 0;
    //$token = obtieneToken();
    //var_dump($clientes[0]);
    //var_dump($unidades);
    //exit;
    
    for ($i=0; $i < count($clientes); $i++)
    {
      $recibo = array();
      
      $coeficiente = $clientes[$i]['coeficiente'];
      $tercero = $clientes[$i]['encargado'];
      $monto = $clientes[$i]['canon'];
      $identificador = $unidades[$clientes[$i]['unidad']]['identificador'];
      $concepto = 'Pago administración apartamento ' . $identificador . ' con coeficiente ' . $clientes[$i]['coeficiente'] . ' para el mes de ' . $mes . ' de ' . $year . '.';;
      $email_tercero = $clientes[$i]["email"];
      $id_crm_persona = $usuarios[$clientes[$i]['id_usuario']];
      $filtror = array('tipo_documento'=>'cartera','id_tercero'=> $id_crm_persona);
      $doccartera = objectToArray(consultaColeccionRespuesta($appl, 'cont_'.$idcopropiedad, $filtror));

      if($conf['interes_incluir'])
        generaRecargo($doccartera, $year, $month, $conf['interes_porcentaje'], 'interes', $tercero, $appl, $idcopropiedad);
      
      if($conf['recargo_incluir'])
        generaRecargo($doccartera, $year, $month, $conf['recargo_porcentaje'], 'recargo', $tercero, $appl, $idcopropiedad);

      $this_cartera = obtenerCartera(objectToArray($doccartera));
      $cartera_total = explode(',' , $this_cartera)[0];
      $interes = explode(',' , $this_cartera)[1];
      $sanciones = explode(',' , $this_cartera)[2];
      $this_pago = totalizaPago($conf['cargos'], $monto, $corte, 'CC'.$consecutivo + $i, $concepto, $tercero, obtenerCuentas($conf), $idcopropiedad, $appl);

      $recibo["consecutivo"] = $consecutivo + $i;
      $recibo["nombre_copropiedad"] = $nombre_copropiedad;
      $recibo["concepto"] = $concepto;
      $recibo["tercero"] = $tercero;
      $recibo["coeficiente"] = $coeficiente;
      $recibo["unidad"] = $identificador;
      $recibo["emailtercero"] = $email_tercero;
      $recibo["cargos"] = $conf['cargos'];
      $recibo["totalapagar"] = $this_pago;
      
      if($conf['descuento_admin_incluir'])
      {
        $porcentaje = ((float)$conf['descuento_admin_porcentaje'])/100;
        $recibo["descuento"] = $this_pago - ($this_pago * $porcentaje);
        $recibo["descuento_texto"] = "Para pago antes del dia " . $conf['descuento_admin_dia'];
      }

      if($conf['interes_incluir'] || $conf['recargo_incluir'])
      {
        $recibo["cartera"] = $this_cartera;
        $recibo["totalapagar"] = $this_pago + $cartera_total + $sanciones + $interes;
      }
      else
      {
        $recibo["totalapagar"] = $this_pago;
      }

      $recibos[] = $recibo;
      creaTransaccion($idcopropiedad, $id_crm_persona, $consecutivo + $i, $tercero, $email_tercero, $concepto, $conf['notas'], $appl, $corte);
    }

    actualizaConsecutivos($idcopropiedad, $i, "cc", $consecutivos);
    //var_dump($recibos);
    return $recibos;
  }

  function obtenerCartera($docs)
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
  }

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

  function obtenerCarteraDetalladaTerceros($usuarios,$terceros)
  {
    $out = array();
    $docs = $usuarios;

    for ($i=0; $i < count($docs); $i++)
    { 
      if($docs[$i]['saldo'] > 0)
      switch ($docs[$i]['tipo_mov']) 
      {
        case 'cargo':
          if(array_key_exists($docs[$i]['id_tercero'], $out))
            $out[$terceros[$docs[$i]['id_tercero']]][$docs[$i]['concepto']] = $out[$docs[$i]['id_tercero']][$docs[$i]['concepto']] + $docs[$i]['saldo'];
          else
            $out[$terceros[$docs[$i]['id_tercero']]][$docs[$i]['concepto']] = $docs[$i]['saldo'];
          var_dump($out);
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

  function generaRecargo($docs, $year, $month, $porcsancion, $tipo, $id_tercero, $appl, $idcopropiedad)
  {
    for ($i=0; $i < count($docs); $i++)
    {
      switch ($tipo) 
      {
        case 'recargo':
          if($docs[$i]['tipo_mov'] == 'cargo')
            if((int)$docs[$i]['year'] == (int)$year)
              if((int)$docs[$i]['month'] == ((int)$month -1))
                {
                  $monto = calculaRecargo($docs[$i]['saldo'], $porcsancion);
                  if($monto > 0)
                    enviarInformacion('cont_'.$idcopropiedad, array("monto" => $monto, "tipo_mov" => "sancion", "tipo_documento" => "cartera", "id_tercero" => $id_tercero), $appl);
                }
          break;
        
        case 'interes':
          if($docs[$i]['tipo_mov'] == 'cargo')
            {
              $monto = calculaRecargo($docs[$i]['saldo'], $porcsancion);
              if($monto > 0)
                enviarInformacion('cont_'.$idcopropiedad, array("monto" => $monto, "tipo_mov" => "interes", "tipo_documento" => "cartera", "id_tercero" => $id_tercero), $appl);
            }
          break;

        default:
          break;
      }
    }
  }

  function calculaMesesMora($start, $end)
  {
    $d1 = new DateTime($start);
    $d2 = new DateTime($end);

    $min_dif = $d1->diff($d2)->m;
    $max_dif = ($d1->diff($d2)->m) + ($d1->diff($d2)->y*12);

    if($min_dif > $max_dif)
      return $min_dif;
    elseif($min_dif <= $max_dif)
      return $max_dif;
  }

  function calculaRecargo($monto, $interes)
  {
    $tasa = $interes / 100;
    return $monto * $tasa;
  }

  function totalizaPago($cargos, $canon, $corte, $idtransaccion, $concepto, $tercero, $conf_cuentas, $idcopropiedad, $appl)
  {
    $resultado = array();
    $acum = $canon;
    
    foreach ($cargos as $key => $value) 
    {
      $acum = $acum + objectToArray($value)["costo"];
      if(objectToArray($value)["nombre"] == "Administracion")
        {
          creaRegistro($corte, $idtransaccion, $conf_cuentas[objectToArray($value)["nombre"]]['cuenta'], "C", $canon, $concepto, $tercero, $idcopropiedad, $appl);
          creaRegistro($corte, $idtransaccion, $conf_cuentas[objectToArray($value)["nombre"]]['contra'], "D", $canon, $concepto, $tercero, $idcopropiedad, $appl);
        }
      else
        {
          creaRegistro($corte, $idtransaccion, $conf_cuentas[objectToArray($value)["nombre"]]['cuenta'], "C", objectToArray($value)["costo"], $concepto, $tercero, $idcopropiedad, $appl);
          creaRegistro($corte, $idtransaccion, $conf_cuentas[objectToArray($value)["nombre"]]['contra'], "D", objectToArray($value)["costo"], $concepto, $tercero, $idcopropiedad, $appl);
        }
    }

    return $acum;
  }

  function creaTransaccion($idcopropiedad, $id_crm_persona, $consecutivo, $tercero, $email_tercero, $concepto, $notas, $appl, $corte)
  {
    $today = date('c');
    $year = explode('/',$corte)[0];
    $month = explode('/',$corte)[1];
    $day = explode('/',$corte)[2];

    $arr = array('id_crm_persona' => $id_crm_persona, 'fecha_creacion' => $today, 'year' => $year, 'month' => $month, 'day' => $day, 'tipo' => 'CC', 'idtransaccion' => 'CC'.$consecutivo, 'nombre_tercero' => $tercero, 'email_tercero' => $email_tercero, 'concepto_documento' => $concepto, 'moneda' => 'COP', 'vendedor_fv' => '', 'forma_pago' => '', 'notas' => $notas, 'anulado' => 'NO', 'tipo_documento' => 'transaccion', 'conciliado' => false);
    //var_dump($idcopropiedad, $arr);
    return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
  }

  function creaCargo($corte, $monto, $tercero, $doc_asoc, $appl, $idcopropiedad)
  {
    $today = date('c');
    $year = explode('/',$corte)[0];
    $month = explode('/',$corte)[1];
    $day = explode('/',$corte)[2];
    $cargosexistentes = consultaColeccionRespuesta($appl, 'cont_'.$idcopropiedad, array("tipo_documento"=>"cartera", "doc" => (string)$doc_asoc));
    if(count($cargosexistentes) > 0)
        $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>count($cargosexistentes) + 1);
      else
        $arr = array("fecha_creacion" => $today, "concepto" => $concepto, "year" => $year, "month" => $month, "monto" => $monto, "saldo" => $monto, "tipo_mov" => "cargo", "tipo_documento" => "cartera", "id_tercero" => $tercero, "doc" => $doc_asoc, "idcargo"=>"1");
    return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
  }

  function creaRegistro($corte, $idtransaccion, $cuenta, $tipo, $monto, $concepto, $tercero, $idcopropiedad, $appl)
  {
    $today = date('c');
    $year = explode('/',$corte)[0];
    $month = explode('/',$corte)[1];
    $day = explode('/',$corte)[2];

    $arr = array("fecha_movimiento" => $today, "cuenta_puc" => $cuenta, "tipo" => $tipo, "monto" => $monto, "concepto" => $concepto, "id_tercero" => $tercero, "year" => $year, "month" => $month, "day" => $day, "estado" => "A", "tipo_documento" => "registrocontable");
    return enviarInformacion('cont_'.$idcopropiedad, $arr, $appl);
  }

  function obtenerCuentas($conf)
  {
    $ctas = array();

    foreach ($conf['cargos'] as $key => $value) 
    {
      $ctas[objectToArray($value)["nombre"]] = array("cuenta" => objectToArray($value)['cuenta'], "contra" => objectToArray($value)['contra']);
    }

    return $ctas;
  }

  function actualizaConsecutivos($idcopropiedad, $incremento, $tipo, $consecutivos)
  {
    $consecutivos[$tipo] = $consecutivos[$tipo] + $incremento;
    return modificaDocumento($consecutivos, array(), "cont_".$idcopropiedad, true);
  }

  function obtenerUsuariosCRM($usuarios)
  {
    $users = array();
    foreach ($usuarios as $key => $value) 
    {
      $users[$value['id_crm_persona']] = $value['nombre'];
    }
    return $users;
  }
