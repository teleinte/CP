<?php include('Pagosclase.php');?>
<?php include("../../template/head.inc") ?>
<?php //include("../../template/css.inc");?>
<?php //include("../../template/js.inc");?>
        
<!DOCTYPE html>
<html>
  <?php include("../../template/head.inc") ?>
  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="stylesheet" href="../../css/jquery-ui.css" />
  <link rel="stylesheet" href="../../css/chosen.css">
  <link rel="stylesheet" href="../../css/estilos-copropiedad.css" type="text/css" media="all">
  <link rel="stylesheet" href="../../css/tablet.css" type="text/css"  media="all and (min-width: 640px) and (max-width: 1199px)">
  <link rel="stylesheet" href="../../css/mobile.css" type="text/css" media="all and (min-width: 100px) and (max-width: 639px)">

  <link rel="alternate stylesheet" title="Aguamarina" href="../../css/color1.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Verde" href="../../css/color2.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Azul" href="../../css/color3.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Morado" href="../../css/color4.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Amarillo" href="../../css/color5.css" type="text/css" media="all">
  <link rel="alternate stylesheet" title="Rojo" href="../../css/color6.css" type="text/css" media="all">

  <!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->

  <!-- For third-generation iPad with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../images/apple-touch-icon-144x144-precomposed.png">
  <!-- For iPhone with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../images/apple-touch-icon-114x114-precomposed.png">
  <!-- For first- and second-generation iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../images/apple-touch-icon-72x72-precomposed.png">
  <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
  <link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="../../js/jquery.validate.js"></script>
  <!-- Template Engine -->
  <!--<script src="http://twitter.github.com/hogan.js/builds/3.0.1/hogan-3.0.1.js"></script>
  <script src="js/copropiedad-template-engine.js"></script>-->
  <!--<script type="text/javascript" src="copropiedad-template-engine.js"></script>-->
  <!-- Variables de Sesion -->
  <!--<script src="../js/copropiedad-set_variables.js"></script>-->
  <!-- jquery alertas acción de cerrar y con html -->
  <script src="../../js/alertas.js"></script>
  <!-- además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
  <script src="../../js/jquery.bsAlerts.js"></script>
  <!-- Script selector de copropiedad -->
  <script src="../../js/jquery-dd.js"></script>
  <script src="../../js/copropiedad-hoy.js"></script>

