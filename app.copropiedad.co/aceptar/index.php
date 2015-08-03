<?php //error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<link rel="stylesheet" type="text/css" href="../template/css/copropiedad.min.css">
<link rel="stylesheet" href="../template/css/jquery-ui.min.css">
<title>Registro de usuario - Copropiedad</title>
<script type="text/javascript" src="../template/js/jquery.min.js"></script>
<script type="text/javascript" src="../template/js/jquery-ui.min.js"></script>
<script src="../template/js/copropiedad-functions.js"></script>
<script src="sjs/registrese-functions.js"></script>
<script src="sjs/registrese.js"></script>
<!-- TRACKING -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64401921-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- FIN TRACKING -->
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
            <div class="titulo-principal">
              <h1>Registro de usuario</h1>
            </div>
            <div class="login">
              <div id="alertas"></div>
              <div id="formcont">
                <form id="registro_form" method="POST" action="validate.php">                    
                  <p><label for="nombre">Nombre:</label>
					         <input type="text" id="nombre" name="nombre" required></p>
                  <p><label for="apellido">Apellido:</label>
					         <input type="text" id="apellido" name="apellido" required></p>
                  <p><label for="email">Dirección de correo electrónico:</label>
					         <input type="email" id="email" name="email" required></p>
                  <p><label for="telefono">Teléfono para contacto:</label>
					         <input type="tel" id="telefono" name="telefono" required></p>
                  <p><label for="captcha">Letras generadas aleatoriamente:</label>
					         <h1 id="captchatext" style="font-size:35px; text-align:center;"></h1>
					         <input  type="text" id="captcha" name="captcha" placeholder="Ingrese las cinco letras que ve arriba" required/></p>
                  <div class="login-botones">
                  	<p style="text-align: center; margin-bottom: 15px;"><input type="checkbox" id="verificar" name="verificar" required/> Si acepto las <a id="condiciones">condiciones de uso, políticas de privacidad.</a></p>
                    <p><input type="submit" class="btn big" value="Enviar Registro" id="enviarregistro"/></p>
                    <p style="text-align: center; margin-top: 15px;" class="olvido">¿Ya tiene una cuenta registrada? , <a id="ingreseaqui" href="https://app.copropiedad.co"> ingrese aquí.</a></p>
                  </div>
                </form>
              </div>              
            </div>
            <div id="gracias" style="padding: 0px 15px; text-align: right;"></div>
        </div>
      </section>
  </div>
  <div id="condmodal" style="display:none">
	<iframe width="100%" height="400px" src="terminos-condiciones.html"></iframe>
  </div>
</body>
</html>