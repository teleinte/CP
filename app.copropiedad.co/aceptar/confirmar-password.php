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
<?php //error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<link rel="stylesheet" type="text/css" href="../template/css/copropiedad.min.css">
<title>Confirmacion de nueva contraseña - Copropiedad</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&response=yes" async defer></script>
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
              <h1>Cambio de contraseña</h1>
            </div>
            <?php if($tkest) { ?>
              <div class="login">
              <h2>Establecer nueva contraseña para la cuenta <strong> <?php echo str_replace("cp-", "", $email); ?></strong></h2>
              <p>La contraseña debe tener por lo menos 6 caracteres incluyendo una letra mayúscula, una letra minúscula y un número</p><br/>
              <div id="alertas"></div>  
                <form id="newpassword_form" method="POST">                   
                    <p><label for="password">Nueva contraseña:</label><input type="password" id="password" name="password" required onchange="this.setCustomValidity(this.validity.patternMismatch ? '' : ''); if(this.checkValidity()) form.passwordconf.pattern = this.value;" title="La contraseña debe contener al menos 6 caracteres, incluyendo letras MAYÚSCULAS/minúsculas y números"></p>
                    <p><label for="passwordconf">Confirmar nueva contraseña:</label><input type="password" id="passwordconf" name="passwordconf" required onchange="this.setCustomValidity(this.validity.patternMismatch ? '' : '');" title="La contraseña escrita en este campo debe coincidir con la escrita en el campo anterior"></p>
                    <input type="hidden" id="email" name="email" value="<?php echo $email; ?>">
                    <input type="hidden" id="token" name="token" value="<?php echo $tokenR; ?>">
                    <input type="hidden" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                  <div class="login-botones">
                    <p><input type="submit" class="btn big" value="Cambiar contraseña"/></p>
                  </div>
                </form>
            <?php } else { ?>
              <div class="login" style="height:auto; margin:5px auto;">
                <h2>¡Su enlace ha expirado!</h2><p>El enlace de cambio de contraseña tiene una caducidad de 24 horas. Por favor realice el proceso de cambio de contraseña de nuevo.</p><p style="margin-top: 15px;"><a class="btn big" style="color:#FFF!important" href="cambiar-password.php">Haga click aquí</a></p>
              </div>
            <?php } ?>  
            </div>
            <div id="gracias" class="login-botones" style="padding:0px 15px; text-align:center;"></div>
        </div>
      </section>
  </div>
</body>
</html>