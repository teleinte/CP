<?php
require("fpdf/fpdf.php");

class crearPdfModel extends FPDF
{
    public function Cabecera($logo , $tipoLogo, $fuente, $tipo_letra,$tamañoFuente, $nombreEmpresa,$nombreDocumento,$minicio,$ainicio,$mfinal,$afinal)
    {
        file_exists($logo);
        //Logo       ruta    x   y ancho alto formato
        $this->Image($logo , 10 ,8, 50);
        //               Arial bold 15
        $this->SetFont($fuente,$tipo_letra,$tamañoFuente);
        //Movernos a la derecha
        $this->Cell(80);
        //tamaño del cuatro 60*10 =>60,10, cadena de texto a mostrar,
        //Indica si los bordes deben se dibujados alrededor de la celda. El valor puede ser un número: 0: sin borde 1: marco o una cadena que contenga una o una 
            //combinación de los siguientes caracteres (en cualquier orden):L: izquierda T: superior  R: derecha  B: inferior
            //Valor por defecto: 0.
        //Indica donde la posición actula debería ir antes de invocar. Los valores posibles son: 0: a la derecha 1: al comienzo de la siguiente línea 2: debajo
        //align Permite centrar o alinear el texto. Los posibles valores son: L o una cadena vacia: alineación izquierda (valor por defecto) C: centro R: alineación derecha
        $this->Cell(110,10, $nombreEmpresa,0,2,'R');        
        //Salto de línea
        $fechador="fechas: Desde el ".$ainicio."-".$minicio."-01 Hasta el ".$afinal."-".$mfinal."-30";
        $this->Ln(1);
        $this->SetFont($fuente,$tipo_letra,10);
        $this->Cell(190,10, $nombreDocumento,0,1,'R');
        $this->Ln(1);
        $this->Cell(190,10,$fechador,0,1,'R');
    }
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

}