<?php
    setlocale(LC_MONETARY, 'es_CO');
    date_default_timezone_set('America/Bogota'); 
    error_reporting(E_ALL);ini_set('display_errors', 1);

    $datos=explode("^",base64_decode($_GET['id']));
    echo"<pre>";
    var_dump($datos);
    // exit();
    $tipos = array("p"=>"prueba","g"=>"general","r"=>"resultados","pr"=>"presupuesto","s"=>"servicios","a"=>"aportes","pt"=>"prueba/terceros","pp"=>"prueba/periodo");
    $nombres = array("p"=>"Balance de prueba","g"=>"Balance General","r"=>"Estado de Resultados","pr"=>"Presupuesto Anual","s"=>"Reporte de Servicios Publicos","a"=>"Aportes a Seguridad Social");
    $nombre = $datos[6];
    //$data=array("token"=>$datos[0],"body"=>array("id_copropiedad"=>$datos[2]));
    
    /******** DATOS DE PRUEBA CON COPROPIEDAD DE PRODUCCION ******/
    $data=array("token"=>$datos[0],"body"=>array("id_copropiedad"=>$datos[2]));
    $datos[3] = 'https://app.copropiedad.co/';
    /********/

    //var_dump($data);
    $tipoarc = $datos[5];
    $data_string = json_encode($data);
    //var_dump($datos[3] + '/api/contabilidad/balance/' + $tipos[$datos[1]] + '/');
    $urlbalance = $datos[3] . 'api/contabilidad/balance/' . $tipos[$datos[1]] . '/';
    //var_dump($urlbalance);
    $ch = curl_init($datos[3] . 'api/contabilidad/balance/' . $tipos[$datos[1]] . '/');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );
    $datosEnviados=curl_exec($ch);        
    $result = json_decode($datosEnviados,true); 
    //echo(json_encode($result));
    echo"<pre>";
    var_dump(json_encode($result));
    
    //var_dump($datos[3] . 'api/contabilidad/obtener/puc/');
    $ch = curl_init($datos[3] . 'api/contabilidad/obtener/puc/');
    $tipo = $datos[5];
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );
    $datosEnviados=curl_exec($ch);
    $oldpuc = json_decode($datosEnviados, true);
    $puc = adecuaPuc($oldpuc["message"][0]["puc"]);
    //var_dump($puc);    
    //var_dump($oldpuc["message"][0]["puc"]);


    if($tipos[$datos[1]]=="general")
    {
        echo "estamos por este lado";
        $nivel = $datos[4];    
        switch ($nivel) 
        {
            case 1:
                $nivelador=1;
                break;
            case 2:
                $nivelador=2;
                break;
            case 3:
                $nivelador=4;
                break;
            case 4:
                $nivelador=6;
                break;
            case 5:            
                $nivelador=8;
                break;
        }
        //echo "<br>esta es la cosa esta ".$nivelador;
        $si=array();
        $D=array();
        $C=array();
        $Dt=0;
        $Ct=0;
        $tot=0;
        $sit=0;
        foreach ($result["message"] as $llave=>$valor)
        {
            echo "<br><br><br>";
            var_dump($llave);
            $barra = substr($llave, 0, 1);            
            echo "<br>esta es la barra ".$barra;
            //exit();
            if (substr($llave, 0, 1)==1 OR substr($llave, 0, 1)==2 OR substr($llave, 0, 1)==3)
            {
                foreach ($valor as $key=>$value)
                {
                    var_dump($value);
                }
            }
            
        }



    }
    else
    {
        echo "no pasa nada no pasa nada";
    }

    exit();



    $nivel = $datos[4];    
    switch ($nivel) 
    {
        case 1:
            $nivelador=1;
            break;
        case 2:
            $nivelador=2;
            break;
        case 3:
            $nivelador=4;
            break;
        case 4:
            $nivelador=6;
            break;
        case 5:            
            $nivelador=8;
            break;
    }    
    $si=array();
    $D=array();
    $C=array();
    $Dt=0;
    $Ct=0;
    $tot=0;
    $sit=0;
    if($tipoarc=="pdf")
    {
        foreach ($result["message"] as $llave=>$valor)
        {
            foreach ($valor as $key=>$value)
            {
                if($key=="SI")
                {
                    ksort($value,2);                                        
                    foreach ($value as $llevesota=>$valarsote)
                    {                           
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $sit+=$varlofinal;
                                }                        
                                $si[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
                if($key=="D")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $Dt+=$varlofinal;
                                }                        
                                $D[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
                if($key=="C")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $Ct+=$varlofinal;
                                }                        
                                $C[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
            }   
        }
        ksort($si,2);
        ksort($D,2);
        ksort($C,2);
        // echo "<pre>";
        // var_dump($si);

        $aregloKey=array();
        if (count($D)!=0)
        {
            foreach($D as $llave=>$valor)
            {
                if(!array_key_exists($llave,$aregloKey))
                {
                    //echo "entramos por este lado".$llave;
                    $aregloKey[$llave]=0;
                }
            }
        }                            
        if (count($C)!=0)
        {
            foreach($C as $llave=>$valor)
            {
                if(!array_key_exists($llave,$aregloKey))
                {
                    //echo "entramos por este lado DOS".$llave;
                    $aregloKey[$llave]=0;
                }
            }
        }
        if (count($si)!=0)
        {
            foreach($si as $llave=>$valor)
            {
                if(!array_key_exists($llave,$aregloKey))
                {
                    //echo "entramos por este lado TRES".$llave;
                    $aregloKey[$llave]=0;
                }
            }
        }
        ksort($aregloKey,2);        
         echo "<pre>";
         var_dump($aregloKey);
        // exit;
        
        // include("class/crearPdfModel.php");
        //  $cabeceraArchivo = new crearPdfModel();
        //  $cabeceraArchivo->AliasNbPages();
        //  $cabeceraArchivo->AddPage();
        //  $cabeceraArchivo->Cabecera("../images/logo-home.png","PNG", "Arial", "B", "15",  $nombre, $nombres[$datos[1]]);        
        //  $cabeceraArchivo->SetFontSize(8);
        //  $cabeceraArchivo->Cell(15,4,"CUENTA");
        //  $cabeceraArchivo->Cell(70,4,"NOMBRE CUENTA");
        //  $cabeceraArchivo->Cell(31,4,"SALDO INICIAL",0,0,'R');
        //  $cabeceraArchivo->Cell(26,4,"DEBITO",0,0,'R');
        //  $cabeceraArchivo->Cell(26,4,"CREDITO",0,0,'R');
        //  $cabeceraArchivo->Cell(26,4,"SALDO FINAL",0,0,'R');
        //  $cabeceraArchivo->Line(26,40,202,40);
        //  $cabeceraArchivo->Ln();
        //  $cabeceraArchivo->SetFont("Arial", "", 8);
        //  $tot=0;
        // // //var_dump($cabeceraArchivo);
        //  $res=0;
        // foreach ($aregloKey as $llave=>$valor)
        // {
        //     $contador=$llave."a";            
        //     if($contador[0]  == 2 || $contador[0] == 3 || $contador[0] == 4)
        //     {
        //         if(!isset($C[$llave])){$C[$llave]=0;}if(!isset($D[$llave])){$D[$llave]=0;}if(!isset($si[$llave])){$si[$llave]=0;}
        //         if(array_key_exists($llave,$puc)){$nombrador = $puc[$llave];}
        //         else {$nombrador = "No existe la cuenta";}                                
        //         $res = $si[$llave] + $C[$llave] - $D[$llave];
        //         if (strlen($llave)==1 || strlen($llave)==2)
        //         {
        //             if(strlen($llave)==1){$tot+=$res;}
        //             $cabeceraArchivo->SetFont("Arial", "B", 8);
        //             $cabeceraArchivo->Cell(15,4,$llave);
        //             if(strlen($nombrador)>40){$cabeceraArchivo->Cell(70,4,substr($nombrador, 0, 40)."...");}
        //             else {$cabeceraArchivo->Cell(70,4,$nombrador);}
                    
        //             if($si[$llave]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(29,4,money_format('%(#1n',$si[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$si[$llave]),0,0,'R');}                    
        //             if($D[$llave]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');}                    
        //             if($C[$llave]){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');}
        //             if($res<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');}
        //         }
        //         else
        //         {
        //             $cabeceraArchivo->SetFont("Arial", "", 8);
        //             $cabeceraArchivo->Cell(15,4,$llave);                    
        //             if(strlen($nombrador)>40){$cabeceraArchivo->Cell(70,4,substr($nombrador, 0, 40)."...");}
        //             else {$cabeceraArchivo->Cell(70,4,$nombrador);}
                    
        //             if($si[$llave]<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$si[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$si[$llave]),0,0,'R');}
        //             if($D[$llave]<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');}
        //             if($C[$llave]<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');}
        //             if($res<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');}
        //         }
                
        //     }
        //     else
        //     {
        //         if(!isset($C[$llave])){$C[$llave]=0;}if(!isset($D[$llave])){$D[$llave]=0;}if(!isset($si[$llave])){$si[$llave]=0;}
        //         //echo "<br>".$llave."---------".$valor.'--------'.$D[$llave].'------------'.$C[$llave].'---------------'.$res;
        //         //exit;
        //         $res = $si[$llave] + $D[$llave] - $C[$llave];
        //         //echo "<br>".$llave."---------".$valor.'--------'.$D[$llave].'------------'.$C[$llave].'---------------'.$res;
        //         if(array_key_exists($llave,$puc)){$nombrador = $puc[$llave];}
        //         else {$nombrador = "No existe la cuenta";}
        //         if (strlen($llave)==1 || strlen($llave)==2)
        //         {
        //             if(strlen($llave)==1){$tot+=$res;}
        //             $cabeceraArchivo->SetFont("Arial", "B", 8);
        //             $cabeceraArchivo->Cell(15,4,$llave);
        //             if(strlen($nombrador)>40){$cabeceraArchivo->Cell(70,4,substr($nombrador, 0, 40)."...");}
        //             else {$cabeceraArchivo->Cell(70,4,$nombrador);}
                    
        //             if($si[$llave]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(29,4,money_format('%(#1n',$si[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$si[$llave]),0,0,'R');}
        //             if($D[$llave]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');}
        //             if($C[$llave]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');}
        //             if($res<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');}
        //         }
        //         else
        //         {
        //             $cabeceraArchivo->SetFont("Arial", "", 8);
        //             $cabeceraArchivo->Cell(15,4,$llave);
        //             if(strlen($nombrador)>40){$cabeceraArchivo->Cell(70,4,substr($nombrador, 0, 40)."...");}
        //             else {$cabeceraArchivo->Cell(70,4,$nombrador);}
        //             if($si[$llave]<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$si[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$si[$llave]),0,0,'R');}
        //             if($D[$llave]<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$D[$llave]),0,0,'R');}
        //             if($C[$llave]<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$C[$llave]),0,0,'R');}
        //             if($res<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
        //             else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$res),0,0,'R');}
        //         }            
        //     }
        //     $cabeceraArchivo->Ln();
        // }
        // $cabeceraArchivo->SetFont("Arial", "B", 8);
        // $cabeceraArchivo->Cell(15,4,"");
        // $cabeceraArchivo->Cell(70,4,"TOTAL GENERAL");        
        // $cabeceraArchivo->Cell(31,4,money_format('%(#1n',$sit),0,0,'R');        
        // $cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Dt),0,0,'R');
        // $cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Ct),0,0,'R');
        // $cabeceraArchivo->Cell(26,4,money_format('%(#1n',$tot),0,0,'R');        
        // $cabeceraArchivo->Output();
    }
    if($tipoarc=="xls")
    {
        foreach ($result["message"] as $llave=>$valor)
        {
            foreach ($valor as $key=>$value)
            {
                if($key=="SI")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $sit+=$varlofinal;
                                }                        
                                $si[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
                if($key=="D")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $Dt+=$varlofinal;
                                }                        
                                $D[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
                if($key=="C")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $Ct+=$varlofinal;
                                }                        
                                $C[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
            }   
        }
        ksort($si,2);
        ksort($D,2);
        ksort($C,2);
        $stringPagina="";
        $stringPagina.='<table cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
        <tr>
            <td style="font-size: 18; color: #054585">NOMBRE DE LA COPRIOPIEDAD</td>
        </tr>    
        <tr>
            <td style="font-size: 16;  color: #054585">BALANCE DE PRUEBAS</td>
        </tr>
    <table>
    <br>
    <br>
    <br>
    <table style="font-size: 14;">
        <tr>
            <td ><strong>CUENTA</strong></td>
            <td ><strong>Nombre de la cuenta</strong></td>
            <td ><strong>Saldo Inicial</strong></td>
            <td ><strong>Debitos</strong></td>
            <td ><strong>Creditos</strong></td>
            <td ><strong>Nuevo Saldo</strong></td>
        </tr>
    ';    
    $tot=0;
        foreach ($si as $llave=>$valor)
        {
            $stringPagina.= "<tr>";
            $contador=$llave."a";
            if(array_key_exists($llave,$puc)){$nombrador = $puc[$llave];} else {$nombrador = "No existe la cuenta";}
            //var_dump($llave);
            if($contador[0]  == 2 || $contador[0] == 3 || $contador[0] == 4)
            {
                $res = $valor + $C[$llave] - $D[$llave];
                if (strlen($llave)==1 || strlen($llave)==2)
                {
                    if(strlen($llave)==1){$tot+=$res;}
                    $stringPagina.= '<td><strong>'.$llave.'</strong></td>';
                    $stringPagina.= '<td><strong>'.$nombrador.'</strong></td>';
                    if($valor<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$valor).'</strong></td>';}else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$valor).'</strong></td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}            
                    if($C[$llave]<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    if($res<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                }
                else
                {
                    $stringPagina.= '<td>'.$llave.'</td>';
                    $stringPagina.= '<td>'.$nombrador.'</td>';
                    if($valor<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$valor).'</td>';}else{$stringPagina.= '<td>'.money_format('%(#10n',$valor).'</td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$D[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$D[$llave]).'</td>';}            
                    if($C[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$C[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$C[$llave]).'</td>';}
                    if($res<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$res).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$res).'</td>';}
                }
                //echo "<br>".$llave."---------".$valor.'--------'.$D[$llave].'------------'.$C[$llave].'---------------'.$res;
            }
            else
            {
                $res = $valor + $D[$llave] - $C[$llave];
                //echo "<br>".$llave."---------".$valor.'--------'.$D[$llave].'------------'.$C[$llave].'---------------'.$res;
                if (strlen($llave)==1 || strlen($llave)==2)
                {
                    if(strlen($llave)==1){$tot+=$res; }
                    $stringPagina.= '<td><strong>'.$llave.'</strong></td>';
                    $stringPagina.= '<td><strong>'.$nombrador.'</strong></td>';
                    if($valor<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$valor).'</strong></td>';}else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$valor).'</strong></td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}            
                    if($C[$llave]<0){echo '<td style="color:red"><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    if($res<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                }
                else
                {
                    $stringPagina.= '<td>'.$llave.'</td>';
                    $stringPagina.= '<td>'.$nombrador.'</td>';
                    if($valor<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$valor).'</td>';}else{$stringPagina.= '<td>'.money_format('%(#10n',$valor).'</td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$D[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$D[$llave]).'</td>';}            
                    if($C[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$C[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$C[$llave]).'</td>';}
                    if($res<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$res).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$res).'</td>';}
                }            
            }
            $stringPagina.= "</tr>";
        }
        $stringPagina.="
            <tr>
                <td colspan='2' style='font-size: 14;'><strong>TOTAL GENERAL</strong></td>
                <td style='font-size: 14;'><strong>".money_format('%(#10n',$sit)."</strong></td>
                <td style='font-size: 14;'><strong>".money_format('%(#10n',$Dt)."</strong></td>
                <td style='font-size: 14;'><strong>".money_format('%(#10n',$Ct)."</strong></td>
                <td style='font-size: 14;'><strong>".money_format('%(#10n',$tot)."</strong></td>
            </tr>";
        $stringPagina.= '</table>';        
        if($tipo=="xls")xls($stringPagina);        
    }
    if($tipoarc=="pantalla")
    {   
        $stringPagina="<!DOCTYPE html>
        <html>
        <head>
            <title>INFORME</title>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        </head>";
        foreach ($result["message"] as $llave=>$valor)
        {
            foreach ($valor as $key=>$value)
            {
                if($key=="SI")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $sit+=$varlofinal;
                                }                        
                                $si[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
                if($key=="D")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $Dt+=$varlofinal;
                                }                        
                                $D[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
                if($key=="C")
                {
                    ksort($value,2);
                    foreach ($value as $llevesota=>$valarsote)
                    {   
                        ksort($valarsote,2);
                        foreach ($valarsote as $llavefinal=>$varlofinal)
                        {
                            $tomador=$llavefinal."a";
                            if((strlen($tomador)-1)<=$nivelador)
                            {
                                if(strlen($tomador)==2)
                                {
                                    //echo '<br>'.$llavefinal.'----------'.$varlofinal;
                                    $Ct+=$varlofinal;
                                }                        
                                $C[$llavefinal]=$varlofinal;
                            }
                        }
                    }
                }
            }   
        }
        ksort($si,2);
        ksort($D,2);        
        ksort($C,2);        
        $stringPagina.="<body>";
        $stringPagina.='<table cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
        <tr>
            <td style="font-size: 18; color: #054585">NOMBRE DE LA COPRIOPIEDAD</td>
        </tr>    
        <tr>
            <td style="font-size: 16;  color: #054585">BALANCE DE PRUEBAS</td>
        </tr>
        <table>
        <br>
        <br>
        <br>
        <table style="font-size: 8;">
        <tr>
            <td style="font-size: 12;">Cuenta</td>
            <td style="font-size: 12;">Nombre de la cuenta</td>
            <td style="font-size: 12;">Saldo Inicial</td>
            <td style="font-size: 12;">Debitos</td>
            <td style="font-size: 12;">Creditos</td>
            <td style="font-size: 12;">Nuevo Saldo</td>
        </tr>
    ';    
    $tot=0;
        foreach ($si as $llave=>$valor)
        {
            $stringPagina.= "<tr>";
            $contador=$llave."a";
            if($contador[0]  == 2 || $contador[0] == 3 || $contador[0] == 4)
            {
                if(array_key_exists($llave,$puc)){$nombrador = $puc[$llave];}
                else {$nombrador = "No existe la cuenta";}
                $res = $valor + $C[$llave] - $D[$llave];
                if (strlen($llave)==1 || strlen($llave)==2)
                {
                    if(strlen($llave)==1){$tot+=$res;}
                    $stringPagina.= '<td><strong>'.$llave.'</strong></td>';
                    $stringPagina.= '<td><strong>'.$nombrador.'</strong></td>';
                    if($valor<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$valor).'</strong></td>';}else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$valor).'</strong></td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}            
                    if($C[$llave]<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    if($res<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                }
                else
                {
                    $stringPagina.= '<td>'.$llave.'</td>';
                    $stringPagina.= '<td>'.$nombrador.'</td>';
                    if($valor<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$valor).'</td>';}else{$stringPagina.= '<td>'.money_format('%(#10n',$valor).'</td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$D[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$D[$llave]).'</td>';}            
                    if($C[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$C[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$C[$llave]).'</td>';}
                    if($res<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$res).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$res).'</td>';}
                }
                //echo "<br>".$llave."---------".$valor.'--------'.$D[$llave].'------------'.$C[$llave].'---------------'.$res;
            }
            else
            {
                $res = $valor + $D[$llave] - $C[$llave];
                //echo "<br>".$llave."---------".$valor.'--------'.$D[$llave].'------------'.$C[$llave].'---------------'.$res;
                if(array_key_exists($llave,$puc)){$nombrador = $puc[$llave];} else { $nombrador = "No existe la cuenta"; }
                
                if (strlen($llave)==1 || strlen($llave)==2)
                {
                    if(strlen($llave)==1){$tot+=$res; }
                    $stringPagina.= '<td><strong>'.$llave.'</strong></td>';
                    $stringPagina.= '<td><strong>'.$nombrador.'</strong></td>';
                    if($valor<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$valor).'</strong></td>';}else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$valor).'</strong></td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$D[$llave]).'</strong></td>';}            
                    if($C[$llave]<0){echo '<td style="color:red"><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$C[$llave]).'</strong></td>';}
                    if($res<0){$stringPagina.= '<td style="color:red"><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                    else{$stringPagina.= '<td><strong>'.money_format('%(#10n',$res).'</strong></td>';}
                }
                else
                {
                    $stringPagina.= '<td>'.$llave.'</td>';
                    $stringPagina.= '<td>'.$nombrador.'</td>';
                    if($valor<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$valor).'</td>';}else{$stringPagina.= '<td>'.money_format('%(#10n',$valor).'</td>';}
                    if($D[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$D[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$D[$llave]).'</td>';}            
                    if($C[$llave]<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$C[$llave]).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$C[$llave]).'</td>';}
                    if($res<0){$stringPagina.= '<td style="color:red">'.money_format('%(#10n',$res).'</td>';}
                    else{$stringPagina.= '<td>'.money_format('%(#10n',$res).'</td>';}
                }            
            }
            $stringPagina.= "</tr>";
        }
        $stringPagina.="
            <tr>
                <td colspan='2'><strong>TOTAL GENERAL</strong></td>
                <td><strong>".money_format('%(#10n',$sit)."</strong></td>
                <td><strong>".money_format('%(#10n',$Dt)."</strong></td>
                <td><strong>".money_format('%(#10n',$Ct)."</strong></td>
                <td><strong>".money_format('%(#10n',$tot)."</strong></td>
            </tr>";
        $stringPagina.= '</table>';
        $stringPagina.="</body>";
        $stringPagina.="</html>";
        //echo "$stringPagina";
        if($tipo=="pantalla"){pantalla($stringPagina);}
}

function adecuaPuc($puc)
{
    $newpuc = Array();
    foreach ($puc as $key => $value) 
    {
        $newpuc[$value["cuenta"]] = $value["nombre"];   
    }
    return $newpuc;
}