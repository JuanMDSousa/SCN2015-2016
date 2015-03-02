<?php
$pensum = $this->obtenerDato('pensums');

include ('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->Write (12,"Informacion del pensums");
$pdf->Ln();
$pdf->Write (10,"Nombre: " . $pensum->obtenerNombre());
$pdf->Ln();
$pdf->Write (12,"Nombre corto: " . $pensum->obtenerNombreCorto());
$pdf->Ln();
$pdf->Write (12,"Observaciones: " . $pensum->obtenerObservaciones());
$pdf->Ln();
$pdf->Write (12,"Codigo: " . $pensum->obtenerCodigo());
$pdf->Ln();
$pdf->Write (12,"     Trayectos correspondientes");
$pdf->Ln();
$trayectos = $pensum->obtenerTrayectos();
foreach ($trayectos as $trayecto) {
	$pdf->Write (12,"             Trayecto ".$trayecto->obtenerNumero());
	$pdf->Ln();
	$pdf->Write (12,"                   Certificado: ".$trayecto->obtenerCertificado());
	$pdf->Ln();
	$pdf->Write (12,"                   Minimo de credito: ".$trayecto->obtenerMinCredito());
	$pdf->Ln();	
	$unidades=$trayecto->obtenerUnidades();
	$cantidadUnidades= count($unidades);
	
	$pdf->Write (12,"                   Cantidad de unidades de credito: ".$cantidadUnidades);
	$pdf->Ln();	
	$pdf->Write (12,"                             Unidades de credito del trayecto ");
	$pdf->Ln();	
	foreach ($unidades as $unidad) {
		$pdf->Write (12,"                                   Nombre: ".$unidad->obtenerNombre());
		$pdf->Ln();
		$pdf->Write (12,"                                         Codigo: ".$unidad->obtenerCodigo());
		$pdf->Ln();
		$pdf->Write (12,"                                         Codigo del ministerio: ".$unidad->obtenerCodUnidad());
		$pdf->Ln();
		$pdf->Write (12,"                                         Tipo: ".$unidad->obtenerTipo());
		$pdf->Ln();
		$pdf->Write (12,"                                         Horas de trabajo independiente: ".$unidad->obtenerHti());
		$pdf->Ln();
		$pdf->Write (12,"                                         Horas de trabajo con el docente: ".$unidad->obtenerHta());
		$pdf->Ln();
		$pdf->Write (12,"                                         Unidades de credito: ".$unidad->obtenerUniCredito());
		$pdf->Ln();
		$pdf->Write (12,"                                         Duracion de semanas: ".$unidad->obtenerDurSemana());
		$pdf->Ln();
		$pdf->Write (12,"                                         Nota minima: ".$unidad->obtenerNotMinima());
		$pdf->Ln();
		$pdf->Write (12,"                                         Nota maxima: ".$unidad->obtenerNotMaxima());
		$pdf->Ln();
	}
}
$pdf->Output("salida.pdf",'F');



?>
