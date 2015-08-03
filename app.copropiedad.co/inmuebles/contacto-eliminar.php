<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="in:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/inmuebles-functions.js"></script>
<script type="text/javascript" src="sjs/contacto-eliminar.js"></script>
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
              <div class="titulo-principal"><h1 teid="ct:html:10"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <form id="usuario_form_eliminar">
                  <table  style="width:400px!important; margin: auto;">
                    <tr>
                        <td colspan="2">
                          <h4><label teid="ct:html:14"></label>
                          <label id="nombremostrar"></label>
                          <label>?</label></h4>
                        </td>
                        <td colspan="2"></td>                   
                    </tr>
                    <tr>
                      <td colspan="2">
                          <select id="opcion" name="opcion" style="width:95%">
                            <option value="NO" teid="ct:html:11"></option>
                            <option value="SI" teid="ct:html:12"></option>             
                          </select>
                      </td>                               
                    </tr>
                    <tr>
                        <td colspan="4">                                
                          <input type = "hidden" id="nombre" name="nombre">
                          <input type = "hidden" id="telefono" name="telefono">
                          <input type = "hidden" id="email" name="email">
                          <input type = "hidden" id="grupo" name="id_usuario">
                          <input type = "hidden" id="id_usuario" name="id_usuario">
                          <input type = "hidden" id="creado_por" name="creado_por">
                          <input type = "hidden" id="fecha_creacion" name="fecha_creacion">
                          <input type = "hidden" id="id_copropiedad" name="id_copropiedad">
                          <input type = "hidden" id="id_crm_persona" name="id_crm_persona">
                          <input type = "hidden" id="unidad" name="unidad">
                          <input type = "hidden" id="estado" name="estado">
                          <input type = "hidden" id="tipo" name="tipo">
                          <input type = "hidden" id="principal" name="principal">
                          <input type = "hidden" id="perfil" name="perfil">
                          <div class="botones-form">
                            <input type="submit" id="btn_enviar" class="btn icono guardar tooltip positivo" teid="ct:val:13, ct:title:16">
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
