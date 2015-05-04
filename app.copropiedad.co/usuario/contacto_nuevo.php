<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<?php include("../template/css.inc");?>
<?php include("../template/js.inc");?>
<!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->
<!-- For third-generation iPad with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/apple-touch-icon-144x144-precomposed.png">
<!-- For iPhone with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114-precomposed.png">
<!-- For first- and second-generation iPad: -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72-precomposed.png">
<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->
<script src="js/copropiedad-enviodatos.js"></script>

<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#usuarioprincipal").hide();
    $("#nuevos").click(function(){
       $("#new-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#new-panel').length) {
            if($('#new-panel').is(":visible")) {
                    $('#new-panel').hide();
                    $('#nuevos').toggleClass("active");
                    }
            }        
        });
  });
  $(document).ready(function(){
    $("#aplicaciones").click(function(){
			$("#app-panel").toggle("fast");
			$(this).toggleClass("active");
			return false;
		});
		$(document).click(function(event) { 
		if(!$(event.target).closest('#app-panel').length) {
			if($('#app-panel').is(":visible")) {
				$('#app-panel').hide();
				$('#aplicaciones').toggleClass("active");
				}
			}        
		});
  });
  $(document).ready(function(){
   $("#pendientes").click(function(){
            $("#pending-panel").toggle("fast");
            $(this).toggleClass("active");
            return false;
            });
            $(document).click(function(event) { 
            if(!$(event.target).closest('#pending-panel').length) {
            if($('#pending-panel').is(":visible")) {
                    $('#pending-panel').hide();
                    $('#pendientes').toggleClass("active");
                    }
            }        
        });
  });
