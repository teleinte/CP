<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/verificar-functions.js"></script>
<script type="text/javascript" src="sjs/verificar.js"></script>
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
              <div class="titulo-principal"><h1 teid="co:html:176"></h1></div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <div class="clearfix"></div>                      
              <table id="cargos" style="width:100%">
                <thead>
                  <tr id="tch">
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
              <div class="botones-form" style="margin-top:15px;">
                <input type="button" class="btn icono borrar ttip" id="cancelar" teid="co:val:119, co:title:216"/>
                <input type="button" class="btn icono guardar ttip positivo" id="generar" teid="co:val:177, co:title:217" />
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