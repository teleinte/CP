<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="re:html:50"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/reservas-functions.js"></script>
<script type="text/javascript" src="sjs/inmuebles.js"></script>
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
          <h1 class="title encuestas" teid="re:html:6"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
        <div class="clearfix"></div>
        <table id="inmuebles" class="stripe" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th teid="re:html:8"></th>
                    <th teid="re:html:9"></th>
                    <th teid="re:html:10"></th>
                    <th teid="re:html:11"></th>
                    <th teid="re:html:12"></th>    
                    <th teid="re:html:13"></th>                 
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="dialog_eliminar" style="display:none">
          <h3 teid="re:html:119"></h3>
          <form>
            <input type="hidden" id="elmongoid" value=""/>
          </form>
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