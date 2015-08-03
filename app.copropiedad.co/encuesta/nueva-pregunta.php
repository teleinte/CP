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
<script type="text/javascript" src="sjs/editar-encuestas.js"></script>
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
              <h1 class="title encuestas" teid="en:html:49"></h1>
            </div>
            <?php require_once('../template/include/alerts.inc'); ?>
              <div class="clearfix">
                <form id="form-pregunta-nueva">
                  <table>
                      <tr>
                        <td>
                          <label for="enunciado_pregunta0" teid="en:html:86"></label>
                        </td>
                        <td>
                          <input type=text class="input" id="enunciado_pregunta0" name="enunciado_pregunta0" required/></td>
                        <td>
                          <label for="tipo_pregunta0" teid="en:html:18"></label>
                        </td>
                        <td>
                          <select id="tipo_pregunta0" name="tipo_pregunta0">
                            <option value="seleccion_multiple_unica_respuesta" teid="en:html:19"></option>
                            <option value="seleccion_multiple_multiple_respuesta" teid="en:html:20"></option>
                            <option value="abierta" teid="en:html:21"></option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td  width="50%" colspan="2">
                          <label for="opciones_pregunta0" teid="en:html:24"></label>
                        </td>
                        <td class="opciones" colspan="2">
                          <textarea id="opciones_pregunta0" rows="4"></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td  width="50%" colspan="2">
                          <label for="obligatoria0" teid="en:html:50"></label>
                        </td>
                        <td class="opciones" colspan="2"><span teid="en:html:23"></span><input id="obligatoria0" type="checkbox" checked>
                        </td>
                      </tr>
                    </table>
                      </div>
                    <div class="botones-form">
                      <input type="submit" class="btn icono guardar ttip positivo" teid="en:val:51, en:title:32"/>
                      <input type="hidden" id="id_encuesta" value=""/>
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