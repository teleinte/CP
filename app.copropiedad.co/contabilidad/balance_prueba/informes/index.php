<?php 
    setlocale(LC_MONETARY, 'es_CO');
    date_default_timezone_set('America/Bogota'); 
    $datos=explode("^",base64_decode($_GET['id']));
    $tipos = array("p"=>"prueba","g"=>"general","r"=>"resultados","pr"=>"presupuesto","s"=>"servicios","a"=>"aportes","pt"=>"prueba/terceros","pp"=>"prueba/periodo");
    $nombres = array("p"=>"Balance de prueba","g"=>"Balance General","r"=>"Estado de Resultados","pr"=>"Presupuesto Anual","s"=>"Reporte de Servicios Publicos","a"=>"Aportes a Seguridad Social");
    $nombre = $datos[6];
    $copropiedades = $datos[2];
    $mesi = $datos[7];
    $anoi = $datos[8];
    $mesf = $datos[9];
    $anof = $datos[10];

    //echo "<pre>";

    $data=array("token"=>$datos[0],"body"=>array("id_copropiedad"=>$copropiedades,"tipo"=>true, "mesinicio"=>$mesi, "anoinicio"=>$anoi, "mesfin"=>$mesf, "anofin"=>$anof));
    $datos[3] = 'https://app.copropiedad.co/';
    $tipoarc = $datos[5];
    $data_string = json_encode($data);
    $urlbalance = $datos[3] . 'api/contabilidad/balance/pruebaintegrado/';
    $ch = curl_init($datos[3] . 'api/contabilidad/balance/pruebaintegrado/');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))
    );
    $datosEnviados=curl_exec($ch);        
    $result = json_decode($datosEnviados,true); 
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
    $Sit=0;
    $Ct=0;
    $Tott=0;
    $sit=0;
    $formacion="";
    $tomador="";
    //var_dump($datosEnviados);
    foreach ($result["message"] as $llave=>$valor)
    {
        foreach ($valor as $a=>$b)
        {
            $tot=0;
            //echo "<br>Esta es la llave ---->".$a." Este es el valor ---->".$b;
            if($a=="mov")
            {

                $tomador=$llave."a";
                //echo "<br><br>Antes de todas estas cosas".(strlen($tomador)-1)." nivelador ".$nivelador;
                // exit;
                if((strlen($tomador)-1)<=$nivelador)
                {
                    $formacion.=$llave.",".$valor["nombre"]; 
                    $formacion.=",".$b["si"].",".$b["d"].",".$b["c"];
                    //echo "<br>esta es la cosa".$tomador ."LLAVEEEE".$llave." nivelador ".$nivelador;
                    if(substr($llave, 0, 1)==2 or substr($llave, 0, 1)==3 or substr($llave, 0, 1)==4)
                    {
                       $tot=$b["si"]+$b["c"]-$b["d"];
                       $formacion.=",".$tot."|";
                       if((strlen($tomador)-1)==1)
                       {
                            $Sit+=$b["si"];
                            $Dt+=$b["d"];
                            $Ct+=$b["c"];
                            $Tott+=$tot;
                       }
                    }
                    else
                    {
                        $tot=$b["si"]-$b["c"]+$b["d"];                       
                        $formacion.=",".$tot."|";
                        if((strlen($tomador)-1)==1)
                       {
                            $Sit+=$b["si"];
                            $Dt+=$b["d"];
                            $Ct+=$b["c"];
                            $Tott+=$tot;
                       }                    
                    }
                }
            }
        }
    }
    $formacion = substr($formacion, 0, -1);
    // echo "<pre>";
    // echo "este es el final".$formacion;
     include("class/crearPdfModel.php");
     $cabeceraArchivo = new crearPdfModel();
     $cabeceraArchivo->AliasNbPages();
     $cabeceraArchivo->AddPage();
     $cabeceraArchivo->Cabecera("../../../template/images/logo-home.png","PNG", "Arial", "B", "15",  $nombre, $nombres[$datos[1]],$mesi,$anoi,$mesf,$anof);
     $cabeceraArchivo->SetFontSize(8);
     $cabeceraArchivo->Cell(15,4,"CUENTA");
     $cabeceraArchivo->Cell(70,4,"NOMBRE CUENTA");
     $cabeceraArchivo->Cell(31,4,"SALDO INICIAL",0,0,'R');
     $cabeceraArchivo->Cell(26,4,"DEBITO",0,0,'R');
     $cabeceraArchivo->Cell(26,4,"CREDITO",0,0,'R');
     $cabeceraArchivo->Cell(26,4,"SALDO FINAL",0,0,'R');
     $cabeceraArchivo->Line(5,40,202,40);
     $cabeceraArchivo->Ln();
     $cabeceraArchivo->SetFont("Arial", "", 8);

     $mostrador=explode("|",$formacion);
     foreach ($mostrador as $validador)
     {

        $muestra=explode(",", $validador);        
        $cabeceraArchivo->SetFont("Arial", "B", 8);
        
        if(strlen($muestra[0])<=1)
        {
            $cabeceraArchivo->Ln();
            //numero de la cuenta
            $cabeceraArchivo->Cell(15,4, $muestra[0]);
            //nombre de la cuentaq
            if(strlen($muestra[1])>40){$cabeceraArchivo->Cell(70,4,substr($muestra[1], 0, 40)."...");}
            else {$cabeceraArchivo->Cell(70,4,$muestra[1]);}
            // saldos iniciales
            if($muestra[2]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[2]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$muestra[2]),0,0,'R');} 
            // debitos
            if($muestra[3]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[3]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$muestra[3]),0,0,'R');} 
            // Creditos
            if($muestra[4]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[4]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$muestra[4]),0,0,'R');}                    
            // Totales    
            if($muestra[5]<0){$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[5]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "B", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$muestra[5]),0,0,'R');}
            //Siguente linea
            $cabeceraArchivo->Ln();
            $cabeceraArchivo->Line(10,$cabeceraArchivo->GetY(),203,$cabeceraArchivo->GetY());
        }
        else
        {
            //numero de la cuenta
            $cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(15,4, $muestra[0]);
            //nombre de la cuentaq
            if(strlen($muestra[1])>40){$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(70,4,substr($muestra[1], 0, 40)."...");}
            else {$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(70,4,$muestra[1]);}
            // saldos iniciales
            if($muestra[2]<0){$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[2]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$muestra[2]),0,0,'R');} 
            // debitos
            if($muestra[3]<0){$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[3]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$muestra[3]),0,0,'R');} 
            // Creditos
            if($muestra[4]<0){$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[4]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$muestra[4]),0,0,'R');}                    
            // Totales    
            if($muestra[5]<0){$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(27,4,money_format('%(#1n',$muestra[5]),0,0,'R');$cabeceraArchivo->SetTextColor(0,0,0);}
            else{$cabeceraArchivo->SetFont("Arial", "", 8);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$muestra[5]),0,0,'R');}
            //Siguente linea
            $cabeceraArchivo->Ln();
        }
     }
     $cabeceraArchivo->SetFont("Arial", "B", 8);
     $cabeceraArchivo->Cell(15,4,"");
     $cabeceraArchivo->Ln();
     $cabeceraArchivo->Line(10,$cabeceraArchivo->GetY(),203,$cabeceraArchivo->GetY());
     $cabeceraArchivo->Cell(70,4,"TOTAL GENERAL");
     if ($Sit<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$Sit),0,0,'R');}
     else{$cabeceraArchivo->Cell(31,4,money_format('%(#1n',$Sit),0,0,'R');}
     if ($Dt<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Dt),0,0,'R');}
     else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Dt),0,0,'R');}
     if ($Ct<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Ct),0,0,'R');}
     else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Ct),0,0,'R');}
     if ($Tott<0){$cabeceraArchivo->SetTextColor(135,14,14);$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Tott),0,0,'R');}
     else{$cabeceraArchivo->Cell(26,4,money_format('%(#1n',$Tott),0,0,'R');}    
     $cabeceraArchivo->Ln();
     $cabeceraArchivo->Line(10,$cabeceraArchivo->GetY(),203,$cabeceraArchivo->GetY());
     
     $cabeceraArchivo->Output();
    exit;

    
