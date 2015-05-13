<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
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

<script src="js/enviarDatos.js"></script>
<script src="../js/jquery.min.js"></script>
    

<script type="text/javascript">

    $(document).ready(function(){

        //$('#copropiedad').attr('disabled', 'disabled');
        
        $('#copropiedadnuevo').attr("href", "copropiedad-nuevo.html")
        $('#nusuario').html("Bienvenido: "+sessionStorage.getItem('nombreCompleto'))

        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../../index.html';
        }
        function fecha()
        {
            var d = new Date();
            var n = d.toISOString(); 
            return n;
        }  
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_copropiedad:sessionStorage.getItem('cp'),
          }
        };
        traerDatos(arr,'consulta/copropiedad/pagosonline', 'POST');
        if($('#tipo').val()=="")
        {
          $('#btn_submit').val('Guardar');
        }
        else
        {
          $('#btn_submit').val('Guardar cambios');
        }
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

<script>    
    $(function() {  
        $( ".modal" ).dialog({
        autoOpen: false,
        modal: true
        })
      $( "#crearcopropiedad" ).dialog({
        width: 600, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form        
        });
    });
  </script>

<!-- Data tables -->
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
<link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">

<script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.colVis.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>
<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<!--<script src="js/functions.js"></script>-->
<script src="js/validate.js"></script>
<script>  $(function(){ $("#tabs").tabs();}); </script>
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
                <div class="contenedor" >
                  <div class="titulo-principal">
                    <h1 class="title tareas">Pagos en línea</h1>
                  </div>
                  <div id="tabs">
                    <ul>
                      <li><a href="#tabs-1">Pagos recibidos</a></li>
                      <li><a href="#tabs-2">Configuracion de pagos</a></li>
                    </ul>
                    <div id="tabs-1">
                      Tabla de pagos :)
                    </div>
                    <div id="tabs-2">
                      <div style="width:300px; margin:0 auto;">
                        <form class="clearfix" id="pagos_info_form">
                          <table>
                              <tr>
                                <td>
                                  <label for="nombre">Nombre usuario:</label>
                                  <input type="text" id="nombre" name="nombre">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label for="apikey">Apikey:</label>
                                  <input type="text" id="apikey" name="apikey">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label for="apikey_login">Apikey login:</label>
                                  <input type="text" id="apikey_login" name="apikey_login">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label for="llave_publica">Llave pública:</label>
                                  <input type="text" id="llave_publica" name="llave_publica">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label for="merchantId">Id comercio:</label>
                                  <input type="text" id="merchantId" name="merchantId">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <label for="accountId">Id Cuenta:</label>
                                  <input type="text" id="accountId" name="accountId">
                                  <input type="hidden" id="tipo" name="tipo" value="0">
                                </td>                                   
                              </tr>
                              <tr>
                                <td colspan="4">
                                  <input type="submit" class="btn icono guardar" id="btn_submit" value="">  
                                  <a type="btn" class="btn icono regresar" href="../dashboard/dashboard.php"> Regresar</a>
                                </td>
                              </tr>
                          </table>
                        </form>
                      </div>
                    </div>
                  </div>
                <div data-alerts="alerts" id ="alertas"></div>
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