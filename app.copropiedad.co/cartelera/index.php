<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="ca:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<link rel="stylesheet" href="scss/estilo.css">
<link rel="stylesheet" href="scss/jquery.cleditor.css">
<script type="text/javascript" src="https://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="sjs/jquery.masonry.min.js"></script>
<script type="text/javascript" src="sjs/imagesloaded.js"></script>
<script type="text/javascript" src="sjs/cartelera-functions.js"></script>
<script type="text/javascript" src="sjs/cartelera.js"></script>
</head>
<body>
  <header>
    <?php require_once("../template/include/header.inc"); ?>
  </header>
      <div id="contenido-principal">
          <section id="central">
              <aside>
                <div class="trescolumnas primera">
                    <?php //require_once('../template/include/newmenu.inc'); ?>
                    <?php //require_once('../template/include/appmenu-1.inc'); ?>
                    <?php require_once('../template/include/backbutton.inc'); ?>
                </div>
                <div class="trescolumnas centro">
                    <?php require_once('../template/include/today.inc'); ?>
                </div>
                <div class="trescolumnas ultima">
                  <?php require_once('../template/include/copropiedades.inc'); ?>
                </div>
              </aside>
              <div class="breadcrumb">
                <?php require_once('../template/include/breadcrumbs.inc'); ?>
              </div>         
                <!-- Codigo de la aplicacion -->
              <div class="contenedor">
                <div class="titulo-principal">
                  <h1 class="title cartelera" teid="ca:html:2"></h1>
                </div>
                <?php require_once('../template/include/alerts.inc'); ?>
                <div class="floatleft"></div>
                <div class="floatright" style="display:inline-block; margin-bottom:5px;">
                  <input type="submit" class="btn ttip" teid="ca:val:3, ca:title:28" id="open-crearanuncio">
                  <input type="submit" class="btn ttip" teid="ca:val:4, ca:title:29" id="open-crearanuncioventa">
                </div>
                <div id="nodata"></div>
              </div>
              <div id="cartelera-board" style="width:100%;">
                <div class="ancho-contenedor"></div>
              </div>
              <div style="display:none;">
                <div id="crearanuncio" class="modal">
                    <form class="clearfix" id="crearanuncio_form">
                      <table>
                        <tr><td width="50%"></td><td width="50%"></td></tr>
                        <tr>
                          <td>
                            <label for="nombre" teid="ca:html:6"></label>
                            <input type="text" id="nombre" name="nombre" required/>
                          </td>
                          <td>
                            <label for="vigencia" teid="ca:html:7"></label>
                            <input type="date" id="vigencia" name="vigencia" style="padding-right:25px; width:89%" required/>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <label for="notas" teid="ca:html:8"></label>
                            <textarea id="notas" name="notas" required></textarea> 
                          </td>
                        </tr>
                      </table>
                      <div class="botones-form" style="text-align: right;"><input type="submit" class="btn icono guardar ttip positivo" teid="ca:val:9, ca:title:28"/></div>
                    </form>
                </div>
                <div id="crearanuncioventa" class="modal">
                    <form class="clearfix" id="crearanuncioventa_form">
                      <table>
                          <tr><td width="50%"></td><td width="50%"></td></tr>
                          <tr>
                            <td colspan="2">
                              <label for="nombreventa" teid="ca:html:11"></label>
                              <input type="text" id="nombreventa" name="nombreventa" required/>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <label for="notasventa" teid="ca:html:12"></label>
                              <textarea id="notasventa" name="notasventa" required></textarea> 
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <label for="vigenciaventa" teid="ca:html:13"></label>
                              <input type="date" id="vigenciaventa" name="vigenciaventa"  style="padding-right:25px; width:89%" required/>
                            </td>
                            <td>
                              <label for="valorventa" teid="ca:html:14"></label>
                              <input type="number" id="valorventa" name="valorventa"  style="padding-right:25px; width:89%" required/>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <div id="fileuploader" class="btn" teid="ca:html:15"></div>
                              <div id="previewFileDiv" style="text-align: center;"><img id="previewFile"/></div><br/>
                              <input type="hidden" id="filepath" name="filepath" value=""/>
                            </td>
                          </tr>
                      </table>
                      <div class="botones-form"><input type="submit" class="btn icono guardar ttip positivo" teid="ca:val:16 , ca:title:29" id="btncrearanuncioventa"/></div>
                    </form>
                </div>
                <div id="editaranuncioventa" class="modal">
                    <form class="clearfix" id="editaranuncioventa_form">
                      <table>
                        <tr><td width="50%"></td><td width="50%"></td></tr>
                          <tr>
                            <td colspan="2">
                              <label for="editventanombre" teid="ca:html:11"></label>
                              <input type="text" id="editventanombre" name="editventanombre" value="" required/>
                              <input type="hidden" id="editventamongoid" name="editventamongoid" value=""/>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <label for="editventanotas" teid="ca:html:12"></label>
                              <textarea id="editventanotas" name="editventanotas" value="" required></textarea> 
                            </td>
                          </tr>
                          <tr>
                          </tr>
                          <tr>
                            <td>
                              <label for="editventavigencia" teid="ca:html:13"></label>
                              <input type="date" id="editventavigencia" name="editventavigencia"  style="padding-right:25px; width:89%" required/>
                            </td>
                            <td>
                              <label for="editventavalor" teid="ca:html:14"></label>
                              <input type="number" id="editventavalor" name="editventavalor"   style="padding-right:25px; width:89%" value="" required/>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div id="editimage" style="height:100px; width:auto;"></div>
                              <input type="hidden" id="filepathedit" name="filepath" value=""/>
                            </td>
                            <td>
                              <div id="fileuploaderedit" class="btn" teid="ca:html:18">
                              </div>
                              <br/>
                              <input type="button" id="filedeleter" teid="ca:val:19"class="btn" style="width:100%"/>
                            </td>
                          </tr>
                      </table>
                      <div class="botones-form">
                            <input type="submit" class="btn icono guardar ttip positivo" teid="ca:val:20, ca:title:30" id="btnEditarAnuncionVenta"/>
                      </div>
                    </form>
                </div>
                <div id="editaranuncio" class="modal">
                    <form class="clearfix" id="editaranuncio_form">
                      <table>
                        <tr><td width="50%"></td><td width="50%"></td></tr>
                          <tr>
                            <td> 
                              <label for="editnombre" teid="ca:html:6"></label>
                              <input type="text" id="editnombre" name="editnombre" value="" required/>
                              <input type="hidden" id="editmongoid" name="editmongoid" value=""/>
                            </td>
                            <td>
                              <label for="editvigencia" teid="ca:html:7"></label>
                              <input type="date" id="editvigencia" name="editvigencia"  value=""  style="padding-right:25px; width:89%" required/>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <label for="editnotas" teid="ca:html:8"></label>
                              <textarea id="editnotas" name="editnotas" value="" required></textarea> 
                            </td>
                          </tr>
                      </table>
                      <div class="botones-form">
                          <input type="submit" class="btn icono guardar ttip positivo" teid="ca:val:20, ca:title:31" id="btnEditarAnuncio"/>
                      </div>
                    </form>
                </div>
                <div id="borraranuncioventa" class="modal">
                    <form class="clearfix" id="borraranuncioventa_form">
                      <h2 teid="ca:html:21"></h2>
                      <input type="hidden" id="mongoidventa" name="mongoidventa" value="">
                      <div class="botones-form">
                        <input type="submit" class="btn icono guardar ttip positivo" teid="ca:val:22 , ca:title:32" id="btnborraranuncioventa_form"/>
                      </div>
                    </form>
                </div>
                <div id="anuncioBorrar" class="modal">
                    <form class="clearfix" id="borraranuncio_form">
                      <h2 teid="ca:html:24"></h2>
                      <input type="hidden" id="mongoid" name="mongoid" value="">
                      <div class="botones-form">
                        <input type="submit" class="btn icono guardar ttip positivo" teid="ca:val:25 , ca:title:33" id="btnborraranuncio_form"/>
                      </div>
                    </form>
                </div>
              </div>
              <!-- Finaliza codigo de la aplicacion -->
          </section>
      <footer>  
        <?php require_once('../template/include/footer.inc'); ?>
      </footer>
    </div>
  </body>
</html>