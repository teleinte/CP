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
<script src="js/copropiedad-cartelera-enviarcorreo.js"></script>
<script src="js/copropiedad-cartelera-enviodatos.js"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="http://imagesloaded.desandro.com/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="js/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>

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
<link rel="stylesheet" type="text/css" href="css/jquery.cleditor.css">
<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/copropiedad-cartelera-functions.js"></script>
<script src="js/copropiedad-cartelera-validate.js"></script>
<style>
  #cartelera-board .ancho-contenedor {width:33.3%;}
  #cartelera-board .item { width: 28.3%; margin: 1%; padding: 1.5%; background:#FFFFAA; -moz-box-shadow:3px 3px 7px rgba(33,33,33,.7); -webkit-box-shadow: 3px 3px 7px rgba(33,33,33,.7); box-shadow: 3px 3px 7px rgba(33,33,33,.7);}
  #cartelera-board .item.ventas {background:#E1F5FF;}

  /*Quitar estos estilos*/
  #cartelera-board .uno {height:200px;}
  #cartelera-board .dos {height: 300px;}
  #cartelera-board .tres {height:400px;}

  /*Agregar a mobile y a tablet.css*/
  @media all and (max-width: 768px) {
  #cartelera-board .ancho-contenedor {width:50%;}
  #cartelera-board .item { width: 45%; margin: 1%; padding: 1.5%;}
  }
  @media all and (max-width: 480px) {
  #cartelera-board .ancho-contenedor {width:100%;}
  #cartelera-board .item { width: 95%; margin: 1%; padding: 1.5%;}
  }

  .ajax-file-upload-statusbar {
    border: 1px solid #0ba1b5;
    margin-top: 10px;
    margin-right: 10px;
    margin: 5px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    width: 150px !important;
    padding: 5px 5px 5px 5px
   }
   
  .ajax-file-upload-filename {
    width: 130px !important;
    height: auto;
    margin: 0 5px 5px 10px;
    text-align:justify;
    display:none;
    color: #807579
   }
   
  .ajax-file-upload-progress {
    margin: 0 10px 5px 10px;
    position: relative;
    width: 130px !important;
    border: 1px solid #ddd;
    padding: 1px;
    border-radius: 3px;
    display: inline-block
   }
   
  .ajax-file-upload-bar {
    background-color: #0ba1b5;
    width: 0;
    height: 20px;
    border-radius: 3px;
    color: #fff
   }
   
  .ajax-file-upload-percent {
    position: absolute;
    display: inline-block;
    top: 3px;
    left: 48%
   }
   
  .ajax-file-upload-red {
    -moz-box-shadow: inset 0 39px 0 -24px #e67a73;
    -webkit-box-shadow: inset 0 39px 0 -24px #e67a73;
    box-shadow: inset 0 39px 0 -24px #e67a73;
    background-color: #e4685d;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    display: inline-block;
    color: #fff;
    font-family: arial;
    font-size: 13px;
    font-weight: normal;
    padding: 4px 15px;
    text-decoration: none;
    text-shadow: 0 1px 0 #b23e35;
    cursor: pointer;
    vertical-align: top;
    margin-right: 5px
   }
   
  .ajax-file-upload-green {
    background-color: #77b55a;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    margin: 0;
    padding: 0;
    display: inline-block;
    color: #fff;
    font-family: arial;
    font-size: 13px;
    font-weight: normal;
    padding: 4px 15px;
    text-decoration: none;
    cursor: pointer;
    text-shadow: 0 1px 0 #5b8a3c;
    vertical-align: top;
    margin-right: 5px
   }
   
  .ajax-file-upload {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 16px;
    font-weight: bold;
    padding: 15px 20px;
    cursor: pointer;
    line-height: 20px;
    height: 25px;
    margin: 0 10px 10px 0;
    display: inline-block;
    background: #fff;
    border: 1px solid #e8e8e8;
    color: #888;
    text-decoration: none;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -moz-box-shadow: 0 2px 0 0 #e8e8e8;
    -webkit-box-shadow: 0 2px 0 0 #e8e8e8;
    box-shadow: 0 2px 0 0 #e8e8e8;
    padding: 6px 10px 4px 10px;
    color: #fff;
    background: #2f8ab9;
    border: 0;
    -moz-box-shadow: 0 2px 0 0 #13648d;
    -webkit-box-shadow: 0 2px 0 0 #13648d;
    box-shadow: 0 2px 0 0 #13648d;
    vertical-align: middle
   }
   
    .ajax-file-upload:hover {
      background: #3396c9;
      -moz-box-shadow: 0 2px 0 0 #15719f;
      -webkit-box-shadow: 0 2px 0 0 #15719f;
      box-shadow: 0 2px 0 0 #15719f
     }
   
  .ajax-upload-dragdrop {
    border: 2px dotted #a5a5c7;
    color: #666;
    text-align: middle !important;
    vertical-align: middle;
    width: 130px !important;
    padding: 20px 10px
   }

   .ajax-upload-dragdrop b{
     padding: 10px 0 !important;
    }
   
  .ajax-upload-dragdrop.state-hover {border: 2px solid #a5a5c7}
   
  .ajax-file-upload-error {color: red}
   
   /*! fancyBox v2.1.5 fancyapps.com | fancyapps.com/fancybox/#license */
  .fancybox-wrap,
  .fancybox-skin,
  .fancybox-outer,
  .fancybox-inner,
  .fancybox-image,
  .fancybox-wrap iframe,
  .fancybox-wrap object,
  .fancybox-nav,
  .fancybox-nav span,
  .fancybox-tmp
  {
    padding: 0;
    margin: 0;
    border: 0;
    outline: none;
    vertical-align: top;
  }

  .fancybox-wrap {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 8020;
  }

  .fancybox-skin {
    position: relative;
    background: #f9f9f9;
    color: #444;
    text-shadow: none;
    -webkit-border-radius: 4px;
       -moz-border-radius: 4px;
            border-radius: 4px;
  }

  .fancybox-opened {
    z-index: 8030;
  }

  .fancybox-opened .fancybox-skin {
    -webkit-box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
       -moz-box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
  }

  .fancybox-outer, .fancybox-inner {
    position: relative;
  }

  .fancybox-inner {
    overflow: hidden;
  }

  .fancybox-type-iframe .fancybox-inner {
    -webkit-overflow-scrolling: touch;
  }

  .fancybox-error {
    color: #444;
    font: 14px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;
    margin: 0;
    padding: 15px;
    white-space: nowrap;
  }

  .fancybox-image, .fancybox-iframe {
    display: block;
    width: 100%;
    height: 100%;
  }

  .fancybox-image {
    max-width: 100%;
    max-height: 100%;
  }

  #fancybox-loading, .fancybox-close, .fancybox-prev span, .fancybox-next span {
    background-image: url('css/images/fancybox_sprite.png');
  }

  #fancybox-loading {
    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -22px;
    margin-left: -22px;
    background-position: 0 -108px;
    opacity: 0.8;
    cursor: pointer;
    z-index: 8060;
  }

  #fancybox-loading div {
    width: 44px;
    height: 44px;
    background: url('css/images/fancybox_loading.gif') center center no-repeat;
  }

  .fancybox-close {
    position: absolute;
    top: -18px;
    right: -18px;
    width: 36px;
    height: 36px;
    cursor: pointer;
    z-index: 8040;
  }

  .fancybox-nav {
    position: absolute;
    top: 0;
    width: 40%;
    height: 100%;
    cursor: pointer;
    text-decoration: none;
    background: transparent url('blank.gif'); /* helps IE */
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    z-index: 8040;
  }

  .fancybox-prev {
    left: 0;
  }

  .fancybox-next {
    right: 0;
  }

  .fancybox-nav span {
    position: absolute;
    top: 50%;
    width: 36px;
    height: 34px;
    margin-top: -18px;
    cursor: pointer;
    z-index: 8040;
    visibility: hidden;
  }

  .fancybox-prev span {
    left: 10px;
    background-position: 0 -36px;
  }

  .fancybox-next span {
    right: 10px;
    background-position: 0 -72px;
  }

  .fancybox-nav:hover span {
    visibility: visible;
  }

  .fancybox-tmp {
    position: absolute;
    top: -99999px;
    left: -99999px;
    visibility: hidden;
    max-width: 99999px;
    max-height: 99999px;
    overflow: visible !important;
  }

  /* Overlay helper */

  .fancybox-lock {
      overflow: hidden !important;
      width: auto;
  }

  .fancybox-lock body {
      overflow: hidden !important;
  }

  .fancybox-lock-test {
      overflow-y: hidden !important;
  }

  .fancybox-overlay {
    position: absolute;
    top: 0;
    left: 0;
    overflow: hidden;
    display: none;
    z-index: 8010;
    background: url('css/images/fancybox_overlay.png');
  }

  .fancybox-overlay-fixed {
    position: fixed;
    bottom: 0;
    right: 0;
  }

  .fancybox-lock .fancybox-overlay {
    overflow: auto;
    overflow-y: scroll;
  }

  /* Title helper */

  .fancybox-title {
    visibility: hidden;
    font: normal 13px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;
    position: relative;
    text-shadow: none;
    z-index: 8050;
  }

  .fancybox-opened .fancybox-title {
    visibility: visible;
  }

  .fancybox-title-float-wrap {
    position: absolute;
    bottom: 0;
    right: 50%;
    margin-bottom: -35px;
    z-index: 8050;
    text-align: center;
  }

  .fancybox-title-float-wrap .child {
    display: inline-block;
    margin-right: -100%;
    padding: 2px 20px;
    background: transparent; /* Fallback for web browsers that doesn't support RGBa */
    background: rgba(0, 0, 0, 0.8);
    -webkit-border-radius: 15px;
       -moz-border-radius: 15px;
            border-radius: 15px;
    text-shadow: 0 1px 2px #222;
    color: #FFF;
    font-weight: bold;
    line-height: 24px;
    white-space: nowrap;
  }

  .fancybox-title-outside-wrap {
    position: relative;
    margin-top: 10px;
    color: #fff;
  }

  .fancybox-title-inside-wrap {
    padding-top: 10px;
  }

  .fancybox-title-over-wrap {
    position: absolute;
    bottom: 0;
    left: 0;
    color: #fff;
    padding: 10px;
    background: #000;
    background: rgba(0, 0, 0, .8);
  }

  /*Retina graphics!*/
  @media only screen and (-webkit-min-device-pixel-ratio: 1.5),
       only screen and (min--moz-device-pixel-ratio: 1.5),
       only screen and (min-device-pixel-ratio: 1.5){

    #fancybox-loading, .fancybox-close, .fancybox-prev span, .fancybox-next span {
      background-image: url('css/images/fancybox_sprite@2x.png');
      background-size: 44px 152px; /*The size of the normal image, half the size of the hi-res image*/
    }

    #fancybox-loading div {
      background-image: url('css/images/fancybox_loading@2x.gif');
      background-size: 24px 24px; /*The size of the normal image, half the size of the hi-res image*/
    }
  }
