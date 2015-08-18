<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="ds:html:29"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/inicio.js"></script>
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
                <div id="indicador" style="z-index:1000;">Seleccione la copropiedad con la que desea trabajar <i class="fa fa-2x fa-arrow-circle-o-up"></i></div>
              </div>
            </aside>
            <div class="breadcrumb">
              <?php require_once('../template/include/breadcrumbs.inc'); ?>
            </div>         
            <div class="contenedor">
            <!-- Codigo de la aplicacion -->
              <div class="aplicaciones" id ="aplicaciones">
              <!--<div class="titulo-principal"><h1 teid="ds:html:30"></h1></div>-->
              <?php require_once('../template/include/alerts.inc'); ?>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:2">
                    <a href="../admin/" id="administracion" class="nivelcero">
                      <div class="absoluto">
                        <i class="fa fa-building-o glyphicon"></i>
                        <h6 clas="glyphiconlegend" teid="ds:html:1"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:4">
                    <a href="../inmuebles" id="contacto" class="niveluno">
                      <div class="absoluto">
                        <i class="fa fa-users glyphicon"></i>
                        <h6 teid="ds:html:3"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:28">
                    <a href="../proveedores" id="contacto" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-suitcase glyphicon"></i>
                        <h6 teid="ds:html:27"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip">
                    <a href="../directorio/" id="directorio" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-phone glyphicon"></i>
                        <h6> Directorio</h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:6">
                    <a href="../calendario/" id="calendario" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-calendar glyphicon"></i>
                        <h6 teid="ds:html:5"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:8">
                    <a href="../tarea/" id="tarea" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-pencil-square glyphicon"></i>
                        <h6 teid="ds:html:7"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:12">
                    <a href="../encuesta/" id="encuestas" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-bar-chart glyphicon"></i>
                        <h6 teid="ds:html:11"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:14">
                    <a href="../cartelera/" id="cartelera" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-thumb-tack glyphicon"></i>
                        <h6 teid="ds:html:13"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:16">
                    <a href="../reservas/" id="reserva" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-trello glyphicon"></i>
                        <h6 teid="ds:html:15"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:18">
                    <a href="../votacion/" id="votacion" class="niveldos">
                      <div class="absoluto">
                        <img src="../template/images/votaciones.png"/><!--<i class="fa fa-pie-chart glyphicon"></i>-->
                        <h6 teid="ds:html:17"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:20">
                    <a href="../solicitudes/" id="solicitudes" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-inbox glyphicon"></i>
                        <h6 teid="ds:html:19"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:22">
                    <a href="../gestion-documental/" id="gestion-documental" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-folder-open-o glyphicon"></i>
                        <h6 teid="ds:html:21"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:24" name="contabilidad">
                    <a href="../contabilidad/" id="contabilidadmenu" class="niveldos niveltres">
                      <div class="absoluto">
                        <i class="fa fa-line-chart glyphicon"></i>
                        <h6 teid="ds:html:23"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="ds:title:26">
                    <a href="../pagosonline/" id="pagosonline" class="niveldos">
                      <div class="absoluto">
                        <i class="fa fa-money glyphicon"></i>
                        <h6 teid="ds:html:25"></h6>
                      </div>
                    </a>
                  </div>
                </div>
				<div class="app">
                  <div id="square" class="ttip" teid="ds:title:33">
                    <a href="../casos-soporte/" id="casos-soporte" class="nivelcero">
                      <div class="absoluto">
                        <i class="fa fa-question-circle glyphicon"></i>
                        <h6 teid="ds:html:32"></h6>
                      </div>
                    </a>
                  </div>
                </div>

              </div>
              <div id="mensaje"></div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
  