<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="en:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/encuestas-functions.js"></script>
<script type="text/javascript" src="sjs/eliminar-encuesta.js"></script>
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
            <div class="titulo-principal">
            <h1 class="title encuestas" teid="en:html:76"></h1>
            </div>
            <?php require_once('../template/include/alerts.inc'); ?>
              <div class="clearfix">
                 <form class="clearfix" id="encuesta_form_eliminar">
                     <table style="width:400px!important; margin: auto;">
                          <tr>
                                <td colspan="2">
                                  <h4 id="nombremostrar" teid="en:html:77"></h4>
                                </td>
                                <td colspan="2"></td>                                                                
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <select id="opcion" name="opcion">
                                    <option value="NO" teid="en:html:31"></option>
                                    <option value="SI" teid="en:html:30"></option>                                  
                                  </select>
                              </td>                              
                          </tr>
                          <tr>
                              <td colspan="4">
                                <input type="hidden" id = "_id" >
                                <input type="hidden" id = "id_copropiedad" >
                                <input type="hidden" id = "id_crm_persona" >
                                <input type="hidden" id = "fecha_creacion" >
                                <input type="hidden" id = "tipo" >
                                <input type="hidden" id = "fecha_fin" >
                                <input type="hidden" id = "nombre" >
                                <input type="hidden" id = "descripcion" >
                                <input type="hidden" id = "estado" >
                                <input type="hidden" id = "invitados" >
                                <input type="hidden" id = "invitados_externos" >
                                <div class="botones-form">
                                  <input type="submit" id="btn_enviar" teid="en:val:78, en:title:79" class="btn icono guardar ttip">
                                </div>
                              </td>
                          </tr>
                        </table>
                    </div>
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