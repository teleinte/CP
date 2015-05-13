<?php

//OBTENCION DE VARIABLES POR GET
$ApiKey = "6u39nqhq8ftd0hlvnjfs66eh8c";
$merchant_id = $_REQUEST['merchantId'];
$referenceCode = $_REQUEST['referenceCode'];
$TX_VALUE = $_REQUEST['TX_VALUE'];
$New_value = number_format($TX_VALUE, 1, '.', '');
$currency = $_REQUEST['currency'];
$transactionState = $_REQUEST['transactionState'];
$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
$firmacreada = md5($firma_cadena);
$firma = $_REQUEST['signature'];
$reference_pol = $_REQUEST['reference_pol'];
$cus = $_REQUEST['cus'];
$extra1 = $_REQUEST['description'];
$pseBank = $_REQUEST['pseBank'];
$lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
$transactionId = $_REQUEST['transactionId'];

//INTERPRETACION DE CODIGOS DE RESPUESTA PayU
if ($_REQUEST['polTransactionState'] == 6 && $_REQUEST['polResponseCode'] == 5) {
	$estadoTx = "Transacción fallida";
}
else if ($_REQUEST['polTransactionState'] == 6 && $_REQUEST['polResponseCode'] == 4) {
	$estadoTx = "Transacción rechazada";
}
else if ($_REQUEST['polTransactionState'] == 12 && $_REQUEST['polResponseCode'] == 9994) {
	$estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
}
else if ($_REQUEST['polTransactionState'] == 7 && $_REQUEST['polResponseCode'] == 15) {
	$estadoTx = "Pendiente, Transacción en validación manual";
}
else if ($_REQUEST['polTransactionState'] == 14 && $_REQUEST['polResponseCode'] == 25) {
	$estadoTx = "Pendiente, Recibo de pago generado. En espera de pago";
}
else if ($_REQUEST['polTransactionState'] == 15 && $_REQUEST['polResponseCode'] == 26) {
	$estadoTx = "Pendiente, Recibo de pago generado. En espera de pago";

}
else if ($_REQUEST['polTransactionState'] == 10 && $_REQUEST['polResponseCode'] == 29) {
	$estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";

}
else if ($_REQUEST['polTransactionState'] == 18 && $_REQUEST['polResponseCode'] == 25) {
	$estadoTx = "Pendiente, Recibo de pago generado. En espera de pago";

}
else if ($_REQUEST['polTransactionState'] == 4 && $_REQUEST['polResponseCode'] == 1) {
	$estadoTx = "Transacción aprobada";
}
else if ($_REQUEST['lapResponseCode'] == "INVALID_CARD") {
	$estadoTx = "Transacción declinada. Número de tarjeta inválido";
}
else {
	$estadoTx=$_REQUEST['lapResponseCode'];
}
?>
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
	<script src="../../js/jquery.min.js"></script>
</head>
<script type="text/javascript">
  $(document).ready(function(){
    $("#regresar").click(function(){ window.location = "index.php"; });
    $("#imprimir").click(function(){ alert('print'); });
  });
</script>
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
                <div class="titulo-principal"><h1 class="title tareas">Pagina Respuesta de Pago | Copropiedad</h1></div>
                  <div style="width:350px; margin: 0px auto;">
                    <h2>Resumen Transacción</h2>
    								<table>
    								<tr>
    									<td>Estado de la transaccion</td>
    									<td><?php echo $estadoTx; ?></td>
    								</tr>
    								<!--<tr>-->
    									<tr>
    										<td>ID de la transaccion</td>
    										<td><?php echo $transactionId; ?></td>
    									</tr>
    									<tr>
    										<td>Referencia de la venta</td>
    										<td><?php echo $reference_pol; ?></td> 
    									</tr>
    									<tr>
    										<td>Referencia de la transaccion</td>
    										<td><?php echo $referenceCode; ?></td>
    									</tr>
    								<!--<tr>-->
    								<?php
    								if($banco_pse != null) {
    								?>
    									<tr>
    										<td>cus </td>
    										<td><?php echo $cus; ?> </td>
    									</tr>
    									<tr>
    										<td>Banco </td>
    										<td><?php echo $pseBank; ?> </td>
    									</tr>
    								<?php
    								}
    								?>
    									<tr>
    										<td>Valor total</td>
    										<td>$<?php echo number_format($TX_VALUE); ?></td>
    									</tr>
    									<tr>
    										<td>Moneda</td>
    										<td><?php echo $currency; ?></td>
    									</tr>
    									<tr>
    										<td>Descripción</td>
    										<td><?php echo ($extra1); ?></td>
    									</tr>
    									<tr>
    										<td>Entidad:</td>
    										<td><?php echo ($lapPaymentMethod); ?></td>
    									</tr>
                      <tr>
                        <td><input type="button" class="btn" value=" Regresar " id="regresar"/></td>
                        <td><input type="button" class="btn" value=" Imprimir " id="imprimir"/></td>
                      </tr>
                    </table>   
                  </div>
              </div>
            </section>
        </div>
        <div id="resultado"></div>
    </body>
</html>
	
