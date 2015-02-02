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
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})      
         $('#copropiedad').attr('disabled', 'disabled');
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Tip:</strong>NO PUDO LISTAR POR TOKEN, Solicitando nuevo token por favor espere.</div>')
            window.location = '../index.html';            
        }
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            _id:params['idt'],            
          }
        };
        traerDatosModificables(arr,"unidad/copropiedadid",params);
      });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#nuevos").click(function(){
      $("#new-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
    });
  });
  $(document).ready(function(){
    $("#aplicaciones").click(function(){
      $("#app-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
    });
  });
  $(document).ready(function(){
    $("#pendientes").click(function(){
      $("#pending-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
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
                <form class="clearfix" id="inmueble_form_editar">
                  <div class="contenedor">
                    <div class="titulo-principal"><h1 class="title tareas">Inmuebles - Editar inmueble</h1></div>                  
                      <div class="clearfix">
                          <table>
                              <tr>
                                  <td colspan="2">
                                    <label for="tipo">Tipo de inmueble:</label>
                                    <select id= "tipo" name="tipo">
                                      <option value='apartamento'>Apartamento</option>
                                      <option value='local'>Local</option>
                                      <option value='bodega'>Bodega</option>
                                      <option value='oficina'>Oficina</option>
                                      <option value='deposito'>Deposito</option>
                                      <option value='saloncomunal'>Salon Comunal</option>
                                      <option value='parqueadero'>Parqueadero</option>
                                    </select>
                                  </td>
                                  <td colspan="2">
                                    <label for="reservable">Es un inmueble reservable?:</label>
                                    <input type="checkbox" id="reservable" name="reservable" value="true"> Si
                                    <!-- <label for="usuario">Usuario de la unidad:</label>
                                    <select id='usuario' name="usuario">
                                      <option value = "">-Seleccione-</option>
                                      <option value = "0">Ninguno</option>
                                      <option value = "14">Jairo Gil Villamarin</option>
                                    </select>-->
                                  </td>  
                              </tr>
                              <tr>
                                  <td colspan="2">                                  
                                    <label for="identificador">Identificador Inmueble:</label>
                                    <input type="text" id = "identificador" name="identificador"></input>
                                    <!-- <select id='estado' name="estado">
                                      <option value = "">-Seleccione-</option>
                                      <option value = "1">Disponible</option>
                                      <option value = "2">Ocupada</option>
                                      <option value = "3">Fuera de servicio</option>
                                    </select> -->
                                    <input type="hidden" id = "nombre"></input>
                                    <input type="hidden" id = "id_copropiedad"></input>
                                    <input type="hidden" id = "id_crm_persona"></input>
                                    <input type="hidden" id = "fecha_creacion"></input>
                                    <input type="hidden" id = "estado"></input>
                                  </td >
                                  <td colspan="2">
                                    <label for="detalle">Detalle del inmueble:</label>
                                    <input type="text" id = "detalle" name="detalle"></input>
                                  </td >
                              </tr>
                              <tr>
                                  <td colspan="2">                                  
                                    <input type="submit" class="btn icono guardar" value="Guardar Inmueble">
                                    <a class="btn icono regresar" href="inmueble.php" id="regresatarea">Regresar</a>
                                  </td >                                  
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
