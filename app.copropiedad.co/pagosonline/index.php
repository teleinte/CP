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
<script type="text/javascript" src="sjs/pagosonline-functions.js"></script>
<script type="text/javascript" src="sjs/pagosonline.js"></script>
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
                    <h1 class="title tareas" teid="pa:html:2"></h1>
                  </div>
                  <?php require_once('../template/include/alerts.inc'); ?>
                  <div id="cuerpoaplicacion">
                    <table id="pagostable" class="stripe" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th></th>
                              <th teid="pa:html:3"></th>
                              <th teid="pa:html:4"></th>
                              <th teid="pa:html:5"></th>
                              <th teid="pa:html:6"></th>
                              <th teid="pa:html:7"></th>
                              <th teid="pa:html:8"></th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>
                <div class="contenedor mitad niveldos">
                  <div class="aplicaciones">
                    <h2 teid="pa:html:48"></h2>
                    <p teid="pa:html:49"></p>
                    <p><span teid="pa:html:50"></span><a href="http://www.payu.com.co/tarifas" teid="pa:html:51" target="_blank"></a></p>

                    <p teid="pa:html:52"></p>

                    <h3 teid="pa:html:53"></h3>
                    <p><span teid="pa:html:54"></span><a href="https://secure.payulatam.com/online_account/512157/create_account.html" teid="pa:html:55" target="_blank"></a></p>
                    <p teid="pa:html:56"></p>

                    <h3 teid="pa:html:57"></h3>
                    <p teid="pa:html:58"></p>
                    <div class="botones-form">
                      <a class="btn big niveldos ttip positivo" teid="pa:html:32, pa:title:61" href="credenciales.php"></a>
                    </div>
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
