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
    <!-- Fullcalendar -->
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='js/fullcalendar/moment.min.js'></script>
    <script src='js/fullcalendar/fullcalendar.min.js'></script>
    <script src='js/fullcalendar/es.js'></script>
    <script src='js/copropiedad-reservas.js'></script>
<!-- The BackEnd -->
    <script src="js/copropiedad-reservas-functions.js"></script>
    <script src="js/copropiedad-reservas-enviodatos.js"></script>
    <script src="js/copropiedad-reservas-enviarcorreo.js"></script>
    <script src="js/copropiedad-reservas-validate.js"></script>
    <script src="../js/chosen.jquery.min.js"></script>
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
                	<div class="titulo-principal"><h1 class="title calendario">Reservas</h1></div>
                  <div style="padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatleft" style="display:inline;"><span style="display:inline;">Fecha   </span><input type="text" id="fecha-reserva" name="fecha-reserva" value=""/>   <span style="display:inline;"></span><select id="ddrecursos" style="display:inline;" style="width:350px;"><option value="" disabled selected>Selecciona el recurso</option></select>   <input type="submit" class="btn" value="Ver disponibilidad" id="btndisponibilidad"/></div>
                    <div class="floatright"  style="padding-top:5px;"><a class="btn" href="reservas.php">Administrador de reservas</a></div>
                    <div style="clear: both;"></div>
                  </div>
                  <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatleft" style="display:inline;"><input type="submit" class="btn" value="<< Semana Anterior" id="btndisponibilidadanterior"/>  <input type="submit" class="btn" value="Semana Siguiente >>" id="btndisponibilidadsiguiente"/></div>
                    <div class="floatright"  style="padding-top:5px;"></div>
                  </div>
                  <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatleft" style="display:inline;" id="leyendarecursos"></div>
                  </div>
                  <div id="calendar-visibility">
                  <div id="reserva-title"></div>
                    <div id="preloader" style="margin:0 auto; padding:10px 20px; background-color:#fefefe; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; background-color: rgba(0,0,0,0.5);"><img src="../images/loading.gif" alt="Cargando..." style="margin:0 auto;"/></div>
                    <div id="calEventDialog">
                    	<form class="clearfix" id="reserva_form">
                          <table>
                              <input type="hidden" id="crea_id_copropiedad" name="id_copropiedad" value=""/>
                              <input type="hidden" id="crea_id_inmueble" name="id_inmueble" value=""/>
                              <input type="hidden" id="crea_grupo" name="grupo" value=""/>
                              <input type="hidden" id="crea_fecha_inicio" name="fecha_inicio" value=""/>
                              <input type="hidden" id="crea_fecha_fin" name="fecha_fin" value=""/>
                              <input type="hidden" id="crea_usuario" name="usuario" value=""/>
                              <input type="hidden" id="crea_estado" name="estado" value="creada"/>
                              <tr>
                                <td>
                                  <div id="reservaStatus"></div>
                                  <p id="reservaData"></p>
                                  <div id="reservaComment"></div>
                                </td>
                              </tr>
                              <tr>
                                  <td colspan="3">
                                    <div id="alertas"></div>
                                    <div id="reservaConfirmar"></div>
                                  </td>
                              </tr>
                          </table>
                        </form>
                    </div>
                    <div id="calendar1"></div>
                    <div id="eventContent" title="Detalles" style="display: none;">
                      <div id="TareaContent">
                        <div class="seccion">
                          <h4>Información de la reserva</h4>
                          <p><strong>Fecha Inicio:</strong> <span id="startTime"></span></p>
                          <p><strong>Fecha Fin:</strong> <span id="endTime"> </span><br> </p>
                        </div>
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