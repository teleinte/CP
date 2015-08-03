<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="cl:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<!-- Fullcalendar -->
<link href='scss/fullcalendar.css' rel='stylesheet' />
<link href='scss/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='sjs/fullcalendar/moment.min.js'></script>
<script src='sjs/fullcalendar/fullcalendar.min.js'></script>
<script src='sjs/fullcalendar/es.js'></script>
<script type="text/javascript" src="sjs/calendario-functions.js"></script>
<script type="text/javascript" src="sjs/calendario.js"></script>
<script type="text/javascript" src="sjs/editar.js"></script>
<style>
  label{margin-bottom:0px !important;}
</style>
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
            <div class="contenedor mitad">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal">
                <h1 class="title calendario" teid="cl:html:44"></h1> 
              </div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <form class="clearfix" id="evento_editar_form">
                <table>
                  <tr><td width="50%"></td><td width="50%"></td></tr>
                  <tr>
                    <td colspan="2">
                      <label for="nombree" teid="cl:html:45"></label>
                      <input type="text" id="nombree" name="nombree" autofocus required/>
                      <input type="hidden" id="fecha_creacion"/>
                      <input type="hidden" id="mongoid"/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="startdatee" teid="cl:html:46"></label>
                      <input type="date" id="datepicker3" name="startdatee" required style="width:90%; padding-right:25px;">
                      <label for="deadlinee" teid="cl:html:47" style="margin-top:10px"></label>
                      <input type="date" id="datepicker4" name="enddatee" required style="width:90%; padding-right:25px;">
                    </td>
                    <td>
                      <label for="starttimee" teid="cl:html:50"></label>
                      <select id="starttimee" name="starttimee" required>
                        <option value = "00:00">00:00</option>
                        <option value = "00:30">00:30</option>
                        <option value = "01:00">01:00</option>
                        <option value = "01:30">01:30</option>
                        <option value = "02:00">02:00</option>
                        <option value = "02:30">02:30</option>
                        <option value = "03:00">03:00</option>
                        <option value = "03:30">03:30</option>
                        <option value = "04:00">04:00</option>
                        <option value = "04:30">04:30</option>
                        <option value = "05:00">05:00</option>
                        <option value = "05:30">05:30</option>
                        <option value = "06:00">06:00</option>
                        <option value = "06:30">06:30</option>
                        <option value = "07:00">07:00</option>
                        <option value = "07:30">07:30</option>
                        <option value = "08:00">08:00</option>
                        <option value = "08:30">08:30</option>
                        <option value = "09:00">09:00</option>
                        <option value = "09:30">09:30</option>
                        <option value = "10:00">10:00</option>
                        <option value = "10:30">10:30</option>
                        <option value = "11:00">11:00</option>
                        <option value = "11:30">11:30</option>
                        <option value = "12:00">12:00</option>
                        <option value = "12:30">12:30</option>
                        <option value = "13:00">13:00</option>
                        <option value = "13:30">13:30</option>
                        <option value = "14:00">14:00</option>
                        <option value = "14:30">14:30</option>
                        <option value = "15:00">15:00</option>
                        <option value = "15:30">15:30</option>
                        <option value = "16:00">16:00</option>
                        <option value = "16:30">16:30</option>
                        <option value = "17:00">17:00</option>
                        <option value = "17:30">17:30</option>
                        <option value = "18:00">18:00</option>
                        <option value = "18:30">18:30</option>
                        <option value = "19:00">19:00</option>
                        <option value = "19:30">19:30</option>
                        <option value = "20:00">20:00</option>
                        <option value = "20:30">20:30</option>
                        <option value = "21:00">21:00</option>
                        <option value = "21:30">21:30</option>
                        <option value = "22:00">22:00</option>
                        <option value = "22:30">22:30</option>
                        <option value = "23:00">23:00</option>
                        <option value = "23:30">23:30</option>
                      </select>
                      <label for="endtimee" teid="cl:html:48" style="margin-top:10px"></label>
                      <select id="endtimee" name="endtimee" required>
                        <option value = "00:00">00:00</option>
                        <option value = "00:30">00:30</option>
                        <option value = "01:00">01:00</option>
                        <option value = "01:30">01:30</option>
                        <option value = "02:00">02:00</option>
                        <option value = "02:30">02:30</option>
                        <option value = "03:00">03:00</option>
                        <option value = "03:30">03:30</option>
                        <option value = "04:00">04:00</option>
                        <option value = "04:30">04:30</option>
                        <option value = "05:00">05:00</option>
                        <option value = "05:30">05:30</option>
                        <option value = "06:00">06:00</option>
                        <option value = "06:30">06:30</option>
                        <option value = "07:00">07:00</option>
                        <option value = "07:30">07:30</option>
                        <option value = "08:00">08:00</option>
                        <option value = "08:30">08:30</option>
                        <option value = "09:00">09:00</option>
                        <option value = "09:30">09:30</option>
                        <option value = "10:00">10:00</option>
                        <option value = "10:30">10:30</option>
                        <option value = "11:00">11:00</option>
                        <option value = "11:30">11:30</option>
                        <option value = "12:00">12:00</option>
                        <option value = "12:30">12:30</option>
                        <option value = "13:00">13:00</option>
                        <option value = "13:30">13:30</option>
                        <option value = "14:00">14:00</option>
                        <option value = "14:30">14:30</option>
                        <option value = "15:00">15:00</option>
                        <option value = "15:30">15:30</option>
                        <option value = "16:00">16:00</option>
                        <option value = "16:30">16:30</option>
                        <option value = "17:00">17:00</option>
                        <option value = "17:30">17:30</option>
                        <option value = "18:00">18:00</option>
                        <option value = "18:30">18:30</option>
                        <option value = "19:00">19:00</option>
                        <option value = "19:30">19:30</option>
                        <option value = "20:00">20:00</option>
                        <option value = "20:30">20:30</option>
                        <option value = "21:00">21:00</option>
                        <option value = "21:30">21:30</option>
                        <option value = "22:30">22:00</option>
                        <option value = "22:30">22:30</option>
                        <option value = "23:00">23:00</option>
                        <option value = "23:30">23:30</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="invitados" teid="cl:html:49"></label>
                      <select id="invitados" name="invitados" disabled>
                        <option value="ninguno" teid="cl:html:51"></option>
                        <option value="asamblea" teid="cl:html:52"></option>
                        <option value="consejo" teid="cl:html:53"></option>
                        <option value="residente" teid="cl:html:54"></option>
                        <!--<option value="proveedor">Proveedores</option>-->
                      </select>
                    </td>
                    <td>
                      <label value="odestinatario" teid="cl:html:55"></label>
                      <!--<label teid="cl:html:56"></label>-->
                      <input type="email" multiple id="odestinatario" name="odestinatario" pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$" disabled/>
                    </td>
                  </tr>
                  <tr>
                    <!--<td>
                      <label for="frecuenciae" teid="cl:html:57"></label>
                      <select id="frecuenciae" name="frecuenciae">
                        <option value = "ninguna" selected="selected" teid="cl:html:58"></option>
                        <option value = "semanal" teid="cl:html:59"></option>
                        <option value = "quincenal" teid="cl:html:60"></option>
                        <option value = "mensual"teid="cl:html:61"></option>
                        <option value = "anual" teid="cl:html:62"></option>
                      </select>
                    </td>-->
                    <td>
                      <label for="ver_copropiedade" teid="cl:html:63" style="display:inline"></label> <img style="display:inline" src="../template/images/tooltip.png" class="tooltip ttip" data-hasqtip="0" title="Escoja si el evento sera visible en el calendario publico para los integrantes de la copropiedad o si solo sera visible en su calendario privado" aria-describedby="qtip-0"/>
                      <select id="ver_copropiedade">
                        <option value="SI" teid="cl:html:64"></option>
                        <option value="NO" teid="cl:html:65"></option>
                      </select>
                      <input type="hidden" id="frecuenciae" value="ninguna"/>
                    </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                        <label teid="cl:html:20"></label>
                        <textarea id="notase" name="notase"></textarea>
                      </td>
                  </tr>
                </table>
                <div id="dialog_eliminare" style="display:none">
                  <h3 teid="cl:html:84"></h3>
                  <p teid="cl:html:86"></p>
                  <form>
                    <input type="hidden" id="elmongoid" value=""/>
                    <input type="hidden" id="elcreacion" value=""/>
                    <input type="hidden" id="elnombre" value=""/>
                    <input type="hidden" id="eldeadline" value=""/>
                    <input type="hidden" id="elfrecuencia" value=""/>
                    <input type="hidden" id="elnotas" value=""/>
                </div>
                <div id="botones-form" style="text-align:right">
                  <input type="button" teid="cl:val:22, cl:title:34" class="btn icono borrar inline ttip" id="btnr_eliminar_evento"/>
                  <input type="submit" teid="cl:val:66, cl:title:33" class="btn icono guardar ttip positivo" value=""/>
                </div>
              </form>
              <div id="error" class="modal"></div>
              <!--<div id="dialog_eliminar" style="display:none">
                  <h3>Desea eliminar el evento?</h3>
                  <input type="hidden" id="comongoid" value=""/>
                  <input type="hidden" id="cocreacion" value=""/>
                  <input type="hidden" id="conombre" value=""/>
                  <input type="hidden" id="codeadline" value=""/>
                  <input type="hidden" id="cofrecuencia" value=""/>
                  <input type="hidden" id="conotas" value=""/>
                </div>
                <div id="botones-form" style="text-align:right">
                  <input type="button" value="Completar" class="btn icono completar inline ttip" id="completar_tarea_calendario" />
                  <input type="submit" teid="cl:val:72, cl:title:73" class="btn icono guardar ttip positivo" />
                </div>
            </div>-->
        <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
