<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="ca:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<link rel="stylesheet" href="scss/estilo.css">
<link rel="stylesheet" href="scss/jquery.cleditor.css">
<script type="text/javascript" src="https://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
<!--
<script type="text/javascript" src="sjs/cartelera-functions.js"></script>
<script type="text/javascript" src="sjs/cartelera.js"></script>-->
</head>
<body>
  <header>
    <?php require_once("../template/include/header.inc"); ?>
  </header>
      <div id="contenido-principal">
          <section id="central">
              <!--<div class="breadcrumb">
                <?php //require_once('../template/include/breadcrumbs.inc'); ?>
              </div>-->        
                <!-- Codigo de la aplicacion -->
              <div class="contenedor">
                <div class="titulo-principal">
                  <h1 class="title cartelera"> Manager Copropiedad </h1>
                </div>
                <?php require_once('../template/include/alerts.inc'); ?>
                <div class="aplicaciones" id ="aplicaciones">
                </div>
              </div>
          </section>
      </div>
</body>
    
</html>
