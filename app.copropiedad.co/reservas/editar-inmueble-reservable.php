<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="re:html:50"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/editar.js"></script>
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
          <h1 class="title" teid="re:html:23"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
          <div class="clearfix">
            <form id="unidad_form">
              <table>
                <tr><td width="40%"></td><td width="30%"></td><td width="30%"></td></tr>
                <tr>
                  <td colspan="3">
                    <label for="nombre"  teid="re:html:15"></label>
                    <input type="text" id="nombre" required></form>
                    <input type="hidden" id="mongoid" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <label for="tiempo_reserva"  teid="re:html:16"></label>
                    <select select id='tiempo_reserva' name="tiempo_reserva" required>
                      <option value = "01">1 </option>
                      <option value = "02">2 </option>
                      <option value = "03">3 </option>
                      <option value = "04">4 </option>
                      <option value = "05">5 </option>
                      <option value = "06">6 </option>
                      <option value = "07">7 </option>
                      <option value = "08">8 </option>
                      <option value = "09">9 </option>
                      <option value = "10">10 </option>
                      <option value = "11">11 </option>
                      <option value = "12">12 </option>
                    </select>
                  </td>
                  <td>
                    <label for="hora_inicio_reserva"  teid="re:html:17"></label>
                    <select id='hora_inicio_reserva' name="hora_inicio_reserva" required><option value="00:00">00:00</option><option value="00:30">00:30</option><option value="01:00">01:00</option><option value="01:30">01:30</option><option value="02:00">02:00</option><option value="02:30">02:30</option><option value="03:00">03:00</option><option value="03:30">03:30</option><option value="04:00">04:00</option><option value="04:30">04:30</option><option value="05:00">05:00</option><option value="05:30">05:30</option><option value="06:00">06:00</option><option value="06:30">06:30</option><option value="07:00">07:00</option><option value="07:30">07:30</option><option value="08:00">08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option><option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option><option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option><option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option><option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option><option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option><option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option><option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option></select>
                  </td>
                  <td>
                    <label for="hora_fin_reserva"  teid="re:html:18"></label>
                    <select id='hora_fin_reserva' name="hora_fin_reserva" required><option value="00:00">00:00</option><option value="00:30">00:30</option><option value="01:00">01:00</option><option value="01:30">01:30</option><option value="02:00">02:00</option><option value="02:30">02:30</option><option value="03:00">03:00</option><option value="03:30">03:30</option><option value="04:00">04:00</option><option value="04:30">04:30</option><option value="05:00">05:00</option><option value="05:30">05:30</option><option value="06:00">06:00</option><option value="06:30">06:30</option><option value="07:00">07:00</option><option value="07:30">07:30</option><option value="08:00">08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option><option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option><option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option><option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option><option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option><option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option><option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option><option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option><option value="23:59">23:59</option></select>
                  </td>
                </tr>
                <tr>
                  <td colspan="3" id = "diasHabilitados">
                    <label for="diasHabilitados" teid="re:html:19"></label>
                    <span><input type="checkbox" class="chkdias" id="lunes" name="dias_reserva" value="1"><span teid="re:html:56"></span></span>
                    <span><input type="checkbox" class="chkdias" id="martes" name="dias_reserva" value="2"><span teid="re:html:57"></span></span>
                    <span><input type="checkbox" class="chkdias" id="miercoles" name="dias_reserva" value="3"><span teid="re:html:58"></span></span>
                    <span><input type="checkbox" class="chkdias" id="jueves" name="dias_reserva" value="4"><span teid="re:html:59"></span></span>
                    <span><input type="checkbox" class="chkdias" id="viernes" name="dias_reserva" value="5"><span teid="re:html:60"></span></span>
                    <span><input type="checkbox" class="chkdias" id="sabado" name="dias_reserva" value="6" checked><span teid="re:html:61"></span></span>
                    <span><input type="checkbox" class="chkdias" id="domingo" name="dias_reserva" value="0" checked><span teid="re:html:62"></span></span>
                    <span><input type="checkbox" class="chkdias" id="semana" name="semana"><span teid="re:html:63"></span></span>
                  </td>
                </tr>
              </table>
              <div class="botones-form">
                <input type="button" class="btn icono borrar ttip" id="cancelar" teid="re:val:122"/>
                <input type="submit" class="btn icono guardar ttip positivo" teid="re:val:24, re:title:64"/>
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