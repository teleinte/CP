<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="../sjs/consecutivos.js"></script>
<script type="text/javascript" src="../sjs/consecutivos-functions.js?v=1.0"></script>
<script type="text/javascript" src="../sjs/consecutivos-crear.js?v=1.0"></script>
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
            <div class="titulo-principal">
              <h1 id="titulador"></h1>
            </div>
            <?php require_once('../../template/include/alerts.inc'); ?>
              <form class="clearfix" id="confignum_form">
                <table>
                    <tr>
                      <td><label teid="co:html:23"></label>
                          <input type="number" id="cc" name="cc" required/></td>
                        <td><label teid="co:html:24"></label>
                          <input type="number" id="rc" name="rc" required/></td>                                      
                        <!--<td><label teid="co:html:25"></label>
                          <input type="number" id="fv" name="fv" value="0"/></td>-->                                
                          <td><label teid="co:html:28"></label>
                            <input type="number" id="fc" name="fc" required/></td>
                    </tr>
                    <tr>
                      <td><label teid="co:html:26"></label>
                          <input type="number" id="ce" name="ce" required/></td>
                        <td><label teid="co:html:27"></label>
                          <input type="number" id="nc" name="nc" required/></td>
                    </tr>
                </table>
                <input type="hidden" id="id"/>
                <div class="botones-form">
                  <input type="submit" class="btn icono guardar ttip" teid="co:val:29, co:title:30" id="guardarNumeracion"/>
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
