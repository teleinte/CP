<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="re:html:50"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/reservas-functions.js"></script>
<script type="text/javascript" src="sjs/adminreservas.js"></script>
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
      <div class="contenedor">
        <!-- Codigo de la aplicacion -->
          <div class="titulo-principal">
            <h1 class="title calendario" teid="re:html:32"></h1>
          </div>
          <?php require_once('../template/include/alerts.inc'); ?>
          <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
            <div class="floatleft" style="display:inline;"><span style="display:inline;" teid="re:html:118"></span>
            <select id="ddrecursos" style="display:inline;">
              <option value="" disabled selected teid="re:html:33"></option>
            </select>
            <input type="hidden" id="fechareservainicio" name="fechareservainicio" value=""/>
            <input type="hidden" id="fechareservafin" name="fechareservafin" value=""/>   
            <input type="submit" class="btn ttip positivo"  teid="re:val:34, re:title:93" id="btndisponibilidad"/></div>
          </div>
          <div id="reservas-table">
            <div id="reserva-title"></div>
              <table id="listareservas" class="stripe" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th teid="re:html:115"></th>
                          <th teid="re:html:116"></th>
                          <th teid="re:html:37"></th>
                          <th>Inmueble de residente</th>
                          <th teid="re:html:38"></th>
                          <th teid="re:html:39"></th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
          <div id="reservaEdit">
            <form id="reservaEditar">
              <input type="hidden" id="mongoid" name="mongoid" value=""/>
              <input type="hidden" id="creacion" name="creacion" value=""/>
              <input type="hidden" id="user" name="user" value=""/>
              <input type="hidden" id="comentario" name="comentario" value=""/>
              <input type="hidden" id="idcopropiedad" name="idcopropiedad" value=""/>
              <input type="hidden" id="idinmueble" name="idinmueble" value=""/>
              <input type="hidden" id="grupo" name="grupo" value=""/>
              <input type="hidden" id="estado" name="estado" value=""/>
              <p><label for="startfecha" teid="re:html:41"></label>
              <input type="date" id="startfecha" name="startfecha" value="" required/></p>
              <p><label for="startfecha" teid="re:html:42"></label>
              <select id="starthora" name="starthora" required>
                <option value="00:00">00:00</option>
                <option value="00:30">00:30</option>
                <option value="01:00">01:00</option>
                <option value="01:30">01:30</option>
                <option value="02:00">02:00</option>
                <option value="02:30">02:30</option>
                <option value="03:00">03:00</option>
                <option value="03:30">03:30</option>
                <option value="04:00">04:00</option>
                <option value="04:30">04:30</option>
                <option value="05:00">05:00</option>
                <option value="05:30">05:30</option>
                <option value="06:00">06:00</option>
                <option value="06:30">06:30</option>
                <option value="07:00">07:00</option>
                <option value="07:30">07:30</option>
                <option value="08:00">08:00</option>
                <option value="08:30">08:30</option>
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
                <option value="18:30">18:30</option>
                <option value="19:00">19:00</option>
                <option value="19:30">19:30</option>
                <option value="20:00">20:00</option>
                <option value="20:30">20:30</option>
                <option value="21:00">21:00</option>
                <option value="21:30">21:30</option>
                <option value="22:00">22:00</option>
                <option value="22:30">22:30</option>
                <option value="23:00">23:00</option>
                <option value="23:30">23:30</option>
              </select></p>
              <p><label for="startfecha" teid="re:html:43"></label>
              <input type="date" id="endfecha" name="endfecha" value="" required/></p>
              <p><label for="startfecha" teid="re:html:44"></label>
              <select id="endhora" name="endhora" required>
                <option value="00:00">00:00</option>
                <option value="00:30">00:30</option>
                <option value="01:00">01:00</option>
                <option value="01:30">01:30</option>
                <option value="02:00">02:00</option>
                <option value="02:30">02:30</option>
                <option value="03:00">03:00</option>
                <option value="03:30">03:30</option>
                <option value="04:00">04:00</option>
                <option value="04:30">04:30</option>
                <option value="05:00">05:00</option>
                <option value="05:30">05:30</option>
                <option value="06:00">06:00</option>
                <option value="06:30">06:30</option>
                <option value="07:00">07:00</option>
                <option value="07:30">07:30</option>
                <option value="08:00">08:00</option>
                <option value="08:30">08:30</option>
                <option value="09:00">09:00</option>
                <option value="09:30">09:30</option>
                <option value="10:00">10:00</option>
                <option value="10:30">10:30</option>
                <option value="11:00">11:00</option>
                <option value="11:30">11:30</option>
                <option value="12:00">12:00</option>
                <option value="12:30">12:30</option>
                <option value="13:00">13:00</option>
                <option value="13:30">13:30</option>
                <option value="14:00">14:00</option>
                <option value="14:30">14:30</option>
                <option value="15:00">15:00</option>
                <option value="15:30">15:30</option>
                <option value="16:00">16:00</option>
                <option value="16:30">16:30</option>
                <option value="17:00">17:00</option>
                <option value="17:30">17:30</option>
                <option value="18:00">18:00</option>
                <option value="18:30">18:30</option>
                <option value="19:00">19:00</option>
                <option value="19:30">19:30</option>
                <option value="20:00">20:00</option>
                <option value="20:30">20:30</option>
                <option value="21:00">21:00</option>
                <option value="21:30">21:30</option>
                <option value="22:00">22:00</option>
                <option value="22:30">22:30</option>
                <option value="23:00">23:00</option>
                <option value="23:30">23:30</option>
                <option value="23:59">23:59</option>
              </select></p>
              <div class="botones-form">
                <input type="submit" class="ttip positivo" teid="re:val:45, re:title:94"/>
              </div>
            </form>
          </div>
          <div id="reservaBorrar">
            <form id="reservaBorrar">
              <p><h4 teid="re:html:95"></h4></p>
              <input type="hidden" id="mongoid" name="mongoid"/>
              <input type="hidden" id="userborrado" name="userborrado"/>
              <div class="botones-form">
                <input type="submit" class="ttip positivo" teid="re:val:96, re:title:97"/>
              </div>
            </form>
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