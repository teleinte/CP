<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pr:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/proveedores-functions.js"></script>
<script type="text/javascript" src="sjs/contacto-editar.js"></script>
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
              <div class="titulo-principal"><h1 teid="ctp:html:7" id="mostrador"</h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <form id="modificar-usuario">
                  <table style=" margin: auto;">
                    <tr>
                        <td style="text-align:right; margin: auto;">
                          <label for="nombre" teid="ctp:html:2"></label>
                        </td>
                        <td>
                          <input type="text" id="nombre" name="nombre" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>                                      
                        <td style="text-align:right; margin: auto;">
                          <label for="telefono" teid="ctp:html:4"></label>
                        </td>
                        <td>
                          <input type="text" id="telefono" name="telefono" required style="width:85%; padding-right:20px;">
                        </td> 
                    </tr>
                    <tr>                                     
                        <td style="text-align:right; margin: auto;">
                          <label for = "email" teid="ctp:html:5"></label>
                        </td>
                        <td>
                          <input type = "text" id="email" name="email" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>                                       
                        <td style="text-align:right;">
                          <input type = "hidden" id="id_usuario" name="id_usuario">
                          <input type = "hidden" id="unidad" name="unidad">
                          <input type = "hidden" id="creado_por" name="creado_por">
                          <input type = "hidden" id="fecha_creacion" name="fecha_creacion">
                          <input type = "hidden" id="id_copropiedad" name="id_copropiedad">
                          <input type = "hidden" id="id_crm_persona" name="id_crm_persona">                          
                          <input type = "hidden" id="estado" name="estado">
                          <input type = "hidden" id="perfil" name="perfil">
                          <input type = "hidden" id="tipo" name="tipo">
                        </td>
                      <td colspan ="2"><br><br></td>
                    </tr>
                  
                  </table>
                  <div class="botones-form">
                    <input type="submit" class="btn icono guardar ttip positivo" teid="ctp:val:6, ctp:title:15">
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
