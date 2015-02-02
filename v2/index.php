
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>APP.Copropiedad.co</title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/chosen.css">
<link rel="stylesheet" href="css/estilos-copropiedad.css" type="text/css" media="all">
<link rel="stylesheet" href="css/tablet.css" type="text/css"  media="all and (min-width: 640px) and (max-width: 979px)">
<link rel="stylesheet" href="css/mobile.css" type="text/css" media="all and (min-width: 100px) and (max-width: 639px)">

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

    <?php include("template/js.inc") ?>
    <script src="js/jquery.validate.js" type="text/javascript"></script>
    <script src="js/copropiedad-functions-login.js"></script>
    <script src="js/copropiedad-enviodatos-login.js"></script>
    <script src="js/copropiedad-validate-login.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
    $(function() {
      $( "#tabs" ).tabs();
      });   
  </script>

</head>
<script type="text/javascript">
$(document).ready(function() {  
  localStorage.clear();
  sessionStorage.clear();
})
</script>
<body class="home">

  <header>
        <div class="contenedor">
            <div class="logo">
               <a href="index.php">
                  <h1>Copropiedad</h1>
               </a>
            </div>
            <div class="menus">
               <nav id="topmenu">
                <ul>
                  
                </ul>
               </nav>
               <nav id="mainmenu">
                <ul id="principal">
                  <li><a target="_blank" href="http://www.copropiedad.co/">Inicio</a></li>
                    <li><a target="_blank" href="http://www.copropiedad.co/categoria/actualidad/">Actualidad</a></li>
                    <li><a target="_blank" href="http://www.copropiedad.co/contacto/">Contacto</a></li>
                </ul>
               </nav>
            </div>
            

        </div>
  </header>
    <div id="contenido-principal">
        <section id="central">
                <div class="contenedor">
                    <div class="title-login">
                      <h1>Bienvenido a</h1>
                    </div>
                    <div class="login">
                      <form id="index_form" method="POST">
                        <h2>Ingreso</h2>
                          <p><label for="usr">Usuario:</label><input type="text" id="usr" name="usr"></p>
                          <p><label for="pas">Contraseña:</label><input type="password" id="pas" name="pas"></p>
                        <div class="login-botones">
                            <p><input type="submit" id="btn_enviar" value="Ingresar" class="btn gray"></p>
                            <p><a class="btn gray" href="registrese/cambiar-password.php" style="margin:5px auto; width:170px;">¿Olvidó su contraseña?</a></p>
                            <p><a class="btn gray" href="registrese/" style="margin:5px auto; width:100px;">Regístrese aquí</a></p>
                        </div>
                        <div id="alertas"></div>
                      </form>
                    </div>
                </div>
                
        </section>
    </div>

</body>
  <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
        var config = {
          '.chosen-select'           : {},
          '.chosen-select-deselect'  : {allow_single_deselect:true},
          '.chosen-select-no-single' : {disable_search_threshold:10},
          '.chosen-select-no-results': {no_results_text:'No se encuentra'},
          '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
      </script>
</html>