<!--[if IE 7 ]><link rel="stylesheet" href="css/ie7.css" type="text/css"> <![endif]-->
<!-- For third-generation iPad with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/apple-touch-icon-144x144-precomposed.png">
<!-- For iPhone with high-resolution Retina display: -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114x114-precomposed.png">
<!-- For first- and second-generation iPad: -->
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72x72-precomposed.png">
<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
<link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-precomposed.png">
<!-- Jquery UI y Tabs -->
<script src="../../js/jquery-ui.js"></script>
    
 
<!-- Selector para cambiar las hojas de estilo -->
<script src="../../js/stylesheet-switcher.js"></script>
<!-- jquery alertas acción de cerrar y con html -->
<script src="../../js/alertas.js"></script>
<!-- http://eltimn.github.io/jquery-bs-alerts/ Además agregar alertas por js. Debe existir el div #alertas-automaticas, con data-alerts="alerts", data-titles opcional(tiene títulos para los diferentes tipos de alertas si se quieren agregar), y data-fade opcional (oculta el div en determinado número de milisegundos). Se puede usar para dar mensajes de sistema de guardado exitoso por ejemplo -->
<script src="../../js/jquery.bsAlerts.js"></script>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="js/enviarDatos.js"></script>
        <script src="js/md5-min.js"></script>
        <script src="../../js/jquery.min.js"></script>
        <script type="text/javascript">


            $(document).ready(function(){

                var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})

                /*if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
                {                      
                    $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
                        window.location = '../../index.html';
                }*/
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
        <script>
             $(document).ready(function()
             {
                var refref='CC'+ Math.floor(Math.random()*1000000000000000000000);
                $("#mostrarRef").html(hex_md5(refref));
                $("#referenceCode").val(hex_md5(refref));
                $('#mostrarDes').html($('#description').val());
                $('#mostrarMonto').html($('#amount').val());
                $('#mostrarNom').html('Jairo Gil');
                $('#mostrarCop').html('Edificio Vanessa');
                $('#mostrarUni').html('CC988');

                //VALIDACION FORMULARIO DE ENTRADA

                $( "#target" ).submit(function( event ) {

                   
                    var calculo=calcularImpuestos(16,$("#amount").val(),true);

                    if($("#buyerEmail").val().indexOf('@', 0) == -1 || $("#buyerEmail").val().indexOf('.', 0) == -1) 
                    {  
                      $('#resultado').html('Complete el campo de correo electronico con el formato correcto. Ej: nombre@ejemplo.com');
                      event.preventDefault(); 
                    } 
                    else
                    {
                      $("#tax").val(0);
                      $("#taxReturnBase").val(0);
                      //$("#taxReturnBase").val(calculo[0]);

                      var ParamFecha=fecha();
                      var cpp= "6u39nqhq8ftd0hlvnjfs66eh8c";
                      //var cpp= "170vp0cv81qjt3i8jslpjbunn6";
                      
                      var sstring=cpp+"~"+$("#merchantId").val()+"~"+$("#referenceCode").val()+"~"+$("#amount").val()+"~"+$('#currency').val();
                      //alert(sstring);
                      $("#signature").val(hex_md5(sstring));

                      //ARMA PAQUETE QUE SE ENVIA A BD
                      var arr = 
                      {
                        token:'Usp63mnzuhI9g9CJkjjqDre7BDoNkAt9yt6AmqzLd5c=',//sessionStorage.getItem('token'),
                        body:
                        { 
                          fecha_creacion:ParamFecha,
                          id_copropiedad : '5511995bbbc118d03fbd2191',//sessionStorage.getItem('cp'),
                          id_crm_persona: '24',//sessionStorage.getItem('id_crm'),
                          estado:'777',// Pendiente                           
                          merchantId:$('#merchantId').val(),
                          apikey:cpp,
                          accountId:$('#accountId').val(),
                          amount:$('#amount').val(),
                          buyerEmail:$('#buyerEmail').val(),
                          referenceCode:$('#referenceCode').val(),
                          description:$('#description').val(),
                          tax:$('#tax').val(),
                          signature:$('#signature').val(),                        
                          currency:$('#currency').val(),
                          test:$('#test').val(),
                          lng:$('#lng').val(),
                          responseUrl:$('#responseUrl').val(),
                          doc: $('#mostrarUni').html(),
                          confirmationUrl:$('#confirmationUrl').val()
                        }
                      };
                      var url = "pagar";
                      envioFormulario(arr,url,'POST');
                    }
                  //alert(JSON.stringify(arr));
                  //event.preventDefault();
                });
              
                //CALCULA LA BASE SI EL MONTO LLEVA IVA INCLUIDO
                function calcularImpuestos(tasa, monto, incluido)
                {
                  if(incluido)
                  {
                      if(tasa==16){ var iva=1.16; }
                      if(tasa==5){ var iva=1.05; }
                      var valorSinIva = (monto/iva);
                      var valorDelIva = valorSinIva*(tasa/100);        
                      var Base=[((Math.round(valorSinIva*100))/100),((Math.round(valorDelIva*100))/100)];
                      return Base;
                  }
                  else
                  {
                      var valorDelIva = monto*(tasa/100);
                      var Base= [monto,valorDelIva];
                      return Base;
                  }                
                }
                //DA FORMATO A FECHA DE CREACION
                function fecha()
                {
                  var d = new Date();
                  var n = (d.getMonth() + 1) + "-" + d.getDate() + "-" + d.getFullYear()+"  "+d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds(); 
                  return n;
                }  
              });
        </script>


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
                        <li><a href="index.php">Salida</a></li>
                      </ul>
                     </nav>
                  </div>
              </div>
        </header>
        <div id="contenido-principal">
            <section id="central">              
                    <div class="contenedor">
                        <div class="titulo-principal"><h1 class="title tareas">Pagos | Copropiedad</h1></div>
                            <div style="width:350px; margin: 0px auto;">
                                <form id="target" method="post" action="https://stg.gateway.payulatam.com/ppp-web-gateway">
                                    <?php
                                    $ocultos=new Pago;
                                    $ocultos->construirFormOculto();
                                    ?>
                                    <table>
                                        <tr>
                                            <td>Nombre Usuario:</td>
                                            <td id="mostrarNom"></td>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td>Copropiedad:</td>
                                                <td id="mostrarCop"></td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td>Descripcion de la venta:</td>
                                                <td id="mostrarDes"></td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td>Documento:</td>
                                                <td id="mostrarUni"></td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td><label>valor a pagar:</label></td>
                                                <td id="mostrarMonto"><!--<input id="amount" name="amount" type="text"><br>--></td>
                                            </tr>
                                        </tr>
                                        <tr>
                                            <tr>
                                                <td><label>Correo electronico comprador:</label></td>
                                                <td><input id="buyerEmail" name="buyerEmail" type="text" ><br></td>
                                            </tr>
                                        </tr><br>
                                        <tr>
                                            <tr>
                                                <td></td>
                                                <td><input name="Submit" type="submit" value="Enviar Pago" ></td>
                                                <td></td>
                                            </tr>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                    </div>
            </section>
        </div>
        <div id="resultado"></div>
    </body>
</html>

