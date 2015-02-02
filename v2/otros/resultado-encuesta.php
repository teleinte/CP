<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Copropiedad</title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/chosen.css">
<link rel="stylesheet" href="css/estilos-copropiedad.css" type="text/css" media="all">
<link rel="stylesheet" href="css/tablet.css" type="text/css"  media="all and (min-width: 640px) and (max-width: 1199px)">
<link rel="stylesheet" href="css/mobile.css" type="text/css" media="all and (min-width: 100px) and (max-width: 639px)">

<link rel="alternate stylesheet" title="Aguamarina" href="css/color1.css" type="text/css" media="all">
<link rel="alternate stylesheet" title="Verde" href="css/color2.css" type="text/css" media="all">
<link rel="alternate stylesheet" title="Azul" href="css/color3.css" type="text/css" media="all">
<link rel="alternate stylesheet" title="Morado" href="css/color4.css" type="text/css" media="all">
<link rel="alternate stylesheet" title="Amarillo" href="css/color5.css" type="text/css" media="all">
<link rel="alternate stylesheet" title="Rojo" href="css/color6.css" type="text/css" media="all">

<!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->

<!-- For third-generation iPad with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144x144-precomposed.png">
<!-- For iPhone with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114x114-precomposed.png">
<!-- For first- and second-generation iPad: -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72x72-precomposed.png">
<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-precomposed.png">
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->

    <script src="js/jquery.min.js"></script>
    
    <!-- Panel de Historial -->
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
    
    <!-- jquery alertas acción de cerrar y con html -->
<script src="js/alertas.js"></script>
<!-- además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="js/jquery.bsAlerts.js"></script>
    
    <!-- Jquery UI y Tabs -->
    <script src="js/jquery-ui.js"></script>
    <script>
		$(function() {
			$( "#tabs" ).tabs();
		  });
		$(function() {
			$( "#datepicker1" ).datepicker();
			$( "#datepicker2" ).datepicker();
		  });
		$(function() {  
		  	$( ".modal" ).dialog({
				autoOpen: false,
				modal: true
				})
			$( "#borrartarea" ).dialog({
				buttons: {
					"No, cancelar": function() {
					  $( this ).dialog( "close" );
					},
					"Si, borrarla": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
			$( "#open-borrartarea" ).click(function() {
			  $( "#borrartarea" ).dialog( "open" );
			});
			$( "#detallestarea" ).dialog({
				width: 420, //Cambiar ancho del modal. Por defecto es 300
				buttons: {
					"Completar Tarea": function() {
					  $( this ).dialog( "close" );
					},
					"Editar Tarea": function() {
					  $( this ).dialog( "close" );
					}
				  },
				open:function () {// Agregarle al primer botón la clase icono completar
						$(this).closest(".ui-dialog")
						.find(".ui-button:first") 
						.addClass("icono completar");
					}
				});
			$( "#open-detallestarea" ).click(function() {
			  $( "#detallestarea" ).dialog( "open" );
			});
			$( "#creartarea" ).dialog({
				width: 500, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form
				buttons: [ { text: "Crear Tarea", click: function() { $( this ).trigger("add-alerts", [
				  {
					message: "Elemento creado satisfactoriamente",
					priority: "success"
				  } ]); } } ,
				  { text: "Cerrar", click: function() { $( this ).dialog( "close" ); } } 
				  ]
				});
			$( "#open-creartarea" ).click(function() {
			  $( "#creartarea" ).dialog( "open" );
			});
		});
	</script>
    
    <!-- Script selector de copropiedad -->
    <script src="js/jquery-dd.js"></script>
	<script>

	$(document).ready(function(e) {		
		//no use
		try {
			var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {
				var val = data.value;
				if(val!="")
					window.open(val,'_parent');
				}}}).data("dd");
	
		} catch(e) {
			//console.log(e);	
		}
		
		$("#ver").html(msBeautify.version.msDropdown);
			
		//convert
		//$("select").msDropdown({roundedBorder:false});
		//createByJson();
		
	});
	
	</script>
   
<!-- Selector para cambiar las hojas de estilo -->
<script src="js/stylesheet-switcher.js"></script>


