<?php
error_reporting(E_ALL);ini_set('display_errors', 1);
date_default_timezone_set('America/Bogota');

if(isset($_GET['tk']) && strlen($_GET['tk']) > 10)
{
  //echo "ingresamos";
  //verificando y soltando las variables
  $envioRolcp = base64_decode($_GET['tk']);
  $estadoNuevo = base64_decode($_GET['en']);
  //echo $envioRolcp.$estadoNuevo;

  $url = "https://appdes.copropiedad.co/api/admin/copropiedad/rol";
  $fields = $envioRolcp;  
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

  //cambiando de estado al usuario

  $url = "https://appdes.copropiedad.co/api/estados/estados";  
  $fieldsEn = $estadoNuevo;  
  //open connection
  $ch = curl_init();
  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fieldsEn);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $resultadito = curl_exec($ch);
  //close connection  
  curl_close($ch);
  $final = json_decode($resultadito,true);
  //$result =$final["message"];
}
?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<link rel="stylesheet" type="text/css" href="../template/css/copropiedad.min.css">
<title>Aceptacion de usuario - Copropiedad</title>
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
              <h1>Aceptacion de usuario</h1>
            </div>           
              <div class="login">                
                <h2><p> Usted ha aceptado, cada vez que ingrese a Copropiedad.co se le preguntará si quiere entrar como administrador o como residente<br>Gracias.</p><br/></h2>
                <p>Ahora puede cerrar esta pagina.</p>
                <!---->
              </div>
            <div id="gracias" class="login-botones" style="padding:0px 15px; text-align:center;"></div>
        </div>
      </section>
  </div>
</body>
</html>


