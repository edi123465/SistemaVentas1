
<?php

//
require('../fpdf/fpdf.php');
include ("./Conexion.php");

class PDF extends FPDF
{
// Page header
function Header()
{
    $this->Image('../imag/logo.png', 240, 8, 33);

    $this->SetFont('Times', 'B', 16);
    
    $this->Cell(70, 10, utf8_decode('REPORTE DE RESERVAS'), 0, 0, 'C');
    $this->Ln(10);
    $this->SetFont('Times','',9);
    $this->Cell(110, 10, utf8_decode('Este reporte genera una impresión de todas las reservas registradas en la Base de Datos'), 0, 0, 'C');
    $this->Ln(5);
    $this->Cell(110, 10, utf8_decode('Las fechas de reserva y vuelo se pueden visualizar únicamente en este reporte'), 0, 0, 'C');
    
    $this->Ln(20);
    
    $this->SetFont('Times','',9);
    $this->SetTextColor(0);
    $this->SetDrawColor(226,90,152);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    
    $this->Cell(15.9, 10, 'ID Reserva', 1,0, 'C', 0);
    $this->Cell(14, 10, 'ID Vuelo', 1,0, 'C', 0);
    $this->Cell(15.7, 10, 'Aerolinea', 1,0, 'C', 0);
    $this->Cell(15.7, 10, utf8_decode('Categoría'), 1,0, 'C', 0);
    $this->Cell(15, 10, 'Horario', 1,0, 'C', 0);
    $this->Cell(19.8, 10, 'Precio Vuelo', 1,0, 'C', 0);
    $this->Cell(14, 10, 'Impuesto', 1,0, 'C', 0);
    $this->Cell(22, 10, 'Precio Reserva', 1,0, 'C', 0);
    $this->Cell(18, 10, utf8_decode('Cédula'), 1,0, 'C', 0);
    $this->Cell(40, 10, 'Nombres y Apellidos', 1,0, 'C', 0);
    $this->Cell(21, 10, 'N.Asientos', 1,0, 'C', 0);
    $this->Cell(21.5, 10, 'Fecha Reserva', 1,0, 'C', 0);
    $this->Cell(20, 10, 'Fecha Vuelo', 1,1, 'C', 0);
    
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Times','I',8);
    // Page number
    $this->Cell(0,10,utf8_decode('Pag.').$this->PageNo().'',0,0,'C');
}
}

$consulta = ("SELECT * FROM reserva re "
            . "INNER JOIN vuelo v on re.idvuelo_r = v.idvuelo " 
            . "INNER JOIN persona pe on re.cedula_r = pe.cedula");
$resultado = $con->query($consulta);




$pdf=new PDF('L','mm','Letter');
$pdf->AddPage();
$pdf->SetFont('Times','',9);
$pdf->SetDrawColor(153,89,128);

while ($fila = $resultado->fetch_assoc()){
    $idV=$fila['idvuelo_r'];
    $cedula=$fila['cedula_r'];
    
    $consultarV = ("SELECT * FROM vuelo WHERE idvuelo='$idV'");
    $resultadoA = $con->query($consulta);
    $consultaP = ("SELECT * FROM persona WHERE cedula='$cedula'");
    $resultadoP = $con->query($consultaP);
    $aerolinea = mysqli_fetch_assoc($resultadoA);
    $persona = mysqli_fetch_assoc($resultadoP);
                        
    $pdf->Cell(15.9, 10, $fila['id_reserva'], 1, 0, 'C', 0);
    $pdf->Cell(14, 10, $fila['idvuelo_r'], 1, 0, 'C', 0);
    $pdf->Cell(15.7, 10, $aerolinea['aerolinea'], 1, 0, 'C', 0);
    $pdf->Cell(15.7, 10, $aerolinea['categoria'], 1, 0, 'C', 0);
    $pdf->Cell(15, 10, $aerolinea['horarios'], 1, 0, 'C', 0);
    $pdf->Cell(19.8, 10, $aerolinea['precio'], 1, 0, 'C', 0);
    $pdf->Cell(14, 10, $aerolinea['impuesto'], 1, 0, 'C', 0);
    $pdf->Cell(22, 10, $fila['precio_reserva'], 1, 0, 'C', 0);
    $pdf->Cell(18, 10, $fila['cedula_r'], 1, 0, 'C', 0);
    $pdf->Cell(40, 10, $persona['nombres'].' '.$fila['apellidos'], 1, 0, 'C', 0);
    $pdf->Cell(21, 10, $fila['can_asientos'], 1, 0, 'C', 0);
    $pdf->Cell(21.5, 10, $fila['fecha_reserva'], 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $fila['fecha_vuelo'], 1, 1, 'C', 0);
}




    

$pdf->Output();
?>

