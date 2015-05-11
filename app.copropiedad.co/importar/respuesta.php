<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
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
<?php include("../template/js.inc");?>

<script src="js/copropiedad-actas-enviodatos.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="js/imagesloaded.js"></script>


<?php include("templates/mcopropiedad.php"); ?> 
<!-- Script selector de copropiedad -->
<script src="../js/jquery-dd.js"></script>
<script>
$(document).ready(function(e) {  
    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
    if(params['idr']==1){$('#alertas').html('<div class="alert alert-success" style="height:10px;">Proceso finalizado con exito.</div>')    
    }
    if(params['idr']==2){{$('#alertas').html('<div class="alert alert-success" style="height:10px;">Proceso finalizado con exito. No hay errores.</div>')}}
    if(params['idr']==3){{$('#alertas').html('<div class="alert alert-error" style="height:10px;">No fue posible obtener el token de activacion.</div>')}}
    if(params['idr']==4){{$('#alertas').html('<div class="alert alert-error" style="height:10px;">El archivo no contiene lineas</div>')}}
    $(document).ready(function(){
    $("#nuevos").click(function(){
       $("#new-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#new-panel').length) {
            if($('#new-panel').is(":visible")) {
                    $('#new-panel').hide();
                    $('#nuevos').toggleClass("active");
                    }
            }        
        });
  });
  $(document).ready(function(){
    $("#aplicaciones").click(function(){
			$("#app-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
		$(document).click(function(event) { 
		if(!$(event.target).closest('#app-panel').length) {
			if($('#app-panel').is(":visible")) {
				$('#app-panel').hide();
				$('#aplicaciones').toggleClass("active");
				}
			}        
		});
  });
  $(document).ready(function(){
   $("#pendientes").click(function(){
            $("#pending-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#pending-panel').length) {
            if($('#pending-panel').is(":visible")) {
                    $('#pending-panel').hide();
                    $('#pendientes').toggleClass("active");
                    }
            }        
        });
  });   
   
  try {      
    var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
      var val = data.value;
      if(val!="")
      {
        if (val=="Nueva"){window.open('../copropiedad/copropiedad-nuevodos.php','_parent');}
        else{sessionStorage.setItem("cp", val)
          javascript:location.reload()  
        }           
      }
    }}}).data("dd");
  } catch(e) {
    //console.log(e); 
  }
  $("#ver").html(msBeautify.version.msDropdown);
});
</script>
<!-- Selector para cambiar las hojas de estilo -->
<script src="../js/stylesheet-switcher.js"></script>
<!-- jquery alertas acción de cerrar y con html -->
<script src="../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../js/jquery.bsAlerts.js"></script>
<!-- Data tables -->


<script type="text/javascript">
    $(document).ready(function(){
        $('#id_copropiedad').val (sessionStorage.getItem('cp'));
        $('#token').val(sessionStorage.getItem('token'));
        $('#ncp').val(sessionStorage.getItem('ncp'));
        $('#id_crm').val(sessionStorage.getItem('id_crm'));
      });
</script>
<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/copropiedad-actas-functions.js"></script>
<script src="js/copropiedad-actas-validate.js"></script>
</head>
<body>
  <?php
  include("../template/header.inc")
  ?>
    <div id="contenido-principal">
        <section id="central">
            <aside>
            <?php
            include("templates/aside.php");
            ?>           
            </aside>                
                <div class="contenedor">
                  <div class="titulo-principal"><h1 class="title cartelera">Importador de Archivos</h1></div>
                  <div class="floatleft"></div>
                  <div class="floatright" style="display:inline-block; margin-bottom:5px;">
                      <a href="../admin/" class="btn" id ="open-creartarea" style="margin-right:5px;">Regresar</a>
                      <!-- <a href="descarga.php" class="btn" id ="open-creartarea" style="margin-right:5px;color: #F51E7C">Descargar la plantilla</a> -->
                  </div>                  
                    <div data-alerts="alerts" id ="alertas"></div>
                </div>
              </div>
        </section>
    </div>
</body>
</html>