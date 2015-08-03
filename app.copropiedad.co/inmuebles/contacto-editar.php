<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="in:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/inmuebles-functions.js"></script>
<script type="text/javascript" src="sjs/contacto-editar.js"></script>
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
              <div class="titulo-principal"><h1 teid="ct:html:1"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
                <form id="modificar-usuario">
                  <table style="width:100%;">
                    <tr><td width="50%"></td><td width="50%"></td></tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="nombre" teid="ct:html:2"></label>
                        </td><td>
                          <input type="text" id="nombre" name="nombre" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">                       
                          <label for="telefono" teid="ct:html:3"></label>
                        </td><td>
                          <input type="text" id="telefono" name="telefono" required style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for = "email" teid="ct:html:4"></label>
                        </td><td>
                          
                          <input type = "text" id="email" name="email" required readonly="readonly" style="width:85%; padding-right:20px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">
                          <label for="grupo" teid="ct:html:5"><img src="../template/images/tooltip.png" class="tooltip ttip" data-hasqtip="0" teid="in:title:58" aria-describedby="qtip-0"></label>
                        </td><td>
                          <select name="grupo" id="grupo"  style="width:95%; padding-right:20px;">               
                              <option value="residente" teid="ct:html:6"></option>
                              <option value="asamblea" teid="ct:html:7"></option>
                              <option value="consejo" teid="ct:html:8"></option>
                          </select>
                          <input type = "hidden" id="id_usuario" name="id_usuario">
                          <input type = "hidden" id="unidad" name="unidad">
                          <input type = "hidden" id="creado_por" name="creado_por">
                          <input type = "hidden" id="fecha_creacion" name="fecha_creacion">
                          <input type = "hidden" id="id_copropiedad" name="id_copropiedad">
                          <input type = "hidden" id="id_crm_persona" name="id_crm_persona">                          
                          <input type = "hidden" id="estado" name="estado">
                          <input type = "hidden" id="perfil" name="perfil">
                          <input type = "hidden" id="principal" name="principal">
                          <input type = "hidden" id="tipo" name="tipo">
                        </td>
                    </tr>
                  </table><br>
                  <div class="botones-form">
                    <input type="submit" class="btn icono guardar ttip positivo" teid="ct:val:9, ct:title:15">
                  </div>
                </form>
            </div>            
            <!-- Finaliza codigo de la aplicacion -->
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>
