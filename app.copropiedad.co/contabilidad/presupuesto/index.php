<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>

</head>
<body>
<header>
  <?php require_once("../../template/include/header.inc"); ?>
  <script type="text/javascript" src="../../template/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../../template/js/dataTables.colVis.min.js"></script>
  <script type="text/javascript" src="../../template/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="../sjs/puc.js"></script>
  <script type="text/javascript" src="js/presupuesto.js"></script>
</header>
    <div id="contenido-principal">
        <section id="central">
            <aside>
              <div class="trescolumnas primera">
                  <?php //require_once('../template/include/newmenu.inc'); ?>
                  <?php //require_once('../template/include/appmenu-1.inc'); ?>
                  <?php require_once('../../template/include/backbutton.inc'); ?>
              </div>
              <div class="trescolumnas centro">
                  <?php require_once('../../template/include/today.inc'); ?>
              </div>
              <div class="trescolumnas ultima">
                <?php require_once('../../template/include/copropiedades.inc'); ?>
              </div>
            </aside>
            <div class="breadcrumb">
              <?php require_once('../../template/include/breadcrumbs.inc'); ?>
            </div>         
            <div class="contenedor">
            <!-- Codigo de la aplicacion -->
              <div class="titulo-principal"><h1 teid="co:html:238"></h1></div>
              <div class="centrado">
                    <h3 teid="co:html:239"></h3>
                    <div style="margin:10px;">
                      <input id="incremento" type="range" min="0" max="10" value="1" step="0.1" style="width:300px;" list="steps"/><br/>
                      <div style="width:100%;" id="numero"><h2 teid="co:html:240"></h2></div>
                      <datalist id="steps"><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option></datalist>
                    </div>
                    <br/>
                    <table class="tpresupuesto" id="presupuesto" align="center" valign="middle">
                      <tr>
                        <th class="tchpresupuesto" teid="co:html:241"></th>
                        <th class="tchpresupuesto" teid="co:html:242"></th>
                        <th class="tchpresupuesto" teid="co:html:243"></th>
                        <th class="tchpresupuesto" teid="co:html:244"></th>
                        <th class="tchpresupuesto" teid="co:html:245"></th>
                      <tr>
                    </table>

                    <a href="../" class="btn" id="regresar" teid="co:html:246, co:title:249"> </a>&nbsp;<input type="button" class="btn" id="generar" teid="co:val:247, co:title:250"/>&nbsp;<input type="button" class="btn" id="generar" teid="co:val:248, co:title:251"/>
                  </div>
            
            </div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
