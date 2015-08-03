<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pr:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/proveedores-functions.js"></script>
<script type="text/javascript" src="sjs/proveedores-editar.js"></script>
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
              <div class="titulo-principal"><h1 teid="pr:html:17"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <form id="form-cliente-editar">
                <table id="form-encuesta-pr">
                  <tr>
                    <td width="50%"></td>
                    <td width="50%"></td>
                  </tr>
                  <tr>
                    <td>
                      <label for="nombre_inmueble"teid="pr:html:7"></label>
                      <input type="text" id = "nombre_inmueble" name="nombre_inmueble" required></input>
                      <input type="hidden" id = "id_unidad" name="id_unidad"></input>
                      <input type="hidden" id = "id_copropiedad" name="id_copropiedad"></input>
                      <input type="hidden" id = "id_crm_persona" name="id_crm_persona"></input>
                      <input type="hidden" id = "tipo_documento" name="tipo_documento"></input>
                      <input type="hidden" id = "tipo_unidad" name="tipo_unidad"></input>
                      <input type="hidden" id = "estado" name="estado"></input>                      
                      <input type="hidden" id = "fecha_creacion" name="fecha_creacion"></input>
                    </td>                    
                    <td>
                      <div class="botones-form">
                        <input type="submit" class="btn icono guardar ttip positivo" teid="pr:val:15, pr:title:28"/>
                      </div>
                    </td>
                  </tr>

                </table>
              </form>
            </div>
            <div class="contenedor">
              <div class="titulo-principal"><h1 class="title encuestas" teid="pr:html:18"></h1></div>
              <table id="contactos_tabla" class="stripe" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th teid="pr:html:19"></th>                                      
                      <th teid="pr:html:20"></th>                          
                      <th teid="pr:html:21"></th>                          
                      <th teid="ta:html:21"></th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>                                      
            </div>
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
