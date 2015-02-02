<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>

<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
    <!-- Jquery UI y tabs y modals -->
    <script src="js/copropiedad-calendar-modals.js"></script>
    <script>
        $(function() {
          $( "#tabs" ).tabs();
          });
    </script>
    <!-- Fullcalendar -->
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='js/fullcalendar/moment.min.js'></script>
    <script src='js/fullcalendar/fullcalendar.min.js'></script>
    <script src='js/fullcalendar/es.js'></script>
    <script src='js/copropiedad-calendar.js'></script>
<!-- The BackEnd -->
    <script src="js/copropiedad-calendar-functions.js"></script>
    <script src="js/copropiedad-calendar-enviodatos.js"></script>
    <script src="js/copropiedad-calendar-enviarcorreo.js"></script>
    <script src="js/copropiedad-calendar-validate.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),}};
        TraerUsuarioCopropiedad(arr,"usuario/copropiedad", sessionStorage.getItem('cp'));
      });
    </script> 

    <script type="text/javascript">
      $(document).ready(function(){
        $("#nuevos").click(function(){
          $("#new-panel").toggle("fast");
          $(this).toggleClass("active");
          return false;
        });
      });
      $(document).ready(function(){
        $("#aplicaciones").click(function(){
          $("#app-panel").toggle("fast");
          $(this).toggleClass("active");
          return false;
        });
      });
      $(document).ready(function(){
        $("#pendientes").click(function(){
          $("#pending-panel").toggle("fast");
          $(this).toggleClass("active");
          return false;
        });
      });
    </script>

    <?php
        include("templates/mcopropiedad.php");
        //include("templates/menu.php");
    ?> 
    
    <!-- Jquery UI y Tabs -->
    <script src="../js/jquery-ui.js"></script>
    <!-- Script selector de copropiedad -->
    <script src="../js/jquery-dd.js"></script>

<script>
  $(document).ready(function(e) {   
    //no use
    try {      
      var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
        var val = data.value;
        if(val!="")
        {
          if (val=="Nueva"){window.open('../copropiedad/copropiedad-nuevodos.php','_parent');}
          else{sessionStorage.setItem("cp", val)
            javascript:location.reload()  
          }           
        }
      }}}).data("dd");
    } catch(e) {
      //console.log(e); 
    }
    $("#ver").html(msBeautify.version.msDropdown);
  });
  </script>
<!-- Selector para cambiar las hojas de estilo -->
<script src="../js/stylesheet-switcher.js"></script>





</head>

