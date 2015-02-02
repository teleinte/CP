<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<head>
<link rel="stylesheet" href="../../css/jquery-ui.css" />
<link rel="stylesheet" href="../../css/chosen.css">
<link rel="stylesheet" href="../../css/estilos-copropiedad.css" type="text/css" media="all">
<link rel="stylesheet" href="../../css/tablet.css" type="text/css"  media="all and (min-width: 640px) and (max-width: 1199px)">
<link rel="stylesheet" href="../../css/mobile.css" type="text/css" media="all and (min-width: 100px) and (max-width: 639px)">

<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->
<script src="../../js/jquery.min.js"></script>
<!-- Jquery UI y Tabs -->
<script src="../../js/jquery-ui.js"></script>
<script>
    $(function() {
      $( "#tabs" ).tabs();
      });
</script>
<script src="../js/functions.js"></script>
<script src="../js/enviodatos.js"></script>
<script src="../js/validate.js"></script>
<script src="../js/enviarcorreo.js"></script>
</head>

<body id="modal">
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
                                        <option value = "">Ninguna</option>
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
                                      <input type="submit" class="btn icono guardar" value="Crear tarea"/>
                                    </td>
                                </tr>
                            </table>
                          </form>
                      </div>
                      <div id="tabs-2">
                        <form class="clearfix">
                            <table>
                                <tr>
                                    <td>
                                      <label for="nombre">Nombre del evento</label>
                                    </td>
                                    <td colspan="2">
                                      <input type="text" id="nombre" name="nombre" />
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <label for="startdate">Fecha Inicio</label>
                                    <input type="text" id="datepicker3" name="startdate">
                                    <label for="starttime">Hora Inicio</label>
                                    <select id="starttime" name="starttime">
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
                                  <td>
                                    <label for="deadline">Fecha Fin</label>
                                    <input type="text" id="datepicker4" name="enddate">
                                    <label for="endtime">Hora Fin</label>
                                    <select id="endtime" name="endtime">
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
                                      <label for="compartir_mail">Compartir este evento (escribe los correos electrónicos de los destinatarios separados por comas)</label>
                                      <input type="text" id="compartir_mail" name="compartir_mail">
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="2">
                                      <label for="frecuencia">Frecuencia del evento</label>
                                      <select id="frecuencia" name="frecuencia">
                                        <option value = "">Ninguna</option>
                                        <option value = "Semanal">Semanal</option>
                                        <option value = "Quincenal">Quincenal</option>
                                        <option value = "Mensual">Mensual</option>
                                        <option value = "Anual">Anual</option>
                                      </select>
                                        <br/><br/><label class="check"><input type="checkbox" id="ver_copropiedad" name="ver_copropiedad" value="true" checked>Hacer este evento publico en la copropiedad</label>
                                    </td>
                                    <td colspan="2">
                                      <label for="frecordatorio">Recordar el evento el día</label>
                                      <input type="text" id="datepicker" name="frecordatorio">
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <label class="check"><input type="checkbox" id="recordatorio_mail" name="recordatorio_mail" value="true">Por email</label>
                                    <label class="check"><input type="checkbox" id="recordatorio_cp" name="recordatorio_cp" value="true" checked>Con notificación en Copropiedad</label><br/>
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
                                      <input type="submit" class="btn icono guardar" value="Crear tarea"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                      </div>
                  </div>
</body>
</html>