<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pe:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/perfil-functions.js"></script>
<script type="text/javascript" src="sjs/empresa.js"></script>
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
      <div class="contenedor mitad">
        <!-- Codigo de la aplicacion -->
          <div class="titulo-principal">
            <h1 class="title contabilidad" teid="pe:html:14"></h1>
          </div>
          <?php require_once('../template/include/alerts.inc'); ?>
            <div class="clearfix">
              <form id="empresa_form" name="empresa_form">
                <table>
                  <tr>
                    <td colspan="2"><label teid="pe:html:15"></label>
                      <input type="text" id="nit" name="nit" required/>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><label teid="pe:html:16"></label>
                      <input type="text" id="nombre_empresa" name="nombre_empresa"  required/>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><label teid="pe:html:17"></label>
                    <input type="text" id="direccion" name="direccion"  required/>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><label teid="pe:html:18"></label>
                      <input type="text" id="ciudad" name="ciudad" required/>
                    </td>
                  </tr>
                  <tr>
                    <td><label teid="pe:html:19"></label>
                      <input type="tel" id="telefono" name="telefono" required style="width:95%"/>
                    </td>
                    <td><label teid="pe:html:20"></label>
                      <input type="text" id="sitio_web" name="sitio_web"/>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><label teid="pe:html:21"></label>
                      <input type="email" id="email" name="email" required/>
                      <input type="hidden" id="mongoid"/>
                    </td>
                  </tr>
                </table>
                <div class="botones-form">
                  <input type="button" class="btn icono borrar ttip" id="cancelar" teid="pe:val:27, pe:title:29"/>
                  <input type="submit" class="btn icono guardar ttip positivo"  teid="pe:val:26, pe:title:28" id="btncrearinfo" /> 
                </div>
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