<body>
	<?php include("../template/header.inc") ?>
    <div id="contenido-principal">
        <section id="central">

                <aside>
                <?php
                include("templates/aside.php");
                ?>           
                </aside>
        		
                <div class="contenedor">
                	<div class="titulo-principal"><h1 class="title calendario">Calendario</h1></div>
                  <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatleft">Colores de calendario: <span class="verde" style="padding:5px 15px;">Tareas</span> <span class="naranja" style="padding:5px 15px;">Eventos</span> <span class="rojo" style="padding:5px 15px;">Copropiedad</span></div>
                    <div class="floatright"><a href="../tarea" class="btn">Ver lista de tareas</a> <a href="../evento" class="btn">Ver lista de eventos</a></div>
                  </div>
                  <div id="preloader" style="margin:0 auto; padding:10px 20px; background-color:#fefefe; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; background-color: rgba(0,0,0,0.5);"><img src="../images/loading.gif" alt="Cargando..." style="margin:0 auto;"/></div>
                    <div id="calEventDialog">
                    	<!--<iframe id ="crear" src="partials/crear.php" width="472" height="540"></iframe>-->
                        <div id="tabs" class="">
                          <ul>
                            <li><a href="#tabs-1">Crear Tarea</a></li>
                            <li><a href="#tabs-2">Crear Evento</a></li>
                          </ul>
                          <div id="tabs-1">
                            <form class="clearfix" id="tarea_form">
                                <table>
                                    <tr>
                                        <td>
                                          <label for="nombre">Nombre de la tarea</label>
                                        </td>
                                        <td colspan="2">
                                          <input type="text" id="nombre" name="nombre" />
                                          <input type="hidden" id="estado" name="estado" value="Por Iniciar" />
                                        </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <label for="responsable">Responsable</label>
                                        <select id='responsable' name="responsable">
                                          <option value = "">-Seleccione-</option>
                                        </select>    
                                      </td>
                                      <td>
                                        <label for="prioridad">Prioridad</label>
                                        <select select id='prioridad' name="prioridad">
                                          <option value = "Baja">Baja</option>
                                          <option value = "Media">Media</option>
                                          <option value = "Alta">Alta</option>
                                        </select>
                                      </td>
                                      <td>
                                        <label for="deadline">Fecha límite</label>
                                        <input type="text" id="datepicker2" name="deadline">
                                      </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                          <label for="compartir_mail">Compartir esta tarea (escribe los correos electrónicos de los destinatarios separados por comas)</label>
                                          <input type="text" id="compartir_mail" name="compartir_mail">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">
                                          <label for="frecuencia">Frecuencia de la tarea</label>
                                          <select id="frecuencia" name="frecuencia">
                                            <option value = "Ninguna">Ninguna</option>
                                            <option value = "Semanal">Semanal</option>
                                            <option value = "Quincenal">Quincenal</option>
                                            <option value = "Mensual">Mensual</option>
                                            <option value = "Anual">Anual</option>
                                          </select>
                                        </td>
                                        <td colspan="2">
                                          <label for="frecordatorio">Recordarme la tarea el día</label>
                                          <input type="text" id="datepicker" name="frecordatorio">
                                        </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                        <label class="check"><input type="checkbox" id="recordatorio_mail" name="recordatorio_mail" value="true">Por email</label>
                                        <label class="check"><input type="checkbox" id="recordatorio_cp" name="recordatorio_cp" value="true" checked>Con notificación en Copropiedad</label>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                          <label>Notas</label>
                                          <textarea id="notas" name="notas"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div id="alertas"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                          <input type="submit" class="btn icono guardar" value="Crear tarea"/>
                                        </td>
                                    </tr>
                                </table>
                              </form>
                          </div>
                          <div id="tabs-2">
                            <form class="clearfix" id="evento_form">
                                <table>
                                    <tr>
                                        <td>
                                          <label for="nombree">Nombre del evento</label>
                                        </td>
                                        <td colspan="2">
                                          <input type="text" id="nombree" name="nombree" />
                                        </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <label for="startdatee">Fecha Inicio</label>
                                        <input type="text" id="datepicker3" name="startdatee">
                                        <label for="starttimee">Hora Inicio</label>
                                        <select id="starttimee" name="starttimee">
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
                                      </td>
                                      <td>
                                        <label for="deadlinee">Fecha Fin</label>
                                        <input type="text" id="datepicker4" name="enddatee">
                                        <label for="endtimee">Hora Fin</label>
                                        <select id="endtimee" name="endtimee">
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
                                            <option value = "22:30">22:30</option>
                                        </select>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                          <label for="compartir_maile">Compartir este evento (escribe los correos electrónicos de los destinatarios separados por comas)</label>
                                          <input type="text" id="compartir_maile" name="compartir_maile">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">
                                          <label for="frecuenciae">Frecuencia del evento</label>
                                          <select id="frecuenciae" name="frecuenciae">
                                            <option value = "Ninguna">Ninguna</option>
                                            <option value = "Semanal">Semanal</option>
                                            <option value = "Quincenal">Quincenal</option>
                                            <option value = "Mensual">Mensual</option>
                                            <option value = "Anual">Anual</option>
                                          </select>
                                            <br/><br/><label class="check"><input type="checkbox" id="ver_copropiedade" name="ver_copropiedade" value="true" checked>Hacer este evento publico en la copropiedad</label>
                                        </td>
                                        <td colspan="2">
                                          <label for="frecordatorio">Recordar el evento el día</label>
                                          <input type="text" id="datepicker5" name="frecordatorioe">
                                        </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2">
                                        <label class="check"><input type="checkbox" id="recordatorio_maile" name="recordatorio_maile" value="true">Por email</label>
                                        <label class="check"><input type="checkbox" id="recordatorio_cpe" name="recordatorio_cpe" value="true" checked>Con notificación en Copropiedad</label><br/>
                                      </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                          <label>Notas</label>
                                          <textarea id="notase" name="notase"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div id="alertas"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                          <input type="submit" class="btn icono guardar" value="Crear Evento"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                          </div>
                      </div>
                    </div>
                    <div id="calendar"></div>
                    <div id="calEventDialogResize">
                      <p>El evento <span id="eventResizeName"></span> finalizará ahora el <span id="eventResizeDate"></span> a las <span id="eventResizeTime"></span> <input type="hidden" id="eventResizeFullDate" value="" /></p>
                    </div>
                    <div id="calEventDialogDrop">
                      <p>El evento <span id="eventDropName"></span> iniciará ahora el <span id="eventDropStartDate"></span> a las <span id="eventDropStartTime"></span> y finalizará el <span id="eventDropEndDate"></span> a las <span id="eventDropEndTime"></span> <input type="hidden" id="eventResizeFullStartDate" value="" /><input type="hidden" id="eventResizeFullEndDate" value="" /></p>
                    </div>
                    <div id="calEventTaskDialogDrop">
                      <p>La tarea <span id="eventDropName"></span> no puede ser convertida en evento.</p>
                    </div>
                    <div id="eventContent" title="Detalles" style="display: none;">
                      <div id="TareaContent">
                        <div class="seccion">
                          <h4>Información general</h4>
                          <p><strong>Nombre de la tarea:</strong> <span id="eventInfo"></span></p>
                          <p><strong>Fecha creación:</strong> <span id="startTime"></span></p>
                          <p><strong>Prioridad:</strong> <span id="eventPrioridad"> </span><br> </p>
                          <p><strong>Fecha límite:</strong> <span id="eventDeadline"> </span><br> </p>
                          <p><strong>Frecuencia de la tarea:</strong> <span id="eventFrecuencia"> </span><br> </p>
                          <p><strong>Recordatorio para el día:</strong> <span id="eventFechaRecordatorio"> </span><br> </p>
                          <p><strong>Recordatorio en Copropiedad:</strong> <span id="eventRecordatorioCP"> </span><br> </p>
                          <p><strong>Recordatorio por Correo:</strong> <span id="eventRecordatorioMail"> </span><br> </p>
                          <p><strong>Notas:</strong> <span id="eventDesc"></span></p>
                        </div>
                        <div class="seccion">
                          <h4>Participantes</h4>
                          <p><strong>Responsable:</strong> <span id="eventResponsable"> </span><br></p>
                          <p><strong>Tarea compartida con:</strong> <span id="eventCompartida"> </span><br></p>
                        </div>
                        <div stle="align:right;">
                            <div id="alertas"></div>
                            <form class="clearfix" id="tarea_form_eliminar" style="display:inline-block; float:right; margin-left:10px;">
                              <input type="hidden" id="eli_nombre" name="eli_nombre" value=""/>
                              <input type="hidden" id="eli_estado" name="eli_estado" value="" />
                              <input type="hidden" id="eli_responsable" name="eli_responsable" value="" />    
                              <input type="hidden" id="eli_prioridad" name="eli_prioridad" value="" />
                              <input type="hidden" id="eli_datepicker2" name="eli_deadline" value="" />
                              <input type="hidden" id="eli_compartir_mail" name="eli_compartir_mail" value="" />
                              <input type="hidden" id="eli_frecuencia" name="eli_frecuencia" value="" />
                              <input type="hidden" id="eli_datepicker" name="eli_frecordatorio" value="" />
                              <input type="hidden" id="eli_recordatorio_mail" name="eli_recordatorio_mail"  value="" />
                              <input type="hidden" id="eli_recordatorio_cp" name="eli_recordatorio_cp"  value="" />
                              <input type="hidden" id="eli_notas" name="eli_notas" value="" />
                              <input type="hidden" id="eli_opcion" name="eli_opcion" value="SI" />
                              <input type="hidden" id="eli_id" name="eli_id" value="" />
                              <input type="submit" class="btn icono borrar inline" value="Eliminar">
                            </form>
                            <form class="clearfix" id="tarea_form_completar" style="display:inline-block; float:right;">
                              <input type="hidden" id="com_nombre" name="com_nombre" value=""/>
                              <input type="hidden" id="com_estado" name="com_estado" value="" />
                              <input type="hidden" id="com_responsable" name="com_responsable" value="" />    
                              <input type="hidden" id="com_prioridad" name="com_prioridad" value="" />
                              <input type="hidden" id="com_datepicker2" name="com_deadline" value="" />
                              <input type="hidden" id="com_compartir_mail" name="com_compartir_mail" value="" />
                              <input type="hidden" id="com_frecuencia" name="com_frecuencia" value="" />
                              <input type="hidden" id="com_datepicker" name="com_frecordatorio" value="" />
                              <input type="hidden" id="com_recordatorio_mail" name="com_recordatorio_mail"  value="" />
                              <input type="hidden" id="com_recordatorio_cp" name="com_recordatorio_cp"  value="" />
                              <input type="hidden" id="com_notas" name="com_notas" value="" />
                              <input type="hidden" id="com_opcion" name="com_opcion" value="SI" />
                              <input type="hidden" id="com_id" name="com_id" value="" />
                              <input type="submit" class="btn icono completar" value="Completar">                            
                            </form>
                            <form class="clearfix" style="display:inline-block; float:right; margin-right:10px;">
                              <a class="btn icono editar inline" id="btn_editar_tarea" href="">Editar</a>
                            </form>
                        </div>
                      </div>
                      <div id="EventoContent">
                        <div class="seccion">
                          <h4>Información general</h4>
                          <p><strong>Nombre del evento:</strong> <span id="ev_nombre"></span></p>
                          <p><strong>Fecha creación:</strong> <span id="ev_fecha_creacion"></span></p>
                          <p><strong>Fecha inicio:</strong> <span id="ev_fecha_inicio"></span></p>
                          <p><strong>Fecha fin:</strong> <span id="ev_fecha_fin"> </span><br> </p>
                          <p><strong>Frecuencia del evento:</strong> <span id="ev_frecuencia"> </span><br> </p>
                          <p><strong>Mostrar en el calendario de la copropiedad:</strong> <span id="ev_cal_copropiedad"> </span><br> </p>
                          <p><strong>Recordatorio para el día:</strong> <span id="ev_recordatorio"> </span><br> </p>
                          <p><strong>Recordatorio en Copropiedad:</strong> <span id="ev_recordatorio_cp"> </span><br> </p>
                          <p><strong>Recordatorio por Correo:</strong> <span id="ev_recordatorio_mail"> </span><br> </p>
                          <p><strong>Compartir con:</strong> <span id="ev_compartir_mail"> </span><br> </p>
                          <p><strong>Notas:</strong> <span id="ev_notas"></span></p>
                        </div>
                        <div stle="align:right;">
                            <div id="alertas"></div>
                            <form class="clearfix" id="evento_form_eliminar" style="display:inline-block; float:right; margin-left:10px;">
                              <input type="hidden" id="eev_nombre" name="eev_nombre" value=""/>
                              <input type="hidden" id="eev_fecha_inicio" name="eev_fecha_inicio" value=""/>
                              <input type="hidden" id="eev_fecha_creacion" name="eev_fecha_creacion" value=""/>
                              <input type="hidden" id="eev_fecha_fin" name="eev_fecha_fin" value=""/>
                              <input type="hidden" id="eev_cal_copropiedad" name="eev_cal_copropiedad" value=""/>
                              <input type="hidden" id="eev_compartir_mail" name="eev_compartir_mail" value="" />
                              <input type="hidden" id="eev_frecuencia" name="eev_frecuencia" value="" />
                              <input type="hidden" id="eev_frecordatorio" name="eev_frecordatorio" value="" />
                              <input type="hidden" id="eev_recordatorio_mail" name="eev_recordatorio_mail"  value="" />
                              <input type="hidden" id="eev_recordatorio_cp" name="eev_recordatorio_cp"  value="" />
                              <input type="hidden" id="eev_notas" name="eev_notas" value="" />
                              <input type="hidden" id="eev_opcion" name="eev_opcion" value="SI" />
                              <input type="hidden" id="eev_id" name="eev_id" value="" />
                              <input type="submit" class="btn icono borrar" value="Eliminar">
                            </form>
                            <form class="clearfix" style="display:inline-block; float:right; margin-top:5px;">
                              <a class="btn icono editar" id="btn_editar_evento" href="">Editar</a>
                            </form>
                            <form class="clearfix" id="evento_form_resize" style="display:inline-block; float:right; margin-left:10px;">
                              <input type="hidden" id="rev_nombre" name="rev_nombre" value=""/>
                              <input type="hidden" id="rev_fecha_inicio" name="rev_fecha_inicio" value=""/>
                              <input type="hidden" id="rev_fecha_creacion" name="rev_fecha_creacion" value=""/>
                              <input type="hidden" id="rev_fecha_fin" name="rev_fecha_fin" value=""/>
                              <input type="hidden" id="rev_cal_copropiedad" name="rev_cal_copropiedad" value=""/>
                              <input type="hidden" id="rev_compartir_mail" name="rev_compartir_mail" value="" />
                              <input type="hidden" id="rev_frecuencia" name="rev_frecuencia" value="" />
                              <input type="hidden" id="rev_frecordatorio" name="rev_frecordatorio" value="" />
                              <input type="hidden" id="rev_recordatorio_mail" name="rev_recordatorio_mail"  value="" />
                              <input type="hidden" id="rev_recordatorio_cp" name="rev_recordatorio_cp"  value="" />
                              <input type="hidden" id="rev_notas" name="rev_notas" value="" />
                              <input type="hidden" id="rev_opcion" name="rev_opcion" value="SI" />
                              <input type="hidden" id="rev_id" name="rev_id" value="" />
                            </form>
                        </div>
                      </div>
                    </div>
               	</div>
        </section>
        <div id="alertas-absolutas">
            <!-- <div class="alert alert-warning">
                <h4>Mantenimiento</h4>
                <p>El día 8 de Diciembre, a partir de las 12:00am, estaremos realizando un<br />mantenimiento al aplicativo por lo que puede presentar algunas fallas.</p>
            </div> -->
      	</div>
    </div>
</body>
</html>