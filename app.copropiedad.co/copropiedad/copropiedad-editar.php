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
        $('#copropiedad').attr('disabled', 'disabled');
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
            window.location = '../../index.php';            
        }
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            _id:params['idt'],
            tipo:"tarea"
          }
        };

        pintarModulos();
        traerDatosModificables(arr,"copropiedad/getlistFilter",params);
        traerColoresModificables(arr,"copropiedad/getlistFilter",params);
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
      var pagesDos = $("#colores").msDropdown().data("dd");      
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
  $("div.toolbar").html('<a href="#" class="btn" id ="open-creartarea">Nueva copropiedad</a>');
  $( "#open-creartarea" ).click(function() {
        $( "#crearcopropiedad" ).dialog( "open" );
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
                  <!-- <div class="titulo-principal"><h1 class="title tareas">Edi Copropiedades</h1></div> -->
                   
                <form class="clearfix" id="copropiedad_form_editar">

                       <!--  <aside>
                    <div class="doscolumnas primera">
                    </div>
                    <div class="doscolumnas ultima">
                        <input type="submit" class="btn icono guardar" value="Guardar Copropiedad">
                        <a class="btn icono regresar" href="" id="regresacopropiedad">Regresar</a>
                    </div>

                </aside> -->
                <div id="alertas"></div>
                <div class="contenedor">
                  <div class="titulo-principal"><h1 class="title tareas">Copropiedades - Editar copropiedad</h1></div>
                    <div class="clearfix">
                        <table>
                            <tr>
                                <td>
                                  <label for="nombre">Nombre Copropiedad:</label>
                                  <input type="text" id="nombre" name="nombre">
                                </td>
                                <td>
                                  <label for="direccion">Direccion:</label>
                                  <input type="text" id="direccion" name="direccion">
                                </td>
                                <td>
                                  <label for="telefono">Telefono:</label>
                                  <input type="text" id="telefono" name="telefono">
                                </td>
                                <td>
                                  <label for="nit">Nit:</label>
                                  <input type="text" id="nit" name="nit">
                                </td>                                                                                                
                            </tr>
                            <tr>
                                <td colspan = "2">
                                  <label for = "email">Correo Electronico:</label>
                                  <input type = "text" id="email" name="email">
                                </td > 
                                <td colspan = "2">
                                  <label for = "tipocopropiedad">Tipo Copropiedad:</label>
                                  <select id="tipocopropiedad" nombre="tipocopropiedad">
                                    <option value="apartamentos">Apartamentos</option>
                                    <option value="oficinas">Oficinas</option>
                                    <option value="parqueaderos">Parqueaderos</option>
                                    <option value="locales">Locales</option>
                                  </select>
                                </td >                                                                                           
                            </tr>
                            <tr>
                                <td colspan = "4">
                                <label>Seleccione si la copropiedad cuenta con alguno de los siguientes elementos:</label>
                                </td>
                            </tr>
                            <tr>
                              <td >
                                <input type="checkbox" id="porteria" name="porteria" value="true">Porteria:
                              </td>
                              <td >
                                <input type="checkbox" id="ascensor" name="ascensor" value="true">Ascensor: 
                              </td>
                              <td >
                                <input type="checkbox" id="bbq" name="bbq" value="true">Zona BBQ:
                              </td>
                              <td >
                                <input type="checkbox" id="piscina" name="piscina" value="true">Piscina:
                              </td>
                            </tr>                            
                            <tr>
                                <td>
                                  <input type="checkbox" id="gimnasio" name="gimnasio" value="true">Gimnasio:
                                </td>
                                <td>                                  
                                  <input type="checkbox" id="sauna" name="sauna" value="true">Sauna:
                                </td>
                                <td>
                                  <input type="checkbox" id="turco" name="turco" value="true">Turco:
                                </td>
                                <td>
                                  <input type="checkbox" id="jardin" name="jardin" value="true">Jardin:
                                </td>
                            </tr>
                           <!-- <tr>
                              <td colspan="4"><label for="nombre">Seleccione los modulos activos para esta copropiedad:</label></td>
                            </tr>
                            <tr>                              
                              <td>                                
                                 <table id="tableModules">
                                    <thead></thead>
                                    <tbody></tbody>                                    
                                </table>
                              </td>
                            </tr> -->
                            <tr>
                              <td colspan=""><label for="color">Color:</label>
                                <select id="colores">
                                  <option value="1" data-image="../images/msdropdown/color1.png" data-description="Uno"></option>
                                  <option value="2" data-image="../images/msdropdown/color2.png" data-description="Dos"></option>
                                  <option value="3" data-image="../images/msdropdown/color3.png" data-description="Tres"></option>
                                  <option value="4" data-image="../images/msdropdown/color4.png" data-description="Cuatro"></option>
                                  <option value="5" data-image="../images/msdropdown/color5.png" data-description="Cinco"></option>
                                  <option value="6" data-image="../images/msdropdown/color6.png" data-description="Seis"></option>
                                  <option value="7" data-image="../images/msdropdown/color7.png" data-description="Siete"></option>
                                  <option value="8" data-image="../images/msdropdown/color8.png" data-description="Ocho"></option>
                                </select>
                                <imput type="hidden" id = "id_crm_persona"></imput>
                                <imput type="hidden" id = "fecha_creacion"></imput>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="">
                                <input type="submit" class="btn icono guardar" value="Guardar Copropiedad">
                                <a class="btn icono regresar" href="copropiedad.php" id="regresacopropiedad">Regresar</a> 
                              </td>
                            </tr>                                                                                 
                        </table>
                        
                    </div>
                </div>
                            
                  </form>

                </div>
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
