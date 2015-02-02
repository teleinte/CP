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
    $('#copropiedad').attr('disabled', 'disabled');
    //no use
    try {      
      var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
        var val = data.value;
        if(val!="")
        {
          if (val=="Nueva"){window.open('../copropiedad/copropiedad.php','_parent');}
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
                <form class="clearfix" id="proveedor_form_editar">
                  <script type="text/javascript">
                      $(document).ready(function(){
                        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
                        {                      
                            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                                window.location = '../index.html';
                        }                        
                        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
                        traerDatosMProveedor(arr,"usuario/personaid", params);                        
                      });
                  </script>
                  <div class="contenedor">
                    <div class="clearfix">
                      <table>
                              <tr>
                                  <td>
                                    <label for="nombre">Empresa:</label>
                                    <input type="text" id="nombreProveedor" name="nombreProveedor">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefonoProveedor" name="telefonoProveedor">
                                  </td>                                  
                                  <td>
                                    <label for="telefonoDosProveedor">Telefono 2:</label>
                                    <input type="text" id="telefonoDosProveedor" name="telefonoDosProveedor">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="emailProveedor" name="emailProveedor">
                                  </td >                                                                                                 
                              </tr>
                              <tr>
                                  <td colspan="4">
                                    <label>Contactos de la empresa</label>
                                  </td>
                              </tr>
                               <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre1" name="nombre1">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono1" name="telefono1">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono Dos:</label>
                                    <input type="text" id="telefono21" name="telefono21">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="mail1" name="mail1">
                                  </td>                                  
                              </tr>
                              <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre2" name="nombre2">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono2" name="telefono2">
                                  </td>                                   
                                  <td>
                                    <label for="telefono">Telefono Dos:</label>
                                    <input type="text" id="telefono22" name="telefono22">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="mail2" name="mail2">
                                  </td>                                                                                                
                              </tr>
                              <tr>
                                  <td>
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" id="nombre3" name="nombre3">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono3" name="telefono3">
                                  </td>                                  
                                  <td>
                                    <label for="telefono">Telefono Dos:</label>
                                    <input type="text" id="telefono23" name="telefono23">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="mail3" name="mail3">
                                  </td>                                                                                                 
                              </tr>
                              <tr>                                  
                                  <td colspan="4">
                                    <label for="descripcion">Notas:</label>                                
                                    <input type="text" name="descripcion" id="descripcionProveedor">
                                    <input type="hidden" name="tipo" id="tipoProveedor" value="proveedor">
                                  </td>
                              </tr>                              
                              <tr>
                                  <td colspan = "4" >
                                    <input type="hidden" name="creado_por" id="creado_por">
                                    <input type="hidden" name="fecha_creacion" id="fecha_creacion"> 
                                    <input type="hidden" name="id_copropiedad" id="id_copropiedad">
                                    <input type="hidden" name="id_crm_persona" id="id_crm_persona">
                                    <input type="hidden" name="estado" id="estado">
                                    <input type="submit" class="btn icono guardar" value="Guardar Proveedor">
                                    <a class="btn icono regresar" href="usuario.php" id="">Regresar</a>
                                  </td>                                      
                              </tr>
                            </table>












                     <!--  <table>
                        <tr>
                            <td>
                              <label for="nombre">Nombre Usuario:</label>
                              <input type="text" id="nombreProveedor" name="nombre">
                            </td>
                            <td>
                              <label for="telefono">Telefono:</label>
                              <input type="text" id="telefonoProveedor" name="telefono">
                            </td>
                            <td>
                              <label for = "email">Correo Electronico:</label>
                              <input type = "text" id="emailProveedor" name="email">
                            </td > 
                            <td>
                              <label for="telefono">Telefono 2:</label>
                              <input type="text" id="telefonoDosProveedor" name="telefonoDos">
                            </td>                                                                                                
                        </tr>                              
                        <tr>                                  
                            <td colspan="4">
                              <label for="descripcion">Notas:</label>                                
                              <input type="text" name="descripcion" id="descripcionProveedor">
                              <input type="hidden" name="tipo" id="tipoProveedor">
                            </td>
                        </tr>                              
                        <tr>
                            <td colspan = "4" >
                              <input type="hidden" name="creado_por" id="creado_por">
                              <input type="hidden" name="fecha_creacion" id="fecha_creacion">
                              <input type="hidden" name="id_copropiedad" id="id_copropiedad">
                              <input type="hidden" name="id_crm_persona" id="id_crm_persona">
                              <input type="hidden" name="estado" id="estado">
                              <input type="submit" class="btn icono guardar" value="Guardar Proveedor">
                              <a class="btn icono regresar" href="usuario.php" id="">Regresar</a>
                            </td>                                      
                        </tr>
                      </table> -->
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
