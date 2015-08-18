<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="sp:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/casos-soporte-functions.js?v=1.0"></script>
<script type="text/javascript" src="sjs/casos.js?v=1.0"></script>
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
              <div class="titulo-principal"><h1 teid="sp:html:2"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <table id="casos-soporte" class="stripe" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th teid="sp:html:3"></th>
                            <th teid="sp:html:4"></th>
                            <th teid="sp:html:5"></th>
                            <th teid="sp:html:36"></th>
                            <th teid="sp:html:6"></th>
                            <th teid="sp:html:18"></th>
                            <th teid="sp:html:33"></th>
                            <th teid="sp:html:34"></th>
                            <th teid="sp:html:21"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="dialog_eliminar" style="display:none">
                  <h3 teid="sp:html:15"></h3>
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
