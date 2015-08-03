<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="re:html:50"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<link href='scss/fullcalendar.css' rel='stylesheet' />
<link href='scss/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='sjs/fullcalendar/moment.min.js'></script>
<script src='sjs/fullcalendar/fullcalendar.min.js'></script>
<script src='sjs/fullcalendar/es.js'></script>
<script type="text/javascript" src="sjs/reservas-functions.js"></script>
<script type="text/javascript" src="sjs/calendario.js"></script>
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
          <h1 class="title calendario" teid="re:html:65"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
        <div style="padding: 10px 0; margin:-15px 0 10px;">
          <div class="floatleft" style="display:inline;">
            <span style="display:inline;" teid="re:html:66"></span>
            <input type="date" id="fecha-reserva" required/>   <span style="display:inline;"></span>
            <select id="ddrecursos" style="display:inline;" style="width:350px;" required>
              <option value="" disabled selected teid="re:html:47"></option>
            </select>   
            <input type="submit" class="btn ttip positivo" teid="re:val:27, re:title:67" id="btndisponibilidad"/>
          </div>
          <div style="clear: both;"></div>
        </div>
        <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
          <div class="floatleft" style="display:inline;"><input type="submit" teid="re:val:25, re:title:68" class="btn ttip" id="btndisponibilidadanterior"/>  <input type="submit" teid="re:val:26, re:title:69"class="btn ttip" id="btndisponibilidadsiguiente"/></div>
          <div class="floatright"  style="padding-top:5px;"></div>
        </div>
        <div id="calendar-visibility">
        <div id="reserva-title"></div>
          <div id="calEventDialog">
          	<form class="clearfix" id="reserva_form">
                <table>
                    <tr>
                      <td>
                        <input type="hidden" id="crea_id_copropiedad" name="id_copropiedad" value=""/>
                        <input type="hidden" id="crea_id_inmueble" name="id_inmueble" value=""/>
                        <input type="hidden" id="crea_fecha_inicio" name="fecha_inicio" value=""/>
                        <input type="hidden" id="crea_fecha_fin" name="fecha_fin" value=""/>
                        <input type="hidden" id="crea_usuario" name="usuario" value=""/>
                        <input type="hidden" id="crea_estado" name="estado" value="creada"/>
                        <div id="reservaStatus"></div>
                        <p id="reservaData"></p>
                        <div id="reservaComment"></div>
                      </td>
                    </tr>
                </table>
                <div class="botones-form"> <div id="reservaConfirmar"></div></div>
              </form>
          </div>
          <div id="calendar1"></div>
          <div id="eventContent" title="Detalles" style="display: none;">
            <div id="TareaContent">
              <div class="seccion">
                <p><strong teid="re:html:35"></strong> <span id="startTime"></span></p>
                <p><strong teid="re:html:36"></strong> <span id="endTime"> </span><br> </p>
                <p><strong teid="re:html:123"></strong> <span id="reservador"> </span><br> </p>
                <p><strong teid="re:html:124"></strong> <span id="comentario"> </span><br> </p>
              </div>
            </div>
          </div>
        </div>
     	 </div>
        <!-- Finaliza codigo de la aplicacion -->
      </section>
      <footer>  
        <?php require_once('../template/include/footer.inc'); ?>
      </footer>
  </div>
</body>
</html>