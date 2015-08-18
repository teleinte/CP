<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>

</head>
<body>
<header>
  <?php require_once("../../template/include/header.inc"); ?>
  <script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
  <script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="sjs/facturacion.js?v=2.0"></script>
  <script type="text/javascript" src="sjs/facturacion-functions.js?v=2.0"></script>
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
                <div class="titulo-principal">
                  <h1 class="title contabilidad" teid="co:html:132"></h1>
                </div>
                <?php require_once('../../template/include/alerts.inc'); ?>
                    <div class="clearfix">
                      <form>
                          <table id="form-factura">
                              <tr>
                                  <td width="25%"><label teid="co:html:108"></label>
                                  <input type="date" id="datepicker1" required/></td>
                                  <td colspan="2"><label teid="co:html:126"></label><h4 id="comprador"></h4></td>
                                  <td width="25%"><label teid="co:html:110"></label>
                                  <h3 id="consecutivo" style="color:red;"></h3></td>
                              </tr>
                              <tr>
                                  <td colspan="2"><label teid="co:html:133"></label>
                                    <select id="proveedoresselect" name="proveedoresselect" data-placeholder="Búsqueda contactos" style="width:100%;" class="chosen-select-creation" tabindex="10" required>
                                        <option value="none"></option>
                                    </select>
                                  </td>
                                  <td>
                                    <label teid="co:html:284"></label>
                                    <h4 id="nomcon"></h4>
                                    <input type="hidden" id="idnit" />
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan="2">
                                    <label teid="co:html:134"></label>
                                    <h3 id="cpnomf" class="cpnom"></h3>
                                  </td>
                                  <td><label teid="co:html:113"></label>
                                  <h4 id="cptel"></h4></td>                                  
                                  <h4 id="cpcel"></h4></td>
                                  <td><label teid="co:html:114"></label>
                                  <h4 id="cpema"></h4><input type="hidden" id="idtercero" /></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td colspan="2">
                                    <label teid="co:html:116"></label>
                                    <input type="text" id="docext" name="docext" value="N/A" teid="co:title:279" required/>
                                  </td>
                                  <td colspan="2">
                                    <label teid="co:html:115"></label>
                                    <input type="text" id="conceptodoc" name="conceptodoc" required/></td>
                                  </td>
                                  <td></td>
                              </tr>
                          </table>
                          <div id="alertas" style="background-color:white;"></div>
                          <table id="agregar-campos">
                              <tr>
                                  <td colspan="5" style="vertical-align:bottom; text-align:center;">
                                    <input type="button" id="btRemove" class="btn icono borrar ttip" teid="co:val:73, co:title:76" style="margin-bottom:10px;"/>
                                    <input type="button" id="btAdd" class="btn icono agregar ttip positivo" teid="co:val:72, co:title:75"  style="margin-bottom:10px;"/>
                                  </td>
                              </tr>
                              <tr>
                                <td width="20%" class="titulo-campos" teid="co:html:48"></td>
                                <td width="20%" class="titulo-campos"teid="co:html:49"></td>
                                <td width="20%" class="titulo-campos" teid="co:html:135"></td>
                                <td width="20%" class="titulo-campos" teid="co:html:50"></td>
                                <td width="20%" class="titulo-campos" teid="co:html:51"></td>
                              </tr>
                          </table>                          
                          <table id="totales">
                            <tr>
                              <td width="20%"></td>
                                <td width="20%"></td>
                                <td width="20%" style="text-align: right;" teid="co:html:52"></td>
                                <td width="20%"><h4 style="text-align: right;" id="totaldebito"></h4></td>
                                <td width="20%"><h4 style="text-align: right;" id="totalcredito"></h4></td>
                            </tr>
                            <tr>
                              <td width="20%"></td>
                                <td width="20%"></td>
                                <td width="20%" style="text-align: right;" teid="co:html:53"></td>
                                <td width="40%" colspan="2"><h3 style="text-align: right;" id="diferencia"></h3></td>
                            </tr>
                          </table>
                          <div class="botones-form">
                            <div id="alertasop" style="background-color:white;"></div>
                            <a href="../" class="btn icono borrar ttip" id="btncancelardocumento" style="margin-right:5px;" teid="co:html:119, co:title:223"></a> <input type="button" class="btn icono guardar ttip" teid="co:val:118, co:title:229" id="btnimprimirdocumento"/> <input type="button" class="btn icono guardar ttip positivo" teid="co:val:117, co:title:228" id="btnguardardocumento"/><!-- <input type="button" class="btn icono borrar" teid="co:val:231, co:title:230" id="btnanulardocumento"/>-->
                          </div>
                        </form>
                    </div>
                </div>
                <div id="imprimible"></div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
