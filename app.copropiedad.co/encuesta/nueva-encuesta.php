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
<script type="text/javascript" src="sjs/crear-encuestas.js"></script>
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
                    <h1 class="title encuestas"teid="en:html:12"></h1>
                  </div>
                  <?php require_once('../template/include/alerts.inc'); ?>
                    <div class="clearfix">
                      <form id="form-encuesta">
                          <table id="form-encuesta-pr">
                            <tr>
                              <td>
                                <label for="nombre" teid="en:html:13"></label>
                                <input type="text" id="nombre" name="nombre" required/>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label for="descripcion" teid="en:html:14"></label>
                                <textarea rows="3" id="descripcion" name="descripcion" required></textarea>
                              </td>
                            </tr>                          
                            <tr>
                              <td>
                                <label for="datepicker" teid="en:html:15"></label>
                                <input type="date" id="datepicker" name="datepicker" required/>
                              </td>
                            </tr>
                          </table>

                          <h2 teid="en:html:16"></h2>
                          <div id="pregunta0" class="clearfix" style="padding: 10px 10px 0; border:2px solid #aaa; margin-bottom:10px; background-color:#eee;">
                            <table>
                              <tr style="max-height: 3px; min-height: 3px;"><td width="33%"></td><td width="34%"></td><td width="33%"></td></tr>
                              <tr>
                                <td>
                                  <label for="enunciado-pregunta0" teid="en:html:17"></label>
                                  <input type=text class="input" id="enunciado-pregunta0" name="enunciado-pregunta0" required/>
                                </td>
                                <td>
                                  <label for="tipo-pregunta0" teid="en:html:18"></label>
                                  <select id="tipo-pregunta0" name="tipo-pregunta0" class="tipo-preg">
                                    <option value="seleccion_multiple_unica_respuesta" teid="en:html:19"></option>
                                    <option value="seleccion_multiple_multiple_respuesta" teid="en:html:20"></option>
                                    <option value="abierta" teid="en:html:21"></option>
                                  </select>
                                </td>
                                <td class="opciones">
                                    <label for="obligatoria0" teid="en:html:22"></label>
                                    <input id="obligatoria0" type="checkbox" checked><span teid="en:html:23"></span>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="3">
                                  <label for="opciones-pregunta0" teid="en:html:24"></label>
                                  <textarea id="opciones-pregunta0" rows="4" required></textarea>
                                </td>
                              </tr>
                            </table>
                          </div>
                          <div class="botones-form">
                            <input type="button" id="btRemove" class="btn icono borrar ttip" teid="en:val:26, en:title:33" style="margin-bottom:10px;"/>                            
                            <input type="button" id="btAdd" class="btn icono agregar ttip positivo" teid="en:val:25, en:title:32" style="margin-bottom:10px;"/>
                          </div>
                          <div class="botones-form">                           
                            <input type="submit" class="btn icono guardar ttip positivo" teid="en:val:27, en:title:34"/>                            
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