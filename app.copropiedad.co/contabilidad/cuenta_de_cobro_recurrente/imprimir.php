<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="sjs/imprimir.js"></script>
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
                <h1 teid="co:html:178"></h1>
              </div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <div class="clearfix"></div>                      
              <div class="botones-form" style="margin-top:15px; text-align:left;">
                <h3 id="cantidad"></h3>
                <a href="../lista_documentos" class="btn" style="margin-right:5px;" teid="co:html:219, co:title:220"></a>
                <input type="button" class="btn icono guardar ttip positivo" id="imprimir" teid="co:val:179, co:title:218"/>
                <!--<input type="button" class="btn icono guardar" id="generar" value="Guardar PDF"/>-->
              </div>
              <div id="recibos"></div>
              <div id="recibosprint" style="display:none"></div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>