<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pe:html:30"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<link rel="stylesheet" src="scss/style.css">
<script type="text/javascript" src="sjs/jquery.minicart.js"></script>
<script type="text/javascript" src="sjs/perfil-functions.js"></script>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/pagos.js"></script>
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
          <h1 class="title"  teid="pe:html:31"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
        <!--<div class="titulo-principal">
          <h2 id="referalcode"></h2>
        </div>-->
        <div class="titulo-principal">
          <h1 class="title"  teid="pe:html:34"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
        <!--<div class="divcentrado">
          <div class="centrado">-->
            <table id="copropiedadescart" class="tcheckout" style="text-align:center;">
              <thead>
                <tr>
                  <th></th>
                  <th class="tchcheckout" teid="pe:html:35"></th>
                  <th class="tchcheckout">Referencia</th>
                  <th class="tchcheckout" teid="pe:html:36"></th>
                  <th class="tchcheckout" teid="pe:html:37"></th>
                  <th class="tchcheckout" teid="pe:html:38"></th>
                  <th class="tchcheckout">Descuento</th>
                </tr>
              </thead>
            </table>
            <div class="clearfix"></div>
            <div class="floatleft" style="text-align: left; width:48%;">
                <div style="float:right"></div>
            </div>
            <div class="floatright" style="width:60%; text-align:right;">
              <div style="float:right">
              <br/>
              <table>
                <tr>
                  <td style="text-align:right">  
                    <h3><span teid="pe:html:39"></span></h3>
                  </td>
                  <td style="text-align:left">
                    <h3><span id="numcop" style="font-weight:bold;" teid="pe:html:43"></span></h3>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h3><span teid="pe:html:41"></span><!--<span class="btn promo" title="Renuevas 5 o mas copropiedades">?</span>&nbsp;--></h3>
                  </td>
                  <td style="text-align:left">
                    <h3><span id="totdes" total="0" style="font-weight:bold; cursor: help;" teid="pe:html:43"></span></h3>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h3><span teid="pe:html:40"></span></h3>
                  </td>
                  <td style="text-align:left">
                    <h3><span id="totpag" total="0" style="font-weight:bold;" teid="pe:html:43"></span></h3>
                  </td>
                </tr>
              </table>
                <div class="botones-form">
                  <input type="submit" id="pagar" link=""  teid="pe:val:42, pe:title:44" class="btn ttip positivo"/>
                </div>
              </div>
            </div>
          <!--</div>
        </div>-->
        </div>
            <!-- Finaliza codigo de la aplicacion -->
      </div>
    </section>
  <footer>  
    <?php require_once('../template/include/footer.inc'); ?>
  </footer>
</div>
</body>
</html>