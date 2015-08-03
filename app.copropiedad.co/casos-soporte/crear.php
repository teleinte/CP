<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="sp:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/casos-soporte-functions.js"></script>
<script type="text/javascript" src="sjs/casos.js"></script>
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
              <div class="titulo-principal"><h1 teid="sp:html:7"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <div id="crearcaso">                 
                <form class="clearfix" id="caso_form">
                  <table>
                      <tr>
                          <td colspan="2"><label teid="sp:html:8"></label><textarea rows="7" id="caso" name="caso" required></textarea></td>
                      </tr>
                       <tr>
                          <td colspan="2"><label teid="sp:html:9"></label><textarea rows="7" id="notas" name = "notas"></textarea></td>                            
                      </tr> 
                      <tr>
                          <td>
                            <div class="botones-form">
                              <input type="submit" id="btn_enviar" class="btn icono guardar ttip positivo" teid="sp:val:10, sp:title:16">
                            </div>
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