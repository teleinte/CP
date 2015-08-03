<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="sl:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/preregistro-functions.js"></script>
<script type="text/javascript" src="sjs/preregistro.js"></script>
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
            </aside>
            <div class="breadcrumb">
              <?php require_once('../template/include/breadcrumbs.inc'); ?>
            </div>         
            <div class="contenedor">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1>Preregistro</h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>                
              <form id="preregistro_form">
                <input type="hidden" id="elmongoid" value=""/>
                <div class="botones-form">
                  <input type="submit" class="btn icono guardar ttip positivo" value="Envar Correo a preregitrados"/>                  
                </div>
              </form>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
