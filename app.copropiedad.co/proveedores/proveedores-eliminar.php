<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pr:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/proveedores-functions.js"></script>
<script type="text/javascript" src="sjs/proveedores-eliminar.js"></script>
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
              <div class="titulo-principal">
                <h1 teid="pr:html:29"></h1>
              </div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <form id="usuario_form_eliminar">
                  <table style="width:400px!important; margin: auto;">
                    <tr>
                        <td colspan="2">
                          <h4><label teid="pr:html:30"></label>
                          <label id="nombremostrar"></label>
                          <label>?</label></h4>
                        </td>
                        <td colspan="2"></td>                                                                
                    </tr>
                    <tr>
                      <td colspan="2">
                          <select id="opcion" name="opcion" style="width:95%">
                            <option value="NO" teid="pr:html:31"></option>
                            <option value="SI" teid="pr:html:32"></option>                                  
                          </select>
                      </td>                              
                    </tr>
                    <tr>
                      <td colspan="4">
                        <input type = "hidden" id="id_copropiedad" name="id_copropiedad">
                        <input type = "hidden" id="id_crm_persona" name="id_crm_persona">                        
                        <input type = "hidden" id="tipo_documento" name="tipo_documento">                        
                        <input type = "hidden" id="tipo_unidad" name="tipo_unidad">                        
                        <input type = "hidden" id="nombre_inmueble" name="nombre_inmueble">                        
                        <input type = "hidden" id="estado" name="estado">
                        <input type = "hidden" id="fecha_creacion" name="fecha_creacion">
                        <div class="botones-form">
                        <input type="submit" id="btn_enviar" teid="pr:val:34, pr:title:33" class="btn icono guardar ttip positivo">
                      </div>
                      </td>
                    </tr>
                  </table>
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
