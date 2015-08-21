<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pr:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/proveedores-functions.js?v=2.0"></script>
<script type="text/javascript" src="sjs/proveedores-crear.js?v=2.0"></script>
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

            <div class="contenedor">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1 teid="pr:html:6"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <form id="proveedor_form">
              <table id="form-encuesta-cl"> 
                <tr>                               
                  <td>
                    <label for="identificador" teid="pr:html:48"></label>
                    <input type="text" id = "nombre_inmueble" name="nombre_inmueble" size="60" required></input>                    
                  </td>
                  <td>
                    <label for="nit" teid="pr:html:62"></label>
                    <input type="number" id = "nit" name="nit" size="60" required></input>                    
                  </td>                              
                </tr>                            
                <tr>
                  <td colspan="0" teid="pr:html:8"><br><br><br></td>
                </tr>
              </table>
              <div id="usuarioprincipal">
                <div id="pregunta0" class="clearfix" style="padding: 20px 10px 0; border:3px solid #eee; margin-bottom:10px;">                  
                  <table>
                    <tr>
                        <td>
                          <label for="nombre0" teid="pr:html:9"></label>
                          <input type="text" id="nombre0" name="nombre0" required>
                        </td>
                        <td>
                          <label for="apellido0" teid="pr:html:10"></label>
                          <input type="text" id="apellido0" name="apellido0" required>
                        </td>
                        <td>
                          <label for="telefono0" teid="pr:html:11"></label>
                          <input type="tel" id="telefono0" name="telefono0" required>
                        </td>                                    
                        <td>
                          <label for = "email0" teid="pr:html:12"></label>
                          <input type = "email" id="email0" name="email0" required>
                        </td>                        
                    </tr>
                  </table>
                </div>
              </div>
              <div class="botones-form">
                <input type="button" teid="pr:val:14, pr:title:25" id="btRemove" class="btn icono borrar ttip" style="margin-bottom:10px;"/>
                <input type="button" teid="pr:val:13, pr:title:24" id="btAdd" class="btn icono agregar ttip positivo" style="margin-bottom:10px;"/>
              </div>
              <div class="botones-form">
                <input type="submit" teid="pr:val:15, pr:title:26" class="btn icono guardar ttip positivo"/>                
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
