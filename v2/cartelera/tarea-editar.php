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
        const rutaAplicatico = "http://aws02.sinfo.co/api/"; 
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
            window.location = '../index.html';                      
        }
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt'],tipo:"tarea"}};
        traerDatosModificables(arr,"tareas/getlistFilter",params);
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
                <form class="clearfix" id="tarea_form_editar">
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
                            <label class="check"><input type="checkbox" id="recordatorio_mail" name="recordatorio_mail" >Por email</label>
                            <label class="check"><input type="checkbox" id="recordatorio_cp" name="recordatorio_cp">Con notificación en Copropiedad</label>
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
                              <input type="hidden" id = "id_copropiedad" value="">
                              <input type="hidden" id = "creador" value="">
                              <input type="hidden" id = "fecha_creacion" value="">
                              <input type="hidden" id = "tipo" value="">
                              <input type="submit" class="btn icono guardar" value="Editar tarea"/>
                              <a class="btn icono regresar" href="index.php">Regresar</a>
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

<!--<div id="tabs">
                      <ul>
                        <li><a href="#tabs-1">Tab1</a></li>
                        <li><a href="#tabs-2">Tab2</a></li>
                        <li><a href="#tabs-3">Tab3</a></li>
                        <li><a href="#tabs-4">Tab4</a></li>
                      </ul>
                      <div id="tabs-1">
                        Contenido 1
                      </div>
                      <div id="tabs-2">
                        Contenido 2
                      </div>
                      <div id="tabs-3">
                        Contenido 3
                      </div>
                      <div id="tabs-4">
                        Contenido 4
                      </div>
                  </div>-->
        
<!--<select data-placeholder="- Seleccione Ortodoncista -" class="chosen-select" style="width:250px;" tabindex="1">
                                        <option value=""></option>
                                        <option value="">DR. MARIN TORRES DIEGO</option>
                                        <option value="">DRA. LEON ESPINEL MATILDE</option>
                                        <option value="">DRA. VEGA MENDOZA LITSY</option>
                                        <option value="">DR. PRIETO IZQUIERDO CARLOS</option>
                                        <option value="">DR. SOTO ANGEL JUAN CARLOS</option>
                                        <option value="">DR. URIBE JARAMILLO ALBERTO</option>
                                        <option value="">DR. IBAÑEZ ALMEYDA TULIO</option>
                                        <option value="">DRA. PARADA PARADA SARA</option>
                                    </select>-->
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
