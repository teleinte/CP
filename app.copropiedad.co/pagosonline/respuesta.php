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
<?php include('Pagosclase.php');?>
        
<!DOCTYPE HTML>
<html dir="ltr" lang="es-CO">
<head>
<?php require_once("../template/include/meta.inc"); ?>
<title teid="pa:html:1"></title>
<?php require_once("../template/include/head-1.inc"); ?>
<script type="text/javascript" src="../template/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.colVis.min.js"></script>
<script type="text/javascript" src="../template/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="sjs/pagosonline-functions.js"></script>
<script type="text/javascript" src="sjs/respuesta.js"></script>
<script src="sjs/jquery.print.js"></script>
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
              <div class="titulo-principal"><h1 class="title tareas" teid="pa:html:17"></h1></div>
              <?php require_once('../template/include/alerts.inc'); ?>
              <div style="width:350px; margin: 0px auto;">
                <h2 teid="pa:html:18"></h2>
								<table>
								<tr>
									<td teid="pa:html:19"></td>
									<td id="estadoTx"><?php echo $estadoTx; ?></td>
								</tr>
								<!--<tr>-->
									<tr>
										<td teid="pa:html:20"></td>
										<td id="transactionId"><?php echo $transactionId; ?></td>
									</tr>
									<tr>
										<td teid="pa:html:21"></td>
										<td id="reference_pol"><?php echo $reference_pol; ?></td> 
									</tr>
									<tr>
										<td teid="pa:html:22"></td>
										<td id="referenceCode"><?php echo $referenceCode; ?></td>
									</tr>
								<!--<tr>-->
								<?php
								if($banco_pse != null) {
								?>
									<tr>
										<td teid="pa:html:24"></td>
										<td id="cus"><?php echo $cus; ?> </td>
									</tr>
									<tr>
										<td teid="pa:html:23"></td>
										<td id="pseBank"><?php echo $pseBank; ?> </td>
									</tr>
								<?php
								}
								?>
									<tr>
										<td teid="pa:html:25"></td>
										<td id="TX_VALUE">$<?php echo number_format($TX_VALUE); ?></td>
									</tr>
									<tr>
										<td teid="pa:html:26"></td>
										<td id="currency"><?php echo $currency; ?></td>
									</tr>
									<tr>
										<td teid="pa:html:27"></td>
										<td id="extra1"><?php echo ($extra1); ?></td>
									</tr>
									<tr>
										<td teid="pa:html:28"></td>
										<td id="lapPaymentMethod"><?php echo ($lapPaymentMethod); ?></td>
									</tr>
								</table>   
                <div id="consolidado" style="margin:10px auto 0px auto; width:450px;">
                  <a type="btn" class="btn icono regresar ttip" teid="pa:html:31, pa:title:63" href="index.php"></a> <input type="button" class="btn ttip positivo" teid="pa:val:29, pa:title:62" id="btnprint" style="margin:5px 0px;"/> <!--<input type="button" class="btn" teid="pa:val:30" value="" id="btnsendemail" style="margin:5px 0px;"/>--> 
                  <div id="consolidado-print"></div>
                </div>
                <div id="resultado"></div>
              </div>
            </div>
          </section>
        </div>
    </body>
</html>
	
