<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="tar:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/tareas-functions.js"></script>
<script type="text/javascript" src="sjs/tareas.js"></script>
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
            <div class="contenedor">
              <!-- Codigo de la aplicacion -->
                  <div class="titulo-principal"><h1 teid="tar:html:2"></h1></div>
                    <table id="tareas" class="stripe" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th teid="tar:html:3"></th>
                                <th teid="tar:html:4"></th>
                                <th teid="tar:html:5"></th>
                                <th>Estado</th>
                                <th teid="ta:html:1"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="dialog_eliminar" style="display:none">
                  <h3 teid="tar:html:37"></h3>
                  <form>
                    <input type="hidden" id="elmongoid" value=""/>
                    <input type="hidden" id="elcreacion" value=""/>
                    <input type="hidden" id="elnombre" value=""/>
                    <input type="hidden" id="eldeadline" value=""/>
                    <input type="hidden" id="elfrecuencia" value=""/>
                    <input type="hidden" id="elnotas" value=""/>
                  </form>
                </div>
                <div id="dialog_completar" style="display:none">
                  <h3 teid="tar:html:38"></h3>
                  <input type="hidden" id="comongoid" value=""/>
                  <input type="hidden" id="cocreacion" value=""/>
                  <input type="hidden" id="conombre" value=""/>
                  <input type="hidden" id="codeadline" value=""/>
                  <input type="hidden" id="cofrecuencia" value=""/>
                  <input type="hidden" id="conotas" value=""/>
                </div>
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
