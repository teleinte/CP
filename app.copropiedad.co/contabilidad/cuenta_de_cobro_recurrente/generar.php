<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="sjs/generar-functions.js"></script>
<script type="text/javascript" src="sjs/generar.js"></script>
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
                <h1 teid="co:html:83"></h1>
              </div>
              <?php require_once('../../template/include/alerts.inc'); ?>
              <div class="clearfix"></div>                      
              <form id ="nuevoGenerador" name="nuevoGenerador">
                <table style="width:100%">
                  <tr><td width="50%"></td><td width="50%"></td></tr>
                  <tr>
                    <td>
                      <label for="datepicker1" teid="co:html:84" style="display:inline;"></label>
                      <input type="date" id="datepicker1" name="fecha_corte" required/>
                    </td>
                    <td>
                      <label for="sancion">Sancion/Beneficio a aplicar</label>
                      <select id="sancion">
                        <option value="descuento">Descuento</option>
                        <option value="recargo">Recargo</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align: left;"><h2 teid="co:html:87"></h2></td>
                  </tr>
                  <tr>
                    <td>
                      <label for="iccp" teid="co:html:88"></label>
                      <select data-placeholder="Cuentas contables" class="chosen-select" id="iccp" style="width:90%;" tabindex="4">
                        <option value=""></option>
                      </select>
                    </td>
                    <td>
                      <label for="icci" teid="co:html:70"></label>
                      <select data-placeholder="Cuentas contables" id="icci"  class="chosen-select" style="width:90%;" tabindex="4">
                        <option value=""></option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label teid="co:html:89"></label>
                      <input type="number" id="interes" style="width:60px" required value="0"/>
                      <span id="porcint" teid="co:html:90"></span>
                    </td>
                    <td>
                      <label teid="co:html:91"></label>
                      <select id="redondeo_interes">
                        <option value="0" teid="co:html:154"></option>
                        <option value="10" teid="co:html:155"></option>
                        <option value="100" teid="co:html:156"></option>
                        <option value="1000" teid="co:html:157"></option>
                      </select>
                    </td>
                  </tr>
                  <tr style="height:20px;"></tr>
                  <tr>
                    <td colspan="2">
                      <h2 teid="co:html:158" style="display:inline;"></h2>
                      <span teid="co:html:160"></span>
                      <input type="number" min="1" max="31" value="10" id="descuento_admin_dia"/>
                      <span teid="co:html:161"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label teid="co:html:159"></label>
                      <input type="number" id="descuento_admin" required style="width:60px;" value="0"/>
                      <span id="porcadmin" teid="co:html:90"></span>                  
                    </td>
                    <td>
                      <label teid="co:html:163"></label>
                      <select id="descuento_redondeo">
                        <option value="0" teid="co:html:154"></option>
                        <option value="10" teid="co:html:155"></option>
                        <option value="100" teid="co:html:156"></option>
                        <option value="1000" teid="co:html:157"></option>
                      </select>
                    </td>
                  </tr>
                  <tr style="height:20px;"></tr>
                  <tr>
                    <td colspan="2">
                      <h2 teid="co:html:164" style="display:inline"></h2>
                      <span teid="co:html:166"></span>
                      <input type="number" min="1" max="31" class="inline num" value="10" id="recargo_dia"/>
                      <span teid="co:html:161"></span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label teid="co:html:165"></label>
                      <input type="number" id="recargo" required style="width:60px;" value="0"/>
                      <span id="porcrec" teid="co:html:90"></span>
                    </td>
                    <td>
                      <label teid="co:html:167"></label>
                      <select id="recargo_redondeo">
                        <option value="0" teid="co:html:154"></option>
                        <option value="10" teid="co:html:155"></option>
                        <option value="100" teid="co:html:156"></option>
                        <option value="1000" teid="co:html:157"></option>
                      </select>
                    </td>
                  </tr>
                  <tr style="height:20px;"></tr>
                  <tr>
                    <td colspan="2" style="text-align: left;">
                      <h2 teid="co:html:168"></h2>
                      <!--<input type="hidden" value="true" id="anticipos_trasladar"/>-->
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label teid="co:html:169"></label>
                      <select data-placeholder="Cuentas contables" class="chosen-select" id="anticipos_cuenta" style="width:90%;" tabindex="4">
                        <option value=""></option>
                      </select>
                    </td>
                    <td>
                      <label teid="co:html:171"></label>
                      <select data-placeholder="Cuentas contables" class="chosen-select" id="anticipos_descuentos" style="width:90%;" tabindex="4">
                        <option value=""></option>
                      </select>
                    </td>
                  </tr>
                  <!--<tr>
                    <td>
                      <h4 teid="co:html:170"></h4>
                    </td>
                    <td>
                      <select data-placeholder="Cuentas contables" class="chosen-select" id="anticipos_cuentasxcobrar" style="width:100%;" tabindex="4">  <option value=""></option>
                      </select>
                    </td>
                  </tr>-->
                  <tr style="height:20px;"></tr>
                  <tr>
                    <td  colspan="2">
                      <h2 teid="co:html:173"></h2>
                      <textarea id="notas" style="width:95%;"></textarea>
                    </td>
                  </tr>
                </table>
                <div id="botones-form" style="text-align:right;">
                  <input type="submit" class="btn icono ver inline ttip positivo" id="verificar" teid="co:val:174, co:title:175"  />
                  <!--<input type="submit" class="btn icono guardar" value="Generar e Imprimir"/>-->
                </div>
              </form>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>