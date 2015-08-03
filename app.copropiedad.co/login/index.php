<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<script>
  var thisURL = "https://appdes.copropiedad.co";
  var _url = thisURL;
  var _url2 = thisURL + "/";
  var _log = thisURL + "/login";
  var _log2 = thisURL + "/login/";
  var _reg = thisURL + "/registrese";
  var _reg2 = thisURL + "/registrese/";
  var _out = "https://appdes.copropiedad.co/login/index.php?logout=1";
  var _outt = "https://appdes.copropiedad.co/login/index.php?logout=2";
  
  if((window.location.href == _url) || (window.location.href == _log) || (window.location.href == _reg) || (window.location.href == _url2) || (window.location.href == _reg2) || (window.location.href == _log2) || (window.location.href == _out) || (window.location.href == _outt))
  {
    if(sessionStorage.getItem('token') != null || sessionStorage.getItem('token') != undefined)
    {
        window.location = thisURL + "/inicio";
    }
  }
</script>
<html dir="ltr" lang="es-ES">
<link rel="stylesheet" type="text/css" href="../template/css/copropiedad.min.css">
<title>Ingreso - Copropiedad</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="../template/js/modernizr.min.js"></script>
<script src="../template/js/copropiedad-functions.js"></script>
<script src="sjs/login-functions.js"></script>
<script src="sjs/login.js"></script>
<!-- TRACKING -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-64401921-1', 'auto');
  ga('send', 'pageview');

  /*if (Modernizr.localstorage && Modernizr.sessionstorage && Modernizr.formvalidation) {
    console.log('test');
  } else {
    alert('no-test');
  }

  console.log(Modernizr);*/
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
              <h1>Inicio de sesión - Desarrollo</h1>
            </div>
              <div class="login">
              <div id="alertas"></div>
              <form id="login">                        
                  <p><label for="email">Correo Electrónico:</label><input type="email" id="usr" required></p>
                  <p><label for="password">Contraseña:</label><input type="password" id="pas" required></p>
                <div class="login-botones" style="text-align: right;">
                  <p><input type="submit" class="btn big" value="Iniciar Sesión"/></p>
                  <p><br/><a href="../registrese/cambiar-password.php">¿Olvidó su contraseña?</a></p><br/>
                  <p><a href="../registrese">Registrar usuario nuevo</a></p>
                </div>
              </form>
            </div>
            <div id="gracias" class="login-botones" style="padding:0px 15px; text-align:center;"></div>
        </div>
      </section>
  </div>
</body>
</html>
