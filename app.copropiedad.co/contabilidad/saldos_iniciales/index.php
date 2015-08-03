<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/saldos-functions.js?v=1.0"></script>
<script type="text/javascript" src="sjs/saldos.js?v=1.0"></script>
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
              <div class="titulo-principal">
                <h1 teid="co:html:46"></h1>
              </div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <div class="clearfix">
              <div id="importarsidiv">
                <h2 teid="co:html:97"></h2>
                <div id="alertame"></div>
                <table>
                  <tr>
                      <td>
                        <h3 teid="in:html:39" style="display:inline;"></h3>
                        <input type="button" class="btn ttip" teid="co:val:106, co:title:214" id="descargarwindows" style="display:inline;"/>&nbsp;
                        <input type="button" class="btn ttip" teid="co:val:252, co:title:253" id="descargarmac" style="display:inline;"/>
                      </td>
                  </tr>
                  <tr>
                      <td>
                        <h3 teid="in:html:41"></h3>
                        <input type="file" class="btn ttip positivo" id="cargar"/>
                      </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <input type="hidden" id="importado" esimportado="no"/>
                    </td>
                  </tr>
                </table>
              </div>
              <form id="form_saldos">
                <table id="form_saldost">
                    <!--<tr><td colspan="3"><h2 teid="co:html:98"></h2></td></tr>-->
                    <!--<tr id="fechatr">
                        <td width="25%"></td>
                        <td width="25%"><label teid="co:html:47"></label></td>
                        <td width="50%"><input type="text" id="datepicker1" name="datepicker1" required/></td>
                    </tr>-->
                </table>
                <table id="agregar_campos" style="display:none;">
                  <tr>
                    <td colspan = 2>
                       <h3>Año saldos iniciales:</h3>                       
                       <select select id='anosi' name="anosi" required>
                          <option value = "2015">2015</option>
                          <option value = "2014">2014</option>
                          <option value = "2013">2013</option>
                          <option value = "2012">2012</option>                          
                        </select>
                    </td>
                    <td colspan = 3>
                        <h3>Mes saldos iniciales:</h3>
                        <select select id='messi' name="messi" required>
                          <option value = "01">1 - Enero</option>
                          <option value = "02">2 - Febrero</option>
                          <option value = "03">3 - Marzo</option>
                          <option value = "04">4 - Abril</option>
                          <option value = "05">5 - Mayo</option>
                          <option value = "06">6 - Junio</option>
                          <option value = "07">7 - Julio</option>
                          <option value = "08">8 - agosto</option>
                          <option value = "09">9 - Septiembre</option>
                          <option value = "10">10 - Octubre</option>
                          <option value = "11">11 - Noviembre</option>
                          <option value = "12">12 - Diciembre</option>
                        </select> 
                    </td>
                  </tr>
                  
                    <!--<tr id="ctrlTable">
                        <td colspan="5" style="vertical-align:bottom; text-align:center;">
                          <input type="button" id="btAdd" class="btn icono agregar" teid="co:val:99, co:title:101" style="margin-bottom:10px;"/>
                          <input type="button" id="btRemove" class="btn icono borrar" teid="co:val:100, co:title:102" style="margin-bottom:10px;"/>
                        </td>
                    </tr>-->
                    <tr>
                      <td width="25%" class="titulo-campos" >Linea</td>
                      <td width="25%" class="titulo-campos" teid="co:html:48"></td>
                      <td width="25%" class="titulo-campos" teid="co:html:49"></td>
                      <td width="25%" class="titulo-campos" teid="co:html:50"></td>
                      <td width="25%" class="titulo-campos" teid="co:html:51"></td>
                    </tr>

                </table>
                <div class="botones-form">
                  <label id="status"></label>                  
                  <input type="button" class="btn icono borrar ttip" id="reload" teid="co:val:276, co:title:277" style="display:none;"/>
                  <input type="submit" class="btn icono guardar ttip positivo" id="guardar" teid="co:val:54, co:title:55" style="display:none;"/>
                </div>
                <!--<table id="totales">
                  <tr>
                    <td width="25%"></td>
                      <td width="25%" style="text-align: right;" teid="co:html:52"></td>
                      <td width="25%"><h4 id="totaldebito" style="text-align: right;"/></h4></td>
                      <td width="25%"><h4 id="totalcredito" style="text-align: right;"></h4></td>
                  </tr>
                  <tr>
                    <td width="25%"></td>
                      <td width="25%" style="text-align: right;" teid="co:html:53"></td>
                      <td width="50%" colspan="2"><h3 id="total" style="text-align: right;"></h3></td>
                  </tr>
                </table>-->
                <div class="botones-form">
                  <label id="status"></label>
                  <input type="button" class="btn icono borrar ttip" id="reload" teid="co:val:276, co:title:277" style="display:none;"/>
                  <input type="submit" class="btn icono guardar ttip positivo" id="guardar" teid="co:val:54, co:title:55" style="display:none;"/>
                </div>
              </form>
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
