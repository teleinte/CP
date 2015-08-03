<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="pr:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="sjs/importar.js"></script>
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
                <div class="titulo-principal">
                  <h1 class="title cartelera" teid="pr:html:37"></h1>
                </div>
                <div id="result" class="contenedor mitad" >
                  <h2 style="text-align:center" id="msg"></h2>
                  <h3 style="text-align:center"><span id="incr"></span></h3>
                  <h3 style="text-align:center"><span id="cocr"></span></h3><br/>
                  <div style="text-align:center;">
                    <a href="../index.php" class="btn icono regresar ttip" id="btncancelardocumento ttip" teid="pr:html:54, pr:title:55"></a>
                  </div>
                </div>
            </div>            
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>