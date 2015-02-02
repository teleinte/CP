<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
<!-- Jquery UI y tabs y modals -->
  <script src='js/copropiedad-reservas-tablas.js'></script>
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="../css/dataTables.responsive.css">
  <link rel="stylesheet" type="text/css" href="../css/dataTables.colVis.css">
  <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
  <script type="text/javascript" language="javascript" src="../js/dataTables.colVis.js"></script>
  <script type="text/javascript" language="javascript" src="../js/dataTables.responsive.js"></script>
<!-- The BackEnd -->
  <script src="js/copropiedad-reservas-functions.js"></script>
  <script src="js/copropiedad-reservas-enviodatos.js"></script>
  <script src="js/copropiedad-reservas-reportes.js"></script>
  <script src="js/jquery.print.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
      var arr = {token:sessionStorage.getItem('token'),body:{id_copropiedad:sessionStorage.getItem('cp'),}};
      TraerUsuarioCopropiedad(arr,"usuario/copropiedad", sessionStorage.getItem('cp'));
    });
  </script> 
  <script type="text/javascript">
    $(document).ready(function(){
      $("#nuevos").click(function(){
        $("#new-panel").toggle("fast");
        $(this).toggleClass("active");
        return false;
      });
    });
    $(document).ready(function(){
      $("#aplicaciones").click(function(){
        $("#app-panel").toggle("fast");
        $(this).toggleClass("active");
        return false;
      });
    });
    $(document).ready(function(){
      $("#pendientes").click(function(){
        $("#pending-panel").toggle("fast");
        $(this).toggleClass("active");
        return false;
      });
    });
  </script>
    <?php
        include("templates/mcopropiedad.php");
        //include("templates/menu.php");
    ?> 
  <!-- Script selector de copropiedad -->
    <script src="../js/jquery-dd.js"></script>
    <script>
  $(document).ready(function(e) {   
  //no use
  try {      
    var pages = $("#copropiedad").msDropdown({on:{change:function(data, ui) {        
      var val = data.value;
      if(val!="")
      {
        if (val=="Nueva"){window.open('../copropiedad/copropiedad-nuevodos.php','_parent');}
        else{sessionStorage.setItem("cp", val)
          javascript:location.reload()  
        }           
      }
    }}}).data("dd");
  } catch(e) {
    //console.log(e); 
  }
  $("#ver").html(msBeautify.version.msDropdown);
  });
  </script>
  <!-- Selector para cambiar las hojas de estilo -->
    <script src="../js/stylesheet-switcher.js"></script>
</head>

<body>
	<?php include("../template/header.inc") ?>
    <div id="contenido-principal">
        <section id="central">
                <aside>
                <?php
                include("templates/aside.php");
                ?>           
                </aside>
        		
                <div class="contenedor">
                	<div class="titulo-principal"><h1 class="title calendario">Reporte de reservas</h1></div>
                  <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatleft" style="display:inline;"><span style="display:inline;">Selecciona el recurso    </span><select id="ddrecursos" style="display:inline;"><option value="" disabled selected>Selecciona el recurso</option></select><input type="input" id="fechainicio" name="fechainicio" value=""/><input type="input" id="fechafin" name="fechafin" value=""/>    <input type="submit" class="btn" value="Ver reporte" id="btnreportereservas"/></div>
                    <div class="floatright"  style="padding-top:5px;"><input type="submit" class="btn" value="Regresar" id="btncalendario" /></div>
                  </div>
                  <div id="reporte-table">
                    <div id="reporte-title"></div>
                      <table id="listareporte" class="stripe" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th>Inmueble</th>
                                  <th>Fecha Inicio</th>
                                  <th>Fecha Fin</th>
                                  <th>Grupo</th>
                                  <th>Usuario</th>
                                  <th>Costo</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
                  <div id="consolidado" style="margin:10px auto 0px auto; width:450px;"></div>
               	</div>
        </section>
        <div id="alertas-absolutas">
            <!-- <div class="alert alert-warning">
                <h4>Mantenimiento</h4>
                <p>El día 8 de Diciembre, a partir de las 12:00am, estaremos realizando un<br />mantenimiento al aplicativo por lo que puede presentar algunas fallas.</p>
            </div> -->
      	</div>
    </div>
</body>
</html>