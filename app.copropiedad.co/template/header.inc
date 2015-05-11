<script type="text/javascript">
      $(document).ready(function(){ 
        $('#nusuario').html('<a href="https://app.copropiedad.co/perfil">' + sessionStorage.getItem('nombreCompleto') + '</a>')
      });
  </script>	
  <div id="cpLoading"> Cargando... </div>


  <header>
        <div class="contenedor">
            <div class="logo">
               <a href="../">
                  <h1>Copropiedad</h1>
               </a>
            </div>
            <div class="menus">
               <nav id="topmenu">
                <ul>
                	<li class="usuario" id="nusuario"></li>
                	<li class="libreta"><a href="../usuario/usuario.php">Directorio</a></li>
                    <li><a href="../index.php?logout=1">Salida</a></li>
					          <li><a href="#">Ayuda</a></li>
                </ul>
               </nav>
            </div>
        </div>
	</header>