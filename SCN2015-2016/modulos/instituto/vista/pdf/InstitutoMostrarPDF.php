<?php
$institutos = $this->obtenerDato('institutos');
$ins = $institutos[0];

include ('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->Write (12,"Informacion del instituto");
$pdf->Ln();
$pdf->Write (10,"Nombre: " . $ins->obtenerNombre());
$pdf->Ln();
$pdf->Write (12,"Nombre corto: " . $ins->obtenerNombreCorto());
$pdf->Ln();
$pdf->Write (12,"Direccion: " . $ins->obtenerDireccion());
$pdf->Ln();
$pdf->Write (12,"Codigo: " . $ins->obtenerCodigo());
$pdf->Ln();
$pdf->Output("salida.pdf",'F');



?>
