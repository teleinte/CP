<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>

<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
    <!-- Jquery UI y tabs y modals -->
    <script src="js/copropiedad-reservas-modals.js"></script>
    <!-- Fullcalendar -->
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='js/fullcalendar/moment.min.js'></script>
    <script src='js/fullcalendar/fullcalendar.min.js'></script>
    <script src='js/fullcalendar/es.js'></script>
<!-- The BackEnd -->
    <script src="js/copropiedad-reservas-functions.js"></script>
    <script src="js/copropiedad-reservas-enviodatos.js"></script>
    <script src="js/copropiedad-reservas-enviarcorreo.js"></script>
    <script src="js/copropiedad-reservas-validate.js"></script>
    <script src="../js/chosen.jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),}};
        TraerUsuarioCopropiedad(arr,"usuario/copropiedad", sessionStorage.getItem('cp'));
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
                	<div class="titulo-principal"><h1 class="title calendario">Reservas</h1></div>
                  <div style="padding: 10px 0; margin:-15px 0 10px;">
                    <div class="aplicaciones" id="aplicaciones">
                      <div class="app"><div id="square"><div class="absoluto"><a href="../reservas/calendario.php" id="calendario-reservas"><img src="../images/calendario.png"><h6>Calendario de reservas</h6></a></div></div></div>
                      <div class="app"><div id="square"><div class="absoluto"><a href="../reservas/inmueble.php" id="config-inmuebles"><img src="../images/configuracion.png"><h6>Configuración de inmuebles</h6></a></div></div></div>
                      <div class="app"><div id="square"><div class="absoluto"><a href="../reservas/reservas.php" id="admin-reservas"><img src="../images/configuracion.png"><h6>Administrador de reservas</h6></a></div></div></div>
                      <div class="app"><div id="square"><div class="absoluto"><a href="../reservas/reporte.php" id="reservas-reporte"><img src="../images/configuracion.png"><h6>Reportes de reservas</h6></a></div></div></div>
                    </div>
                  </div>
        </section>
        <div id="alertas-absolutas">
            <!-- <div class="alert alert-warning">
                <h4>Mantenimiento</h4>
                <p>El día 8 de Diciembre, a partir de las 12:00am, estaremos realizando un<br />mantenimiento al aplicativo por lo que puede presentar algunas fallas.</p>
            </div> -->
      	</div>
    </div>
</body>
</html>