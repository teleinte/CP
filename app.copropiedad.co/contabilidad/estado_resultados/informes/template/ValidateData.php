<?php
$multiple = isset($_POST['multiple']) ? $_POST['multiple'] : null;
$unitario = isset($_POST['unitario']) ? $_POST['unitario'] : null;
$abierta = isset($_POST['abierta']) ? $_POST['abierta'] : null;


//echo "pilas este es el multiple".$multiple;
//echo "<pre>";
//var_dump($multiple);


if (validaPreguntas($multiple, "multiple"))
{    
    $errors=1;
}
if (validaPreguntas($unitario, "unitario"))
{    
    $errors=1;    
}
if (validaPreguntas($abierta, "abierta"))
{    
    $errors=1;    
}
if ($errors==1)
{
    exit;
}
else
{
    $i=0;    
    while($i<count($abierta))
    {
        //$usuario=$_POST['usuario'];
        $usuario="ed35rs2617yg";
        $partido=  explode("|", $abierta[$i]);
        $pregunta=$partido[2];
        $encuesta=$partido[3];
        $respuesta=$abierta[$i+1];
        $data = array(
        "token" =>$_POST['token'], 
        "body" => array(
            "id_encuesta" => $encuesta,
            "id_pregunta" => $pregunta,
            "enunciado" => $partido[4],
            "id_crm_persona" => $usuario,
            "tipo"=>"A",
            "respuesta" =>$respuesta
            ));        
        if($abierta[$i+1]!='' )
        {            
            enviodatos($data);
        }
        else
        {
            $sumador+=1;
            $y+=$sumador;
        }
        $partido="";
        $pregunta="";
        $encuesta="";
        $usuario="";
        $respuesta="";
        $i+=2;   
    } 
    
    $j=0;
//    echo "<pre>";
//    var_dump($multiple);
//    echo "<br>";
    while($j<count($multiple))
    {
        //$usuario=$_POST['usuario'];
        $usuario="ed35rs2617yg";
        $datoinicial=explode("|", $multiple[$j]);
        if($datoinicial[0]=="multiple")
        {
            $enunciado=$datoinicial[4];
            $id_encuestas=$datoinicial[3];
            $id_pregunta=$datoinicial[2];            
        }
        else
        {
            $data = array(
            "token" =>$_POST['token'], 
            "body" => array(
                "id_encuesta" => $id_encuestas,
                "id_pregunta" => $id_pregunta,
                "id_crm_persona" => $usuario,
                "enunciado" => $enunciado,
                "renunciado"=> $datoinicial[3],
                "tipo"=>"mr",
                "respuesta" =>$datoinicial[0]
                ));
//            echo "<pre>";
//            var_dump($data);
            enviodatos($data);
        }
        $j++;
    }
    
    $k=1;   
    $x=0;
    $sumador2=0;
//    echo "<pre>";
//    var_dump($unitario);
//    echo "<br>";
    while($k<count($unitario))
    {
        //$usuario=$_POST['usuario'];
        $usuario="ed35rs2617yg";
        $otrosdatos=explode("|", $unitario[$x]);        
        $partido=  explode("|", $unitario[$k]);        
        $pregunta=$partido[1];
        $encuesta=$partido[2];
        $respuesta=$partido[0];
        $data = array(
        "token" => $_POST['token'], 
        "body" => array(
            "id_encuesta" => $encuesta,
            "id_pregunta" => $pregunta,
            "id_crm_persona" => $usuario,
            "enunciado" => $otrosdatos[4],
            "renunciado"=> $partido[3],
            "tipo"=>"ur",
            "respuesta" =>$respuesta
            ));
        
//        echo "<pre>";
//        var_dump($data);        
        
        if($partido[0]!='' && $partido[0]!='unitario' )
        {            
            //echo "entro al envio datos";
            $x+=2;
            enviodatos($data);
            $sumador2+=1;
        }
        else
        {
            $sumador2+=1;
            $y+=$sumador2;
        }        
        $partido="";
        $pregunta="";
        $encuesta="";
        $usuario="";
        $respuesta="";        
        $k++;        
    }
    
     echo "cambio";    
}

function validaPreguntas($datos,$tipo)
{
    $error=0;
    $i=0;
    while($i<count($datos))
    {
        $sinPalo = explode("|", $datos[$i]);    
        if($sinPalo[1]==="SI")
        {
            $sinPalo2 = explode("|", $datos[$i+1]);            
            if($sinPalo2[0]===$tipo || $sinPalo2[0]==="")
            {
                if($tipo=="multiple")
                {
                    echo "<br>Debe seleccionar una o mas opciones en la pregunta: ".$sinPalo[4];                    
                }
                if ($tipo=="unitario")
                {
                    echo "<br>Debe seleccionar una opción en la pregunta: ".$sinPalo[4];                    
                }
                if($tipo=="abierta")
                {
                    echo "<br>Debe escribir algo en la pregunta: ".$sinPalo[4];
                }
                $error+=1;
                $i++;
            }
            else
            {
               $error+=0;
               $i++;
            }
        }
        else
        {
            $i++;
        }
    }
    return $error;
}



function enviodatos($arr)
{
//    echo "<pro>";
//    var_dump($arr);    
    $data = $arr;
    $data_string = json_encode($data);
    $ch = curl_init('http://aws02.sinfo.co/api/encuestas/encuesta/votar/');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Content-Type: application/json',                                                                                
        'Content-Length: ' . strlen($data_string))                                                                       
    );
    $result = json_decode(curl_exec($ch),true);
    //echo "<pro>";
    //var_dump($result);    
}