</script>
    <?php include("templates/mcopropiedad.php"); //include("templates/menu.php");?> 
    <!-- Jquery UI y Tabs -->
    <script src="../js/jquery-ui.js"></script>
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
          else{sessionStorage.setItem("cp", val);
            javascript:location.reload();
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
<!-- jquery alertas acción de cerrar y con html -->
<script src="../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../js/jquery.bsAlerts.js"></script>

<script src="../js/jquery.validate.js" type="text/javascript"></script> 
<script src="js/functions.js"></script>
<script src="js/validate.js"></script>
<script>
  $(document).ready(function(){
    $("#btncliente").click(function(){
        $("#tablepr").html('');
        $("#tablecl").html('');
        $("#tablecl").html('<table id="form-encuesta-cl"> <tr> <td> <label for="tipo">Tipo de inmueble:</label> <select id= "tipo" name="tipo"> <option value="apartamento">Apartamento</option> <option value="local">Local</option> <option value="bodega">Bodega</option> <option value="oficina">Oficina</option> <option value="deposito">Deposito</option> <option value="saloncomunal">Salon Comunal</option> <option value="parqueadero">Parqueadero</option> </select> </td> <td> <label for="identificador">Identificador Inmueble:</label> <input type="text" id = "identificador" name="identificador"></input> <input type="hidden" id = "nombre"></input> <input type="hidden" id = "id_copropiedad"></input> <input type="hidden" id = "id_crm_persona"></input> </td> <td> <label for="detalle">Detalle del inmueble:</label> <input type="text" id = "detalle" name="detalle"></input> </td> </tr> <tr> <td> <label for="coeficiente">Porcentaje Coeficiente:</label> <input type="text" id = "coeficiente" name="coeficiente"></input> </td> <td > <label for="canon">Canon de Administración:</label> <input type="text" id = "canon" name="canon"></input> </td> <td><div style="display:none;"><input type="checkbox" name="proveedor" id="proveedor"></div></td> </tr> <tr> <td colspan="0">Detalles del los contactos asociados:<br><br><br> </td> </tr>');
        $("#usuarioprincipal").show();
        $("#provcheck").hide();
    });

    $("#btnproveedor").click(function(){
        $("#tablepr").html('');
        $("#tablecl").html('');
        $("#tablepr").html('<table id="form-encuesta-pr"> <tr> <td> <label for="identificador">Nombre proveedor</label> <input type="text" id = "identificador" name="identificador"></input> </td> <td> <label for="detalle">Direccion</label> <input type="text" id = "detalle" name="detalle"></input> </td> <td > <label for="canon">Telefono</label> <input type="text" id = "canon" name="canon"></input> </td> <td> <input type="hidden" name="tipo" id="tipo" value="proveedor"/> <div style="display:none;"><input type="checkbox" name="proveedor" id="proveedor" checked></div><input type="hidden" name="coeficiente" id="coeficiente" value="n/a"/> <input type="hidden" id = "nombre"></input> <input type="hidden" id = "id_copropiedad"></input> <input type="hidden" id = "id_crm_persona"></input> </td> </tr> <tr> </tr> <tr> <td colspan="0">Detalles del los contactos asociados:<br><br><br> </td> </tr> </table>'); 
        $("#usuarioprincipal").show();
    });
  });
</script>
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
                  <div class="titulo-principal"><h1 class="title encuestas">Crear Contacto</h1></div>
                    <div class="clearfix">
                      <form id="unidad_form">
                          <h3 style="display:inline-block">El contacto a agregar es un &nbsp;&nbsp;</h3><input type="button" id="btnproveedor" name="btnproveedor" value="  PROVEEDOR  " class="btn"/>&nbsp;&nbsp;<input type="button" id="btncliente" name="btncliente" value="  CLIENTE  " class="btn"/>
                          <div id="tablecl">
                          </div>
                          <div id="tablepr">
                          </div>
                          <div id="usuarioprincipal">
                            <div id="pregunta0" class="clearfix" style="padding: 20px 10px 0; border:3px solid #eee; margin-bottom:10px;">
                              <label>Usuario/Contacto Responsable</label><br><br><br>
                              <table>
                                <tr>
                                    <td>
                                      <label for="nombre0">Nombre:</label>
                                      <input type="text" id="nombre0" name="nombre0">
                                    </td>
                                    <td>
                                      <label for="apellido0">Apellido:</label>
                                      <input type="text" id="apellido0" name="apellido0">
                                    </td>
                                    <td>
                                      <label for="telefono0">Telefono:</label>
                                      <input type="text" id="telefono0" name="telefono0">
                                    </td>
                                    <td>
                                      <label for="telefono0">Celular:</label>
                                      <input type="text" id="celular0" name="celular0">
                                    </td>
                                    <td>
                                      <label for = "email0">Correo Electronico:</label>
                                      <input type = "text" id="email0" name="email0">
                                    </td> 
                                    <td>
                                      <label for = "empresa0">Empresa:</label>
                                      <input type = "text" id="empresa0" name="empresa0">
                                    </td>
                                    <td colspan ="2">
                                      <label for="grupo0">Grupo de usuarios:</label>
                                      <select name="grupo0" id="grupo0">                
                                          <option value="residente">Residente</option>
                                          <option value="asamblea">Asamblea</option>
                                          <option value="consejo">Consejo</option>
                                          <option value="proveedores">Proveedor</option>
                                          <option value="residente2">Residente no copropietario</option>
                                      </select>
                                    </td>
                                </tr>
                              </table>
                            </div>
                          </div>
                          <div class="botones-form">
                            <input type="button" id="btAdd" class="btn icono agregar" value="Agregar usuario" style="margin-bottom:10px;"/>
                            <input type="button" id="btRemove" class="btn icono borrar" value="Remover usuario" style="margin-bottom:10px;"/>
                            <input type="submit" class="btn icono guardar" value="Guardar"/>
                            <a class="btn icono regresar" href="usuario.php">Regresar</a>
                          </div>
                      </form>
                        <div data-alerts="alerts" id ="alertas"></div>
                    </div>
                </div>
        </section>
        <div id="alertas-absolutas"></div>
    </div>
</body>


  
<script>
    $(document).ready(function() {
        var iCnt = 0;
        // CREATE A "DIV" ELEMENT AND DESIGN IT USING JQUERY ".css()" CLASS.
        var container = $(document.createElement('div')).css({
            padding: '0', margin: '0 0 20px 0', width: '100%', border: 'none'
        });
        $('#btAdd').click(function() {
            if (iCnt <= 19) {
                iCnt = iCnt + 1;
                // ADD TEXTBOX.
                $(container).append('<div id="pregunta' + iCnt + '" class="clearfix" style="padding: 20px 10px 0; border:3px solid #eee; margin-bottom:10px;"><table><tr><td><label for="nombre' + iCnt + '">Nombre:</label><input type="text" id="nombre' + iCnt + '" name="nombre' + iCnt + '"></td><td><label for="apellido' + iCnt + '">Apellido:</label><input type="text" id="apellido' + iCnt + '" name="apellido' + iCnt + '"></td><td><label for="telefono' + iCnt + '">Telefono:</label><input type="text" id="telefono' + iCnt + '" name="telefono' + iCnt + '"></td><td><label for="celular' + iCnt + '">Celular:</label><input type="text" id="celular' + iCnt + '" name="celular' + iCnt + '"></td><td><label for = "email' + iCnt + '">Correo Electronico:</label><input type = "text" id="email' + iCnt + '" name="email' + iCnt + '"></td> <td><label for = "empresa' + iCnt + '">Empresa:</label><input type = "text" id="empresa' + iCnt + '" name="empresa' + iCnt + '"></td><td colspan ="2"><label>Grupo de usuarios:</label><select name="grupo' + iCnt + '" id="grupo' + iCnt + '"><option value="residente">Residente</option><option value="asamblea">Asamblea</option><option value="consejo">Consejo</option></select></td></tr></table></div>');
                $('#pregunta0').after(container);   // ADD BOTH THE DIV ELEMENTS TO THE "main" CONTAINER.
            }
            else {      // AFTER REACHING THE SPECIFIED LIMIT, DISABLE THE "ADD" BUTTON. (20 IS THE LIMIT WE HAVE SET)
                $(container).append('<label class="limite-preg">Alcanzó el máximo de preguntas</label>'); 
                $('#btAdd').attr('class', 'btn icono agregar disabled'); 
                $('#btAdd').attr('disabled', 'disabled');
            }
        });
        $('#btRemove').click(function() {   // REMOVE ELEMENTS ONE PER CLICK.
            if (iCnt != 0) { $('#pregunta' + iCnt).remove(); iCnt = iCnt - 1; $('.limite-preg').remove();}
            if (iCnt == 0) { 
        $(container).empty(); 
                $(container).remove();
            }
      if (iCnt <= 20) {
                $('#btAdd').removeAttr('disabled');
        $('#btAdd').attr('class', 'btn icono agregar');
            }
        });
    });

</script>     
</html>
