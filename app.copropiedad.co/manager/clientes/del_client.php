<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../../template/head.inc") ?>
<link rel="stylesheet" href="../../css/jquery-ui.css" />
  <link rel="stylesheet" href="../../css/chosen.css">
  <link rel="stylesheet" href="../../css/estilos-copropiedad.css" type="text/css" media="all">
  <link rel="stylesheet" href="../../css/tablet.css" type="text/css"  media="all and (min-width: 640px) and (max-width: 1199px)">
  <link rel="stylesheet" href="../../css/mobile.css" type="text/css" media="all and (min-width: 100px) and (max-width: 639px)">

  <link rel="alternate stylesheet" title="Aguamarina" href="../../css/color1.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Verde" href="../../css/color2.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Azul" href="../../css/color3.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Morado" href="../../css/color4.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Amarillo" href="../../css/color5.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Rojo" href="../../css/color6.css" type="text/css" media="all">

  <!-- For third-generation iPad with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../images/apple-touch-icon-144x144-precomposed.png">
  <!-- For iPhone with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../images/apple-touch-icon-114x114-precomposed.png">
  <!-- For first- and second-generation iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../images/apple-touch-icon-72x72-precomposed.png">
  <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
  <link rel="apple-touch-icon-precomposed" href="../../images/apple-touch-icon-precomposed.png">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="../../js/jquery.validate.js"></script>
  <!-- Template Engine -->
  <!--<script src="http://twitter.github.com/hogan.js/builds/3.0.1/hogan-3.0.1.js"></script>
  <script src="js/copropiedad-template-engine.js"></script>-->
  <!--<script type="text/javascript" src="copropiedad-template-engine.js"></script>-->
  <!-- Variables de Sesion -->
  <!--<script src="../js/copropiedad-set_variables.js"></script>-->
  <!-- jquery alertas acción de cerrar y con html -->
  <script src="../../js/alertas.js"></script>
  <!-- además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
  <script src="../../js/jquery.bsAlerts.js"></script>
  <!-- Script selector de copropiedad -->
  <script src="../../js/jquery-dd.js"></script>
  <script src="../../js/copropiedad-hoy.js"></script>

<script src="../../js/jquery.min.js"></script>
    

<script type="text/javascript">

    $(document).ready(function()
    {    
        $('#copropiedad').attr('disabled', 'disabled');
        
        $('#nusuario').html("Bienvenido:");

        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

        /*if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
            $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                window.location = '../../index.html';
        }*/
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
            id:params['idt']
          }
        };
        traerDatosEliminables(arr,'clientes/getlist/edit', params);
    });
</script>

<script src="js/validate.js"></script>
<script src="js/enviarDatos.js"></script>

<!-- Jquery UI y Tabs -->
<script src="../../js/jquery-ui.js"></script>

<!-- Selector para cambiar las hojas de estilo -->
<script src="../../js/stylesheet-switcher.js"></script>



  <!-- <script>
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
  </script>-->

</head>
<body>
  <header>
    <div class="contenedor">
        <div class="logo">
           <a href="index.php">
              <h1>Copropiedad</h1>
           </a>
        </div>
        <div class="menus">
           <nav id="topmenu">
            <ul>                 
              <li><a href="index.php">Salida</a></li>
            </ul>
           </nav>
        </div>
    </div>
  </header>
    <div id="contenido-principal">
        <section id="central">                
                <div class="contenedor">
                  <div class="titulo-principal">
                    <h1 class="title tareas">Clientes | Copropiedad</h1>
                  </div>
                  <table style="width:400px!important; margin: auto;">
                    <tr>
                          <td colspan="2"><label id="nombremostrar">Desea eliminar el cliente de copropiedad</label></td>
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
                          <input type="hidden" id = "name_client">
                          <input type="hidden" id = "fecha_registro">
                          <input type="hidden" id="referencia" name="referencia">
                          <input type="hidden" id="fecha_fin" name="fecha_fin">
                          <input type="hidden" id = "cc_client">
                          <input type="hidden" id = "email_client">
                          <input type="hidden" id = "tel_client">
                          <input type="hidden" id = "dir_client">
                          <input type="hidden" id = "cel_client">
                          <input type="hidden" id = "id_crm">
                          <input type="hidden" id = "origin_client">
                          <input type="hidden" id = "pais_client">
                          <input type="hidden" id = "ciudad_client">
                          <input type="button" id="btn_eliminar" value="Guardar cambios" class="btn icono guardar">
                          <a class="btn icono regresar" href="index.php">Regresar</a>
                        </td>
                      </tr>
                    </table>
                <div data-alerts="alerts" id ="alertas"></div>
              </div>
        </section>
    </div>
</body>
<!--scripts selector con búsqueda como en http://harvesthq.github.io/chosen/-->
 <script src="../../js/chosen.jquery.js" type="text/javascript"></script>
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