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
        		<div id="vencidas">
              <div class="titulo-principal"><h1>Aviso de pago</h1>
                <div id="message_cp" style="margin:15px 5px;"></div>
              	<table id="tVencidas" class="stripe" cellspacing="0" width="100%" border="1">
                  <tr>
                    <td>
                      <h4><strong>COPROPIEDAD</strong></h4>
                    </td>
                    <td>
                      <h4><strong>FECHA FIN VIGENCIA</h4></strong>
                    </td>
                  </tr>
              	</table>
                <div id="advice_cp"></div>                 
              </div>
            </div>
            <div id="ingreso">
              <div class="titulo-principal"><h1 id="titulo-perfil">Elija el perfil de ingreso</h1>
              <div id="tIngreso" style="margin:15px 5px;"></div>
            </div>
                <div data-alerts="alerts" id ="alertas"></div>
        	</div>
        </section>
    </div>
</body>
</html>
