<?php

//extracción de la información
$institutos = $this->obtenerDato('institutos');
$patron = $this->obtenerDato("patron");
$nbArch = $this->obtenerNombreArchivoDestino(); //extraer el nombre de archivo destino

/* incluimos primeramente el archivo que contiene la clase fpdf */
include ('fpdf/fpdf.php');
/* tenemos que generar una instancia de la clase */
$pdf = new FPDF();
$pdf->AddPage();

/* seleccionamos el tipo, estilo y tamaño de la letra a utilizar */
$pdf->SetFont('Helvetica', 'B', 14);

$pdf->Write (12,"Lista de institutos. Patron de busqueda: '$patron'");

$pdf->Ln();
$pdf->Ln();

$pdf->Write(10, "#  N. Corto      Nombre");
$pdf->Ln();
$pdf->SetFont('Helvetica', 'I', 12);

$cont = 1;
foreach ($institutos as $ins) {
	$pdf->Write (12, $cont . ". " . $ins->obtenerNombreCorto() . ":        " . $ins->obtenerNombre());
	$pdf->Ln(); //salto de linea
	$cont++;
}
$pdf->Output($nbArch,'F');



?>
