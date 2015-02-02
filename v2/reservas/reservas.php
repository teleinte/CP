<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>

<!-- The CSS! -->
	<?php include("../template/css.inc") ?>
<!-- The JS! -->
	<?php include("../template/js.inc") ?>
    <!-- Jquery UI y tabs y modals -->
    <script src="js/copropiedad-reservas-modals.js"></script>
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
    <script src="js/copropiedad-reservas-enviarcorreo.js"></script>
    <script src="js/copropiedad-reservas-validate.js"></script>
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
                	<div class="titulo-principal"><h1 class="title calendario">Reservas</h1></div>
                  <div style="overflow: hidden; padding: 10px 0; margin:-15px 0 10px;">
                    <div class="floatleft" style="display:inline;"><span style="display:inline;">Selecciona el recurso    </span><select id="ddrecursos" style="display:inline;"><option value="" disabled selected>Selecciona el recurso</option></select><input type="hidden" id="fechareservainicio" name="fechareservainicio" value=""/><input type="hidden" id="fechareservafin" name="fechareservafin" value=""/>    <input type="submit" class="btn" value="Ver reservas" id="btndisponibilidad"/></div>
                    <div class="floatright"  style="padding-top:5px;"><input type="submit" class="btn" value="Regresar" id="btncalendario" /></div>
                  </div>
                  <div id="reservas-table">
                    <div id="reserva-title"></div>
                      <table id="listareservas" class="stripe" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th></th>
                                  <th>Fecha Inicio</th>
                                  <th>Fecha Fin</th>
                                  <th>Usuario</th>
                                  <th>Comentario</th>
                                  <th>Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
                  <div id="reservaEdit">
                    <form id="reservaEditar">
                      <h3><a id="encabezadoEdicion">Modificar fechas de reserva</a></h3>
                      <input type="hidden" id="mongoid" name="mongoid" value=""/>
                      <input type="hidden" id="creacion" name="creacion" value=""/>
                      <input type="hidden" id="user" name="user" value=""/>
                      <input type="hidden" id="comentario" name="comentario" value=""/>
                      <input type="hidden" id="idcopropiedad" name="idcopropiedad" value=""/>
                      <input type="hidden" id="idinmueble" name="idinmueble" value=""/>
                      <input type="hidden" id="grupo" name="grupo" value=""/>
                      <input type="hidden" id="estado" name="estado" value=""/>
                      <p><label for="startfecha">Ingresa la nueva fecha de inicio de la reserva</label>
                      <input type="text" id="startfecha" name="startfecha" value=""/></p>
                      <p><label for="startfecha">Ingresa la nueva hora de inicio de la reserva</label>
                      <select type="text" id="starthora" name="starthora">
                        <option value="00:00">00:00</option>
                        <option value="00:30">00:30</option>
                        <option value="01:00">01:00</option>
                        <option value="01:30">01:30</option>
                        <option value="02:00">02:00</option>
                        <option value="02:30">02:30</option>
                        <option value="03:00">03:00</option>
                        <option value="03:30">03:30</option>
                        <option value="04:00">04:00</option>
                        <option value="04:30">04:30</option>
                        <option value="05:00">05:00</option>
                        <option value="05:30">05:30</option>
                        <option value="06:00">06:00</option>
                        <option value="06:30">06:30</option>
                        <option value="07:00">07:00</option>
                        <option value="07:30">07:30</option>
                        <option value="08:00">08:00</option>
                        <option value="08:30">08:30</option>
                        <option value="09:00">09:00</option>
                        <option value="09:30">09:30</option>
                        <option value="10:00">10:00</option>
                        <option value="10:30">10:30</option>
                        <option value="11:00">11:00</option>
                        <option value="11:30">11:30</option>
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                        <option value="14:00">14:00</option>
                        <option value="14:30">14:30</option>
                        <option value="15:00">15:00</option>
                        <option value="15:30">15:30</option>
                        <option value="16:00">16:00</option>
                        <option value="16:30">16:30</option>
                        <option value="17:00">17:00</option>
                        <option value="17:30">17:30</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                        <option value="22:00">22:00</option>
                        <option value="22:30">22:30</option>
                        <option value="23:00">23:00</option>
                        <option value="23:30">23:30</option>
                      </select></p>
                      <p><label for="startfecha">Ingresa la nueva fecha de finalización de la reserva</label>
                      <input type="text" id="endfecha" name="endfecha" value=""/></p>
                      <p><label for="startfecha">Ingresa la nueva hora de finalización de la reserva</label>
                      <select type="text" id="endhora" name="endhora">
                        <option value="00:00">00:00</option>
                        <option value="00:30">00:30</option>
                        <option value="01:00">01:00</option>
                        <option value="01:30">01:30</option>
                        <option value="02:00">02:00</option>
                        <option value="02:30">02:30</option>
                        <option value="03:00">03:00</option>
                        <option value="03:30">03:30</option>
                        <option value="04:00">04:00</option>
                        <option value="04:30">04:30</option>
                        <option value="05:00">05:00</option>
                        <option value="05:30">05:30</option>
                        <option value="06:00">06:00</option>
                        <option value="06:30">06:30</option>
                        <option value="07:00">07:00</option>
                        <option value="07:30">07:30</option>
                        <option value="08:00">08:00</option>
                        <option value="08:30">08:30</option>
                        <option value="09:00">09:00</option>
                        <option value="09:30">09:30</option>
                        <option value="10:00">10:00</option>
                        <option value="10:30">10:30</option>
                        <option value="11:00">11:00</option>
                        <option value="11:30">11:30</option>
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                        <option value="14:00">14:00</option>
                        <option value="14:30">14:30</option>
                        <option value="15:00">15:00</option>
                        <option value="15:30">15:30</option>
                        <option value="16:00">16:00</option>
                        <option value="16:30">16:30</option>
                        <option value="17:00">17:00</option>
                        <option value="17:30">17:30</option>
                        <option value="18:00">18:00</option>
                        <option value="18:30">18:30</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                        <option value="22:00">22:00</option>
                        <option value="22:30">22:30</option>
                        <option value="23:00">23:00</option>
                        <option value="23:30">23:30</option>
                      </select></p>
                      <div id="alertas"></div>
                      <input type="submit" value="Modificar reserva"/>
                      <!--<input type="submit" id="btnreservaEditar" value="Modificar reserva"/>-->
                    </form>
                  </div>
                  <div id="reservaBorrar">
                    <form id="reservaBorrar">
                      <h2>¿Desea liminar la reserva del recurso?</h2>
                      <input type="hidden" id="mongoid" name="mongoid"/>
                      <input type="submit" value="Eliminar reserva"/>
                    </form>
                  </div>
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