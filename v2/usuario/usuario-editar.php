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
                <form class="clearfix" id="usuario_form_editar">                                
                  
                  <script type="text/javascript">
                      $(document).ready(function(){
                        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
                        {                      
                            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                                window.location = '../index.html';
                        }
                        var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp')}};
                        traerUnidades(arr,"unidad/nousuario", parseInt(sessionStorage.getItem('cp')));
                        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
                        traerDatosModificables(arr,"usuario/personaid", params);                        
                      });
                  </script>
                  <div class="contenedor">
                    <div class="titulo-principal"><h1 class="title tareas">Contactos - Editar Contacto</h1></div>
                      <div class="clearfix">
                          <table>
                              <tr>
                                  <td>
                                    <label for="nombre">Nombre Usuario:</label>
                                    <input type="text" id="nombre" name="nombre">
                                  </td>
                                  <td>
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" id="telefono" name="telefono">
                                  </td>
                                  <td>
                                    <label for = "email">Correo Electronico:</label>
                                    <input type = "text" id="email" name="email">
                                  </td > 
                                  <td>
                                    <label for="unidad">Inmueble</label>
                                    <select name="unidad" id="unidad">
                                      <option value="">-seleccione-</option>
                                      <option value="0|-Ninguno-">-Ninguno-</option>
                                    </select>                                  
                                  </td>                                                                                                
                              </tr>
                              <tr>
                                  <td>
                                    <label for="empresa">Empresa:</label>
                                    <input type="text" id="empresa" name="empresa">
                                  </td>                                                                                                                  
                              </tr>
                              <tr>
                                  <td colspan = "4">
                                  <label>Seleccione si el usuario cuenta con las siguentes opciones:</label>
                                  </td>
                              </tr>
                              <tr>
                                  <td >
                                    Tiene Niños: <input type="checkbox" id="tiene_ninios" name="tiene_ninios" value="true">
                                  </td>
                                  <td >
                                    Tiene Empleada: <input type="checkbox" id="tiene_empleada" name="tiene_empleada" value="true">
                                  </td>
                                  <td >
                                    Tiene Mascota: <input type="checkbox" id="tiene_mascota" name="tiene_mascota" value="true">
                                  </td>
                                  <td >
                                    Tiene Bicicleta: <input type="checkbox" id="tiene_bicicleta" name="tiene_bicicleta" value="true">
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                    Tiene Vehiculo: <input type="checkbox" id="tiene_vehiculo" name="tiene_vehiculo" value="true">
                                  </td>                                      
                              </tr>
                              <tr>
                                  <td colspan ="2">
                                    <label>Seleccione un grupo de usuarios:</label>
                                    <select name="grupo" id="grupo">                                    
                                        <option value="residente">Residente</option>
                                        <option value="asamblea">Asamblea</option>
                                        <option value="consejo">Consejo</option>
                                        <option value="proveedores">Proveedores</option>
                                    </select>
                                  </td>
                                  <td colspan="2">
                                    <label for="descripcion">Descripción:</label>                                
                                    <input type="text" name="descripcion" id="descripcion">
                                  </td>
                              </tr>
                              <tr>                                      
                                  <td>
                                    <label for="enombre">Contacto emergencia nombre:</label>
                                    <input type="text" name="enombre" id="enombre">
                                  </td>
                                  <td>
                                    <label for="etelefono">Telefono de Emergencia:</label>
                                    <input type="text" name="etelefono" id="etelefono">
                                  </td>
                                  <td>
                                    <label for="ecorreo">Correo de Emergencia:</label>
                                    <input type="text" name="ecorreo" id="ecorreo">
                                    <input type="hidden" name="tipo" id="tipo" value="residente">
                                  </td>
                              </tr>
                                <td>                                  
                                  <input type="hidden" name="creado_por" id="creado_por">
                                  <input type="hidden" name="fecha_creacion" id="fecha_creacion">
                                  <input type="hidden" name="id_copropiedad" id="id_copropiedad">
                                  <input type="hidden" name="id_crm_persona" id="id_crm_persona">
                                  <input type="hidden" name="estado" id="estado">
                                </td>
                              </tr>

                              <tr>
                                <td >
                                  <input type="submit" class="btn icono guardar" value="Guardar Usuario">
                                  <a class="btn icono regresar" href="usuario.php" id="">Regresar</a>
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
