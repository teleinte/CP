<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<!-- <script type="text/javascript" src="../sjs/inicio.js"></script> -->
<script type="text/javascript" src="sjs/cuentas_recurrentes.js"></script>
</head>
<body>
<header>
  <?php require_once("../../template/include/header.inc"); ?>
</header>
    <div id="contenido-principal">
        <section id="central">
            <aside>
              <div class="trescolumnas primera">
                  <?php //require_once('../template/include/newmenu.inc'); ?>
                  <?php //require_once('../template/include/appmenu-1.inc'); ?>
                  <?php require_once('../../template/include/backbutton.inc'); ?>
              </div>
              <div class="trescolumnas centro">
                  <?php require_once('../../template/include/today.inc'); ?>
              </div>
              <div class="trescolumnas ultima">
                <?php require_once('../../template/include/copropiedades.inc'); ?>
              </div>
            </aside>
            <div class="breadcrumb">
              <?php require_once('../../template/include/breadcrumbs.inc'); ?>
            </div>         
            <div class="contenedor">
            <!-- Codigo de la aplicacion -->
            <?php require_once('../../template/include/alerts.inc'); ?>
              <div class="aplicaciones" id ="aplicaciones">
                <h2 style="margin-left:20px;" teid="co:html:62"></h2>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:271">
                    <a href="cargos.php" id="configuracioninicial">
                      <div class="absoluto">
                      <i class="fa fa-cog glyphicon"></i>
                      <h6 teid="co:html:63"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:272">
                    <a href="asignacion-costos.php" id="saldosIniciales">
                      <div class="absoluto">
                        <i class="fa fa-flag glyphicon"></i>
                        <h6 teid="co:html:64"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="app">
                  <div id="square" class="ttip" teid="co:title:273">
                    <a href="generar.php" id="cuentarecurrente">
                      <div class="absoluto">
                        <i class="fa fa-cogs glyphicon"></i>
                        <h6 teid="co:html:65"></h6>
                      </div>
                    </a>
                  </div>
                </div>
                
              </div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>



