<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<link rel="stylesheet" type="text/css" href="../template/css/copropiedad.min.css">
<title>Ingreso - Copropiedad</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="../template/js/copropiedad-functions.js"></script>
<script src="sjs/review.js"></script>
</head>
<body class="home registrar">
<header style="width:500px;">
    <div class="contenedor" >
      <div class="logo">
         <a href="http://www.copropiedad.co">
            <h1>Copropiedad</h1>
         </a>
      </div>
    </div>
  </header>
  <div id="contenido-principal">
      <section id="central" style="width:500px;">
        	<div class="contenedor">                
        		<div  id="vencidas">
                  <div class="titulo-principal"><h1 class="title tareas">Copropiedades Vencidas</h1>
                  	<br><br><br>
                  	<table id="tVencidas" class="stripe" cellspacing="0" width="100%"> 
                  	</table>
                  </div>                    
                </div>
                <div id="ingreso">
                  <div class="titulo-principal"><h1 class="title tareas">Elija el perfil de ingreso</h1>
                  	<br><br><br>
                  	<table id="tIngreso" class="stripe" cellspacing="0" width="100%"> 
                  	</table>
                  </div>                    
                </div>                
                    <form class="clearfix" id="tarea_form">

                    </form>
                <div data-alerts="alerts" id ="alertas"></div>
        	</div>
        </section>
    </div>
</body>
</html>
