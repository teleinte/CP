<?php //error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>

<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
    <!-- Jquery UI y tabs y modals -->
    <script src="js/copropiedad-calendar-modals.js"></script>
	<!-- Fullcalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
	<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='js/fullcalendar/moment.min.js'></script>
	<script src='js/fullcalendar/fullcalendar.min.js'></script>
	<script src='js/fullcalendar/es.js'></script>
	<script src='js/copropiedad-calendar.js'></script>
<!-- The BackEnd -->
	<script src="js/copropiedad-calendar-enviodatos.js"></script>
</head>

<body>
	<?php include("../template/header.inc") ?>
    <div id="contenido-principal">
        <section id="central">
        		<?php include("../template/aside.inc") ?>
                <div class="contenedor">
                	<div class="titulo-principal"><h1 class="title calendario">Calendario</h1><a href="tareas.html" class="btn" style="position: absolute; right:0;">Ver en lista</a></div>
                    <div id="calEventDialog">
                    	<iframe src="crear-evento-o-tarea.php" width="600" height="540"></iframe>
                    </div>
                    <div id="calendar"></div>
                    <div id="eventContent" title="Detalles de Evento" style="display: none;">
                        <p id="eventInfo"></p>
                        <strong>Inicio:</strong> <span id="startTime"></span><br>
                        <strong>Finalización:</strong> <span id="endTime"></span><br>
                        <strong>Responsable:</strong> <p id="eventDesc"></p>
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