<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="ccp:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/copropiedad-functions.js"></script>
<script type="text/javascript" src="sjs/copropiedad-eliminar.js"></script>
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
              <!--<div class="trescolumnas ultima">
                <?php /*require_once('../template/include/copropiedades.inc');*/ ?>
              </div>-->
            </aside>

            <div class="breadcrumb">
              <?php require_once('../template/include/breadcrumbs.inc'); ?>
            </div>

            <div class="contenedor mitad">
              <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1 teid="ccp:html:19"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <form class="clearfix" id="copropiedad_form_editar">
                    <table style="width:400px!important; margin: auto;">
                        <tr>
                            <td colspan="2">
                              <h4 id="nombremostrar" teid="ccp:html:20"></h4>
                            </td>
                            <td colspan="2"></td>  
                        </tr>
                        <tr>
                            <td colspan="2">                                   
                              <select id="opcion" name="opcion">
                                <option value="NO" teid="ccp:html:21"></option>
                                <option value="SI" teid="ccp:html:22"></option>                                  
                              </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                              <input type="hidden" id = "id_crm_persona">
                              <input type="hidden" id = "fecha_creacion">
                              <input type="hidden" id = "nombre">
                              <input type="hidden" id = "direccion">
                              <input type="hidden" id = "telefono">
                              <input type="hidden" id = "nit">
                              <input type="hidden" id = "ciudad">
                              <input type="hidden" id = "referencia">
                              <input type="hidden" id = "vigencia">
                              <input type="hidden" id = "pagosonline">
                              <div class="botones-form">
                                  <input type="submit" class="btn icono guardar ttip positivo" teid="ccp:val:28, ccp:title:26">
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
