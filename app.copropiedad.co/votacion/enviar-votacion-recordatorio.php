<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="vo:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/votaciones-functions.js?v=1.0"></script>
<script type="text/javascript" src="sjs/recordar-votaciones.js?v=1.0"></script>
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
              <h1 class="title encuestas" teid="vo:html:74"></h1>
            </div>
            <?php require_once('../template/include/alerts.inc'); ?>
              <div class="clearfix">
                <form id="form-envio-encuesta" class="clearfix">
                        <table width='90%'>
                            <tr>
                                <td width='30%'>
                                    <label for="asunto" teid="en:html:61"></label>
                                </td>
                                <td colspan="3">
                                    <input type="text" value="" id="asunto" name="asunto" Disabled/>
                                </td>
                            </tr>
                             <tr>
                                <td>
                                    <label for="mensaje" teid="en:html:62"></label>
                                </td>
                                <td colspan="3">
                                    <textarea rows="5" id="mensaje" name="mensaje" required></textarea>
                                    <input type="hidden" id="id_encuesta">
                                    <input type="hidden" id="fechaFin">
                                    <input type="hidden" id="metodo">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">                                    
                                    <div class="botones-form">
                                      <input type="submit" id ="mastarde" class="btn icono actualizar ttip" teid="en:val:82, en:title:83"/>
                                      <input type="submit" class="btn icono guardar ttip positivo" value="Enviar Recordatorio"/>
                                    <div>
                                </td>                                
                            </tr>
                        </table>
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