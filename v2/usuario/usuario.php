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
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../../index.php';
        }
        var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
        traerDatos(arr,"usuario/copropiedad", parseInt(sessionStorage.getItem('id_crm')));        
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
<script>
  $(function() {
  $( "#tabs" ).tabs();});
</script>
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
  $("div.toolbar").html('<a href="#" class="btn" id ="open-crearinmueble">Nuevo Contacto</a>');
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
                  <div class="titulo-principal"><h1 class="title libreta-contactos">Directorio</h1></div>
                    <table id="example" class="stripe" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Empresa</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="crearinmueble" class="modal" title="Crear nuevo Contacto">
                  <div class="titulo-principal"><h1 class="title tareas">Contacto - Nuevo Contacto</h1></div>
                  <div id="tabs" class="">
                    <ul>
                      <li><a href="#tabs-1">Crear Contacto Residente</a></li>
                      <li><a href="#tabs-2">Crear Contacto Proveedor</a></li>
                    </ul>
                    <div id="tabs-1">
                      <script type="text/javascript">
                        $(document).ready(function(){
                          var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                          if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
                          {                      
                              $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                                  window.location = '../index.html';
                          }
                          var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
                          traerUnidades(arr,"unidad/nousuario", parseInt(sessionStorage.getItem('cp')));
                          });
                      </script>
                      <form class="clearfix" id="usuario_form">
                        <div class="contenedor">
                          <div class="clearfix">
                            <table>
                              <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre" name="nombre">
                                  </td>
                                  <td>
                                    <label for="apellido">Apellido:</label>
                                    <input type="text" id="apellido" name="apellido">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono" name="telefono">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="email" name="email">
                                  </td >                                                                                                                                                                  
                              </tr>
                              <tr>
                                <td>
                                    <label for = "empresa">Empresa:</label>
                                    <input type = "text" id="empresa" name="empresa">
                                </td>
                                <td>
                                    <label for="unidad">Inmueble</label>
                                    <select name="unidad" id="unidad">
                                      <option value="">-seleccione-</option>
                                      <option value="0">-Ninguno-</option>
                                    </select>                                  
                                </td>  
                              </tr>
                              <tr>
                                  <td colspan = "4">
                                  <label>Seleccione si el usuario cuenta con las siguentes opciones:</label>
                                  </td>
                              </tr>
                              <tr>
                                  <td >
                                    Tiene Niños: <input type="checkbox" id="tiene_ninios" name="tiene_ninios" value="true">
                                  </td>
                                  <td >
                                    Tiene Empleada: <input type="checkbox" id="tiene_empleada" name="tiene_empleada" value="true">
                                  </td>
                                  <td >
                                    Tiene Mascota: <input type="checkbox" id="tiene_mascota" name="tiene_mascota" value="true">
                                  </td>
                                  <td >
                                    Tiene Bicicleta: <input type="checkbox" id="tiene_bicicleta" name="tiene_bicicleta" value="true">
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                    Tiene Vehiculo: <input type="checkbox" id="tiene_vehiculo" name="tiene_vehiculo" value="true">
                                  </td>                                      
                              </tr>
                              <tr>
                                  <td colspan ="2">
                                    <label>Seleccione un grupo de usuarios:</label>
                                    <select name="grupo" id="grupo">                                    
                                        <option value="residente">Residente</option>
                                        <option value="asamblea">Asamblea</option>
                                        <option value="consejo">Consejo</option>
                                        <!-- <option value="proveedores">Proveedores</option> -->
                                    </select>
                                  </td>
                                  <td colspan="2">
                                    <label for="descripcion">Descripción:</label>                                
                                    <input type="text" name="descripcion" id="descripcion">
                                  </td>
                              </tr>
                              <tr>                                      
                                  <td>
                                    <label for="enombre">Contacto emergencia nombre:</label>
                                    <input type="text" name="enombre" id="enombre">
                                  </td>
                                  <td>
                                    <label for="etelefono">Telefono de Emergencia:</label>
                                    <input type="text" name="etelefono" id="etelefono">
                                  </td>
                                  <td>
                                    <label for="ecorreo">Correo de Emergencia:</label>
                                    <input type="text" name="ecorreo" id="ecorreo">
                                    <input type="hidden" name="tipo" id="tipo" value="residente">
                                  </td>
                              </tr>
                              <tr>
                                  <td colspan = "4" >
                                    <input type="submit" class="btn icono guardar" value="Guardar Contacto">
                                  </td>                                      
                              </tr>
                            </table>
                          </div>
                        </div>
                      </form>
                      <div data-alerts="alerts" id ="alertas"></div>
                    </div>
                    <div id="tabs-2">                                         
                      <form class="clearfix" id="proveedor_form">
                        <div class="contenedor">
                          <div class="clearfix">
                            <table>
                              <tr>
                                  <td>
                                    <label for="nombre">Empresa:</label>
                                    <input type="text" id="nombreProveedor" name="nombreProveedor">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefonoProveedor" name="telefonoProveedor">
                                  </td>                                  
                                  <td>
                                    <label for="telefonoDosProveedor">Telefono 2:</label>
                                    <input type="text" id="telefonoDosProveedor" name="telefonoDosProveedor">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="emailProveedor" name="emailProveedor">
                                  </td >                                                                                                 
                              </tr>
                              <tr>
                                  <td colspan="4">
                                    <label>Contactos de la empresa</label>
                                  </td>
                              </tr>
                               <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre1" name="nombre1">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono1" name="telefono1">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono Dos:</label>
                                    <input type="text" id="telefono21" name="telefono21">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="mail1" name="mail1">
                                  </td>                                  
                              </tr>
                              <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre2" name="nombre2">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono2" name="telefono2">
                                  </td>                                   
                                  <td>
                                    <label for="telefono">Telefono Dos:</label>
                                    <input type="text" id="telefono22" name="telefono22">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="mail2" name="mail2">
                                  </td>                                                                                                
                              </tr>
                              <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre3" name="nombre3">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono3" name="telefono3">
                                  </td>                                  
                                  <td>
                                    <label for="telefono">Telefono Dos:</label>
                                    <input type="text" id="telefono23" name="telefono23">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="mail3" name="mail3">
                                  </td>                                                                                                 
                              </tr>
                              <tr>                                  
                                  <td colspan="4">
                                    <label for="descripcion">Notas:</label>                                
                                    <input type="text" name="descripcion" id="descripcionProveedor">
                                    <input type="hidden" name="tipo" id="tipoProveedor" value="proveedor">
                                  </td>
                              </tr>                              
                              <tr>
                                  <td colspan = "4" >
                                    <input type="submit" class="btn icono guardar" value="Guardar Proveedor">
                                  </td>                                      
                              </tr>
                            </table>
                          </div>
                        </div>
                      </form>
                      <div data-alerts="alerts" id ="alertas"></div>
                    </div>
                  </div>
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