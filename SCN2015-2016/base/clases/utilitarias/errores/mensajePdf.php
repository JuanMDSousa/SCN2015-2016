<?php

include ('recursos/fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Write (12,"Mensaje: ".$mensaje);
$pdf->Write (30,"Codigo error: ".$codigo);

$pdf->Output("salida.pdf",'I');

?>
