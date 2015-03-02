<?php

	$estudiantes = Vista::obtenerDato('estudiante');
	$curso = Vista::obtenerDato("datocurso");
	
	$pdf = new FPDF('l','mm','A4');

	$pdf->AddPage();
	$pdf->SetFont('Arial','B',11);
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetLeftMargin(15);
	$pdf->SetTopMargin(22);
	
	$pdf->Image('recursos/imgPropias/fotos/iut.png',20);
	$pdf->Image('recursos/imgPropias/fotos/head.png',70,10,200);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(0,10,"LISTADO DE ESTUDIANTES DE ".$curso[0]['nombredep']." - PERIODO ".$curso[0]['periodo']." - TRAYECTO ".$curso[0]['num_trayecto'],0,0,'',true);
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(50,7,"UNIDAD CURRICULAR: ",0,0,'',true);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(80,7,"       ".$curso[0]['nombreuni'],0,0,'',true);
	$pdf->Ln();

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(40,7,"PROFESOR: ",0,0,'',true);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(80,7,"                ".$curso[0]['nombredocente'],0,0,'',true);
	$pdf->Ln();
	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(40,7,"SECCIÓN:",0,0,'',true);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(130,7,"                ".$curso[0]['seccion'],0,0,'',true);
	$pdf->Ln();
	$pdf->Ln();
	
	$alto = 7;
	$ancho = 22;

	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(10,$alto,"#",1,0,'C',true);
	$pdf->Cell(25,$alto,"Cédula",1,0,'C',true);
	$pdf->Cell(55,$alto,"Apellido y Nombre",1,0,'C',true);
	for($i = 0; $i < 8; $i++)
		$pdf->Cell($ancho,$alto,"",1,0,'C',true);
	$pdf->Ln();

	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0);

	for($i=0;$i<count($estudiantes);$i++){
		$pdf->Cell(10,$alto,$i+1,1,0,'C',true);
		$pdf->Cell(25,$alto,$estudiantes[$i]['cedula'],1,0,'C',true);
		$pdf->Cell(55,$alto,$estudiantes[$i]['apellido1'].", ".$estudiantes[$i]['nombre1'],1,0,'C',true);
		
		for($j = 0; $j < 8; $j++)
			$pdf->Cell($ancho,$alto,"",1,0,'C',true);
		$pdf->Ln();
	}

	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(0,10,"OBSERVACIONES: ",0,0,'',true);
	

	$pdf->Output("Acta de Notas ".$curso[0]['nombreuni'].".pdf", 'I');
?>