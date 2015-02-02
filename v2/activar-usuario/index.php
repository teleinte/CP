<?php error_reporting(E_ALL);ini_set('display_errors', 1); ?>
<?php 
  if((isset($_POST['user']) && isset($_POST['pass'])))
  {
    if($_POST['user']== "copropiedad" && $_POST['pass']== "t3l31nt3")
      {$login = true;$fail=false;$success = "init";}
    else
      {$login = false;$fail=true;$success = "init";}
  }
  else
  {
    if(isset($_POST['user'])&& isset($_POST['pass']))
      $fail = true;
    else
      $fail = false;

    $login = false;
  }

  if((isset($_POST['email']) && isset($_POST['token'])))
  {
    $data = array("token" => $_POST['token'], "body" => array("email" => $_POST['email']));                                                                    
    $data_string = json_encode($data);                                                                                   
     
    $ch = curl_init('http://auth.teleinte.com/auth/activate/');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );                                                                                                                   
     
    $result = json_decode(curl_exec($ch),true);

    if($result['status'])
    {
      $success = "ok";
      $login = true;
      $fail = false;
    }
    else
    {
      $success = "no";
      $login = true;
      $fail = false;
    }
  }
?>
<!DOCTYPE HTML>
<html dir="ltr" lang="es-ES">
<?php include("../template/head.inc") ?>
<!-- The CSS! -->
  <?php include("../template/css.inc") ?>
<!-- The JS! -->
  <?php include("../template/js.inc") ?>
<!-- The BackEnd -->
  <script src="js/functions.js"></script>
<!-- Selector para cambiar las hojas de estilo -->
</head>
<body>
    <header>
          <div class="contenedor">
              <div class="logo">
                 <a href="index.html">
                    <h1>Copropiedad</h1>
                 </a>
              </div>
              <div class="menus">
                 <nav id="topmenu">
                  <ul>
                    <li class="usuario" id="nusuario">Bienvenido: Copropiedad</li>                    
                    <li><a href="index.php">Salida</a></li>
                  </ul>
                 </nav>
              </div>
          </div>
    </header>
    <div id="contenido-principal">
        <section id="central">
            <div class="contenedor">
            <div class="title-login">
              <h1>Activación / Desactivación de usuarios en copropiedad</h1>
            </div>
            <?php if($login) { ?>
            <div id="listaUsuarios" class="login" style="width:450px;">
              <div id="alertas">
                <?php if($success == "ok" && $success != "init") { echo ('<div class="alert alert-success">Usuario activado con éxito.</div>'); } elseif($success == "no" && $success != "init") { echo ('<div class="alert alert-error"><strong>Error:</strong>No se ha podido activar el usuario.</div>'); }?>
              </div>
              <div id="btn_listausers" class="btn gray"><p>Obtener lista de usuarios</p></div>
              <div id="usuario" style="margin-top:10px;">
                
              </div>
            </div>
            <?php } else { ?>
            <div class="login">
              <form id="index_form" method="POST">
                <h2>Ingreso</h2>
                  <p><label for="usr">Usuario:</label><input type="text" id="user" name="user"></p>
                  <p><label for="pas">Contraseña:</label><input type="password" id="pass" name="pass"></p>
                <div class="login-botones">
                    <p><input type="submit" id="btn_enviar" value="Ingresar" class="btn gray"></p>
                </div>
                <div id="alertas">
                  <?php if($fail) { echo ('<div class="alert alert-error"><strong>Error:</strong>Usuario o clave invalidos.</div>'); }?>
                </div>
              </form>
            </div>
            <?php } ?>
            </div>
        </section>
    </div>
  </body>
</html>