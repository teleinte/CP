<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="ccp:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/copropiedad-functions.js"></script>
<script type="text/javascript" src="sjs/copropiedad.js"></script>
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
                <div id="indicador">Seleccione la copropiedad con la que desea trabajar <i class="fa fa-2x fa-arrow-circle-o-up"></i></div>
              </div>
            </aside>

            <div class="breadcrumb">
              <?php require_once('../template/include/breadcrumbs.inc'); ?>
            </div>

            <div class="contenedor">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1 teid="ccp:html:2"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                 <table id="copropiedades" class="stripe" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th></th>
                          <th teid="ccp:html:3"></th>
                          <th teid="ccp:html:4"></th>
                          <th teid="ccp:html:5"></th>
                          <th teid="ccp:html:6"></th>
                          <th teid="ta:html:1"></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                 </table>
            </div>            
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
