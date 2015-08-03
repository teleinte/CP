<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pe:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/perfil-functions.js"></script>
<script type="text/javascript" src="sjs/perfil.js"></script>
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
          <h1 class="title" teid="pe:html:2"></h1>
          <?php require_once('../template/include/alerts.inc'); ?>
        </div>
            <form id="perfil_datos">
              <table id="datos" style="width:100% !important;">
                <tbody>
                  <tr>
                    <td>
                      <label for="nombre" teid="pe:html:5"></label><br/>
                      <input type="text" id="nombre" required style="width:96%; padding-right:20px; margin-top:5px;"/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="apellido" teid="pe:html:7"></label><br/>
                      <input type="text" id="apellido" required style="width:96%; padding-right:20px; margin-top:5px;"/>
                    </td>
                  </tr>
                <tr>
                  <td>
                    <input type="button" id="cambioPassword" teid="pe:val:9, pe:title:12" class="btn icono editar ttip"/>
                    <input type="hidden" id="cambiopwd" value="0">
                  </td>
                </tr>
                </tbody>
                <tbody style="border:2px solid #aaa; background-color:#eee; display:none; padding:10px; margin:5px;" id="passwordbody">
                  <tr>
                    <td>
                      <label for="pwd" teid="pe:html:6"></label><br/>
                      <input type="password" id="pwd" name="pwd" placeholder="Deshabilitado" disabled style="width:94%; padding-right:20px; margin-top:5px;" onchange="this.setCustomValidity(this.validity.patternMismatch ? '' : ''); if(this.checkValidity()) form.cpwd.pattern = this.value;" class="ttip" title="La contraseña debe contener al menos 6 caracteres, incluyendo una letra mayúscula, una letra minúscula y un número"/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <label for="cpwd" teid="pe:html:8"></label><br/>
                      <input type="password" id="cpwd" name="cpwd" class="ttip" placeholder="Deshabilitado" disabled style="width:94%; padding-right:20px; margin-top:5px;" onchange="this.setCustomValidity(this.validity.patternMismatch ? '' : '');" title="La contraseña escrita en este campo debe coincidir con la escrita en el campo anterior">
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="botones-form" style="margin-top:5px">
                    <input type="submit" id="guardaPerfil" teid="pe:val:10, pe:title:13" class="btn icono guardar ttip positivo"/>
              </div>
            </form>
            <!-- Finaliza codigo de la aplicacion -->
          </div>
        </section>
        <footer>  
          <?php require_once('../template/include/footer.inc'); ?>
        </footer>
    </div>
</body>
</html>