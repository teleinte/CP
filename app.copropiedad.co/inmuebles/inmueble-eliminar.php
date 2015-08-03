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
<script type="text/javascript" src="sjs/inmuebles-eliminar.js"></script>
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
              <div class="titulo-principal"><h1 teid="in:html:76"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <form id="form-inmueble-eliminar">
                <table  style="width:400px!important; margin: auto;">
                    <tr>
                        <td colspan="2">
                          <h4><label teid="in:html:77"></label>
                          <label id="nombremostrar"></label>
                          <label>?</label></h4>
                        </td>
                        <td colspan="2"></td>                   
                    </tr>
                    <tr>
                      <td colspan="2">
                          <select id="opcion" name="opcion" style="width:95%">
                            <option value="NO" teid="in:html:78"></option>
                            <option value="SI" teid="in:html:79"></option>             
                          </select>
                      </td>                               
                    </tr>
                    <tr>
                        <td colspan="4">                                                            
                          <div class="botones-form">
                            <input type="submit" id="btn_enviar" class="btn tooltip positivo" teid="in:val:80, in:title:81">
                          </div>
                            <input type="hidden" id = "id_unidad" name="id_unidad"></input>
                            <input type="hidden" id = "id_copropiedad" name="id_copropiedad"></input>
                            <input type="hidden" id = "id_crm_persona" name="id_crm_persona"></input>
                            <input type="hidden" id = "tipo_documento" name="tipo_documento"></input>
                            <input type="hidden" id = "tipo_unidad" name="tipo_unidad"></input>
                            <input type="hidden" id = "estado" name="estado"></input>
                            <input type="hidden" id = "nombre_inmueble" name="nombre_inmueble"></input> 
                            <input type="hidden" id = "fecha_creacion" name="fecha_creacion"></input>
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
