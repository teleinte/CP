<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="vo:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/votaciones-functions.js"></script>
<script type="text/javascript" src="sjs/enviar-votacion.js"></script>
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
              <h1 class="title votaciones" teid="vo:html:33"></h1>
            </div>
            <?php require_once('../template/include/alerts.inc'); ?>
              <div class="clearfix">
                <form id="form-envio-encuesta" class="clearfix">
                  <table width='90%'>
                            <tr>
                                <td width='30%'>
                                    <label for="asunto" teid="vo:html:34"></label>
                                </td>
                                <td colspan="3">
                                    <input type="text" value="" id="asunto" name="asunto" Disabled/>
                                </td>
                            </tr>                                                       
                            <tr>
                            <td colspan=4 >
                              <div style="padding: 10px 5px 5; border:2px solid #aaa; padding:5px; background-color:#eee;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius: 5px;">
                              <table>
                                <tr>
                                  <td>
                                    <label for="invitados" teid="vo:html:36"></label>
                                    <select id="invitados" name ="invitados">                                      
                                      <option value="asamblea" teid="vo:html:37"></option>
                                      <option value="consejo" teid="vo:html:38"></option>                                      
                                      <!--<option value="proveedor" teid="en:html:67"></option>-->
                                    </select>
                                  </td>                                 
                                </tr>
                                </table>
                              </div>
                             <td> 
                            </tr>                            
                             <tr>
                                <td>
                                    <label for="mensaje" teid="vo:html:35"></label>
                                </td>
                                <td colspan="3">
                                    <textarea rows="5" id="mensaje" name="mensaje" required></textarea>
                                    <input type="hidden" id="id_encuesta">
                                    <input type="hidden" id="fechaFin">
                                    <input type="hidden" id="metodo">
                                    <input type="hidden" id="odestinatario" name="odestinatario" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">                                    
                                    <div class="botones-form">
                                      <input type="submit" id ="mastarde" class="btn icono actualizar ttip" teid="vo:val:62, vo:title:63"value=""/>
                                      <input type="submit" class="btn icono guardar ttip positivo" teid="vo:val:43, vo:title:44"/>
                                    <div>
                                </td>                                
                            </tr>
                        </table>        
                </form>
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