<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>

<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
    <!-- Jquery UI y tabs y modals -->
    <script src="js/copropiedad-calendar-copropiedad-modals.js"></script>
    <script>
        $(function() {
          $( "#tabs" ).tabs();
          });
    </script>
    <!-- Fullcalendar -->
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='js/fullcalendar/moment.min.js'></script>
    <script src='js/fullcalendar/fullcalendar.min.js'></script>
    <script src='js/fullcalendar/es.js'></script>
    <script src='js/copropiedad-calendar-copropiedad.js'></script>
<!-- The BackEnd -->
    <script src="js/copropiedad-calendar-copropiedad-functions.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

        var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),}};
        TraerUsuarioCopropiedad(arr,"usuario/copropiedad", sessionStorage.getItem('cp'));

        $('#regresatarea').attr("href", "../tareas/tareas.html")
        $('#nusuario').html("Bienvenido: "+sessionStorage.getItem('nombreCompleto'))

        $("#historial").click(function(){
          $("#hist-panel").toggle("fast");
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
    </script>
    <?php include("../template/menu.inc") ?>
</head>

<body>
	<?php include("../template/header.inc") ?>
    <div id="contenido-principal">
        <section id="central">
        		<?php include("../template/aside.inc") ?>
                <div class="contenedor">
                	<div class="titulo-principal"><h1 class="title calendario">Calendario de eventos de la copropiedad</h1></div>
                    <div id="preloader" style="margin:0 auto; padding:10px 20px; background-color:#fefefe; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; background-color: rgba(0,0,0,0.5);"><img src="../images/loading.gif" alt="Cargando..." style="margin:0 auto;"/></div>
                    <div id="calendar"></div>
                    <div id="eventContent" title="Detalles" style="display: none;">
                      <div id="EventoContent">
                        <div class="seccion">
                          <h4>Información general</h4>
                          <p><strong>Nombre del evento:</strong> <span id="ev_nombre"></span></p>
                          <p><strong>Fecha creación:</strong> <span id="ev_fecha_creacion"></span></p>
                          <p><strong>Fecha inicio:</strong> <span id="ev_fecha_inicio"></span></p>
                          <p><strong>Fecha fin:</strong> <span id="ev_fecha_fin"> </span><br> </p>
                          <p><strong>Notas:</strong> <span id="ev_notas"></span></p>
                        </div>
                      </div>
                    </div>
               	</div>
        </section>
        <div id="alertas-absolutas">
            <div class="alert alert-warning">
                <h4>Mantenimiento</h4>
                <p>El día 8 de Diciembre, a partir de las 12:00am, estaremos realizando un<br />mantenimiento al aplicativo por lo que puede presentar algunas fallas.</p>
            </div>
      	</div>
    </div>
</body>
</html>