<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="in:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="sjs/inmuebles-functions.js"></script>
<script type="text/javascript" src="sjs/inmuebles-crear.js"></script>
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
              <div class="titulo-principal"><h1 teid="in:html:6"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <form id="unidad_form">
              <table id="form-encuesta-cl" style="width:100%;"> 
                <tr>                               
                  <td>
                    <label for="identificador" teid="in:html:7"></label>
                    <input type="text" id = "nombre_inmueble" name="nombre_inmueble" required style="width:95%"></input>                               
                  </td>                              
                </tr>
              </table>
              <br/>
              <h3 teid="in:html:8"></h3>
              <div id="usuarioprincipal">
                <div id="pregunta0" class="clearfix" style="padding: 20px 10px 0; border:3px solid #aaa; margin-bottom:10px; background-color:#eee">                  
                  <table>
                    <tr>
                      <td width="50%">
                        <label for="nombre0" teid="in:html:9"></label>
                        <input type="text" id="nombre0" name="nombre0" required>
                      </td>
                      <td width="50%">
                        <label for="apellido0" teid="in:html:10"></label>
                        <input type="text" id="apellido0" name="apellido0" required>
                      </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                      <td>
                        <label for="telefono0" teid="in:html:11"></label>
                        <input type="tel" id="telefono0" name="telefono0" required style="width:95%">
                      </td>
                      <td>
                        <label for = "email0" teid="in:html:12"></label>
                        <input type = "email" id="email0" name="email0" required>
                      </td>
                    </tr>
                    <tr>                                     
                      <td>
                        <label for="grupo0" teid="in:html:13"><img src="../template/images/tooltip.png" class="tooltip ttip" data-hasqtip="0" teid="in:title:58" aria-describedby="qtip-0"></label>
                        <select name="grupo0" id="grupo0">
                            <option value="residente" teid="in:html:14"></option>
                            <option value="consejo" teid="in:html:15"></option>
                            <option value="asamblea" teid="in:html:16"></option>
                        </select>
                      </td>
                      <td>
                        <label for="principal0" teid="in:html:17"><img src="../template/images/tooltip.png" class="tooltip ttip" data-hasqtip="0" teid="in:title:57" aria-describedby="qtip-0"></label>
                          <input type="radio" name="principal0" id = "principal0" checked="checked">
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="botones-form">
                <input type="button" teid="in:val:19, in:title:29" id="btRemove" class="btn icono borrar ttip" style="margin-bottom:10px;"/>
                <input type="button" teid="in:val:18, in:title:28" id="btAdd" class="btn icono agregar ttip positivo" style="margin-bottom:10px;"/>
              </div>
              <div class="botones-form">
                <input type="submit" teid="in:val:20, in:title:30" class="btn icono guardar ttip positivo"/>                
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
