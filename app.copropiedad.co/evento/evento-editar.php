<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
<?php include("../template/js.inc");?>
<!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->


<!-- For third-generation iPad with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/apple-touch-icon-144x144-precomposed.png">
<!-- For iPhone with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114-precomposed.png">
<!-- For first- and second-generation iPad: -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72-precomposed.png">
<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->
<script src="js/copropiedad-enviodatos.js"></script>
<script src="js/copropiedad-calendar-enviarcorreo.js"></script>
<script src="../js/jquery.min.js"></script>
    

<script type="text/javascript">
    $(document).ready(function(){
        $('#copropiedad').attr('disabled', 'disabled');
        const rutaAplicatico = "https://app.copropiedad.co/api/"; 
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
            window.location = '../index.html';                      
        }
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt'],tipo:"evento"}};
        traerEventosModificables(arr,"eventos/geteventoFilter",params);
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#nuevos").click(function(){
       $("#new-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#new-panel').length) {
            if($('#new-panel').is(":visible")) {
                    $('#new-panel').hide();
                    $('#nuevos').toggleClass("active");
                    }
            }        
        });
  });
  $(document).ready(function(){
    $("#aplicaciones").click(function(){
			$("#app-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
		$(document).click(function(event) { 
		if(!$(event.target).closest('#app-panel').length) {
			if($('#app-panel').is(":visible")) {
				$('#app-panel').hide();
				$('#aplicaciones').toggleClass("active");
				}
			}        
		});
  });
  $(document).ready(function(){
   $("#pendientes").click(function(){
            $("#pending-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#pending-panel').length) {
            if($('#pending-panel').is(":visible")) {
                    $('#pending-panel').hide();
                    $('#pendientes').toggleClass("active");
                    }
            }        
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
<!-- jquery alertas acción de cerrar y con html -->
<script src="../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../js/jquery.bsAlerts.js"></script>

<script>    
    $(function() {  
        $( ".modal" ).dialog({
        autoOpen: false,
        modal: true
        })
      $( "#creartarea" ).dialog({
        width: 600, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form        
        });
      $( "#editarcopropiedad" ).dialog({
        width: 750, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form        
        });
    });
  </script>
<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">

<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.colVis.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>

<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/functions.js"></script>
<script src="js/validate.js"></script>


</head>
<body>
  <?php
  include("../template/header.inc")
  ?>
    <div id="contenido-principal">
        <section id="central">
            <aside>
            <?php
            include("templates/aside.php");
            ?>

            </aside>                
                <div class="contenedor">
                  <!-- <div class="titulo-principal"><h1 class="title tareas">Edi Copropiedades</h1></div> -->
                    <form class="clearfix" id="evento_form_editar">
                        <table>
                            <col width="25%"><col width="25%"><col width="25%"><col width="25%">
                            <tr>
                                <td colspan="2">
                                  <label for="nombree">Nombre del evento</label>
                                </td>
                                <td colspan="2">
                                  <input type="text" id="nombree" name="nombree" />
                                  <input type="hidden" id="fecha_creacione" name="fecha_creacione"/>  
                                </td>
                            </tr>
                            <tr>
                              <td colspan="2">
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
                                    <option value = "22:30">22:30</option>
                                </select>
                              </td>
                              <td colspan="2">
                                <label for="enddatee">Fecha Fin</label>
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
                                <td colspan="2">
                                  <label for="compartir_maile">Compartir este evento (escribe los correos electrónicos de los destinatarios separados por comas)</label>
                                  <input type="text" id="compartir_maile" name="compartir_maile">
                                </td>
                                <td colspan="2">
                                    <label for="invitados">Invitados Copropiedad:</label>
                                    <select id="invitados" name ="invitados">
                                      <option value="asamblea">Asamblea</option>
                                      <option value="consejo">Consejo</option>
                                      <option value="residente">Residentes</option>
                                      <option value="proveedor">Proveedores</option>
                                      <option value="manual">Ingreso manual de destinatarios</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                  <label for="frecuenciae">Frecuencia del evento</label>
                                  <select id="frecuenciae" name="frecuenciae">
                                    <option value = "Ninguna" selected="selected">Ninguna</option>
                                    <option value = "Semanal">Semanal</option>
                                    <option value = "Quincenal">Quincenal</option>
                                    <option value = "Mensual">Mensual</option>
                                    <option value = "Anual">Anual</option>
                                  </select>
                                </td>
                                <td colspan="2">
                                  <label for="frecordatorio">Recordar el evento el día</label>
                                  <input type="text" id="datepicker5" name="frecordatorioe">
                                </td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                  <label class="check"><input type="checkbox" id="ver_copropiedade" name="ver_copropiedade">Hacer este evento publico en la copropiedad</label>
                              </td>
                              <td>
                                <label class="check"><input type="checkbox" id="recordatorio_maile" name="recordatorio_maile">Recordar via email</label>
                              </td>
                              <td>
                                <label class="check"><input type="checkbox" id="recordatorio_cpe" name="recordatorio_cpe" checked>Recordar en Copropiedad</label>
                              </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                  <label>Notas</label>
                                  <textarea id="notase" name="notase"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div id="alertas"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                  <input type="submit" class="btn icono guardar" value="Finalizar edición de evento"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="crearcopropiedad" class="modal" title="Crear nueva copropiedad">
                <div data-alerts="alerts" id ="alertas"></div>
                </div>
        </section>
    </div>
</body>

<!--scripts selector con búsqueda como en http://harvesthq.github.io/chosen/-->
  <script src="../js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'No se encuentra'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
      </script>
    
</html>
