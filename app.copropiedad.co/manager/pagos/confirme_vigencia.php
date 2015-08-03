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

<!--<script src="../../v2/js/jquery.min.js"></script>-->
<!--<script src="js/copropiedad-enviodatos.js"></script>-->
<script src="../../js/jquery.min.js"></script>

  <script>
    $(document).ready(function() 
    { // Función que suma o resta días a la fecha indicada
      sumaFecha = function(d, fecha)
      {
        fecha.setDate(fecha.getDate()+parseInt(d));
        return (fecha);
       }
    });
  </script>
  <script src="js/validate.js"></script>
  <script src="js/md5-min.js"></script>
  <script src="js/copropiedad-enviodatos.js"></script>
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/copropiedad-hoy.js"></script>

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
        var get= params['id'];
        var dat = get.split('+');
        var arr = 
        {
          token:sessionStorage.getItem('token'),
          body:
          {
            id_copropiedad:dat[0],
            referenceCode:dat[1],
          }
        };
        //alert(JSON.stringify(arr));
        traerDatosVigencia(arr,'pagosteleinte/getlist/copropiedad','POST');
    });
</script>

<script>    
    $(function() 
    {  
      $( ".modal" ).dialog(
      {
        autoOpen: false,
        modal: true
      })
      $( "#crearcopropiedad" ).dialog(
      {
        width: 600, //Cambiar ancho del modal. Por defecto es 300. Más info para formularios en http://jqueryui.com/dialog/#modal-form        
      });
    });
  </script>


    
<!-- Jquery UI y Tabs -->
<script src="../../js/jquery-ui.js"></script>
<!-- Script selector de copropiedad -->
<script src="../../js/jquery-dd.js"></script>
<!-- Selector para cambiar las hojas de estilo -->
<script src="../../js/stylesheet-switcher.js"></script>
<!-- jquery alertas acción de cerrar y con html -->
<script src="../../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../../js/jquery.bsAlerts.js"></script>
<script src="../../js/jquery.validate.js" type="text/javascript"></script>  
</head>
<body>
  <?php
  include("../../template/header.inc")
  ?>
    <div id="contenido-principal">
      <section id="central">           
          <div class="contenedor">
            <div class="titulo-principal"><h1 class="title tareas">Acreditar Vigencias | Copropiedad</h1></div>               
            <script type="text/javascript">
              $(document).ready(function()
              {
                var params={};
                window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value)
                  {
                    params[key] = value;
                  })
                /*if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
                {                      
                  $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                      window.location = '../index.php';
                }                        
                        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
                        var arr = {token:sessionStorage.getItem('token'),body:{_id:params['idt']}};
                        traerDatosMProveedor(arr,"admin/copropiedad/usuario/personaid", params);*/                        
                      });
                  </script>
                  <div class="contenedor">
                      <div class="titulo-principal"><h1 class="title encuestas">Desea acreditar la vigencia de la copropiedad?
                        <div class="clearfix">
                            <form id="usuario_form_eliminar">
                                <table style="width:400px!important; margin: auto;">
                          <tr>
                                <td colspan="2"><label id="nombremostrar"></label></td>
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
                                <input type = "hidden" id="id_crm_persona" name="id_crm_persona">
                                <input type = "hidden" id="fecha_pago" name="fecha_pago">
                                <input type = "hidden" id="fecha_confirmacion" name="fecha_confirmacion">
                                <input type = "hidden" id="referencia_activa" name="referencia_activa">
                                <input type = "hidden" id="valor" name="valor">
                                <input type = "hidden" id="id_copropiedad" name="id_copropiedad">
                                <input type = "hidden" id="ncp" name="ncp">
                                <input type = "hidden" id="cruzado" name="cruzado">
                                <input type = "hidden" id="email_pagador" name="email_pagador">
                                <input type = "hidden" id="name_pagador" name="name_pagador">
                                <input type = "hidden" id="referenceCode" name="referenceCode">
                                <input type = "hidden" id="estado" name="estado">
                                <input type="submit" id="btn_enviar" value="Acreditar Vigencia" class="btn icono guardar">
                                <a class="btn icono regresar" href="index.php">Regresar</a>
                              </td>
                            </tr>
                        </table>
                      </form>
                      <div id="alertas"></div> 
                    </div>
                  </div>                
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
</html>