<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="css/dataTables.colVis.css">
<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="js/dataTables.responsive.js"></script>
<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
	$('#res-encuesta').DataTable( {
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
		"dom": 'lfrtp',
		"language": {
            "sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar enunciado:",
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
	$('#abierta-encuesta').DataTable( {
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
		"dom": 'lfrtp',
		"language": {
            "sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar respuesta:",
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

<!-- Gráficos: http://canvasxpress.org/pie.html, http://canvasxpress.org/bar.html y http://canvasxpress.org/stacked.html -->
<link rel="stylesheet" href="css/canvasXpress.css" type="text/css"/>
<script type="text/javascript" src="js/canvasXpress.min.js"></script>
    <script>
      $(document).ready(function() {

        var cx1 = new CanvasXpress('canvas1',
          {
            'y' : {
              'vars' : ['A', 'B', 'C', 'D'],
              'smps' : ['Pregunta1', 'Pregunta2', 'Pregunta3', 'Pregunta4'],
              'data' : [[18, 8, 5, 10], [2, 12, 9, 0], [0, 0, 7, 0], [0, 0, 3, 0]]
            },
          },
          {'graphOrientation': 'horizontal',
          'graphType': 'Stacked',
		  'background': '#f9f9f9',
          'legendBackgroundColor': false,
          'sampleSeparationFactor': 1,
          'smpLabelScaleFontFactor': 0.8,
          'smpTitle': 'Preguntas Encuesta',
          'smpTitleFontStyle': 'italic',
          'title': 'Estadísticas',
          'titleHeight': 60,
		  'colors': ['#27AE60', '#F0830B', '#2980B9', '#C0392B', '#16A085', '#8E44AD', '#F51E7C'],
		  'disableMenu': true,
		  'disableToolbar': true}
        );

        var cx2 = new CanvasXpress('canvas2',
          {
            'y' : {
              'vars' : ['Si', 'No'],
              'smps' : ['Pregunta1'],
              'data' : [[18], [2]]
            }
          },
          {'graphType': 'Pie',
          'pieSegmentLabels': 'outside',
          'pieSegmentPrecision': 1,
          'pieSegmentSeparation': 2,
          'pieType': 'solid',
		  'background': '#f9f9f9',
          'legendBox': false,
		  'colors': ['#27AE60', '#F0830B', '#2980B9', '#C0392B', '#16A085', '#8E44AD', '#F51E7C'],
		  'disableMenu': true,
		  'disableToolbar': true
		  //canvasBoxColor: '#fff'
		  }
        );
		
		var cx3 = new CanvasXpress('canvas3',
          {
            'y' : {
              'vars' : ['Si', 'No'],
              'smps' : ['Pregunta2'],
              'data' : [[8], [12]]
            }
          },
          {'graphType': 'Pie',
          'pieSegmentLabels': 'outside',
          'pieSegmentPrecision': 1,
          'pieSegmentSeparation': 2,
          'pieType': 'solid',
		  'background': '#f9f9f9',
          'legendBox': false,
		  'colors': ['#27AE60', '#F0830B', '#2980B9', '#C0392B', '#16A085', '#8E44AD', '#F51E7C'],
		  'disableMenu': true,
		  'disableToolbar': true}
        );
		
		var cx4 = new CanvasXpress('canvas4',
          {
            'y' : {
              'vars' : ['Corrediza', 'Enrrollable', 'Abatible', 'Plegable'],
              'smps' : ['Pregunta3'],
              'data' : [[5], [9], [7], [3]]
            }
          },
          {'axisTickScaleFontFactor': 1.5,
          'axisTitleScaleFontFactor': 1.5,
          'fontStyle': 'bold italic',
          'graphOrientation': 'vertical',
          'graphType': 'Bar',
		  'background': '#f9f9f9',
          'legendBox': false,
          'legendScaleFontFactor': 1.2,
          'plotByVariable': true,
          'showSampleNames': false,//Este es para quitar la leyenda 'Pregunta3' de la parte inferior
		  //'smpLabelFontStyle': 'italic',
		  //'smpLabelInterval': 2,
		  //'smpLabelRotate': 45,
		  //'smpLabelScaleFontFactor': 0.8,
          'xAxis2Show': false,
		  'colors': ['#27AE60', '#F0830B', '#2980B9', '#C0392B', '#16A085', '#8E44AD', '#F51E7C'],
		  'disableMenu': true,
		  'disableToolbar': true}
        );
		

      });

    </script>
    <script>
		$(document).ready(function(){
            $('#encuesta1-pregunta1').click(function() {
                $("#total-resultado").hide();
				$("#primer-resultado").show();
				$("#segundo-resultado").hide();
				$("#tercer-resultado").hide();
				$("#cuarto-resultado").hide();
            });
			$('#encuesta1-pregunta2').click(function() {
                $("#total-resultado").hide();
				$("#primer-resultado").hide();
				$("#segundo-resultado").show();
				$("#tercer-resultado").hide();
				$("#cuarto-resultado").hide();
            });
			$('#encuesta1-pregunta3').click(function() {
                $("#total-resultado").hide();
				$("#primer-resultado").hide();
				$("#segundo-resultado").hide();
				$("#tercer-resultado").show();
				$("#cuarto-resultado").hide();
            });
			$('#encuesta1-pregunta4').click(function() {
                $("#total-resultado").hide();
				$("#primer-resultado").hide();
				$("#segundo-resultado").hide();
				$("#tercer-resultado").hide();
				$("#cuarto-resultado").show();
            });
			$('#regresar-total').click(function() {
                $("#total-resultado").show();
				$("#primer-resultado").hide();
				$("#segundo-resultado").hide();
				$("#tercer-resultado").hide();
				$("#cuarto-resultado").hide();
            });
    });
	</script>

</head>

<body>
	<header>
        <div class="contenedor">
            <div class="logo">
               <a href="index.html">
                  <h1>Copropiedad</h1>
               </a>
            </div>
            <div class="menus">
               <nav id="topmenu">
                <ul>
                	<li class="usuario">Perfil de Jairo Pedraza</li>
                	<li class="libreta"><a href="#">Directorio</a></li>
                    <li><a href="#">Salida Segura</a></li>
					<li><a href="#">Ayuda</a></li>
                </ul>
               </nav>
            </div>
            

        </div>
	</header>
    <div id="contenido-principal">
        <section id="central">
        		<aside>
                	<div class="trescolumnas primera">
                    	<div class="panel" id="new-panel">
                            <p><a href="#" id="open-borrartarea">Copropietario</p>
                            <p><a href="#" id="open-detallestarea">Residente</a></p>
                            <p><a href="#">Proveedor</a></p>
                            <p><a href="#" id="open-creartarea">Tarea</a></p>
                            <p><a href="nueva-encuesta.html">Votación/Encuesta</a></p>
                            <p><a href="#">Evento</a></p>
                            <p><a href="#">Unidad</a></p>
                        </div>
                        <div id="borrartarea" class="modal" title="Borrar tarea">
                          <p>¿Realmente desea borrar la tarea <a href="#">Revisar Tejado</a>?</p>
                        </div>
                        <div id="detallestarea" class="modal" title="Detalles de tarea">
                          <div class="seccion">
                          	<h4>Información general</h4>
                            <p><strong>Nombre de la tarea:</strong> Podado de Jardín</p>
                            <p><strong>Prioridad:</strong> Baja</p>
                            <p><strong>Fecha límite:</strong> 01/12/2014</p>
                            <p><strong>Frecuencia de la tarea:</strong> Ninguna</p>
                            <p><strong>Recordatorio para el día:</strong> 30/11/2014</p>
                            <p><strong>Recordatorio vía:</strong> email</p>
                            <p><strong>Notas:</strong> Nuevas notas</p>
                          </div>
                          <div class="seccion">
                          	<h4>Participantes</h4>
                            <p><strong>Responsable:</strong> Germán Velásquez</p>
                            <p><strong>Tarea compartida con:</strong> email@email.com, email@email.com, email@email.com, email@email.com, email@email.com, email@email.com</p>
                          </div>
                        </div>
                        <div id="creartarea" class="modal" title="Crear nueva tarea">
                          <form class="clearfix">
                          	<table>
                                <tr>
                                    <td>
                                    	<label>Nombre de la tarea</label>
                                    </td>
                                    <td colspan="2">
                                    	<input type="text" data-validation="required" />
                                    </td>
                               	</tr>
                                <tr>
                                	<td><label>Responsable</label>
                                    	<select><option>Senen Lara</option></select></td>
                                   	<td><label>Prioridad</label>
                                    	<select><option>Baja</option></select></td>
                                   	<td><label>Fecha límite</label>
                                    	<input type="text" id="datepicker1" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-error-msg="La fecha debe estar en formato dd/mm/yyyy" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                    	<label>Compartir esta tarea (escribe los correos electrónicos de los destinatarios separados por comas)</label>
                                        <input type="text" value="email@email.com,email@email.com,email@email.com"/>
                                    </td>
                               	</tr>
                                <tr>
                                    <td rowspan="2">
                                    	<label>Frecuencia de la tarea</label>
                                    	<select><option>Ninguna</option>
                                        <option>Semanal</option>
                                        <option>Quincenal</option>
                                        <option>Mensual</option>
                                        <option>Anual</option></select>
                                    </td>
                                    <td colspan="2">
                                    	<label>Recordarme la tarea el día</label>
                                    	<input type="text" id="datepicker2" />
                                    </td>
                               	</tr>
                                <tr>
                                	<td colspan="2">
                                        <label class="check"><input type="checkbox" name="CheckboxGroup1" id="CheckboxGroup1_0">Por email</label>
                                        <label class="check"><input type="checkbox" name="CheckboxGroup1" id="CheckboxGroup1_1">Con notificación en Copropiedad</label>
                                	</td>
                               	</tr>
                                <tr>
                                    <td colspan="3">
                                    	<label>Notas</label>
                                    	<textarea>Ingresa Alguna Notas</textarea>
                                    </td>
                               	</tr>
                          	</table>
                          </form>
                          <div data-alerts="alerts"></div>
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn" id="nuevos" href="#" title="nuevos">Nuevo...</a>
                        <div class="panel" id="app-panel">
                            <div class="aplicaciones">
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/configuracion.png" />
                                            <h6>Configuración</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/contabilidad.png" />
                                            <h6>Contabilidad</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/cartelera.png" />
                                            <h6>Cartelera</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="residentes.html"><img src="images/residentes.png" />
                                            <h6>Residentes</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/proveedores.png" />
                                            <h6>Proveedores</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/buzon.png" />
                                            <h6>Buzón de Quejas</h6></a>
                                        </div>
                                    </div>
                                    <div class="notificacion">
                                        <a href="#"><span>1</span></a>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/reservas.png" />
                                            <h6>Reservas</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/foros.png" />
                                            <h6>Foros</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/documentos.png" />
                                            <h6>Documentos</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="calendario.html"><img src="images/calendario.png" />
                                            <h6>Calendario</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/alertas.png" />
                                            <h6>Alertas</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/presupuesto.png" />
                                            <h6>Presupuesto</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/estado-cuenta.png" />
                                            <h6>Estado de Cuenta</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="encuestas.html"><img src="images/encuestas.png" />
                                            <h6>Encuestas</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/consejo.png" />
                                            <h6>Consejo</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/asamblea.png" />
                                            <h6>Asamblea</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/micrositio.png" />
                                            <h6>Micrositio</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="tareas.html"><img src="images/tareas.png" />
                                            <h6>Tareas</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/solicitudes.png" />
                                            <h6>Solicitudes</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/compraventa.png" />
                                            <h6>Compraventa</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/encomiendas.png" />
                                            <h6>Encomiendas</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="app">
                                    <div id="square">
                                        <div class="absoluto">
                                            <a href="#"><img src="images/parqueaderos.png" />
                                            <h6>Parqueaderos</h6></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn" id="aplicaciones" href="#" title="aplicaciones"><img src="images/aplicaciones.png" alt="aplicaciones"/></a>
                    </div>
                    <div class="trescolumnas centro">
                        <div class="panel" id="pending-panel">
                            <ul>
                            	<li>
                                	<div class="floatleft">Revisar Tejado</div>
                                    <div class="floatright">Vence Hoy</div>
                                </li>
                                <li>
                                	<div class="title">Vencidas</div>
                                	<div class="floatleft">Llamar a Bancolombia</div>
                                    <div class="floatright">20/11/2014</div>
                                </li>
                                <li>
                                	<div class="title">Solicitudes</div>
                                	<div class="floatleft">Mantenimiento del ascensor</div>
                                    <div class="floatright">01/12/2014</div>
                                </li>
                            </ul>
                        </div>
                        <div style="clear:both;"></div>
                        <a class="trigger btn white" id="pendientes" href="#" title="pendientes"><span class="noti-pendientes">2</span>Para hacer hoy...</a>
                    </div>
                    <div class="trescolumnas ultima">
                    	<span class="titulo-cop">Mis Copropiedades:</span>
                    	<div class="selector-copropiedad">
                            <select style="width:100%"  name="copropiedad" id="copropiedad" >
                              <option value="#" data-image="images/msdropdown/color1.png" data-description="Calle 152 No. 13-64" selected="selected">EDIFICIO ALMAR</option>
                              <option value="#" data-image="images/msdropdown/color2.png" data-description="Calle 25 No. 32A-90">PARQUE TAKAY</option>
                              <option value="#" data-image="images/msdropdown/color3.png" data-description="Carrera 69D No. 25-50">PORTAL DEL SALITRE</option>
                              <option value="#" data-image="images/msdropdown/color4.png" data-description="Carrera 10 No. 96-29">EDIFICIO CENTRO EJECUTIVO</option>
                              <option value="#" data-image="images/msdropdown/color5.png" data-description="Carrera 31A No. 25-54">CENTRO GRANCOLOMBIANO DE VIVIENDA</option>
                              <option value="#" data-image="images/msdropdown/color6.png" data-description="Calle 152 No. 13-98">EDIFICIO MARQUÉS II</option>
                           </select>
                        </div>
                    </div>
                </aside>
                <div class="contenedor">
                	<div class="titulo-principal"><h1 class="title encuestas">Resultados de la Encuesta - Nueva Puerta</h1></div>
                    <h4>Pulse en el nombre de cada enunciado para ver las respuestas de sus encuestados a cada pregunta.</h4>
                    <div id="contenedor-resultados">
                        <div class="tabla-preguntas">
                            <table id="res-encuesta" class="stripe" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Enunciado</th>
                                        <th>Respuestas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>1</td>
                                        <td><a href="#" id="encuesta1-pregunta1">¿Está usted haciendo uso del parqueadero en este momento?</a></td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>2</td>
                                        <td><a href="#" id="encuesta1-pregunta2">¿Piensa que es necesario cambiar la puerta de la entrada del parqueadero?</a></td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>3</td>
                                        <td><a href="#" id="encuesta1-pregunta3">¿Qué tipo de puerta debería comprarse para le entrada del parqueadero? (Para seleccionar varias opciones pulse la tecla 'Ctrl')</a></td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>4</td>
                                        <td><a href="#" id="encuesta1-pregunta4">Si tiene alguna observación o sugerencia respecto a este tema por favor escríbala en el siguiente campo</a></td>
                                        <td>10</td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            <a href="#" class="btn" id="regresar-total">Regresar a Estadísticas de encuesta</a>
                        </div>
                        <div class="resultados-graph">
    
                            <div id="total-resultado"><canvas id='canvas1' width='640' height='450'></canvas></div>
                            <div id="primer-resultado" style="display: none;"><canvas id='canvas2' width='640' height='450'></canvas></div>
                            <div id="segundo-resultado" style="display: none;"><canvas id='canvas3' width='640' height='450'></canvas></div>
                            <div id="tercer-resultado" style="display: none;"><canvas id='canvas4' width='640' height='450'></canvas></div>
                            <div id="cuarto-resultado" style="display: none;">
                                <table id="abierta-encuesta" class="stripe" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>Respuesta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>1</td>
                                            <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2</td>
                                            <td>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>3</td>
                                            <td>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>4</td>
                                            <td>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>5</td>
                                            <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>6</td>
                                            <td>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>7</td>
                                            <td>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>8</td>
                                            <td>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>9</td>
                                            <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>10</td>
                                            <td>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis.</td>
                                        </tr>
                                    </tbody>
                                </table>
                           	</div>
                        </div>
                  	</div>
               	</div>
        </section>
        <div id="alertas-absolutas">
            <div class="alert alert-dismissable alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Información:</strong> Este es un mensaje de información en html, con botón para ocultarlo.
            </div>
            <div class="alert alert-error">
                <h4>¡Aún no registramos tu pago!</h4>
                <p>Recuerda ponerte al día para seguir disfrutando de tu servicio<br />antes del 10/12/2014. Ir a <a href="#">Pagar mi Servicio</a></p>
            </div>
      	</div>
    </div>

</body>

<!-- Scripts para validar. Tomado de http://formvalidator.net/ -->
	<script src="js/form-validator/jquery.form-validator.min.js"></script>
    <script>
	$.validate();
    </script><!-- Valida todos los formularios de la página -->
   <!-- //Para validar sólo los formularios con id #registration y #login en la página
    $.validate({
      form : '#registration, #login'
    });
    -->

</html>
