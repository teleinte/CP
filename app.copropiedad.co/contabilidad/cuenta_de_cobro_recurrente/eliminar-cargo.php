<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../../template/include/meta.inc"); ?>
<title teid="co:html:1"></title>
<?php require_once("../../template/include/head-2.inc"); ?>
<script type="text/javascript" src="sjs/cargos-editar.js"></script>
<script type="text/javascript" src="sjs/cargos-functions.js"></script>
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
            <h1 teid="co:html:203"></h1>
            </div>
            <?php require_once('../../template/include/alerts.inc'); ?>
               <!--<h3 class="center" teid="co:html:197"></h3>-->
                <form id="eliminarCargo">
                  <h3 class="center"></h3>
                  <br><br>
                  <div class="clearfix tablacargos">
                    <table id="tablaContenedora">
                      <thead>                              
                        <tbody>
                        </tbody>                                  
                      </thead>                                                            
                    </table>                            
                    <br><br>
                      <div id='fila0' class="opciones" style="padding: 20px 1.5% 0; border:1px solid #eee; margin-bottom:0;">
                        <table>
                          <tr>
                            <td width="25%"></td>
                            <td width="25%" id="cargoMostrar"></td>
                            <td width="25%"><select id="opcion"><option value='no' teid="co:html:204"></option><option value='si' teid="co:html:205"></option></select></td>
                            <td width="25%">
                              <input type="hidden" id="cargo"/>
                              <input type="hidden" id="Activo_Pasivo"/>
                              <input type="hidden" id="cuenta_ingreso"/> 
                              <input type="hidden" class="hidden" id="indicesfinales">
                            </td>
                          </tr></table>
                        <table id="otra_tabla">
                          <tr>
                              <td colspan="5" style="vertical-align:bottom; text-align:center;">
                                <div class="botones-form">
                                <input type="submit" class="btn icono guardar ttip positivo" teid="co:val:206, co:title:207"/>
                                </div>
                              </td>
                          </tr>
                        </table>                              
                    </div>  
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
