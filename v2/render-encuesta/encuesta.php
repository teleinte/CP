<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>

<!doctype html>
<html xml:lang="es-es" lang="es-es" >
<head>
    <?php include("../template/css.inc");?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE, NOSNIPPET" />
    <title>Copropiedad - Encuesta</title>
    <link href="favicon.ico" rel="shortcut icon" />    
    <style>
		body#encuesta header .center img {margin: 10px auto 0;}
		body#encuesta .contenedor textarea {width:96%; padding:5px 2%;}
		body#encuesta input[type="button"] {background-color: #F51E7C;}
		body#encuesta input[type="button"]:hover {background-color: #666666;}
		body#encuesta .respuesta {padding-left:20px;}
		body#encuesta #central {max-width: 100%;}
		body#encuesta #central .contenedor {padding-bottom: 30px;}
   </style>
</head>
<?php include("../template/head.inc") ?>

<?php include("../template/js.inc");?>
<!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->
<!-- For third-generation iPad with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/apple-touch-icon-144x144-precomposed.png">
<!-- For iPhone with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114-precomposed.png">
<!-- For first- and second-generation iPad: -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72-precomposed.png">
<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->

<script src="../js/jquery.min.js"></script>
    
    <!-- Jquery UI y Tabs -->
    <script src="../js/jquery-ui.js"></script>
    <!-- Script selector de copropiedad -->
    <script src="../js/jquery-dd.js"></script>  
<!-- Selector para cambiar las hojas de estilo -->

<!-- jquery alertas acción de cerrar y con html -->
<script src="../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../js/jquery.bsAlerts.js"></script>
</head>
<body id="encuesta">
  <header>
        <div class="contenedor">
			<div class="center"><a href="#" taget="_blank"><img src="../images/logo-copropiedad-home.png"/></a></div>
        </div>
  </header>
    
    <div id="contenido-principal">
        <section id="central">
        	<div class="contenedor">
                <div class="titulo-principal"><h1 class="title encuestas">Encuesta</h1></div>
                
                <p><?php include("template/traeEncuesta.php");?></p>
                
                
                <form id="enviarEncuesta" name="EnviarEncuesta">
                    
                <?php
                        include("template/pintaPreguntas.php")
                        ?>

                    <input type="hidden" id="idEncusta" name="idEncusta" value="<?php echo $_GET['ide'];?>" />
                    <input type="hidden" id="usuario" name="usuario" value="<?php echo base64_decode($_GET['usr']);?>" />
                    <input type="hidden" id="token" name="token" value="<?php echo base64_decode($_GET['stk']);?>" />
                    
                <input type="button" id="enviarBtn" value="Enviar Encuesta"/>
                
                </form>
          	</div>
      	</section>
	</div>
        <div style="margin:0 auto!important;" id="respuesta"></div>

</body>

<script>   
$(function(){
 $("#enviarBtn").click(function(){
 var url = "template/ValidateData.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#enviarEncuesta").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               if(data === "cambio")
               {
                   location = "template/encuestaTerminada.php";
               }
               else
               {
                   $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
               }
               
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
});
</script>

</html>

