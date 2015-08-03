<?php
echo "<pre>";
var_dump($_REQUEST);













//echo "<pre>";
//var_dump(calcularImpuestos(16,$_REQUEST['amount'],true));
//var_dump(calcularImpuestos(16,$_REQUEST['amount'],false));
//
//var_dump(calcularImpuestos(5,$_REQUEST['amount'],true));
//var_dump(calcularImpuestos(5,$_REQUEST['amount'],false));



function calcularImpuestos($tasa=16, $monto, $incluido=true)
{
    if($incluido)
    {
        //Formula para calcular el impuesto IVA para colombia incluido en productos
        if($tasa==16){ $iva=1.16; }
        if($tasa==5){ $iva=1.05; }
        $valorSinIva = ($monto/$iva);
        $valorDelIva = $monto*($tasa/100);        
        $resultado=array($valorSinIva,$valorDelIva);
        return $resultado;
    }
    else
    {
        $valorDelIva = $monto*($tasa/100);        
        $resultado=array($monto,$valorDelIva);
        return $resultado;
    }
}

