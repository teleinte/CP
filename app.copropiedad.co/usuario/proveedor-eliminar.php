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
<script type="text/javascript">
    $(document).ready(function(){
        $('#copropiedad').attr('disabled', 'disabled');
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../index.html';
        }
        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
        traerDatosMProveedor(arr,"usuario/personaid", params);
    });
</script>
<script type="text/javascript">
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
</script>

    <?php
        include("templates/mcopropiedad.php");
        //include("templates/menu.php");
    ?> 
    
    <!-- Jquery UI y Tabs -->
    <script src="../js/jquery-ui.js"></script>
    <!-- Script selector de copropiedad -->
    <script src="../js/jquery-dd.js"></script>
  <script>
  $(document).ready(function(e) {   
    //no use
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
<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/functions.js"></script>
<script src="js/validate.js"></script>
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
                  <!-- <div class="titulo-principal"><h1 class="title tareas">Edi Copropiedades</h1></div> -->
                <form class="clearfix" id="proveedor_form_eliminar">
                <div class="contenedor">
                  <div id="resultado"></div>
                  <div class="titulo-principal"><h1 class="title tareas">Usuarios - Eliminar Usuarios</h1></div>
                    <div class="clearfix" >
                      <table style="width:400px!important; margin: auto;">
                            <tr>
                                <td colspan="2"><label id="nombremostrar">Eliminar el Usuario</label></td>
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
                                <input type="hidden" id = "creado_por" value="">
                                <input type="hidden" id = "fecha_creacion" value="">
                                <input type="hidden" id = "id_copropiedad" value="">
                                <input type="hidden" id = "id_crm_persona" value="">
                                <input type="hidden" id = "nombreProveedor" value="">                            
                                <input type="hidden" id = "telefonoProveedor" value="">
                                <input type="hidden" id = "emailProveedor" value="">             
                                <input type="hidden" id = "descripcionProveedor" value="">
                                <input type="hidden" id = "tipoProveedor" value="">
                                <input type="hidden" id = "estado" value="">
                                <input type="hidden" id = "telefonoDosProveedor" value="">
                                <input type="hidden" id = "nombre1" value="">
                                <input type="hidden" id = "telefono1" value="">
                                <input type="hidden" id = "telefono21" value="">
                                <input type="hidden" id = "mail1" value="">
                                <input type="hidden" id = "nombre2" value="">
                                <input type="hidden" id = "telefono2" value="">
                                <input type="hidden" id = "telefono22" value="">
                                <input type="hidden" id = "mail2" value="">
                                <input type="hidden" id = "nombre3" value="">
                                <input type="hidden" id = "telefono3" value="">
                                <input type="hidden" id = "telefono23" value="">
                                <input type="hidden" id = "mail3" value="">
                                <input type="submit" id="btn_enviar" value="Eliminar Usuario" class="btn icono guardar">
                                <a class="btn icono regresar" href="usuario.php">Regresar</a>
                              </td>
                            </tr>
                        </table>
                    </div>
                </div>
          </form>
                 <div data-alerts="alerts" id ="alertas"></div>
                </div>
        </section>
    </div>
</body>

<!--scripts selector con búsqueda como en http://harvesthq.github.io/chosen/-->
  <script src="../js/chosen.jquery.js" type="text/javascript"></script>
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
