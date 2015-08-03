<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="vo:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/encuestas-functions.js"></script>
<script type="text/javascript" src="sjs/editar-pregunta.js"></script>
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
            <div class="titulo-principal"><h1 class="title encuestas" teid="vo:html:67"></h1></div>
            <?php require_once('../template/include/alerts.inc'); ?>
              <div class="clearfix">
                 <form class="clearfix" id="form-elmina-pregunta"> 
                  
                  <div class="titulo-principal"><h1 class="title tareas" teid="vo:html:68"></h1></div>
                    <div class="clearfix">
                     <table style="width:400px!important; margin: auto;">
                          <tr>
                                <td colspan="2"><h4 id="nombremostrar" teid="vo:html:69"></h4></td>
                                <td colspan="2"></td>                                                                
                            </tr>
                            <tr>
                              <td colspan="2">
                                  <select id="opcion" name="opcion">
                                    <option value="NO" teid="vo:html:70"></option>
                                    <option value="SI" teid="vo:html:71"></option>                                  
                                  </select>
                              </td>                              
                            </tr>
                            <tr>
                              <td colspan="4">                                
                                <input type="hidden" id = "id_encuesta">
                                <input type="hidden" id = "enunciado_pregunta0">
                                <input type="hidden" id = "tipo_pregunta0">
                                <input type="hidden" id = "opciones_pregunta0">
                                <div class="botones-form"><input type="submit" id="btn_enviar" teid="vo:html:72" value="" class="btn icono guardar ttip positivo"></div>
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