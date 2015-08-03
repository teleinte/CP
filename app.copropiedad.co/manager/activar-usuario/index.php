<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<?php 
  if((isset($_POST['user']) && isset($_POST['pass'])))
  {
    if($_POST['user']== "copropiedad" && $_POST['pass']== "t3l31nt3")
      {$login = true;$fail=false;$success = "init";}
    else
      {$login = false;$fail=true;$success = "init";}
  }
  else
  {
    if(isset($_POST['user'])&& isset($_POST['pass']))
      $fail = true;
    else
      $fail = false;

    $login = false;
  }

  if((isset($_POST['email']) && isset($_POST['token'])))
  {
    $data = array("token" => $_POST['token'], "body" => array("email" => $_POST['email']));                                                                    
    $data_string = json_encode($data);                                                                                   
    if(($_POST['tipo'])=="activo"){
      $ch = curl_init('http://auth.teleinte.com/auth/deactivate/');                                                                      
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json',                                                                                
          'Content-Length: ' . strlen($data_string))                                                                       
      );                                                                                                                   
       
      $result = json_decode(curl_exec($ch),true);

      if($result['status'])
      {
        $success = "ok";
        $login = true;
        $fail = false;
      }
      else
      {
        $success = "no";
        $login = true;
        $fail = false;
      }

    } 
    else{
      $ch = curl_init('http://auth.teleinte.com/auth/activate/');                                                                      
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json',                                                                                
          'Content-Length: ' . strlen($data_string))                                                                       
      );                                                                                                                   
       
      $result = json_decode(curl_exec($ch),true);

      if($result['status'])
      {
        $success = "ok";
        $login = true;
        $fail = false;
      }
      else
      {
        $success = "no";
        $login = true;
        $fail = false;
      }
    }
  }
?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../../template/head.inc") ?>
<link rel="stylesheet" href="../../css/jquery-ui.css" />
  <link rel="stylesheet" href="../../css/chosen.css">
  <link rel="stylesheet" href="../../css/estilos-copropiedad.css" type="text/css" media="all">
  <link rel="stylesheet" href="../../css/tablet.css" type="text/css"  media="all and (min-width: 640px) and (max-width: 1199px)">
  <link rel="stylesheet" href="../../css/mobile.css" type="text/css" media="all and (min-width: 100px) and (max-width: 639px)">

  <link rel="alternate stylesheet" title="Aguamarina" href="../../css/color1.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Verde" href="../../css/color2.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Azul" href="../../css/color3.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Morado" href="../../css/color4.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Amarillo" href="../../css/color5.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Rojo" href="../../css/color6.css" type="text/css" media="all">

  <!-- For third-generation iPad with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../images/apple-touch-icon-144x144-precomposed.png">
  <!-- For iPhone with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../images/apple-touch-icon-114x114-precomposed.png">
  <!-- For first- and second-generation iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../images/apple-touch-icon-72x72-precomposed.png">
  <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
  <link rel="apple-touch-icon-precomposed" href="../../images/apple-touch-icon-precomposed.png">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="../../js/jquery.validate.js"></script>
  <!-- Template Engine -->
  <!--<script src="http://twitter.github.com/hogan.js/builds/3.0.1/hogan-3.0.1.js"></script>
  <script src="js/copropiedad-template-engine.js"></script>-->
  <!--<script type="text/javascript" src="copropiedad-template-engine.js"></script>-->
  <!-- Variables de Sesion -->
  <!--<script src="../js/copropiedad-set_variables.js"></script>-->
  <!-- jquery alertas acción de cerrar y con html -->
  <script src="../../js/alertas.js"></script>
  <!-- además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
  <script src="../../js/jquery.bsAlerts.js"></script>
  <!-- Script selector de copropiedad -->
  <script src="../../js/jquery-dd.js"></script>
  <script src="../../js/copropiedad-hoy.js"></script>
  <script src="../../js/jquery.min.js"></script>

<!-- Selector para cambiar las hojas de estilo -->
</head>
<body>
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
                    <li class="usuario" id="nusuario">Bienvenido: Copropiedad</li>                    
                    <li><a href="index.php">Salida</a></li>
                  </ul>
                 </nav>
              </div>
          </div>
    </header>
    <div id="contenido-principal">
        <section id="central">
            <div class="contenedor">
            <div class="title-login">
              <h1>Activación / Desactivación de usuarios en copropiedad</h1>
            </div>
            <?php if($login) { ?>
            <div id="listaUsuarios" class="login" style="width:450px;">
              <div id="alertas">
                <?php if($success == "ok" && $success != "init") { echo ('<div class="alert alert-success">Usuario activado con éxito.</div>'); } elseif($success == "no" && $success != "init") { echo ('<div class="alert alert-error"><strong>Error:</strong>No se ha podido activar el usuario.</div>'); }?>
              </div>
              <div id="btn_listausers"><p>Obtener lista de usuarios</p></div>
              <label for="usuarioin">Usuarios inactivos:</label><div id="usuarioin" style="margin-top:10px;"></div>
              <label for="usuario">Usuarios activos:</label><div id="usuario" style="margin-top:10px;">  
              </div>
            </div>
            <?php } else { ?>
            <div class="login">
              <form id="index_form" method="POST">
                <h2>Ingreso</h2>
                  <p><label for="usr">Usuario:</label><input type="text" id="user" name="user"></p>
                  <p><label for="pas">Contraseña:</label><input type="password" id="pass" name="pass"></p>
                <div class="login-botones">
                    <p><input type="submit" id="btn_enviar" value="Ingresar" class="btn gray"></p>
                </div>
                <div id="alertas">
                  <?php if($fail) { echo ('<div class="alert alert-error"><strong>Error:</strong>Usuario o clave invalidos.</div>'); }?>
                </div>
              </form>
            </div>
            <?php } ?>
            </div>
        </section>
    </div>
  </body>
</html>