</style>
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
                  <div class="titulo-principal"><h1 class="title cartelera">Cartelera de anuncios</h1></div>
                  <div class="floatleft"></div>
                  <div class="floatright" style="display:inline-block; margin-bottom:5px;"><input type="submit" class="btn" value="Crear anuncio" id="open-crearanuncio">  <input type="submit" class="btn" value="Iniciar una venta" id="open-crearanuncioventa"></div>
                </div>
                <div id="cartelera-board" style="margin-top:15px; display:block; width:100%;"><div class="ancho-contenedor"></div></div>
                <div style="display:none;">

                <div id="crearanuncio" class="modal" title="Crear anuncio de cartelera">
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
                <div id="crearanuncioventa" class="modal" title="Crear anuncio de cartelera">
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
                </div>

                <div id="editaranuncioventa" class="modal" title="Editar anuncio de venta">
                    <form class="clearfix" id="editaranuncioventa_form">
                      <table>
                          <tr>
                              <td>
                                <label for="editventanombre">Titulo del anuncio</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="editventanombre" name="editventanombre" value=""/>
                                <input type="hidden" id="editventamongoid" name="editventamongoid" value=""/>
                              </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="editventanotas">Descripción del anuncio</label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <textarea id="editventanotas" name="editventanotas" value=""></textarea> 
                            </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="editventavigencia">Fin de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="editventavigencia" name="editventavigencia"  value=""/>
                              </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="editventavalor">Valor de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="editventavalor" name="editventavalor"  value=""/>
                              </td>
                          </tr>
                          <tr>
                            <td> <label for="editventafoto">Adjunta una foto de tu articulo</label></td>
                            <td colspan="2">
                              <div id="editimage"></div>
                            </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                  <div id="alertas"></div>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                <input type="submit" class="btn icono guardar" value="Editar Anuncio"/>
                              </td>
                          </tr>
                      </table>
                    </form>
                    <div data-alerts="alerts" id ="alertas"></div>
                </div>

                <div id="editaranuncio" class="modal" title="Editar anuncio de venta">
                    <form class="clearfix" id="editaranuncio_form">
                      <table>
                          <tr>
                              <td>
                                <label for="editnombre">Titulo del anuncio</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="editnombre" name="editnombre" value=""/>
                                <input type="hidden" id="editmongoid" name="editmongoid" value=""/>
                              </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="editnotas">Descripción del anuncio</label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3">
                              <textarea id="editnotas" name="editnotas" value=""></textarea> 
                            </td>
                          </tr>
                          <tr>
                              <td>
                                <label for="editvigencia">Fin de la publicación</label>
                              </td>
                              <td colspan="2">
                                <input type="text" id="editvigencia" name="editvigencia"  value=""/>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                  <div id="alertas"></div>
                              </td>
                          </tr>
                          <tr>
                              <td colspan="3">
                                <input type="submit" class="btn icono guardar" value="Editar Anuncio"/>
                              </td>
                          </tr>
                      </table>
                    </form>
                    <div data-alerts="alerts" id ="alertas"></div>
                </div>

                <div id="borraranuncioventa" class="modal" title="Borrar anuncio de venta">
                    <form class="clearfix" id="borraranuncio_form">
                      <table>
                          <tr>
                            <td><h2>Realmente desea borrar el anuncio?</h2></td>
                            <input type="hidden" id="mongoidventa" name="mongoidventa" value="">
                          </tr>
                          <tr>
                            <td colspan="3">
                              <input type="submit" class="btn icono guardar" value="Borrar Anuncio" id="btnborraranuncioventa_form"/>
                            </td>
                          </tr>
                      </table>
                    </form>
                    <div data-alerts="alerts" id ="alertas"></div>
                </div>
                <div id="anuncioBorrar" class="modal" title="Borrar anuncio de cartelera">
                    <form class="clearfix" id="borraranuncio_form">
                      <table>
                          <tr>
                            <td><h2>Realmente desea borrar el anuncio?</h2></td>
                            <input type="hidden" id="mongoid" name="mongoid" value="">
                          </tr>
                          <tr>
                            <td colspan="3">
                              <input type="submit" class="btn icono guardar" value="Borrar Anuncio" id="btnborraranuncio_form"/>
                            </td>
                          </tr>
                      </table>
                    </form>

                <div data-alerts="alerts" id ="alertas"></div>
                </div>
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
