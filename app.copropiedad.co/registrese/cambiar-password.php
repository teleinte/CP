<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<!-- The CSS! -->
<?php include("../template/css.inc") ?>
<link rel="stylesheet" type="text/css" href="css/jquery.realperson.css"> 
<!-- The JS! -->
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.validate.js"></script>
<script src="js/copropiedad-registrese-enviocorreo.js"></script>
<script src="js/copropiedad-registrese-enviodatos.js"></script>
<script src="js/copropiedad-registrese-validate.js"></script>
<script>
  CreaToken("Registrese","123465789");
</script>
</head>
<body class="home">
  <header>
    <div class="contenedor">
      <div class="logo">
         <a href="../">
            <h1>Copropiedad</h1>
         </a>
      </div>
      <div class="menus">
         <nav id="mainmenu">
          <!--<ul id="principal">
			<li><a .target="_blank" href="./">Inicio</a></li>
			<li><a .target="_blank" href="../registrese/">Registro</a></li>
          </ul>-->
         </nav>
      </div>
    </div>
  </header>
  <div id="contenido-principal">
      <section id="central">
        <div class="contenedor">
            <div class="titulo-principal">
              <h1>Solicitud de cambio de contraseña</h1>
            </div>
            <div class="login">
            <div id="alertas"></div>
              <form id="cambio_form" method="POST">
                  <p><label for="nombre">Su nombre: *</label><input type="text" id="nombre" name="nombre"></p>
                  <p><label for="email">Email que tiene registrado: *</label><input type="text" id="email" name="email"></p>
                <div class="login-botones">
                  <p><input type="submit" class="btn big" value="Enviar link de cambio de contraseña"/></p><br>
                  <p><a href="https://app.copropiedad.co/index.php">Regresar al ingreso</a></p>
                </div>
              </form>
            </div>
        </div>
      </section>
  </div>
</body>
</html>