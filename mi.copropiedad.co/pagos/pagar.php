<?php 
$data = explode("^",base64_decode($_GET["id"]));
var_dump($data);

function construirFormOculto($datos, $responseUrl, $confirmationUrl)
{
  //sessionStorage.getItem('email')+"^"+y['documento']+"^"+y['concepto']+"^"+y['monto']+"^"+pagos['merchantId']+"^"+pagos['apikey']+"^"+pagos['accountId']
  $form = '<input type="hidden" id="merchantId" name="merchantId" value="'.$datos[4].'" ><input type="hidden" id="amount" name="amount" value="0" ><input type="hidden" id="referenceCode" name="referenceCode" value="'.$referenceCode.'" ><input type="hidden" id="description" name="description" value="'.$datos[2].'" ><input type="hidden" id="taxReturnBase" name="taxReturnBase" value="0" ><input type="hidden" id="accountId" name="accountId" value="'.$datos[6].'" ><input type="hidden" id="tax" name="tax" value="0" ><input type="hidden" id="partnerId" name="partnerId" value="512157" ><input type="hidden" id="signature" name="signature" value="'.$signature.'" ><input type="hidden" id="currency" name="currency" value="COP" ><input type="hidden" id="test" name="test" value="1" ><input type="hidden" id="lng" name="lng" value="es" ><input type="hidden" id="responseUrl" name="responseUrl" value="'.$responseUrl.'" ><input type="hidden" id="confirmationUrl" name="confirmationUrl" value="'.$confirmationUrl.'" >';
  echo $form;
}
?>

