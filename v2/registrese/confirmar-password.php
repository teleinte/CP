<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<?php
date_default_timezone_set('America/Bogota');
$tokenR = htmlspecialchars_decode($_GET['token']);
$temp = base64_decode($_GET['code']);
$arr = explode("^",$temp);
$nombre = htmlspecialchars_decode($arr[0], ENT_HTML5);
$email = htmlspecialchars_decode($arr[1]);
$tkest = ValidateToken($tokenR);

function ValidateToken($token)
{
  	$date=date('YmdHis');            
    $objs = array('date'=>$date,'type'=>'Message','sender'=>"remote sender", 'message'=>'Validacion de token', 'request'=>'SetToken'.$token, 'response'=>'null');
  	$result = Decrypt($token);
  	$part = explode("|",$result);
  	$dateToken = end($part);
  	$dateNow = date('YmdHis');
  	if (is_numeric($dateToken) and $dateToken > $dateNow){return true;}else{return false;}
}

function Decrypt($data){$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5('J4!r06¡l'), base64_decode($data), MCRYPT_MODE_CBC, md5(md5('J4!r06¡l'))), "\0");return $output;}
?>
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
<script src="js/jquery.plugin.min.js"></script> 
<script src="js/jquery.realperson.min.js"></script>
<script src="js/copropiedad-registrese-enviocorreo.js"></script>
<script src="js/copropiedad-registrese-enviodatos.js"></script>
<script src="js/copropiedad-registrese-validate.js"></script>
</head>
<body class="home">
  <header>
    <div class="contenedor">
      <div class="logo">
         <a href="index.php">
            <h1>Copropiedad</h1>
         </a>
      </div>
      <div class="menus">
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
              <h1>Cambio de contraseña</h1>
            </div>
            <?php if($tkest) { ?>
              <h2><?php echo str_replace("%20", " ", $nombre); ?> has solicitado un cambio de contraseña</h2>
              <p> Tu correo en copropiedad es <strong> <?php echo str_replace("cp-", "", $email); ?></strong>. por favor ingresa tu nueva contraseña.</p>
              <div class="login">
                <form id="newpassword_form" method="POST">                        
                    <p><label for="password">Nueva contraseña: *</label><input type="password" id="password" name="password"></p>
                    <p><label for="passwordconf">Confirmar nueva contraseña: *</label><input type="password" id="passwordconf" name="passwordconf"></p>
                    <input type="hidden" id="email" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" id="token" name="token" value="<?php echo $tokenR; ?>">
                    <input type="hidden" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                  <div class="login-botones">
                    <p><input type="submit" class="btn gray" value="Cambiar contraseña"/></p>
                  </div>
                </form>
              <div id="alertas"></div>
            <?php } else { ?>
              <div class="alert alert-dismissable alert-error" style="height:auto; margin:5px auto;">
                <h2>Tu link ha expirado!</h2>Los links de activación tienen una validez de 24 horas. ¿Deseas crear un nuevo link para continuar con el proceso?. <a class="btn gray" style="color:#FFF!important" href="generar-link.php">Haz click aquí</a>
              </div>
            <?php } ?>  
            </div>
        </div>
      </section>
  </div>
</body>
</html>