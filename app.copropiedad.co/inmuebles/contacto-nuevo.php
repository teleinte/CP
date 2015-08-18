<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="in:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/inmuebles-functions.js"></script>
<script type="text/javascript" src="sjs/contacto-nuevo.js"></script>
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

            <div class="contenedor mitad" >
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1><span teid="in:html:27"></span><span id="inmueble_name"></span></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <form id="nuevo-usuario" >
                  <table style="width:100%;">
                    <tr><td width="50%"></td><td width="50%"></td></tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="nombre" teid="in:html:9"></label>
                        </td>
                        <td>
                          <input type="text" id="nombre" name="nombre" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="apellido" teid="in:html:10"></label>
                        </td>
                        <td>
                          <input type="text" id="apellido" name="apellido" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for = "email" teid="in:html:12"></label>
                        </td>
                        <td>
                          <input type = "email" id="email" name="email" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="telefono" teid="in:html:11"></label>
                        </td>
                        <td>
                          <input type="tel" id="telefono" name="telefono" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>   
                        <td style="text-align:right;">
                          <label for="grupo" teid="in:html:13"><img src="../template/images/tooltip.png" class="tooltip ttip" data-hasqtip="0" teid="in:title:58" aria-describedby="qtip-0"></label>
                        </td>
                        <td>
                          <select name="grupo" id="grupo" style="width:95%; padding-right:20px;">                                    
                              <option value="residente"teid="in:html:14"></option>
                              <option value="asamblea" teid="in:html:16"></option>
                              <option value="consejo" teid="in:html:15"></option>
                          </select>                        
                        </td>
                    </tr>
                  </table>
                  <div class="botones-form">
                    <input type="submit" class="btn icono guardar ttip positivo" teid="in:val:20, in:title:32">
                  </div>
                </form>
            </div>            
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
