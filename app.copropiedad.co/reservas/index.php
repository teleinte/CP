<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="re:html:50"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/reservas.js"></script>
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
       	<div class="titulo-principal">
          <h1 class="title calendario" teid="re:html:1"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
          <div style="padding: 10px 0; margin:-15px 0 10px;">
            <div class="aplicaciones" id="aplicaciones">
              <div class="app">
                <div id="square">
                  <a class="ttip" href="inmuebles-reservables.php" id="reservas-reporte" teid="re:title:51">
                    <div class="absoluto">
                      <i class="fa fa-building-o glyphicon"></i>
                      <h6 teid="re:html:2"></h6>
                    </div>
                  </a>
                </div>
              </div>
              <div class="app">
                <div id="square">
                  <a href="calendario-de-reservas.php" id="calendario-reservas" teid="re:title:52" class="niveltres ttip">
                    <div class="absoluto">
                      <i class="fa fa-calendar glyphicon"></i>
                      <h6 teid="re:html:3"></h6>
                    </div>
                  </a>
                </div>
              </div>
              <div class="app">
                <div id="square">
                  <a href="administrador-de-reservas.php" id="admin-reservas" teid="re:title:53" class="niveltres ttip">
                    <div class="absoluto">
                      <i class="fa fa-check-circle-o glyphicon"></i>
                      <h6 teid="re:html:4"></h6>
                    </div>
                  </a>
                </div>
              </div>
              <div class="app">
                <div id="square">
                  <a href="reporte-de-reservas.php" id="reservas-reporte" teid="re:title:54" class="niveltres ttip">
                    <div class="absoluto">
                      <i class="fa fa-file-text glyphicon"></i>
                      <h6 teid="re:html:5"></h6>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Finaliza codigo de la aplicacion -->
      </section>
      <footer>  
        <?php require_once('../template/include/footer.inc'); ?>
      </footer>
  </div>
</body>
</html>
