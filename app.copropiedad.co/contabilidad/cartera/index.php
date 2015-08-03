<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/cartera-functions.js"></script>
<script type="text/javascript" src="sjs/cartera.js"></script>
<style>
@media print  
{
    .recibo{
        page-break-inside: avoid;
    }
}
</style>
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
                <h1 teid="co:html:59"></h1>
              </div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <div class="clearfix"></div>  
              <div clas=="botones-form">
                <input type="button" class="ttip positivo" id="print" teid="co:val:235, co:title:237"/>
              </div>           
              <div id="carteraprint">
              <table id="cartera">
                <thead>
                  <tr>
                    <td></td>
                    <td teid="co:html:60"></td>
                    <td teid="co:html:236"></td>
                    <td teid="co:html:280"></td>
                    <td teid="co:html:61"></td>
                    <td teid="co:html:281"></td>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
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