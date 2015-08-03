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
                <h1 class="title calendario" teid="cl:html:2"></h1>
              </div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                <div class="floatleft">
                  <span teid="cl:html:3"></span> 
                  <span class="verde" style="padding:5px 15px;" teid="cl:html:4"></span> 
                  <span class="naranja" style="padding:5px 15px;" teid="cl:html:5"></span> 
                  <span class="rojo" style="padding:5px 15px;" teid="cl:html:6"></span>
                </div>
              </div>
          <div id="calEventDialog">
            <p><span teid="cl:html:82"></span></p>
          </div>
          <div id="notavailable">
            <p><span>No es posible crear tareas o eventos en fechas pasadas.</span></p>
          </div>
          <div id="calendar"></div>
          <div id="calEventDialogResize">
            <p><span teid="cl:html:9"></span><span id="eventResizeName"></span><span teid="cl:html:10"></span><span id="eventResizeDate"></span><span teid="cl:html:11"></span><span id="eventResizeTime"></span> <input type="hidden" id="eventResizeFullDate" value="" /></p><p>Se enviarán actualizaciones por correo electrónico a los invitados del evento.</p>
          </div>
          <div id="calEventDialogDrop">
            <p><span teid="cl:html:9"></span><span id="eventDropName"></span><span teid="cl:html:12"></span><span id="eventDropStartDate"></span><span teid="cl:html:11"></span><span id="eventDropStartTime"></span> <span teid="cl:html:13"></span><span id="eventDropEndDate"></span><span teid="cl:html:11"></span><span id="eventDropEndTime"></span> <input type="hidden" id="eventResizeFullStartDate" value="" /><input type="hidden" id="eventResizeFullEndDate" value="" /></p><p>Se enviarán actualizaciones por correo electrónico a los invitados del evento.</p>
          </div>
          <div id="calEventTaskDialogDrop">
            <p><span teid="cl:html:14"></span><span id="eventDropName"></span><span teid="cl:html:15"></span></p>
          </div>
          <div id="eventContent" style="display: none;">
            <div id="TareaContent">
              <div class="seccion">
                <!--<h4 teid="cl:html:16"></h4>-->
                <p><strong teid="cl:html:17"></strong> <span id="eventInfo"></span></p>
                <p><strong teid="cl:html:18"></strong> <span id="eventDeadline"> </span><br> </p>
                <p><strong teid="cl:html:20"></strong> <span id="eventDesc"></span></p>
              </div>
              <div class="botones-form">
                <!--<input type="button" teid="cl:val:22, cl:title:30" class="btn icono borrar inline"  id="btnr_eliminar_tarea"/>
                <input type="button" teid="cl:val:23, cl:title:31" class="btn icono completar inline" id="btnr_completar_tarea"/>-->
                <input type="button" teid="cl:val:21, cl:title:29"class="btn icono editar inline positivo" id="btnr_editar_tarea"/>
              </div>
            </div>
            <div id="EventoContent">
              <div class="seccion">
                <!--<h4 teid="cl:html:16"></h4>-->
                <p><strong teid="cl:html:24"></strong> <span id="ev_nombre"></span></p>
                <p><strong teid="cl:html:80"></strong> <span id="ev_fecha_inicio"></span></p>
                <p><strong teid="cl:html:81"></strong> <span id="ev_fecha_fin"> </span><br> </p>
                <p><strong teid="cl:html:26"></strong> <span id="ev_cal_copropiedad"> </span><br> </p>
                <!--<p><strong teid="cl:html:27"></strong> <span id="ev_invitados"> </span><br> </p>
                <p><strong teid="cl:html:28"></strong> <span id="ev_otros"> </span><br> </p>-->
                <p><strong teid="cl:html:20"></strong> <span id="ev_notas"></span></p>
              </div>
              <div class="botones-form">
                <input type="button" teid="cl:val:21, cl:title:33" class="btn icono editar inline positivo" id="btnr_editar_evento"/>
              </div>
              <form class="clearfix" id="evento_form_resize" style="display:inline-block; float:right; margin-left:10px;">
                    <input type="hidden" id="rev_nombre" name="rev_nombre" value=""/>
                    <input type="hidden" id="rev_fecha_inicio" name="rev_fecha_inicio" value=""/>
                    <input type="hidden" id="rev_fecha_creacion" name="rev_fecha_creacion" value=""/>
                    <input type="hidden" id="rev_fecha_fin" name="rev_fecha_fin" value=""/>
                    <input type="hidden" id="rev_cal_copropiedad" name="rev_cal_copropiedad" value=""/>
                    <input type="hidden" id="rev_frecuencia" name="rev_frecuencia" value="" />
                    <input type="hidden" id="rev_notas" name="rev_notas" value="" />
                    <input type="hidden" id="rev_id" name="rev_id" value="" />
                    <input type="hidden" id="rev_invitados" name="rev_notas" value="" />
                    <input type="hidden" id="rev_otros" name="rev_id" value="" />
              </form>
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
