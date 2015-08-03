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
<script type="text/javascript" src="sjs/resultado-votaciones.js"></script>
<link rel="stylesheet" href="scss/canvasXpress.css" type="text/css"/>
<script type="text/javascript" src="sjs/canvasXpress.min.js"></script>
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
              <div class="clearfix">
                <div class="titulo-principal">
                <h1 class="title encuestas" id="tituloEncuesta"></h1>
                </div>
                <?php require_once('../template/include/alerts.inc'); ?>
                    <h4 id="totalEncuestados"></h4>
                    <h4 id ="totalInvitados"></h4>
                    <!-- <h4 teid="vo:html:51"></h4> -->
                    <div id="contenedor-resultados">
                        <div class="tabla-preguntas">
                            <table id="res-encuesta" class="stripe" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th teid="vo:html:53"></th>
                                        <th teid="vo:html:54"></th>
                                        <th teid="ta:html:1"></th>                                        
                                    </tr>

                                </thead>
                                <tbody>                                    
                                </tbody>
                            </table>
                            
                        </div>
                        <div class="resultados-graph" id="resultados-graph">
                            <div id="particular"></div>
                            
                        </div>
                        </div>
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