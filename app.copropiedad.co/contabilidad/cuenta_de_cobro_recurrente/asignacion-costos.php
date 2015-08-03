<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/asignar-cargos-functions.js"></script>
<script type="text/javascript" src="sjs/asignar-cargos.js"></script>
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
            <div class="contenedor mitad">
            <!-- Codigo de la aplicacion -->
            <div class="titulo-principal"><h1 teid="co:html:78"></h1></div>
            <?php require_once('../../template/include/alerts.inc'); ?>
              <div id="bodyapp">
                <table width="100%">
                  <tr>
                    <td>
                    <h3 teid="in:html:39" style="display:inline;"></h3>
                    <input type="button" id="descargar" class="btn ttip" teid="co:val:149, co:title:215" />&nbsp;
                    <input type="button" id="descargarmac" class="btn ttip" teid="co:val:252, co:title:253" />
                    </td>
                  </tr>
                  <tr height="20px"></tr>
                  <tr>
                    <td>
                      <h3 teid="in:html:41"></h3>
                      <input type="file" id="cargar" class="btn ttip" value="Cargar archivo diligenciado" />
                    </td>
                  </tr>
                </table>
              </div>
              <!--<form id="asignar-cargo">
                  <table id="tablaContenedora" style="width:100%">
                    <tr><td width="50%"></td><td width="50%"></td></tr>
                    <td colspan="2"><h2 teid="co:html:148"></h2></td>
                    <tr>
                      <td style="text-align:right">
                        <label for="inmueble"><h3 teid="co:html:79"></h3></label>
                      </td>
                      <td>
                        <select id="inmueble" style="width:90%" require></select>
                      </td>
                    </tr>  
                  </table>
                <div class="botones-form">
                  <input type="submit" class="btn icono guardar tooltip" id="accion" teid="co:val:80, co:title:208"/>
                </div>
              </form>-->
              <div id="importacion" style="display:none;">
                <input type="hidden" id="importado" esimportado="no"/>
                <table id="cargos"></table>
                <br/><br/><label id="status"></label>
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
