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
$(document).ready(function(){
    $('#copropiedad').attr('disabled', 'disabled');
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
$(document).ready(function(e) {  
    $( ".modal" ).dialog({
      autoOpen: false,
      modal: true
    });
    
    $( "#crearsubiracta" ).dialog({
      resizable: false,
      autoOpen: false,
      title: 'Iniciar una venta'
    });

    $( "#open-crearsubiracta" ).click(function() {
          $("#crearsubiracta").dialog( "open" );
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
        const rutaAplicatico = "https://app.copropiedad.co/api/";
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../index.html';
        }        
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt'],tipo:"acta"}};
        traerDatosModificables(arr,"documentos/getlistFilter",params);
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
                  <div class="titulo-principal"><h1 class="title cartelera">Archivos de Actas</h1></div>                                           
                </div>
                <form class="clearfix" id="acta_form_eliminar">
                      <table style="width:400px!important; margin: auto;">
                          <tr>
                               <td colspan="2"><label id="nombremostrar">Eliminar El Acta: </label></td>
                               <td colspan="2"></td>                                                                
                            </tr>
                            <tr>
                              <td colspan="2">
                                  <select id="opcion" name="opcion">
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>                                  
                                  </select>
                              </td>                              
                            </tr>
                            <tr>
                              <td colspan="4">                                
                                <input type="hidden" id="nombrearchivo">
                                <input type="hidden" id="observacion">
                                <input type="hidden" id="filepath">
                                <input type="hidden" id="tipo">
                                <input type="hidden" id="estado">
                                <input type="hidden" id="fecha_creacion">
                                <input type="button" id="btn_eliminar" value="Eliminar Acta" class="btn icono guardar">
                                <a class="btn icono regresar" href="index.php">Regresa</a>
                              </td>
                            </tr>
                        </table>
                    </form>
                <div data-alerts="alerts" id ="alertas"></div>
              </div>
        </section>
    </div>
</body>
</html>