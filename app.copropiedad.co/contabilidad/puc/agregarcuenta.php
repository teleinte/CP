<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title "ds:html:29"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="sjs/pucagregar.js?v=1.0"></script>
<!-- <script type="text/javascript" src="sjs/contabilidad-functions.js"></script> -->
</head>
<body>
<header>
  <?php require_once("../../template/include/header.inc"); ?>  
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
              <div class="titulo-principal"><h1>Agregar cuenta</h1></div>
              <div class="clearfix">
                <form class="clearfix" id="crearCuenta">
                  <table class="center" >
                    <tbody>
                      <tr>
                        <td>
                          <label for="cuentaAnterior"><h3>Cuenta Anterior</h3></label>
                        </td>
                        <td>
                          <h3 id="cuentaAnterior"></h3>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label for="cuenta">Numero de la nueva cuenta</label>
                        </td>
                        <td id="nuevaCuenta"></td>
                      </tr>
                      <tr>
                        <td><label for="nombreCuenta">Descripción cuenta</label></td>
                        <td><input type="text" id="nombreCuenta" name="nombreCuenta" style="width:200px;height:15px" required></td>
                      </tr>                          
                    </tbody>
                  </table>  
                    <div class="botones-form">
                      <input type="submit" class="btn icono guardar ttip positivo" value="Guardar cuenta" id="guardarCuenta"/>
                    </div>
                    <div id="alertas"></div>
                </form>
              </div>
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
