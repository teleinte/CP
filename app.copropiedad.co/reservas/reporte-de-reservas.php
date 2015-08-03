<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="re:html:50"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/reservas-functions.js"></script>
<script type="text/javascript" src="sjs/reporte.js"></script>
<script type="text/javascript" src="sjs/jquery.print.js"></script>
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
          <div class="titulo-principal">
            <h1 class="title calendario" teid="re:html:46"></h1>
          </div>
          <?php require_once('../template/include/alerts.inc'); ?>
          <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
            <div class="floatleft" style="display:inline;" id="control">
              <span style="display:inline;" teid="re:html:92"></span>
              <select id="ddrecursos" style="display:inline;" required/>
              </select>
              <input type="date" id="fechainicio" name="fechainicio" value="" required/>
              <input type="date" id="fechafin" name="fechafin" value="" required/>    
              <input type="submit" class="btn ttip positivo" teid="re:val:48, re:title:98" id="btnreportereservas"/>
            </div>
          </div>
          <div id="reporte-table">
            <div id="reporte-title"><br/><br/></div>
            <div id="consolidado2"></div>
            <h2 style="text-align:center" teid="re:html:121"></h2>
            <div><br/></div>

              <table id="listareporte" class="stripe" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th teid="re:html:99"></th>
                          <th teid="re:html:100"></th>
                          <th teid="re:html:101"></th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
          <div id="consolidado" style="margin:10px auto 0px auto; width:450px;"></div>
         <!-- Finaliza codigo de la aplicacion -->
      </div>
      </section>
      <footer>  
        <?php require_once('../template/include/footer.inc'); ?>
      </footer>
  </div>
</body>
</html>