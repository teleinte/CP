<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
<?php include("../template/js.inc");?>

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
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
            window.location = '../index.html';                      
        }
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        traerElectores(arr,"encuestas/encuesta/VotantesTotales/",params['idt']);
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
        traerCabecerasRersultados(arr,"encuestas/encuesta/copropiedad/filtro",params);
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        traerPreguntasResultado(arr,"encuestas/encuesta/resultadosTotales",params['idt']);
        
        
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        traerElectantes(arr,"mailer/mail/encuestas/contarInvitados/",params['idt']);
        
        
        //if (!sessionStorage.getItem("idp"))
        //{
            var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
            traerSetPreguntas(arr,"encuestas/encuesta/pregunta/listarIdEncuestas/",params);
        //}
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


<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">
<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>
 <script>
      $(document).ready(function() {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});          
        url="encuestas/encuesta/resultadosPorPregunta";  
        rutaAplicativo = "http://aws02.sinfo.co/api/";        
        var idps = sessionStorage.getItem("idp"); 
        var aidps = idps.split("|");
        for(valores in aidps)
        {
            var arr = {token:sessionStorage.getItem('token'),body:{id_pregunta:aidps[valores]}};            
            $.ajax(
            {
                url: rutaAplicativo+url,
                type: 'POST',
                data: JSON.stringify(arr),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                async: false,
                success: function(msg) 
                {
                    var msgDividido = JSON.stringify(msg);
                    var mensaje =  JSON.parse(msgDividido);
                    var msgDivididoDos = JSON.stringify(mensaje.message);
                    var datos = JSON.parse(msgDivididoDos);                    
                    var contador = 1;
                    $.each(datos, function(x , y) 
                    {
                        if (y['tipo']==="mr")
                        {
                            $('#resultados-graph').append('<div class="sinver" id="'+aidps[valores]+'" style="display:none"> .</div>');
                            $("#"+aidps[valores]).append('<canvas id="canvas'+aidps[valores]+'" width="640" height="450">');                            
                            var parametros = {};
                            var variables = [];
                            var votos = [];
                            
                            $.each(y[0], function(alpha , beta) {
                                var sumador = [];
                                //alert(alpha +" : "+ beta);
                                sumador.push(beta);
                                votos.push(sumador);
                                variables.push(alpha);                                
                            });                            
                            //alert(variables);
                            //alert(votos);                            
                            var jsonVotos = JSON.stringify(votos);
                            //alert(jsonVotos);
                            parametros = {
                            'y' : 
                                {
                                  'vars' : variables,
                                  'smps' : [y['enunciado']],
                                  'data' : JSON.parse(jsonVotos)
                                }
                            };
                            
                            var cx4 = new CanvasXpress
                            (
                                "canvas"+aidps[valores],parametros,
                                  {
                                    'title':y['enunciado'],
                                    "titleHeight": 60,
                                    'setMinX':0,
                                    "smpTitleScaleFontFactor": 1,
                                    'axisTickScaleFontFactor': 1.5,
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
                                    'disableToolbar': true
                                }
                            );
                        }
                        
                        if (y['tipo']==="ur")
                        {   
                            $('#resultados-graph').append('<div class="sinver" id="'+aidps[valores]+'" style="display:none"></div>');
                            $("#"+aidps[valores]).append('<canvas id="canvas'+aidps[valores]+'" width="640" height="450">');
                            var parametros = {};
                            var variables = [];
                            var votos = [];
                            $.each(y[0], function(alpha , beta) {
                                var sumador = [];                                
                                sumador.push(beta);
                                votos.push(sumador);
                                variables.push(alpha);                                
                            });                            
                            var jsonVotos = JSON.stringify(votos);
                            parametros = {
                            'y' : 
                                {
                                  'vars' : variables,
                                  'smps' : [y['enunciado']],
                                  'data' : JSON.parse(jsonVotos)
                                }
                            };
                            var cx3 = new CanvasXpress(
                            "canvas"+aidps[valores],parametros,
                              {
                                'graphType': 'Pie',
                                'title':y['enunciado'],
                                'titleHeight': 60,
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
                            
                        }
                        if (y['tipo']==="A")
                        {
                            $('#resultados-graph').append('<div class="sinver" id="'+aidps[valores]+'" style="display:none"></div>');
                            $("#"+aidps[valores]).append('<table id="'+contador+aidps[valores]+'" class="stripe" cellspacing="0" width="100%"><thead><tr><th></th><th>#</th><th>Respuesta</th></tr></thead>');                            
                            $("#"+contador+aidps[valores]).DataTable( {
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
                            var res = y['opiniones'].split("|");                            
                            var i=0;
                            var t = $("#"+contador+aidps[valores]).DataTable();
                            while(i<res.length)
                            {                                
                                t.row.add( [
                                '',
                                i,                            
                                res[i]
                                ] ).draw();
                                i++;
                            }                            
                        contador++;
                        }
                    });                
                }
            });
        }
});
    </script>
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
} );
</script>

<!-- Gráficos: http://canvasxpress.org/pie.html, http://canvasxpress.org/bar.html y http://canvasxpress.org/stacked.html -->
<link rel="stylesheet" href="../css/canvasXpress.css" type="text/css"/>
<script type="text/javascript" src="../js/canvasXpress.min.js"></script>      
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
                <div class="titulo-principal"><h1 class="title encuestas" id="tituloEncuesta"></h1></div>
                    <h4 id="totalEncuestados"></h4>
                    <h4 id ="totalInvitados"></h4>
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
                                </tbody>
                            </table>
                            <a href="#" class="btn" id="regresar-total">Regresar a Estadísticas de encuesta</a>
                        </div>
                        <div class="resultados-graph" id="resultados-graph">
                            <div id="particular"></div>
                            
                        </div>
                        </div>
                  	</div>
               	</div>
        </section>
<!--        <div id="alertas-absolutas">
            <div class="alert alert-dismissable alert-info"></div>
            <div class="alert alert-error"></div>
      	</div>-->
    </div>

</body>
</html>
