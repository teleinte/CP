<?php include('Pagoclase.php');?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pe:html:30"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/jquery.minicart.js"></script>
<script type="text/javascript" src="sjs/md5-min.js"></script>
<script type="text/javascript" src="sjs/perfil-functions.js"></script>
<script type="text/javascript" src="sjs/confirmar.js"></script>
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
          <h1 class="title" teid="pe:html:50"></h1>
        </div>
        <?php require_once('../template/include/alerts.inc'); ?>
        <div class="divcentrado">
          <div class="centrado">
          <h3 teid="pe:html:51"></h3>
          <br/>
            <table id="copropiedadescart" class="tcheckout">
              <thead>
                <tr>
                  <th></th>
                  <th class="tchcheckout" teid="pe:html:35"></th>
                  <th class="tchcheckout" teid="pe:html:37"></th>
                  <th class="tchcheckout">Descuento</th>
                </tr>
              </thead>
            </table>
            <div class="clearfix"></div>
            <div class="floatright" style="width:100%; text-align:right;">
              <div style="float:right">
              <br/>
              <table>
                <tr>
                  <td style="text-align:right">
                    <h3><span teid="pe:html:39"></span></h3>
                  </td>
                  <td style="text-align:center">
                    <h3><span id="numcop" style="font-weight:bold;" teid="pe:html:43"></span></h3>
                  </td>
                </tr>
                <tr>
                  <td>    
                    <h3><span teid="pe:html:41"></span></h3>
                  </td>
                  <td>
                    <h3><span id="totdes" total="0" style="font-weight:bold; cursor: help;" teid="pe:html:43"></span></h3>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h3><span teid="pe:html:40"></span></h3>
                  </td>
                  <td>
                    <h3><span id="totpag" total="0" style="font-weight:bold;" teid="pe:html:43"></span></h3>
                  </td>
                </tr>
              </table>
                <form id="target" method="post" action="https://gateway.payulatam.com/ppp-web-gateway">
                  <?php
                    $ocultos= new objetoto;
                    $ocultos->construirFormOculto();
                  ?>
                  <input type="button" id="regresar" class="btn icono regresar ttip" teid="pe:val:64"/>
                  <input type="submit" id="pagar" teid="pe:val:42, pe:title:44" class="btn completar icono ttip positivo"/>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Finaliza codigo de la aplicacion -->
        </div>
      </div>
    </section>
  <footer>  
    <?php require_once('../template/include/footer.inc'); ?>
  </footer>
</div>
</body>
</html>