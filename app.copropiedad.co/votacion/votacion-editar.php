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
<script type="text/javascript" src="sjs/editar-votaciones.js"></script>
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
                  <div class="titulo-principal"><h1 class="title encuestas" teid="vo:html:21"></h1></div>
                  <?php require_once('../template/include/alerts.inc'); ?>
                    <div class="clearfix">
                      <form id="form-encuesta-editar">
                          <table id="form-encuesta-pr">
                            <tr>
                              <td>
                                <label for="nombre" teid="vo:html:13"></label>
                                <input type="text" id="nombre" name="nombre" required/>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <label for="descripcion" teid="vo:html:14"></label>
                                <textarea rows="3" id="descripcion" name="descripcion" required></textarea>
                              </td>
                            </tr>                          
                            <tr>
                              <td>
                                <label for="datepicker" teid="vo:html:15"></label>
                                <input type="date" id="datepicker" name="datepicker" required/>
                              </td>
                            </tr>
                          </table>                         
                          <div class="botones-form">
                            <input type="submit" class="btn icono guardar ttip positivo" teid="vo:val:22, vo:title:28" />
                            <input type="hidden" id="id_copropiedad" value=""/>
                            <input type="hidden" id="id_crm_persona" value=""/>
                            <input type="hidden" id="fecha_creacion" value=""/>
                            <input type="hidden" id="estado" value=""/>
                          </div>
                        </form>                        
                      </div>
              </div>
                        <div class="contenedor">
                        <div class="titulo-principal">
                          <h1 class="title encuestas" teid="vo:html:23"></h1>
                        </div>
                          <table id="tablaPreguntas" class="stripe" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th></th>
                                      <th teid="vo:html:24"></th>
                                      <th teid="vo:html:26"></th>                                      
                                      <th teid="ta:html:1"></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>                                      
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