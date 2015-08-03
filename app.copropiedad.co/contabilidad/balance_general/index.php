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
  <script type="text/javascript" src="sjs/bpruebas.js?v=1.0"></script>
  <script type="text/javascript" src="sjs/bpruebas-funtions.js?v=1.0"></script>
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
            <div class="titulo-principal"><h1 teid="co:html:93"></h1></div>
            <?php require_once('../../template/include/alerts.inc'); ?>
            <div class="centrado">
              <h2 teid="co:html:189"></h2>
                <select id="nivel" name="nivel">  
                  <option value="1" teid="co:html:191"></option>
                  <option value="2" teid="co:html:192"></option>
                  <option value="3" teid="co:html:193"></option>
                  <option value="4" teid="co:html:194"></option>
                  <option value="5" teid="co:html:195"></option>
                </select><br/>
                <div style="width:600px; margin:0 auto;">
                  <table width="100%">
                    <tr><td width="50%"></td><td width="50%"></td></tr>
                    <tr>
                      <td style="text-align:right">
                        <input type="hidden" id="mesi" value=""/>
                        <input type="hidden" id="anoi" value=""/>
                        <label for="mesf"  teid="co:html:256"></label>
                        <select id="mesf" name="mesf">  
                          <option value="01">1</option>
                          <option value="02">2</option>
                          <option value="03">3</option>
                          <option value="04">4</option>
                          <option value="05">5</option>
                          <option value="06">6</option>
                          <option value="07">7</option>
                          <option value="08">8</option>
                          <option value="09">9</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                        </select>
                      </td>
                      <td style="text-align:left">
                        <label for="anof"  teid="co:html:255"></label>
                        <select id="anof" name="anof">  
                          <option value="2013">2013</option>
                          <option value="2014">2014</option>
                          <option value="2015" selected>2015</option>
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                        </select>
                      </td>
                    </tr>
                  </table>
                </div>
                <br/><input type="button" class="btn ttip positivo" id="generar" teid="co:val:94, co:title:209" />
            </div>
            <!-- Finaliza codigo de la aplicacion -->
            </div>
        </section>
        <footer>  
          <?php require_once('../../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
