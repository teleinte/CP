<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
  <?php include("../template/head.inc") ?>
  <?php include("../template/css.inc");?>
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

    <script src="js/copropiedad-enviodatos.js"></script>
    <script src="../js/jquery.min.js"></script>
    <!-- Jquery UI y Tabs -->
    <script src="../js/jquery-ui.js"></script>    
    <!-- Script selector de copropiedad -->
    <script src="../js/jquery-dd.js"></script>
           
    <!-- Selector para cambiar las hojas de estilo -->
    <script src="../js/stylesheet-switcher.js"></script>
    <!-- jquery alertas acción de cerrar y con html -->
    <script src="../js/alertas.js"></script>
    <!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
    <script src="../js/jquery.bsAlerts.js"></script> 
  </head>

  <body>
    <?php
      include("../template/header.inc")
    ?>
    <div id="contenido-principal">
      <section id="central">
        <div id="alertas">                  
        </div>
        <div class="contenedor">
          <div style="text-align:center">
            <h2>Hable con su administrador para que realice la activación de su usuario</h2>
          </div>
        </div>
      </section>
    </div>
  </body>

<!--scripts selector con búsqueda como en http://harvesthq.github.io/chosen/-->
  <script src="../js/chosen.jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = 
    {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'No se encuentra'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) 
    {
      $(selector).chosen(config[selector]);
    }
  </script>   
</html>
