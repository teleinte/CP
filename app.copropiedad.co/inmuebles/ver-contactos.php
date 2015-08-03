<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="in:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/inmuebles-functions.js"></script>
<script type="text/javascript" src="sjs/ver-contacto.js"></script>
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
              <div class="titulo-principal"><h1 class="title encuestas" teid="in:html:23"></h1></div>
              <table id="contactos_tabla" class="stripe" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th teid="in:html:3"></th>                                      
                      <th teid="in:html:24"></th>                          
                      <th teid="in:html:25"></th>
                      <th teid="in:html:55"></th>
                      <th teid="in:html:56"></th>
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
