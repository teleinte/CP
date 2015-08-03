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
<script type="text/javascript" src="sjs/credenciales.js"></script>
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
                  <h1 class="title tareas" teid="pa:html:33"></h1>
                </div>
                <?php require_once('../template/include/alerts.inc'); ?>
                <div style="width:300px; margin:0 auto;">
                  <form class="clearfix" id="pagos_info_form">
                    <table>
                        <tr>
                          <td>
                            <label for="nombre" teid="pa:html:34"></label>
                            <input type="text" id="nombre" name="nombre" required>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label for="apikey" teid="pa:html:35"></label>
                            <input type="text" id="apikey" name="apikey" required>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label for="apikey_login" teid="pa:html:36"></label>
                            <input type="text" id="apikey_login" name="apikey_login" required>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label for="llave_publica" teid="pa:html:37"></label>
                            <input type="text" id="llave_publica" name="llave_publica" required>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label for="merchantId" teid="pa:html:38"></label>
                            <input type="text" id="merchantId" name="merchantId" required>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label for="accountId" teid="pa:html:39"></label>
                            <input type="text" id="accountId" name="accountId" required>
                            <input type="hidden" id="tipo" name="tipo" value="0">
                          </td>                                   
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="botones-form">
                              <a type="btn" class="btn icono regresar ttip" href="index.php" teid="pa:html:40, pa:title:60"></a>
                              <input type="submit" class="btn icono guardar ttip positivo" id="btn_submit" teid="pa:val:42, pa:title:59">  
                            </div>
                          </td>
                        </tr>
                    </table>
                  </form>
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
