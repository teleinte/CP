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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="../js/jquery.validate.js"></script>
  <!-- Template Engine -->
  <!--<script src="http://twitter.github.com/hogan.js/builds/3.0.1/hogan-3.0.1.js"></script>
  <script src="js/copropiedad-template-engine.js"></script>-->
  <!--<script type="text/javascript" src="copropiedad-template-engine.js"></script>-->
  <!-- Variables de Sesion -->
  <!--<script src="../js/copropiedad-set_variables.js"></script>-->
  <!-- jquery alertas acción de cerrar y con html -->
  <script src="../js/alertas.js"></script>
  <!-- además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
  <script src="../js/jquery.bsAlerts.js"></script>
  <!-- Script selector de copropiedad -->
  <script src="../js/jquery-dd.js"></script>

    <script src="/js/copropiedad-functions-login.js"></script>
    <script src="/js/copropiedad-enviodatos-login.js"></script>
    <script src="/js/copropiedad-validate-login.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script>
    $(function() {
      $( "#tabs" ).tabs();
      });   
  </script>

</head>
<script type="text/javascript">
$(document).ready(function(){  
  if(sessionStorage.getItem("token") === null || sessionStorage.getItem("cp") === null)
  {
    sessionStorage.clear();
  }
  else
  {
    var logout = getUrlParameter('logout');
    if(logout == "1")
    {
      sessionStorage.clear();
      $('#alertas').html('<div class="alert alert-success" style="height:10px;">Sesión cerrada satisfactoriamente.</div>');
    }
    else if(logout == "2")
    {
      sessionStorage.clear();
      $('#alertas').html('<div class="alert alert-success" style="height:10px;">Token caducado. Es necesario iniciar sesión de nuevo.</div>'); 
    }
    else
    {
      var rutaAplicativo = "https://app.copropiedad.co/api/hoy/verificar/";  
      var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
      $.post(rutaAplicativo, JSON.stringify(arr))
      .done(function(msg){
          var msgDividido = JSON.stringify(msg);
          var mensaje =  JSON.parse(msgDividido);
          var msgDivididoDos = JSON.stringify(mensaje.message);
          var datos3 = JSON.parse(msgDivididoDos);    

          if (datos3=="Token invalido")
            window.location = '../index.php?logout=2';
          else
            window.location.replace('https://app.copropiedad.co/dashboard/');
        });
    }  
  }
});

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}          
</script>
<body class="home">
  <header>
    <div class="contenedor">
      <div class="logo">
         <a href="./">
            <h1>Copropiedad</h1>
         </a>
      </div>
      <div class="menus">
         <nav id="mainmenu">
          <!--ul id="principal">
			<li><a .target="_blank" href="registrese/">Registro</a></li>
			<li><a .target="_blank" href="registrese/cambiar-password.php">Olvidó contraseña?</a></li>
          </ul-->
         </nav>
      </div>
    </div>
  </header>
    <div id="contenido-principal">
        <section id="central">
                <div class="contenedor">
                    <!--div class="title-login">
                      <h1>Ingreso</h1>
                    </div-->
                    <div class="login">
                    <div id="alertas"></div>
                      <form id="index_form" method="POST">
                          <p><label for="usr">Usuario:</label><input type="text" id="usr" name="usr" placeholder="Ingrese su email registrado"></p>
                          <p><label for="pas">Contraseña:</label><input type="password" id="pas" name="pas" placeholder="Ingrese su contraseña de acceso"></p>
                        <div class="login-botones">
                            <p><input type="submit" id="btn_enviar" value="Ingresar" class="btn big"></p>
                            <p class="olvido"><a href="registrese/cambiar-password.php">¿Olvidó su contraseña?</a></p>
                            <p><a href="registrese/">¿Es un nuevo usuario? Regístrese aquí</a></p>
                        </div>
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
