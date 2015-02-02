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
        const rutaAplicatico = "http://aws02.sinfo.co/api/";        
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../index.html';
        }
        var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"tarea"}};
        traerDatos(arr,"encuestas/encuesta/copropiedad/activas", sessionStorage.getItem('cp'));         
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
<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.colVis.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>

<script>   
    $(function() {  
        $( ".modal" ).dialog({
        autoOpen: false,
        modal: true
        })
      
      $( "#enviar-encuesta" ).dialog({
        width: 700, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form
        buttons: [ { text: "Enviar Encuesta", click: function() { $( this ).trigger("add-alerts", [
          {
          message: "Encuesta enviada satisfactoriamente",
          priority: "success"
          } ]); } } ,
          { text: "Cancelar", click: function() { $( this ).dialog( "close" ); } } 
          ]
        });
      $( "#open-enviar-encuesta" ).click(function() {
        $( "#enviar-encuesta" ).dialog( "open" );
      });
    });
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
  $("div.toolbar").html('<a href="nueva-encuesta.php" class="btn">Crear Encuesta</a>');
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
                  <div class="titulo-principal"><h1 class="title encuestas">Mis Encuestas</h1></div>
                    <table id="example" class="stripe" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Fecha Final</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>                                      
                </div>
                <div id="enviar-encuesta" class="modal" title="Envío Encuesta - Nueva Puerta">
                        <form class="clearfix">
                          <table>
                              <tr>
                                  <td>
                                      <label>Asunto</label>
                                  </td>
                                  <td colspan="3">
                                      <input type="text" value="Ingrese asunto" />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      <label>Mensaje del correo</label>
                                  </td>
                                  <td colspan="3">
                                      <textarea rows="5">Buenos días,<br /><br />Estamos realizando una encuesta...</textarea>
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                    <label>Destinatarios</label>
                                  </td>
                                  <td>
                                      <select>
                                          <option>Asamblea</option>
                                          <option>Consejo</option>
                                          <option>Residentes</option>
                                          <option>Copropietarios</option>
                                      </select>
                                  </td>
                                  <td width="20%">
                                    <label>Agregar otros destinatarios</label>
                                  </td>
                                  <td>
                                      <select data-placeholder="- Seleccione Usuarios -" class="chosen-select" style="width:250px;" tabindex="1" multiple>
                                        <option value=""></option>
                                        <optgroup label="Edificio Almar">
                                          <option>Nombre Completo(correo@correo.com)</option>
                                          <option>Nombre Completo(correo@correo.com)</option>
                                          <option>Nombre Completo(correo@correo.com)</option>
                                          <option>Nombre Completo(correo@correo.com)</option>
                                        </optgroup>
                                        <optgroup label="Parque Takay">
                                          <option>Nombre Completo(correo@correo.com)</option>
                                          <option>Nombre Completo(correo@correo.com)</option>
                                          <option>Nombre Completo(correo@correo.com)</option>
                                          <option>Nombre Completo(correo@correo.com)</option>
                                        </optgroup>
                                    </select>
                                  </td>
                              </tr>
                          </table>
                        </form>
                        <div data-alerts="alerts"></div>
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
