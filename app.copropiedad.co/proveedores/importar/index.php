<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="pr:html:1">Importar proveedores y contactos</title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="sjs/importar.js?v=2.0"></script>
<script type="text/javascript" src="sjs/importacion-functions.js?v=2.0"></script>
</head>
<body>
<header>
  <?php require_once("../../template/include/header.inc"); ?>
</header>
    <div id="contenido-principal">
        <section id="central">
            <aside>
              <div class="trescolumnas primera">                  
                  <?php require_once('../../template/include/backbutton.inc'); ?>
              </div>
              <div class="trescolumnas centro">
                  <?php require_once('../../template/include/today.inc'); ?>
              </div>              
            </aside>
            <div class="breadcrumb">
              <?php require_once('../../template/include/breadcrumbs.inc'); ?>
            </div>
            <div class="contenedor mitad">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal">
                <h1 teid="pr:html:46"></h1>
              </div>
              
              <form id="formEnvio" action="subir.php" method="POST" enctype="multipart/form-data">
              <table style="margin: auto;">   
                <tr>
                  <td>
                    <!--<h2 teid="pr:html:47"></h2>-->
                    <?php require_once('../../template/include/alerts.inc'); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h3 style="display:inline-block;" teid="in:html:39" ></h3> 
                        <input type="button" class="btn" teid="co:val:106, co:title:214" id="descargarwindows" style="display:inline;"/>&nbsp;
                        <input type="button" class="btn" teid="co:val:252, co:title:253" id="descargarmac" style="display:inline;"/>
                    <h3 teid="in:html:75"></h3>
                    <img src="ejemplo_plantilla_proveedores.png" style="min-width:600px; max-width:600px; margin:0 auto;"/>   
                  </td>
                </tr>
                <tr>
                  <td>
                    <h3 teid="in:html:41"></h3>
                        <input type="file" class="btn ttip" id="cargar"/>
                        <input type="hidden" name="id_copropiedad" id="id_copropiedad" />
                        <input type="hidden" name="ncp" id="ncp" />
                        <input type="hidden" name="id_crm" id="id_crm" />
                        <input type="hidden" name="token" id="token" /> 
                        <br/>                       
                        <div id="alertaserror" style="margin:10px 0px;"></div>   
                  </td>
                </tr>
              </table>
              <!--<div id="buttons"></div>-->
                <div id="scroller"  style="overflow:scroll; white-space: nowrap; overflow: -moz-scrollbars-vertical; overflow: -moz-scrollbars-horizontal;">
                  <table id="agregar_campos" style="display:none; width:600px !important; margin:0 auto;">
                    <tr style="text-align:center;">
                      <td width="17%" class="titulo-campos" teid="pr:html:48"></td>
                      <td width="16%" class="titulo-campos" teid="pr:html:49"></td>
                      <td width="16%" class="titulo-campos" teid="pr:html:50"></td>
                      <td width="16%" class="titulo-campos" teid="pr:html:51"></td>
                      <td width="16%" class="titulo-campos" teid="pr:html:52"></td>
                      <td width="16%" class="titulo-campos" teid="pr:html:62"></td><!-- 
                      <td width="16%" class="titulo-campos" teid="pr:html:53"></td> -->                      
                    </tr>
                  </table>
                </div>
              </form>
            </div>            
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
