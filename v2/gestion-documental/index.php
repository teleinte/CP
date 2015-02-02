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
<script src="js/copropiedad-gestiond-enviarcorreo.js"></script>
<script src="js/copropiedad-gestiond-enviodatos.js"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>

<?php include("templates/mcopropiedad.php"); ?> 
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
<!-- Data tables -->
<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/copropiedad-gestiond-functions.js"></script>
<script src="js/copropiedad-gestiond-validate.js"></script>
<link href="css/estilo-filemanager.css" rel="stylesheet"/>
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
                  <div class="titulo-principal"><h1 class="title cartelera">Documentos de la copropiedad</h1></div>
                  <div class="floatleft"></div>
                  <div class="floatright" style="display:inline-block; margin-bottom:5px;"><input type="submit" class="btn" value="Subir archivo" id="open-crearanuncio"></div>
                </div>
                <div class="filemanager">

                  <div class="search">
                    <input type="search" placeholder="Buscar un archivo" />
                  </div>

                  <div class="breadcrumbs"></div>

                  <ul class="data"></ul>

                  <div class="nothingfound">
                    <div class="nofiles"></div>
                    <span>No tienes archivos actualmente</span>
                  </div>

                </div>

                <!--<div id="subirarchivo" class="modal" title="Crear anuncio de cartelera">
                    <form class="clearfix" id="crearanuncio_form">
                      <table>
                          <tr>
                              <td>
                                <label for="nombre">Titulo del anuncio</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="nombre" name="nombre" />
                              </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="notas">Descripción del anuncio</label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <textarea id="notas" name="notas" style="height:250px; width:250px; resize:none;"></textarea> 
                            </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="vigencia">Fin de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="vigencia" name="vigencia" />
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                  <div id="alertas"></div>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                <input type="submit" class="btn icono guardar" value="Crear Anuncio"/>
                              </td>
                          </tr>
                      </table>
                    </form>
                    <div data-alerts="alerts" id ="alertas"></div>
                </div>
                <div id="compartirarchivo" class="modal" title="Crear anuncio de cartelera">
                    <form class="clearfix" id="crearanuncio_form">
                      <table>
                          <tr>
                              <td>
                                <label for="nombreventa">Titulo de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="nombreventa" name="nombreventa" />
                              </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="notasventa">Descripción de la publicación</label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <textarea id="notasventa" name="notasventa" style="height:250px; width:250px; resize:none;"></textarea> 
                            </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="vigenciaventa">Fin de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="vigenciaventa" name="vigenciaventa" />
                              </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="valorventa">Valor de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="valorventa" name="valorventa" />
                              </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="fotoventa" style="padding-top:40px;">Adjunta una foto de tu articulo</label>
                              </td>
                              <td colspan="2">
                                <div style="width:150px; height:80px;" id="previewFileDiv"><img id="previewFile"/></div><br/>
                                <div id="fileuploader">  Cargar Foto</div>
                              </td>
                              <input type="hidden" id="filepath" name="filepath" value=""/>
                          </tr>
                          <tr>
                              <td colspan="3">
                                  <div id="alertas"></div>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                <input type="submit" class="btn icono guardar" value="Crear Publicación" id="btncrearanuncioventa"/>
                              </td>
                          </tr>
                      </table>
                    </form>
                    <div data-alerts="alerts" id ="alertas"></div>
                </div>-->

                <div data-alerts="alerts" id ="alertas"></div>
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