<!DOCTYPE html>
<html>
  <?php include("../../template/head.inc") ?>
  <link rel="shortcut icon" href="../../favicon.ico" />
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
  <link rel="apple-touch-icon-precomposed" href="../../images/apple-touch-icon-precomposed.png">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="../../js/jquery.bsAlerts.js"></script>
  <script src="../../js/jquery-dd.js"></script>
  <script src="../../js/copropiedad-hoy.js"></script>
  <!-- Jquery UI y Tabs -->
  <script src="../../js/jquery-ui.js"></script>  
  <!-- Selector para cambiar las hojas de estilo -->
  <script src="../../js/stylesheet-switcher.js"></script>
  <!-- jquery alertas acción de cerrar y con html -->
  <script src="../../js/alertas.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="https://hayageek.github.io/jQuery-Upload-File/jquery.uploadfile.min.js"></script>
  <script src="js/enviarDatos.js"></script>
  <script src="js/md5-min.js"></script>
  <?php include("templates/mcopropiedad.php"); ?> 
  <script type="text/javascript">
      $(document).ready(function()
      {
        var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;})
        if(!sessionStorage.getItem('token') || !sessionStorage.getItem('nombre') || !sessionStorage.getItem('apellido') || !sessionStorage.getItem('email') || !sessionStorage.getItem('id_crm'))    
        {                      
          $('#alertas').html('<div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>ERROR: </strong>su sesión a caducado, sera dirigido al inicio.</div>')            
          window.location = '../../index.html';
        }
      });
  </script>
  <script>
   $(document).ready(function()
   {
      var refref='CC'+ Math.floor(Math.random()*1000000000000000000000);
      var referenceCode = hex_md5(refref);

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
            var ParamFecha=fecha();
            var ccp = <?php echo '"' . $data[5] . '"'; ?>;
            var amo = <?php echo '"' . $data[3] . '"'; ?>;
            var accid = <?php echo '"' . $data[6] . '"'; ?>;
            var sstring=ccp+"~"+$("#merchantId").val()+"~"+referenceCode+"~"+amo+"~"+"COP";
            var sign = hex_md5(sstring);

            $("#tax").val(0);
            $("#taxReturnBase").val(0);
            $("#amount").val(amo);
            $("#referenceCode").val(referenceCode);
            $("#accountId").val(accid);
            $("#signature").val(sign);


            //ARMA PAQUETE QUE SE ENVIA A BD
            var arr = 
            {
              token:sessionStorage.getItem('token'),
              body:
              { 
                fecha_creacion:ParamFecha,
                id_copropiedad : sessionStorage.getItem('cp'),
                id_crm_persona: sessionStorage.getItem('id_crm'),
                estado:'777',
                merchantId:$('#merchantId').val(),
                apikey:<?php echo '"' . $data[5] . '"'; ?>,
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
                doc: $('#documento').html(),
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
  <style>
    .ajax-file-upload-statusbar 
    {
      border: 1px solid #0ba1b5;
      margin-top: 10px;
      margin-right: 10px;
      margin: 5px;
      -moz-border-radius: 4px;
      -webkit-border-radius: 4px;
      border-radius: 4px;
      width: 150px !important;
      padding: 5px 5px 5px 5px
     }
     
    .ajax-file-upload-filename 
    {
      width: 130px !important;
      height: auto;
      margin: 0 5px 5px 10px;
      text-align:justify;
      display:none;
      color: #807579
     }
     
    .ajax-file-upload-progress 
    {
      margin: 0 10px 5px 10px;
      position: relative;
      width: 130px !important;
      border: 1px solid #ddd;
      padding: 1px;
      border-radius: 3px;
      display: inline-block
     }
     
    .ajax-file-upload-bar 
    {
      background-color: #0ba1b5;
      width: 0;
      height: 20px;
      border-radius: 3px;
      color: #fff
     }
     
    .ajax-file-upload-percent 
    {
      position: absolute;
      display: inline-block;
      top: 3px;
      left: 48%
     }
     
    .ajax-file-upload-red 
    {
      -moz-box-shadow: inset 0 39px 0 -24px #e67a73;
      -webkit-box-shadow: inset 0 39px 0 -24px #e67a73;
      box-shadow: inset 0 39px 0 -24px #e67a73;
      background-color: #e4685d;
      -moz-border-radius: 4px;
      -webkit-border-radius: 4px;
      border-radius: 4px;
      display: inline-block;
      color: #fff;
      font-family: arial;
      font-size: 13px;
      font-weight: normal;
      padding: 4px 15px;
      text-decoration: none;
      text-shadow: 0 1px 0 #b23e35;
      cursor: pointer;
      vertical-align: top;
      margin-right: 5px
     }
     
    .ajax-file-upload-green 
    {
      background-color: #77b55a;
      -moz-border-radius: 4px;
      -webkit-border-radius: 4px;
      border-radius: 4px;
      margin: 0;
      padding: 0;
      display: inline-block;
      color: #fff;
      font-family: arial;
      font-size: 13px;
      font-weight: normal;
      padding: 4px 15px;
      text-decoration: none;
      cursor: pointer;
      text-shadow: 0 1px 0 #5b8a3c;
      vertical-align: top;
      margin-right: 5px
     }
     
    .ajax-file-upload 
    {
      font-family: Arial,Helvetica,sans-serif;
      font-size: 16px;
      font-weight: bold;
      padding: 15px 20px;
      cursor: pointer;
      line-height: 20px;
      height: 25px;
      margin: 0 10px 10px 0;
      display: inline-block;
      background: #fff;
      border: 1px solid #e8e8e8;
      color: #888;
      text-decoration: none;
      border-radius: 3px;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      -moz-box-shadow: 0 2px 0 0 #e8e8e8;
      -webkit-box-shadow: 0 2px 0 0 #e8e8e8;
      box-shadow: 0 2px 0 0 #e8e8e8;
      padding: 6px 10px 4px 10px;
      color: #fff;
      background: #2f8ab9;
      border: 0;
      -moz-box-shadow: 0 2px 0 0 #13648d;
      -webkit-box-shadow: 0 2px 0 0 #13648d;
      box-shadow: 0 2px 0 0 #13648d;
      vertical-align: middle
     }
     
      .ajax-file-upload:hover 
      {
        background: #3396c9;
        -moz-box-shadow: 0 2px 0 0 #15719f;
        -webkit-box-shadow: 0 2px 0 0 #15719f;
        box-shadow: 0 2px 0 0 #15719f
       }
     
    .ajax-upload-dragdrop 
    {
      border: 2px dotted #a5a5c7;
      color: #666;
      text-align: middle !important;
      vertical-align: middle;
      width: 130px !important;
      padding: 20px 10px
     }

     .ajax-upload-dragdrop b{
       padding: 10px 0 !important;
      }
     
    .ajax-upload-dragdrop.state-hover {border: 2px solid #a5a5c7}
     
    .ajax-file-upload-error {color: red}  
  </style>
    <script type="text/javascript">
      $(document).ready(function(){ 
        $('#nusuario').html("Bienvenido: "+sessionStorage.getItem('nombreCompleto'));
        $('#pagador').html(sessionStorage.getItem('nombreCompleto'));
        $('#copropiedad').html(sessionStorage.getItem('ncp'));
        var actual = Number(<?php echo $data[3];?>);
        var convertido = '$ ' + actual.toLocaleString('es-CO', { style: 'currency', currency:'COP'});
        $('#monto').html(convertido);
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
                <li class="usuario" id="nusuario"></li>
              </ul>
             </nav>
          </div>
      </div>
    </header>
    <div id="contenido-principal">
      <section id="central">              
        <div class="contenedor">
          <div class="titulo-principal">
            <h1 class="title tareas">Portal de pagos en linea | Copropiedad</h1>
          </div>
          <div class="floatleft"></div>
          <div class="floatright" style="display:inline-block; margin-bottom:5px;">
            <a href="http://mi.copropiedad.co/pagos/" class="btn" style="margin-right:5px;">Regresar</a>
          </div>
          <div style="width:350px; margin: 0px auto;">
            <form id="target" method="post" action="https://stg.gateway.payulatam.com/ppp-web-gateway">
                <?php
                $responseUrl = "https://mi.copropiedad.co/pagos/respuesta.php";
                $confirmationUrl = "https://app.copropiedad.co/api/payu/pagarpol/";
                construirFormOculto($data,$responseUrl,$confirmationUrl);
                ?>
                <table>
                    <tr>
                        <td>Nombre Usuario:</td>
                        <td id="pagador"></td>
                    </tr>
                    <tr>
                        <tr>
                            <td>Copropiedad:</td>
                            <td id="copropiedad"></td>
                        </tr>
                    </tr>
                    <tr>
                        <tr>
                            <td>Descripcion de la venta:</td>
                            <td id="descripcion"><?php echo $data[2] ?></td>
                        </tr>
                    </tr>
                    <tr>
                        <tr>
                            <td>Documento:</td>
                            <td id="documento"><?php echo $data[1] ?></td>
                        </tr>
                    </tr>
                    <tr>
                        <tr>
                            <td><label>Valor a pagar:</label></td>
                            <td id="monto"><?php echo $data[3] ?></td>
                        </tr>
                    </tr>
                    <tr>
                        <tr>
                            <td><label>Correo electronico comprador:</label></td>
                            <td><input id="buyerEmail" name="buyerEmail" type="text" value="<?php echo str_replace("cp-","",$data[0]); ?>"><br></td>
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
      </section>
    </div>
    <div id="resultado"></div>
  </body>
</html>
