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
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
            window.location = '../index.html';                      
        }
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
        traerCabecerasModificables(arr,"encuestas/encuesta/copropiedad/filtro",params);
        var arr = {token:sessionStorage.getItem('token'),body:{id_encuesta:params['idt']}};
        traerPreguntas(arr,"encuestas/encuesta/pregunta/listar",params);        
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
    <?php include("templates/mcopropiedad.php"); //include("templates/menu.php");?> 
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

<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/functions.js"></script>
<script src="js/validate.js"></script>

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
                  <div class="titulo-principal"><h1 class="title encuestas">Modificar Encuesta</h1></div>
                    <div class="clearfix">
                      <form id="form-encuesta-editar">
                          <table id="form-encuesta-pr">
                            <tr>
                              <td colspan="2" width="50%"><label for="nombre">Nombre de la Encuesta:</label>
                              <input type="text" id="nombre" name="nombre"/></td>
                              <td colspan="2"><label for="datepicker">Fecha Finalización:</label>
                              <input type="text" id="datepicker" name="datepicker"/></td>
                            </tr>
<!--                            <tr>
                              <td>
                                <label for="invitados">Invitados Copropiedad:</label>
                                <select id="invitados" name ="invitados">
                                  <option value="Asamblea">Asamblea</option>
                                  <option value="Consejo">Consejo</option>
                                  <option value="Residentes">Residentes</option>
                                  <option value="Copropietarios">Copropietarios</option>
                                </select>
                              </td>
                              <td colspan="2">
                                <label value="odestinatario">Otros Destinatarios: (correos electronicos separadospor coma)</label>
                                <input type="text" id="odestinatario" name="odestinatario"/>
                              </td>
                            </tr>
                            <tr>-->
                              <td>
                                <label for="descripcion">Encabezado de la encuesta</label>
                                <textarea rows="3" id="descripcion" name="descripcion">Ingrese la descripción que se le va a desplegar a los usuarios que van a llenar la encuesta</textarea>
                              </td>
                            </tr>
                          </table>                          
                          <div class="botones-form">
                            <input type="submit" class="btn icono guardar" value="Guardar Encuesta"/>
                            <a class="btn icono regresar" href="index.php">Regresar</a>
                            <input type="hidden" id="id_copropiedad" value=""/>
                            <input type="hidden" id="id_crm_persona" value=""/>
                            <input type="hidden" id="fecha_creacion" value=""/>
                            <input type="hidden" id="estado" value=""/>
                          </div>
                        </form> 
                        <div data-alerts="alerts" id ="alertas"></div>                       
                    </div>
                </div>

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
                            var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})                            
                            $("div.toolbar").html('<a href="nueva-pregunta.php?idt='+params['idt']+'" class="btn">Nueva Pregunta</a>');
                          } );
                        </script>

                        <div class="contenedor">
                        <div class="titulo-principal"><h1 class="title encuestas">Preguntas de la encuesta</h1></div>
                          <table id="example" class="stripe" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th>Pregunta</th>
                                      <th>Tipo Pregunta</th>
                                      <th>Opciones de respuesta</th>
                                      <th>Pregunta obligatoria?</th>
                                      <th>Acciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>                                      
                      </div>
        </section>
        <div data-alerts="alerts" id ="alertas"></div>
    </div>
</body>


  
<script>
    $(document).ready(function() {
        var iCnt = 0;
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
        var container = $(document.createElement('div')).css({
            padding: '0', margin: '0 0 20px 0', width: '100%', border: 'none'
        });
        $('#btAdd').click(function() {
            if (iCnt <= 19) {
                iCnt = iCnt + 1;
                // ADD TEXTBOX.
                $(container).append('<div id="pregunta' + iCnt + '" class="clearfix" style="padding: 20px 10px 0; border:1px solid #eee; margin-bottom:10px;"><table><tr><td><label for="enunciado-pregunta' + iCnt + '">Enunciado</label></td><td><input type=text class="input" id="enunciado-pregunta' + iCnt + '" name ="enunciado-pregunta' + iCnt + '"/></td><td><label for="tipo-pregunta' + iCnt + '">Tipo de pregunta</label></td><td><select id="tipo-pregunta' + iCnt + '" name="tipo-pregunta' + iCnt + '"><option value="seleccion_multiple_unica_respuesta">Selección múltiple con única respuesta</option><option value="seleccion_multiple_multiple_respuesta">Selección múltiple con múltiple respuesta</option><option value="abierta">Abierta</option></select></td></tr><tr><td  width="50%" colspan="2"><label for="opciones-pregunta' + iCnt + '">Si la pregunta es de tipo selección, por favor escriba cada opción en una línea</label></td><td class="opciones" colspan="2"><textarea id="opciones-pregunta' + iCnt + '" name="opciones-pregunta' + iCnt + '" rows="4"></textarea></td></tr></table></div>');
                $('#form-encuesta-pr').after(container);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                $(container).append('<label class="limite-preg">Alcanzó el máximo de preguntas</label>'); 
                $('#btAdd').attr('class', 'btn icono agregar disabled'); 
                $('#btAdd').attr('disabled', 'disabled');
            }
        });
        $('#btRemove').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt != 0) { $('#pregunta' + iCnt).remove(); iCnt = iCnt - 1; $('.limite-preg').remove();}
            if (iCnt == 0) { 
        $(container).empty(); 
                $(container).remove();
            }
      if (iCnt <= 20) {
                $('#btAdd').removeAttr('disabled');
        $('#btAdd').attr('class', 'btn icono agregar');
            }
        });
    });

</script>     
</html>
