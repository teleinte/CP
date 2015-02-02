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
<script src="../js/jquery.min.js"></script>
    

<script type="text/javascript">

    $(document).ready(function(){
        $('#unidadnuevo').attr("href", "inmueble-nuevo.html")
        $('#nusuario').html("Bienvenido: "+sessionStorage.getItem('nombreCompleto'))
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../../index.html';
        }
        var arr = 
        {
            token:sessionStorage.getItem('token'),
            body:
            {
                id_copropiedad:sessionStorage.getItem('cp')//,
                //id_crm_persona:sessionStorage.getItem('id_crm')
            }
        };
        traerDatos(arr,"unidad/copropiedad", parseInt(sessionStorage.getItem('cp')));
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
      $( "#crearinmueble" ).dialog({
        width: 600, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form        
        });
    });
  </script>
 <script>
//   $(function(){

//         $(document).trigger("add-alerts", [
//       {
//       message: "Esta es una alerta. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "warning"
//       },
//       {
//       message: "Esta es una alerta de información. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "info"
//       },
//       {
//       message: "Este es una alerta de error. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "error"
//       },
//       {
//       message: "Esta es una alerta de éxito. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "success"
//       }
//     ]);
//       });
 </script>

<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">

<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.colVis.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>
<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
  $('#example').DataTable( {
    responsive: {
      details: {
                type: 'column'
            }
    },
    columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ],
    "dom": '<"toolbar">lfCrtip',
    "colVis": {
      "buttonText": "Columnas",
      exclude: [ 0, 1 ]
    },
    "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
        }
  } );
  $("div.toolbar").html('<a href="#" class="btn" id ="open-crearinmueble">Nuevo Inmueble</a>');
  $( "#open-crearinmueble" ).click(function() {
        $( "#crearinmueble" ).dialog( "open" );
      });
  } );
</script> 


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
                  <div class="titulo-principal"><h1 class="title tareas">Mis Inmuebles</h1></div>
                    <table id="example" class="stripe" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Copropiedad</th>                            
                                <th>Tipo Inmueble</th>
                                <th>Detalle Inmueble</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="crearinmueble" class="modal" title="Crear nuevo inmueble">
                  
                  <script type="text/javascript">
                    $(document).ready(function(){
                      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;}) 
                      if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
                      {                      
                          $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
                          window.location = '../index.html';            
                      }
                      var arr = { token:sessionStorage.getItem('token'), body: { _id:sessionStorage.getItem('cp'), }};
                      traerDatosCopropiedad(arr,"copropiedad/getlistFilter",params);
                      var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),}};
                      TraerUsuarioCopropiedad(arr,"usuario/copropiedad", parseInt(sessionStorage.getItem('cp')));
                    });
                    
                  </script>


                    <form class="clearfix" id="unidad_form">
                      <div class="contenedor">
                        <div class="titulo-principal"><h1 class="title tareas">Inmuebles - Nuevo Inmueble</h1></div>                  
                          <div class="clearfix">
                              <table>
                                  <tr>
                                      <td colspan="2">
                                        <label for="tipo">Tipo de inmueble:</label>
                                        <select id= "tipo" name="tipo">
                                          <option value='apartamento'>Apartamento</option>
                                          <option value='local'>Local</option>
                                          <option value='bodega'>Bodega</option>
                                          <option value='oficina'>Oficina</option>
                                          <option value='deposito'>Deposito</option>
                                          <option value='saloncomunal'>Salon Comunal</option>
                                          <option value='parqueadero'>Parqueadero</option>
                                        </select>
                                      </td>
                                      <td colspan="2">
                                        <label for="reservable">Es un inmueble reservable?:</label>
                                        <input type="checkbox" id="reservable" name="reservable" value="true"> Si
                                        <!-- <label for="usuario">Usuario de la unidad:</label>
                                        <select id='usuario' name="usuario">
                                          <option value = "">-Seleccione-</option>
                                          <option value = "0">Ninguno</option>
                                          <option value = "14">Jairo Gil Villamarin</option>
                                        </select>-->
                                      </td>  
                                  </tr>
                                  <tr>
                                      <td colspan="2">                                  
                                        <label for="identificador">Identificador Inmueble:</label>
                                        <input type="text" id = "identificador" name="identificador"></input>                                        
                                        <input type="hidden" id = "nombre"></input>
                                        <input type="hidden" id = "id_copropiedad"></input>
                                        <input type="hidden" id = "id_crm_persona"></input>
                                      </td >
                                      <td colspan="2">
                                        <label for="detalle">Detalle del inmueble:</label>
                                        <input type="text" id = "detalle" name="detalle"></input>
                                      </td >                                                              
                                  </tr>
                                  <tr>
                                      <td colspan="4">                                  
                                        <input type="submit" class="btn icono guardar" value="Guardar Inmueble">
                                      </td >                                                              
                                  </tr>                                
                              </table>
                          </div>
                      </div>
                      </form>
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
