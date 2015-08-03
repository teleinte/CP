<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pr:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/proveedores-functions.js"></script>
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

            <div class="contenedor mitad">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1 teid="ctp:html:1"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <form id="nuevo-usuario">
                  <table style=" margin: auto;">
                    <tr>
                        <td width="50%"></td>
                        <td width="50%"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="nombre" teid="ctp:html:2"></label>
                        </td>
                        <td>
                          <input type="text" id="nombre" name="nombre" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="apellido" teid="ctp:html:3"></label>
                        </td>
                        <td>
                          <input type="text" id="apellido" name="apellido" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>   
                        <td style="text-align:right;">
                          <label for="telefono" teid="ctp:html:4"></label>
                        </td>
                        <td>
                          <input type="tel" id="telefono" name="telefono" required style="width:85%; padding-right:20px;">
                        </td> 
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for = "email" teid="ctp:html:5"></label>
                        </td>
                        <td>
                          <input type = "email" id="email" name="email" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>                   
                  </table>
                  <div class="botones-form">
                    <input type="submit" teid="ctp:val:6, ctp:title:14" class="btn icono guardar ttip positivo">
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
