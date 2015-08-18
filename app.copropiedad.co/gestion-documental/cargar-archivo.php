<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="gd:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script src="https://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
<script type="text/javascript" src="sjs/gestion-functions.js"></script>
<script type="text/javascript" src="sjs/cargar.js"></script>
<link rel="stylesheet" href="scss/estilo.css">
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
            <div class="contenedor mitad">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1 teid="gd:html:9"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <div>
                  <form class="clearfix" id="uploaddoc">
                    <table>
                        <tr><td width="50%"></td><td width="50%"></td></tr>
                        <tr>
                          <td colspan="2">
                            <label for="nombre" teid="gd:html:10"></label>
                            <input type="text" id="nombre"required/>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <label for="comentario" teid="gd:html:11"></label>
                            <textarea id="comentario" required></textarea> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label for="tipo" teid="gd:html:12"></label>
                            <select id="tipo" required>
                              <option value=""teid="gd:html:17"></option>
                              <option value="acta" teid="gd:html:18"></option>
                              <option value="documentos" teid="gd:html:19"></option>
                              <option value="facturas" teid="gd:html:20"></option>
                              <option value="cotizaciones" teid="gd:html:21"></option>
                              <option value="otros" teid="gd:html:22"></option>
                              <option value="informes" teid="gd:html:37"></option>
                            </select>
                          </td>
                          <td>
                            <div id="fileuploader" class="btn" teid="gd:html:13"> </div>
                            <input type="hidden" id="filepath" name="filepath" value="none"/>
                          </td>
                        </tr>
                        <tr>
                          <td>
                           <label for="invitados" teid="gd:html:38"></label>
                            <select id="invitados" name="invitados">
                              <option value="ninguno" teid="cl:html:51"></option>
                              <option value="asamblea" teid="cl:html:52"></option>
                              <option value="consejo" teid="cl:html:53"></option>
                              <option value="residente" teid="cl:html:54"></option>
                            </select>
                          </td>
                          <td>
                            <label value="odestinatario" teid="cl:html:55"></label>
                            <input type="email" multiple id="odestinatario" name="odestinatario" pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$"/>
                          </td>
                        </tr>
                    </table>
                    <div class="botones-form">
                      <input type="submit" class="btn icono guardar ttip positivo" id="btncrearanuncioventa" teid="gd:val:14, gd:title:26"/>
                    </div>
                  </form>
                </div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
