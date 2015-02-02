<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
<?php include("../template/js.inc");?>

<script src="js/copropiedad-enviodatos.js"></script>
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
    <script src="../js/jquery.min.js"></script>
    
    <!-- Panel de Historial -->
    <script type="text/javascript">
  $(document).ready(function(){
    $("#nuevos").click(function(){
      $("#new-panel").toggle("fast");
      $(this).toggleClass("active");
      return false;
    });
  });
  $(document).ready(function(){
    $("#aplicacionesDos").click(function(){
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
      include("templates/menu.php");
    ?> 
    
    <!-- Jquery UI y Tabs -->
    <script src="../js/jquery-ui.js"></script>
        
    <!-- Script selector de copropiedad -->
    <script src="../js/jquery-dd.js"></script>
  <script>

  $(document).ready(function(e) {
    //$('#copropiedad').attr('disabled', 'disabled');
    //no use
    try {      
      var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
        var val = data.value;
        if(val!="")
        {
          if (val=="Nueva"){window.open('../copropiedad/copropiedad-nuevodos.php','_parent');}
          else
          {
            sessionStorage.setItem("cp", val)
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
//   $(function(){

//         $(document).trigger("add-alerts", [
//       {
//       message: "Esta es una alerta. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "warning"
//       },
//       {
//       message: "Esta es una alerta de información. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "info"
//       },
//       {
//       message: "Este es una alerta de error. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "error"
//       },
//       {
//       message: "Esta es una alerta de éxito. Todo el div #alertas-automaticas se oculta a los 6 segundos porque tiene un data-fade. Tendrá automáticamente la opción de cerrar",
//       priority: "success"
//       }
//     ]);
//       });
// </script>
    
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

                <div id="alertas">
                    <!-- <div class="alert alert-dismissable alert-info">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Información:</strong> Este es un mensaje de información en html, con botón para ocultarlo.
                    </div>
                    <div class="alert alert-dismissable alert-success">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Tip:</strong> Este es un mensaje de OK o exitoso en html, con botón para ocultarlo.
                    </div>
                    <div class="alert alert-error">
                      <strong><em>Error:</em></strong>
                        <br />
                        Este es un mensaje de error en html, sin botón para cerrarlo.
                    </div>
                    <div class="alert alert-warning">
                      <h4>Warning:</h4>
                      <p>Mensaje de alerta sin botón para cerrarlo, y con un h4 como título.</p>
                    </div> -->
                </div>
                <div class="contenedor">
                  <div class="aplicaciones" id ="aplicaciones"></div>

                    <!-- <div id="alertas-automaticas" data-alerts="alerts" data-titles="{&quot;success&quot;: &quot;&lt;em&gt;Exitoso!&lt;/em&gt;&quot;,&quot;warning&quot;: &quot;&lt;em&gt;Alerta!&lt;/em&gt;&quot;,&quot;danger&quot;: &quot;&lt;em&gt;Error!&lt;/em&gt;&quot;,&quot;info&quot;: &quot;&lt;em&gt;Información!&lt;/em&gt;&quot;}" data-ids="myid" data-fade="6000"></div>
                    <h3>Botones</h3>
                    <h4>En línea</h4>
                    <a class="btn ver solo inline" title="Ver" href="#"></a>
                    <a class="btn regresar solo inline" title="Regresar" href="#"></a>
                    <a class="btn agregar solo inline" title="Agregar" href="#"></a>
                    <a class="btn guardar solo inline" title="Guardar" href="#"></a>
                    <a class="btn importar solo inline" title="Importar" href="#"></a>
                    <a class="btn editar solo inline" title="Editar" href="#"></a>
                    <a class="btn borrar solo inline" title="Borrar" href="#"></a>
                    <a class="btn actualizar solo inline" title="Actualizar" href="#"></a>
                    <a class="btn descargar solo inline" title="Descargar" href="#"></a>
                    <a class="btn completar solo inline" title="Completar" href="#"></a>
                    <a class="btn anexo solo inline" title="Anexar" href="#"></a><br />
                    <input type="button" class="btn ver solo inline" value=""/>
                    <input type="submit" class="btn regresar solo inline" value=""/>
                    <button class="btn agregar solo inline"></button>
                    <input type="button" class="btn guardar solo inline" value=""/>
                    <input type="submit" class="btn importar solo inline" value=""/>
                    <input type="button" class="btn editar solo inline" value=""/>
                    <input type="button" class="btn borrar solo inline" value=""/>
                    <button class="btn actualizar solo inline"></button>
                    <input type="button" class="btn descargar solo inline" value=""/>
                    <input type="button" class="btn completar solo inline" value=""/>
                    <input type="button" class="btn anexo solo inline" value=""/>
                    <h4>En bloque</h4>
                    <a class="btn ver solo" title="Ver" href="#"></a>
                    <a class="btn regresar solo" title="Regresar" href="#"></a>
                    <a class="btn agregar solo" title="Agregar" href="#"></a>
                    <input type="button" class="btn guardar solo" value=""/>
                    <input type="submit" class="btn importar solo" value=""/>
                    <a class="btn editar solo" title="Editar" href="#"></a>
                    <a class="btn borrar solo" title="Borrar" href="#"></a>
                    <button class="btn actualizar solo"></button>
                    <a class="btn descargar solo" title="Descargar" href="#"></a>
                    <a class="btn completar solo" title="Completar" href="#"></a>
                    <a class="btn anexo solo" title="Anexar" href="#"></a>
                    <h4>Con textos</h4>
                    <a class="btn icono ver inline" href="#">Ver</a>
                    <a class="btn icono completar inline" href="#">Completar</a>
                    <input type="submit" class="btn icono importar" value="Importar"/>
                    <input type="button" class="btn icono guardar" value="Guardar"/>
                    <button class="btn icono actualizar">Actualizar</button>
                    
                    <div class="titulo-principal"><h1 class="title" style="padding-top:20px;">Títulos</h1></div>
                    <div class="titulo-principal"><h1 class="title libreta-contactos">Directorio</h1></div>
                    <div class="titulo-principal"><h1 class="title residentes">Residentes</h1></div>
                    <div class="titulo-principal"><h1 class="title configuracion">Configuración</h1></div>
                    <div class="titulo-principal"><h1 class="title contabilidad">Contabilidad</h1></div>
                    <div class="titulo-principal"><h1 class="title cartelera">Cartelera</h1></div>
                    <div class="titulo-principal"><h1 class="title proveedores">Proveedores</h1></div>
                    <div class="titulo-principal"><h1 class="title buzon">Buzón de Quejas</h1></div>
                    <div class="titulo-principal"><h1 class="title reservas">Reservas</h1></div>
                    <div class="titulo-principal"><h1 class="title foros">Foros</h1></div>
                    <div class="titulo-principal"><h1 class="title documentos">Documentos</h1></div>
                    <div class="titulo-principal"><h1 class="title calendario">Calendario</h1></div>
                    <div class="titulo-principal"><h1 class="title alertas">Alertas</h1></div>
                    <div class="titulo-principal"><h1 class="title presupuesto">Presupuesto</h1></div>
                    <div class="titulo-principal"><h1 class="title estado-cuenta">Estado de Cuenta</h1></div>
                    <div class="titulo-principal"><h1 class="title encuestas">Encuestas</h1></div>
                    <div class="titulo-principal"><h1 class="title consejo">Consejo</h1></div>
                    <div class="titulo-principal"><h1 class="title asamblea">Asamblea</h1></div>
                    <div class="titulo-principal"><h1 class="title micrositio">Micrositio</h1></div>
                    <div class="titulo-principal"><h1 class="title compraventa">Compraventa</h1></div>
                    <div class="titulo-principal"><h1 class="title tareas">Tareas</h1></div>
                    <div class="titulo-principal"><h1 class="title solicitudes">Solicitudes</h1></div>
                    <div class="titulo-principal"><h1 class="title encomiendas">Encomiendas</h1></div>
                    <div class="titulo-principal"><h1 class="title parqueaderos">Parqueaderos</h1></div>
                </div> -->
        </section>
    </div>

<!--<div id="tabs">
                      <ul>
                        <li><a href="#tabs-1">Tab1</a></li>
                        <li><a href="#tabs-2">Tab2</a></li>
                        <li><a href="#tabs-3">Tab3</a></li>
                        <li><a href="#tabs-4">Tab4</a></li>
                      </ul>
                      <div id="tabs-1">
                        Contenido 1
                      </div>
                      <div id="tabs-2">
                        Contenido 2
                      </div>
                      <div id="tabs-3">
                        Contenido 3
                      </div>
                      <div id="tabs-4">
                        Contenido 4
                      </div>
                  </div>-->
        
<!--<select data-placeholder="- Seleccione Ortodoncista -" class="chosen-select" style="width:250px;" tabindex="1">
                                        <option value=""></option>
                                        <option value="">DR. MARIN TORRES DIEGO</option>
                                        <option value="">DRA. LEON ESPINEL MATILDE</option>
                                        <option value="">DRA. VEGA MENDOZA LITSY</option>
                                        <option value="">DR. PRIETO IZQUIERDO CARLOS</option>
                                        <option value="">DR. SOTO ANGEL JUAN CARLOS</option>
                                        <option value="">DR. URIBE JARAMILLO ALBERTO</option>
                                        <option value="">DR. IBAÑEZ ALMEYDA TULIO</option>
                                        <option value="">DRA. PARADA PARADA SARA</option>
                                    </select>-->
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
