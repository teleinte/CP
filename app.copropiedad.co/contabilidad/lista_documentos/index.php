<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>

</head>
<body>
<header>
  <?php require_once("../../template/include/header.inc"); ?>
  <script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
  <script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="sjs/listar.js?v=1.0"></script>
  <script type="text/javascript" src="sjs/listar-functions.js?v=1.0"></script>
  
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
              <div class="titulo-principal"><h1 teid="co:html:213"></h1></div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <table id="listaTabla" class="stripe" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th></th>
                      <th teid="co:html:140"></th>
                      <th teid="co:html:141"></th>
                      <th teid="co:html:142"></th>
                      <th teid="co:html:143"></th>
                      <th teid="co:html:144"></th>
                      <th teid="co:html:278"></th>
                      <th teid="ta:html:1"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
             <div id="editarpopup" title="Documento Contable"></div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
