<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/cargos-functions.js"></script>
<script type="text/javascript" src="sjs/cargos.js"></script>
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
                <h1 teid="co:html:66"></h1>
              </div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <h3 class="center" teid="co:html:67"></h3><br><br><br><br>
              <div class="clearfix tablabancos">
                <form id ="nuevoPCuentasCobro">
                  <table id="tablaCuentas" width='100%'>
                    <thead>
                      <tr>
                        <th></th>
                        <th width="25%" class="titulo-campos" teid="co:html:68"></th>
                        <th width="25%" class="titulo-campos" teid="co:html:69"></th>
                        <th width="25%" class="titulo-campos" teid="co:html:70"></th>                                    
                        <th width="25%" class="titulo-campos" teid="ta:html:1"></th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>                                                    
                  </table>
                  <h3 class="center" teid="co:html:71"></h3>
                  <br><br>
                  <div id='filas0' class="opciones" style="padding: 20px 1.5% 0; margin-bottom:0; background-color: #fff;">
                  <table id="agregar-campos1">
                      <tr>
                          <td width="33%" class="titulo-campos" teid="co:html:68"></td>
                          <td width="33%" class="titulo-campos" teid="co:html:69"></td>
                          <td width="34%" class="titulo-campos" teid="co:html:70"><input type="hidden" class="hidden" id="numeradores"/></td>
                          <!-- <td width="25%" class="titulo-campos">Descripción</td>                                     -->
                      </tr>                                                                
                  </table>
                  <table id="otra_tabla1">
                      <tr>
                          <td colspan="5" style="vertical-align:bottom; text-align:center;">
                            <div class="botones-form">
                              <input type="button" id="btRemoveC" class="btn icono borrar ttip" teid="co:val:73, co:title:76" style="margin-bottom:10px;"/>
                              <input type="button" id="btAddC" class="btn icono agregar ttip positivo" teid="co:val:72, co:title:75" style="margin-bottom:10px;"/>
                              <input type="submit" class="btn icono guardar ttip positivo" teid="co:val:74, co:title:77"/>
                            </div>
                          </td>
                      </tr>
                  </table>
                </form>
              <div>
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
