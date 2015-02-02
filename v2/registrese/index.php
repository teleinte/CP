<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<!-- The CSS! -->
<?php include("../template/css.inc") ?>
<link rel="stylesheet" type="text/css" href="css/jquery.realperson.css"> 
<!-- The JS! -->
<!--[if lte IE 9]>
  <script src="js/html5.js"></script>
<![endif]-->
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.validate.js"></script>
<script src="js/jquery.plugin.min.js"></script> 
<script src="js/jquery.realperson.min.js"></script>
<script src="js/copropiedad-registrese-enviocorreo.js"></script>
<script src="js/copropiedad-registrese-enviodatos.js"></script>
<script src="js/copropiedad-registrese-validate.js"></script>
<script>
  CreaToken("Registrese","123465789");
  $(function() {
    $('#verif').realperson();
  });
</script>
</head>
<body class="home">
  <header>
    <div class="contenedor">
      <div class="logo">
         <a href="index.php">
            <h1>Copropiedad</h1>
         </a>
      </div>
      <div class="menus">
         <nav id="mainmenu">
          <ul id="principal">
            <li><a target="_blank" href="http://www.copropiedad.co/">Inicio</a></li>
              <li><a target="_blank" href="http://www.copropiedad.co/categoria/actualidad/">Actualidad</a></li>
              <li><a target="_blank" href="http://www.copropiedad.co/contacto/">Contacto</a></li>
          </ul>
         </nav>
      </div>
    </div>
  </header>
  <div id="contenido-principal">
      <section id="central">
        <div class="contenedor">
            <div class="title-login">
              <h1>Registro de usuario</h1>
            </div>
            <div class="login">
              <form id="registro_form" method="POST">                        
                  <p><label for="nombre">Nombre: *</label><input type="text" id="nombre" name="nombre"></p>
                  <p><label for="apellido">Apellido: *</label><input type="text" id="apellido" name="apellido"></p>
                  <p><label for="email">Email: *</label><input type="text" id="email" name="email"></p>
                  <p><label for="telefono">Telefono: *</label><input type="text" id="telefono" name="telefono"></p>
                  <p><label for="nombreedificio">Nombre de la copropiedad: </label><input type="text" id="nombreedificio" name="nombreedificio"></p>
                  <p><label for="direccion">Direccion de la copropiedad: *</label><input type="text" id="direccion" name="direccion"></p>                  
                  <p>
                    <label for="tipo">Usted es? *</label>
                    <select name="tipo" id="tipo" style="width:100%">
                      <option value="">-- Seleccione --</option>
                      <option value="administrador">Administrador</option>
                      <option value="copropietario">Copropietario o residente</option>
                    </select>
                  </p>
                  <p>
                    <label for="pais">Pais de ubicación? *</label>
                    <select name="pais" id="pais" style="width:100%">
                      <option value="CO" selected>Colombia</option>
                    </select>
                  </p>
                  <p>
                    <label for="ciudad">Ciudad de ubicación? *</label>
                    <select name="ciudad" id="ciudad" style="width:100%">
                      <option value="">-- Seleccione --</option>
                      <option value ="Leticia">Leticia<option>
                      <option value ="Medellín">Medellín<option>
                      <option value ="Arauca">Arauca<option>
                      <option value ="Barranquilla">Barranquilla<option>
                      <option value ="Cartgena">Cartgena<option>
                      <option value ="Tunja">Tunja<option>
                      <option value ="Manizales">Manizales<option>
                      <option value ="Florencia">Florencia<option>
                      <option value ="Yopal">Yopal<option>
                      <option value ="Popayán">Popayán<option>
                      <option value ="Valledupar">Valledupar<option>
                      <option value ="Quibdó">Quibdó<option>
                      <option value ="Montería">Montería<option>
                      <option value ="Bogotá" selected>Bogotá<option>
                      <option value ="Puerto Inírida">Puerto Inírida<option>
                      <option value ="San José del Guaviare">San José del Guaviare<option>
                      <option value ="Neiva">Neiva<option>
                      <option value ="Riohacha">Riohacha<option>
                      <option value ="Santa Marta">Santa Marta<option>
                      <option value ="Villavicencio">Villavicencio<option>
                      <option value ="Pasto">Pasto<option>
                      <option value ="Cúcuta">Cúcuta<option>
                      <option value ="Mocoa">Mocoa<option>
                      <option value ="Armenia">Armenia<option>
                      <option value ="Pereira">Pereira<option>
                      <option value ="San Andres">San Andres<option>
                      <option value ="Bucaramanga">Bucaramanga<option>
                      <option value ="Sincelejo">Sincelejo<option>
                      <option value ="Ibagué">Ibagué<option>
                      <option value ="Cali">Cali<option>
                      <option value ="Mitú">Mitú<option>
                      <option value ="Puerto Carreño">Puerto Carreño<option>
                    </select>
                  </p>                 
                  <p><label for="verif">Verifica que eres un ser humano: </label><input type="text" id="verif" name="verif"></p>
                <div class="login-botones">
                  <p><input type="submit" class="btn gray" value="Registrarme"/></p>
                </div>
              </form>
              <div id="alertas"></div>
            </div>
        </div>
      </section>
  </div>
</body>
</html>