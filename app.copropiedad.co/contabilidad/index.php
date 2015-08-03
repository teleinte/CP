<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/contabilidad.js?v=1.0"></script>
<script type="text/javascript" src="sjs/contabilidad-functions.js?v=1.0"></script>
</head>
<body>
<header>
  <?php require_once("../template/include/header.inc"); ?>
</header>
    <div id="contenido-principal">
        <section id="central">
            <aside>
              <div class="trescolumnas primera">
                  <?php //require_once('../template/include/newmenu.inc'); ?>
                  <?php //require_once('../template/include/appmenu-1.inc'); ?>
                  <?php require_once('../template/include/backbutton.inc'); ?>
              </div>
              <div class="trescolumnas centro">
                  <?php require_once('../template/include/today.inc'); ?>
              </div>
              <div class="trescolumnas ultima">
                <?php require_once('../template/include/copropiedades.inc'); ?>
              </div>
            </aside>
            <div class="breadcrumb">
              <?php require_once('../template/include/breadcrumbs.inc'); ?>
            </div>         
            <div class="contenedor">
            <!-- Codigo de la aplicacion -->
            <?php require_once('../template/include/alerts.inc'); ?>
              <div class="aplicaciones" id ="aplicaciones">
                <h2 style="margin-left:20px;" teid="co:html:2"></h2>
                  <div class="app">
                    <div id="square" class="ttip" teid="co:title:257">
                      <a href="consecutivos/" id="consecutivos">
                        <div class="absoluto">
                          <i class="fa fa-list-ol glyphicon" ></i>
                          <h6 teid="co:html:20"></h6>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="app">
                    <div id="square" class="ttip" teid="co:title:258">
                      <a href="puc/" id="puc">
                        <div class="absoluto">
                          <i class="fa fa-server glyphicon" ></i>
                          <h6 teid="co:html:21"></h6>
                        </div>
                      </a>
                    </div>
                  </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:259">
                    <a href="saldos_iniciales/" id="saldosIniciales">
                      <div class="absoluto">
                        <i class="fa fa-flag glyphicon" ></i>
                        <h6 teid="co:html:4"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div style="clear:both;"></div>
                <h2 style="margin-left:20px;"teid="co:html:8"></h2>                
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:260">
                    <a href="lista_documentos/" id="listadocumentos">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:14"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:261">
                    <a href="cuenta_de_cobro_recurrente/" id="cuentarecurrente">
                      <div class="absoluto">
                        <i class="fa fa-cogs glyphicon" ></i>
                        <h6 teid="co:html:7"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:262">
                    <a href="factura_de_compra/" id="facturasdecompra">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:9"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:263">
                    <a href="comprobante_de_egreso/" id="comprobanteegreso">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:10"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:264">
                    <a href="cuenta_de_cobro/" id="cuentacobro">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:11"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:265">
                    <a href="nota_de_contabilidad/" id="notacontabilidad">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:12"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:266">
                    <a href="recibo_de_caja/" id="recibocaja">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:13"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div style="clear:both;"></div>
                <h2 style="margin-left:20px;" teid="co:html:15"></h2>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:267">
                    <a href="cartera/" id="cartera">
                      <div class="absoluto">
                        <i class="fa fa-usd glyphicon" ></i>
                        <h6 teid="co:html:6"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">                
                  <div id="square" class="ttip" teid="co:title:268">
                    <a href="balance_prueba/" id="balanceprueba">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:16"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:269">
                    <a href="balance_general/" id="balancegeneral">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:17"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:270">
                    <a href="estado_resultados/" id="estadoresultados">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:18"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <!--<div class="app">
                  <div id="square" class="ttip">
                    <a href="presupuesto/" id="presupuesto">
                      <div class="absoluto">
                        <i class="fa fa-file-text-o glyphicon" ></i>
                        <h6 teid="co:html:19"></h6>
                      </div>
                    </a>
                  </div>
                </div>-->
                <!-- <div class="app">
                  <div id="square" class="ttip" teid="ds:title:26">
                    <div class="absoluto">
                     <a href="servicios_publicos/" id="serviciospublicos"><i class="fa fa-file-text-o glyphicon" ></i><h6>Reporte de servicios públicos</h6></a>
                    </div>
                  </div>
                </div> -->
              </div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
