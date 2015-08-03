<?php
error_reporting(E_ALL);ini_set('display_errors', 1);
date_default_timezone_set('America/Bogota');
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

if(isset($_GET['token']) && strlen($_GET['token']) > 10)
{
  $tokenR = htmlspecialchars_decode($_GET['token']);
  $temp = base64_decode($_GET['code']);
  $arr = json_decode(htmlspecialchars_decode(urldecode($temp)));
  //var_dump($arr);
  $nombre = htmlspecialchars_decode($arr->body->nombre, ENT_HTML5);
  $email = htmlspecialchars_decode($arr->body->email);
  $tkest = ValidateToken($tokenR);
  $ecp = $_GET['ecp'];

  //set POST variables
  $url = "https://appdes.copropiedad.co/api/activacion/";
  $fields = json_encode(array("token"=>"notoken", "body" => array("token" => urlencode($tokenR), "email" => $email)));
  //open connection
  $ch = curl_init();
  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $resultadito = curl_exec($ch);
  //close connection
  curl_close($ch);
  $final = json_decode($resultadito,true);
  $result =$final["message"];
  //$result = "1";
}
else
{
  $result = "1";
  $tkest = false;
}

function objectToArray($d) 
{
  if (is_object($d)) 
  {    
      $d = get_object_vars($d);
  }
  if (is_array($d)) 
  {    
      return array_map(__FUNCTION__, $d);
  }
  else 
  {
      return $d;
  }
}
?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<link rel="stylesheet" type="text/css" href="../template/css/copropiedad.min.css">
<title>Activación de usuario - Copropiedad</title>
<script type="text/javascript" src="../template/js/jquery.min.js"></script>
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
<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: Co_Copropiedad_Activacion_TP
URL of the webpage where the tag is expected to be placed: https://appdes.copropiedad.co/registrese/
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 07/24/2015
-->
<script type="text/javascript">
var axel = Math.random() + "";
var a = axel * 10000000000000;
document.write('<iframe src="https://4862415.fls.doubleclick.net/activityi;src=4862415;type=typfc0;cat=co_co00;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
</script>
<noscript>
<iframe src="https://4862415.fls.doubleclick.net/activityi;src=4862415;type=typfc0;cat=co_co00;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
</noscript>
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->
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
              <h1>Activación de usuario</h1>
            </div>
            <?php if($result == "1") { ?>
                <?php if($tkest) { ?>
                  <!--
                  Start of DoubleClick Floodlight Tag: Please do not remove
                  Activity name of this tag: CO_CoPropiedad_TYP
                  URL of the webpage where the tag is expected to be placed: http://www.copropiedad.co/gracias/
                  This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
                  Creation Date: 05/13/2015
                  -->
                  <script type="text/javascript">
                  var axel = Math.random() + "";
                  var a = axel * 10000000000000;
                  document.write('<iframe src="https://4862415.fls.doubleclick.net/activityi;src=4862415;type=typfc0;cat=co_co0;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
                  </script>
                  <noscript>
                  <iframe src="https://4862415.fls.doubleclick.net/activityi;src=4862415;type=typfc0;cat=co_co0;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
                  </noscript>
                  <!-- End of DoubleClick Floodlight Tag: Please do not remove -->
                  <div class="login">
                  <h2>Bienvenido a Copropiedad.co <?php //echo str_replace("+"," ",str_replace("%20", " ", $nombre)); ?></h2>
                  <p>Se ha registrado su cuenta con el correo <strong> <?php echo str_replace("cp-", "", $email); ?></strong>, por favor actívela escribiendo su nueva contraseña.</p>
                  <p>La contraseña debe tener por lo menos 6 caracteres incluyendo una letra mayúscula, una letra minúscula y un número</p><br/>
                  <div id="alertas"></div>
                    <form id="activation_form" method="POST">                        
                        <p><label for="password">Nueva contraseña:</label><input type="password" id="password" name="password" required onchange="this.setCustomValidity(this.validity.patternMismatch ? '' : ''); if(this.checkValidity()) form.passwordconf.pattern = this.value;" title="La contraseña debe contener al menos 6 caracteres, incluyendo letras MAYUSCULAS/minusculas y numeros"></p>
                        <p><label for="passwordconf">Confirmar nueva contraseña:</label><input type="password" id="passwordconf" name="passwordconf" required onchange="this.setCustomValidity(this.validity.patternMismatch ? '' : '');" title="La contraseña escrita en este campo debe coincidir con la escrita en el campo anterior"></p>
                        <input type="hidden" id="arr" name="arr" value="<?php echo htmlspecialchars(json_encode($arr)); ?>"/>
                        <input type="hidden" id="ecp" name="ecp" value="<?php echo $ecp; ?>"/>
                      <div class="login-botones">
                        <p><input type="submit" class="btn big" value="Activar"/></p>
                      </div>
                    </form>
                <?php } else { ?>
                    <div class="login" style="height:auto; margin:5px auto;">
                      <h2>¡Su correo de activacion ha expirado o no es valido!</h2><p>El correo de activación tiene una caducidad de 24 horas. ¿Desea reenviar el correo de activacion para continuar con el proceso?.</p><p style="margin-top: 15px;"><a class="btn big" style="color:#FFF!important" href="generar-link.php">Haga click aquí</a></p>
                    </div>
                  <?php } } 
              else {?>  
              <div class="login" style="height:auto; margin:5px auto;">
                <h2 style="text-align:center;">¡Su cuenta ya ha sido activada!</h2><p style="text-align:right;"><a href="cambiar-password.php"> ¿Olvidó su contraseña? </a></p><div class="login-botones"><p style="text-align:right;"><a class="btn big" href="https://appdes.copropiedad.co/"> Iniciar Sesion </a></p></div>
              </div>
            <?php } ?>
            </div>
            <div id="gracias" class="login-botones" style="padding:0px 15px; text-align:center;"></div>
        </div>
      </section>
  </div>
</body>
</html>