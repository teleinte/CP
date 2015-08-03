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
<script type="text/javascript" src="sjs/editar.js"></script>
<!--<script type="text/javascript" src="../tarea/sjs/tareas.js"></script>-->
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
              <h1 class="title calendario" teid="cl:html:71"></h1>
            </div>
            <?php require_once('../template/include/alerts.inc'); ?>
              <form class="clearfix" id="tarea_editar_form">
                <table>
                  <tr>
                    <td colspan="2">
                      <label for="nombre" teid="cl:html:17"></label>
                      <input type="text" id="nombre" name="nombre" autofocus required/>
                      <input type="hidden" id="estado" name="estado" teid="cl:val:37" />
                      <input type="hidden" id="fecha_creacion"/>
                      <input type="hidden" id="mongoid"/>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2">
                      <label for="deadline" teid="cl:html:18"></label>
                      <input type="date" id="datepicker2" name="deadline" required style="width:95%; padding-right:25px;">
                    </td>
                    <!--<td>
                        <label for="frecuencia" teid="cl:html:19"></label>
                        <select id="frecuencia" name="frecuencia" required>
                          <option value = "Ninguna" selected="selected" teid="cl:html:58"></option>
                          <option value = "Semanal" teid="cl:html:59"></option>
                          <option value = "Quincenal" teid="cl:html:60"></option>
                          <option value = "Mensual" teid="cl:html:61"></option>
                          <option value = "Anual" teid="cl:html:62"></option>
                        </select>
                      </td>-->
                  </tr>
                  <tr>
                      <td colspan="2">
                        <label teid="cl:html:20"></label>
                        <textarea id="notas" name="notas"></textarea>
                        <input type="hidden" id="frecuencia" value="ninguna"/>
                      </td>
                  </tr>
                </table>
                <div id="dialog_eliminar" style="display:none">
                  <h4 teid="tar:html:37"></h4>
                  <form>
                    <input type="hidden" id="elmongoid" value=""/>
                    <input type="hidden" id="elcreacion" value=""/>
                    <input type="hidden" id="elnombre" value=""/>
                    <input type="hidden" id="eldeadline" value=""/>
                    <input type="hidden" id="elfrecuencia" value=""/>
                    <input type="hidden" id="elnotas" value=""/>
                </div>
                <div id="dialog_completar" style="display:none">
                  <h4 teid="tar:html:38"></h4>
                  <input type="hidden" id="comongoid" value=""/>
                  <input type="hidden" id="cocreacion" value=""/>
                  <input type="hidden" id="conombre" value=""/>
                  <input type="hidden" id="codeadline" value=""/>
                  <input type="hidden" id="cofrecuencia" value=""/>
                  <input type="hidden" id="conotas" value=""/>
                </div>
                <div id="botones-form" style="text-align:right">
                  <input type="button" teid="cl:val:22, cl:title:30" class="btn icono borrar inline btnr_eliminar_tarea"  id="btnr_eliminar_tarea"/>
                  <input type="button" value="Completar" class="btn icono completar inline ttip" id="completar_tarea_calendario" />
                  <input type="submit" teid="cl:val:72, cl:title:73" class="btn icono guardar ttip positivo" id="guardar_tarea_calendario"/>
                </div>
              </form>
            </div>
        <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
