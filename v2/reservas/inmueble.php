<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>

<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
    <!-- Jquery UI y tabs y modals -->
    <script src="js/copropiedad-reservas-modals.js"></script>
    <script src='js/copropiedad-reservas-inmuebles.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
    <link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">

    <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../js/dataTables.colVis.js"></script>
    <script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>
<!-- The BackEnd -->
    <script src="js/copropiedad-reservas-functions.js"></script>
    <script src="js/copropiedad-reservas-enviodatos.js"></script>
    <script src="js/copropiedad-reservas-enviarcorreo.js"></script>
    <script src="js/copropiedad-reservas-validate.js"></script>
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
                	<div class="titulo-principal"><h1 class="title calendario">Inmuebles reservables</h1></div>
                  <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatright" style="display:inline;"><input type="submit" class="btn" value="Agregar inmueble" id="btnagregarinmueble" />  <a class="btn" href="index.php">Regresar</a></div>
                  </div>
                  <div id="inmuebles-table">
                      <table id="listainmuebles" class="stripe" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th>Nombre despliegue</th>
                                  <th>Grupo</th>
                                  <th>Tiempo max. de reserva</th>
                                  <th>Hora apertura</th>
                                  <th>Hora cierre</th>
                                  <th>Dias de reserva</th>
                                  <th>Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
                  <div id="inmuebleCrear">
                    <form class="clearfix" id="crearInmuebleForm">
                        <table>
                            <tr>
                                <td>
                                  <label for="inmueble">Seleccione el inmueble</label>
                                </td>
                                <td colspan="2">
                                  <select id="inmueble" name="inmueble" style="width:100%;"></select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                  <label for="nombre_despliegue">Nombre despliegue</label>
                                </td>
                                <td colspan="2">
                                  <input type="text" id="nombre_despliegue" name="nombre_despliegue" />
                                </td>
                            </tr>
                            <tr>
                              <td><label for="treintas">Inicio de la reserva</label></td>
                              <td colspan="2">
                                <label class="check"><input type="radio" id="treintas0" name="treintas" value="00" checked>A horas cerradas (00:00)</label>
                                <label class="check"><input type="radio" id="treintas3" name="treintas" value="30">A medias horas (00:30)</label>
                              </td>
                            </tr>
                            <tr>
                              <td><label for="tiempo_reserva">Tiempo maximo de reserva</label></td>
                              <td colspan="2">
                                <select select id='tiempo_reserva' name="tiempo_reserva">
                                  <option value = "01">1 hora</option>
                                  <option value = "02">2 horas</option>
                                  <option value = "03">3 horas</option>
                                  <option value = "04">4 horas</option>
                                  <option value = "05">5 horas</option>
                                  <option value = "06">6 horas</option>
                                  <option value = "07">7 horas</option>
                                  <option value = "08">8 horas</option>
                                  <option value = "09">9 horas</option>
                                  <option value = "10">10 horas</option>
                                  <option value = "11">11 horas</option>
                                  <option value = "12">12 horas</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                                <td><label>Horas de reservas</label></td>
                                <td colspan="2">
                                  <p>Hora Inicio <select id='hora_inicio_reserva' name="hora_inicio_reserva" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                                  <p>Hora Fin <select id='hora_fin_reserva' name="hora_fin_reserva" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                                </td>
                            </tr>
                            <tr>
                              <td><label for="dias_reserva">Horas no reservables</label></td>
                              <td colspan="2">
                                <p>Inicio de restricción <select id='hora_inicio_restriccion' name="hora_inicio_restriccion" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                                <p>Fin de restricción <select id='hora_fin_restriccion' name="hora_fin_restriccion" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                              </td>
                            </tr>
                            <tr>
                                <td><label for="grupo">Grupo de recursos</label></td>
                                <td colspan="2">
                                  <select id='grupo' name="grupo">
                                    <option value = "">Seleccione Grupo</option>
                                    <option value = "Zonas Recreativas">Zonas Recreativas</option>
                                    <option value = "Zonas Comerciales">Zonas Comerciales</option>
                                    <option value = "Zonas Deportivas">Zonas Deportivas</option>
                                    <option value = "Zonas Comunales">Zonas Comunales</option>
                                    <option value = "Zonas Sociales">Zonas Sociales</option>
                                    <option value = "Zonas Humedas">Zonas Humedas</option>
                                  </select>    
                                </td>
                            </tr>
                            <tr>
                              <td><label for="dias_reserva">Dias reservables</label></td>
                              <td colspan="2">
                                <span style="display:inline;"><input type="checkbox" id="lunes" name="dias_reserva" value="1">Lunes</span>
                                <span style="display:inline;"><input type="checkbox" id="martes" name="dias_reserva" value="2">Martes</span>
                                <span style="display:inline;"><input type="checkbox" id="miercoles" name="dias_reserva" value="3">Miercoles</span>
                                <span style="display:inline;"><input type="checkbox" id="jueves" name="dias_reserva" value="4">Jueves</span>
                                <span style="display:inline;"><input type="checkbox" id="viernes" name="dias_reserva" value="5">Viernes</span>
                                <span style="display:inline;"><input type="checkbox" id="sabado" name="dias_reserva" value="6">Sabado</span>
                                <span style="display:inline;"><input type="checkbox" id="domingo" name="dias_reserva" value="0">Domingo</span>
                              </td>
                            </tr>
                            <tr>
                                <td>
                                  <label for="costo">Costo de reserva</label>
                                </td>
                                <td colspan="2">
                                  <input type="text" id="costo" name="costo" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div id="alertas"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                  <input type="submit" class="btn icono guardar" value="Crear inmueble"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                  </div>
                  <div id="inmuebleEditar">
                    <form class="clearfix" id="editarInmuebleForm">
                        <table>
                            <tr>
                                <td>
                                  <label for="edit_nombre_despliegue">Nombre despliegue</label>
                                </td>
                                <td colspan="2">
                                  <input type="text" id="edit_nombre_despliegue" name="edit_nombre_despliegue" />
                                  <input type="hidden" name="edit_mongoid" id="edit_mongoid" value="" />
                                  <input type="hidden" name="edit_inmueble" id="edit_inmueble" value="" />
                                </td>
                            </tr>
                            <tr>
                              <td><label for="edit_treintas">Inicio de la reserva</label></td>
                              <td colspan="2">
                                <label class="check"><input type="radio" id="edit_treintas0" name="edit_treintas" value="00" checked>A horas cerradas (00:00)</label>
                                <label class="check"><input type="radio" id="edit_treintas3" name="edit_treintas" value="30">A medias horas (00:30)</label>
                              </td>
                            </tr>
                            <tr>
                              <td><label for="edit_tiempo_reserva">Tiempo maximo de reserva</label></td>
                              <td colspan="2">
                                <select select id='edit_tiempo_reserva' name="edit_tiempo_reserva">
                                  <option value = "01">1 hora</option>
                                  <option value = "02">2 horas</option>
                                  <option value = "03">3 horas</option>
                                  <option value = "04">4 horas</option>
                                  <option value = "05">5 horas</option>
                                  <option value = "06">6 horas</option>
                                  <option value = "07">7 horas</option>
                                  <option value = "08">8 horas</option>
                                  <option value = "09">9 horas</option>
                                  <option value = "10">10 horas</option>
                                  <option value = "11">11 horas</option>
                                  <option value = "12">12 horas</option>
                                </select>
                              </td>
                            </tr>
                            <tr>
                                <td><label>Horas de reservas</label></td>
                                <td colspan="2">
                                  <p>Hora Inicio <select id='edit_hora_inicio_reserva' name="edit_hora_inicio_reserva" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                                  <p>Hora Fin <select id='edit_hora_fin_reserva' name="edit_hora_fin_reserva" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                                </td>
                            </tr>
                            <tr>
                              <td><label>Horas no reservables</label></td>
                              <td colspan="2">
                                <p>Inicio de restricción <select id='edit_hora_inicio_restriccion' name="edit_hora_inicio_restriccion" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                                <p>Fin de restricción <select id='edit_hora_fin_restriccion' name="edit_hora_fin_restriccion" style="width:150px; display: inline-block;"><option value = "06">06:00</option> <option value = "07">07:00</option> <option value = "08">08:00</option> <option value = "09">09:00</option> <option value = "10">10:00</option> <option value = "11">11:00</option> <option value = "12">12:00</option> <option value = "13">13:00</option> <option value = "14">14:00</option> <option value = "15">15:00</option> <option value = "16">16:00</option> <option value = "17">17:00</option> <option value = "18">18:00</option> <option value = "19">19:00</option> <option value = "20">20:00</option> <option value = "21">21:00</option> <option value = "22">22:00</option> <option value = "23">23:00</option></select></p>
                              </td>
                            </tr>
                            <tr>
                                <td><label for="edit_grupo">Grupo de recursos</label></td>
                                <td colspan="2">
                                  <select id='edit_grupo' name="edit_grupo">
                                    <option value = "">Seleccione Grupo</option>
                                    <option value = "Zonas Recreativas">Zonas Recreativas</option>
                                    <option value = "Zonas Comerciales">Zonas Comerciales</option>
                                    <option value = "Zonas Deportivas">Zonas Deportivas</option>
                                    <option value = "Zonas Comunales">Zonas Comunales</option>
                                    <option value = "Zonas Sociales">Zonas Sociales</option>
                                    <option value = "Zonas Humedas">Zonas Humedas</option>
                                  </select>    
                                </td>
                            </tr>
                            <tr>
                              <td><label for="edit_dias_reserva">Dias reservables</label></td>
                              <td colspan="2">
                                <span style="display:inline;"><input type="checkbox" id="edit_lunes" name="edit_dias_reserva" value="1">Lunes</span>
                                <span style="display:inline;"><input type="checkbox" id="edit_martes" name="edit_dias_reserva" value="2">Martes</span>
                                <span style="display:inline;"><input type="checkbox" id="edit_miercoles" name="edit_dias_reserva" value="3">Miercoles</span>
                                <span style="display:inline;"><input type="checkbox" id="edit_jueves" name="edit_dias_reserva" value="4">Jueves</span>
                                <span style="display:inline;"><input type="checkbox" id="edit_viernes" name="edit_dias_reserva" value="5">Viernes</span>
                                <span style="display:inline;"><input type="checkbox" id="edit_sabado" name="edit_dias_reserva" value="6">Sabado</span>
                                <span style="display:inline;"><input type="checkbox" id="edit_domingo" name="edit_dias_reserva" value="0">Domingo</span>
                              </td>
                            </tr>
                            <tr>
                                <td>
                                  <label for="edit_costo">Costo de reserva</label>
                                </td>
                                <td colspan="2">
                                  <input type="text" id="edit_costo" name="edit_costo" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div id="alertas"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                  <input type="submit" value="Editar inmueble"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                  </div>
                  <div id="inmuebleBorrar">
                    <form class="clearfix" id="borrarInmuebleForm">
                      <h2>¿Desea borrar las reglas de reserva del inmueble?</h2>
                      <input type="hidden" id="del_mongoid" name="del_mongoid" value="">
                      <input type="submit" value="Eliminar inmueble"/>
                    </form>
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