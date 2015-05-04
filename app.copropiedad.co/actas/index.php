<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
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
<?php include("../template/js.inc");?>

<script src="js/copropiedad-actas-enviodatos.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="js/imagesloaded.js"></script>


<?php include("templates/mcopropiedad.php"); ?> 
<!-- Script selector de copropiedad -->
<script src="../js/jquery-dd.js"></script>
<script>
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



$(document).ready(function(e) {  

    $( ".modal" ).dialog({
      autoOpen: false,
      modal: true
    });
    
    $( "#crearsubiracta" ).dialog({
      resizable: false,
      autoOpen: false,
      title: 'Subir un acta'
    });

    $( "#open-crearsubiracta" ).click(function() {
          $("#crearsubiracta").dialog( "open" );
    });

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


<script type="text/javascript">

    $(document).ready(function(){
        const rutaAplicatico = "https://app.copropiedad.co/api/";
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../index.html';
        }        
        var arr = { token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),tipo:"acta"}};
        traerDatos(arr,"documentos/getlist", sessionStorage.getItem('cp'));
    });
</script>



<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/copropiedad-actas-functions.js"></script>
<script src="js/copropiedad-actas-validate.js"></script>
<style>
 
  .ajax-file-upload-statusbar {
    border: 1px solid #0ba1b5;
    margin-top: 10px;
    margin-right: 10px;
    margin: 5px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    width: 150px !important;
    padding: 5px 5px 5px 5px
   }
   
  .ajax-file-upload-filename {
    width: 130px !important;
    height: auto;
    margin: 0 5px 5px 10px;
    text-align:justify;
    display:none;
    color: #807579
   }
   
  .ajax-file-upload-progress {
    margin: 0 10px 5px 10px;
    position: relative;
    width: 130px !important;
    border: 1px solid #ddd;
    padding: 1px;
    border-radius: 3px;
    display: inline-block
   }
   
  .ajax-file-upload-bar {
    background-color: #0ba1b5;
    width: 0;
    height: 20px;
    border-radius: 3px;
    color: #fff
   }
   
  .ajax-file-upload-percent {
    position: absolute;
    display: inline-block;
    top: 3px;
    left: 48%
   }
   
  .ajax-file-upload-red {
    -moz-box-shadow: inset 0 39px 0 -24px #e67a73;
    -webkit-box-shadow: inset 0 39px 0 -24px #e67a73;
    box-shadow: inset 0 39px 0 -24px #e67a73;
    background-color: #e4685d;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    display: inline-block;
    color: #fff;
    font-family: arial;
    font-size: 13px;
    font-weight: normal;
    padding: 4px 15px;
    text-decoration: none;
    text-shadow: 0 1px 0 #b23e35;
    cursor: pointer;
    vertical-align: top;
    margin-right: 5px
   }
   
  .ajax-file-upload-green {
    background-color: #77b55a;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    margin: 0;
    padding: 0;
    display: inline-block;
    color: #fff;
    font-family: arial;
    font-size: 13px;
    font-weight: normal;
    padding: 4px 15px;
    text-decoration: none;
    cursor: pointer;
    text-shadow: 0 1px 0 #5b8a3c;
    vertical-align: top;
    margin-right: 5px
   }
   
  .ajax-file-upload {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 16px;
    font-weight: bold;
    padding: 15px 20px;
    cursor: pointer;
    line-height: 20px;
    height: 25px;
    margin: 0 10px 10px 0;
    display: inline-block;
    background: #fff;
    border: 1px solid #e8e8e8;
    color: #888;
    text-decoration: none;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -moz-box-shadow: 0 2px 0 0 #e8e8e8;
    -webkit-box-shadow: 0 2px 0 0 #e8e8e8;
    box-shadow: 0 2px 0 0 #e8e8e8;
    padding: 6px 10px 4px 10px;
    color: #fff;
    background: #2f8ab9;
    border: 0;
    -moz-box-shadow: 0 2px 0 0 #13648d;
    -webkit-box-shadow: 0 2px 0 0 #13648d;
    box-shadow: 0 2px 0 0 #13648d;
    vertical-align: middle
   }
   
    .ajax-file-upload:hover {
      background: #3396c9;
      -moz-box-shadow: 0 2px 0 0 #15719f;
      -webkit-box-shadow: 0 2px 0 0 #15719f;
      box-shadow: 0 2px 0 0 #15719f
     }
   
  .ajax-upload-dragdrop {
    border: 2px dotted #a5a5c7;
    color: #666;
    text-align: middle !important;
    vertical-align: middle;
    width: 130px !important;
    padding: 20px 10px
   }

   .ajax-upload-dragdrop b{
     padding: 10px 0 !important;
    }
   
  .ajax-upload-dragdrop.state-hover {border: 2px solid #a5a5c7}
   
  .ajax-file-upload-error {color: red}
   
</style>
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
                  <div class="titulo-principal"><h1 class="title cartelera">Archivos de Actas</h1></div>
                  <div class="floatleft"></div>
                  <div class="floatright" style="display:inline-block; margin-bottom:5px;">
                      <a href="../gestion-documental/" class="btn" id ="open-creartarea" style="margin-right:5px;">Regresar</a>
                      </div>
                      <input type="button" class="btn" value="Subir un Acta" id="open-crearsubiracta">
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
                        } );
                        </script> 
                        <table id="example" class="stripe" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th>Nombre Documento</th>
                                  <th>Observación</th>
                                  <th>Fecha de carga</th>                                
                                  <th>Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>                      
                </div>
                
                
                <div id="crearsubiracta" class="modal" title="Crear Acta">
                    <form class="clearfix" id="crearacta_form">
                      <table>
                          <tr>
                              <td>
                                <label for="nombrearchivo">Nombre Acta</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="nombrearchivo" name="nombrearchivo" />
                              </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="observacion">Descripción del archivo</label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <textarea id="observacion" name="observacion" style="height:200px; width:250px; resize:none;"></textarea> 
                            </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="fotoventa" style="padding-top:40px;">Adjuntar el Archivo</label>
                              </td>
                              <td colspan="2">
                                <div style="width:150px; height:80px;" id="previewFileDiv"><img id="previewFile"/></div><br/>
                                <div id="fileuploader">Cargar Archivo</div>
                              </td>
                              <input type="hidden" id="filepath" name="filepath" value=""/>
                          </tr>
                          <tr>
                              <td colspan="3">
                                  <div id="alertas"></div>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                <input type="submit" id="btn_enviar" class="btn icono guardar" value="Crear Publicación"/>                                
                              </td>
                          </tr>
                      </table>
                    </form>
                    <div data-alerts="alerts" id ="alertas"></div>
                
                </div>
              </div>
        </section>
    </div>
</body>
</html>
