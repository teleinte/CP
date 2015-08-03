<?php include('Pagosclase.php');?>
  
<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pa:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/md5-min.js"></script>
<script type="text/javascript" src="sjs/jquery.print.js"></script>
<script type="text/javascript" src="sjs/pagosonline-functions.js"></script>
<script type="text/javascript" src="sjs/newpagos.js"></script>
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
                  <div class="titulo-principal"><h1 class="title tareas" teid="pa:html:10"></h1></div>
                    <?php require_once('../template/include/alerts.inc'); ?>
                      <div style="width:350px; margin: 0px auto;">
                          <form id="pagos_form" method="post" action="https://stg.gateway.payulatam.com/ppp-web-gateway">
                              <?php
                              $ocultos=new Pago;
                              $ocultos->construirFormOculto();
                              ?>
                              <table>
                                  <tr>
                                      <td teid="pa:html:11"></td>
                                      <td id="mostrarNom"></td>
                                  </tr>
                                  <tr>
                                      <tr>
                                          <td teid="pa:html:12"></td>
                                          <td id="mostrarCop"></td>
                                      </tr>
                                  </tr>
                                  <tr>
                                      <tr>
                                          <td teid="pa:html:13"></td>
                                          <td><input id="description" name="description" type="text" required><br></td>
                                      </tr>
                                  </tr>
                                  <tr>
                                      <tr>
                                          <td><label teid="pa:html:14"></label></td>
                                          <td><input id="amount" name="amount" type="text" required><br></td>
                                      </tr>
                                  </tr>
                                  <tr>
                                      <tr>
                                          <td><label teid="pa:html:15, pa:title:47"></label></td>
                                          <td><input id="buyerEmail" name="buyerEmail" type="text" required><br></td>
                                      </tr>
                                  </tr><br>
                                  <tr>
                                      <tr>
                                          <td></td>
                                          <td><input type="submit" name="Submit" class="ttip positivo" teid="pa:val:16, pa:title:46"></td>
                                          <td></td>
                                      </tr>
                                  </tr>
                              </table>
                          </form>
                      </div>
                    <div id="alertas"></div>
              </div>
            </section>
        </div>
    </body>
</html>

