<?php
	
	$trayectos = Vista::obtenerDatos();
	if(isset($trayectos['pensum'])){
		$conta = 0;
		$contr = 0;
		$nota = 0;
		$fec = getdate();

		$pdf = new FPDF('p','mm','A4');

		$pdf->AddPage();
		$pdf->SetFont('Arial','B',11);
		$pdf->SetTextColor(0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetLeftMargin(15);
		$pdf->SetTopMargin(20);
		
		$pdf->Image('recursos/imgPropias/fotos/iut.png',20);
		$pdf->Image('recursos/imgPropias/fotos/head.png',70,10,200);
		
		$pdf->SetFont('Arial','B',14);
		$pdf->Ln();
		$pdf->Cell(0,10,"INFORMACIÓN DE LOS TRAYECTOS DEL PENSUM",0,0,'C',true);
		$pdf->Ln();
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Pensum",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$trayectos['pensum'][0]['nombre'],1,0,'C',true);
		$pdf->Ln();

		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Nombre Corto",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$trayectos['pensum'][0]['nom_corto'],1,0,'C',true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Observaciones",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$trayectos['pensum'][0]['observaciones'],1,0,'C',true);
		$pdf->Ln();				

		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Fecha de Emisión",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		if($fec['hours']>11){
			$fec['hours']-=11;
			$a = "PM";
		}
		else
			$a = "AM";
		$pdf->Cell(130,7,$fec['hours'].":".$fec['minutes'].$a." - ".$fec['mday']."/".$fec['mon']."/".$fec['year'],1,0,'C',true);
		$pdf->Ln();
		
		$pdf->Ln();
		$pdf->SetFont('Arial','B',14);
		$pdf->SetTextColor(0);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();

		$pdf->Cell(0,5,"TRAYECTOS DEL PENSUM",0,0,'C',true);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetFont('Arial','B',11);
		$pdf->SetFillColor(0);
		$pdf->SetTextColor(255);
		
		$pdf->Cell(40,10,"Numero de Trayecto",1,0,'C',true);
		$pdf->Cell(80,10,"Cértificado",1,0,'C',true);
		$pdf->Cell(70,10,"Min Credito",1,0,'C',true);		
		$pdf->Ln();

		$pdf->SetFont('Arial','',11);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		
		for($i=0;$i<count($trayectos['pensum']);$i++){
			$pdf->Cell(40,8,$i,1,0,'C',true);
			$pdf->Cell(80,8,$trayectos['pensum'][$i]['certificado'],1,0,'C',true);
			$pdf->Cell(70,8,$trayectos['pensum'][$i]['min_credito'],1,0,'C',true);
		$pdf->Ln();
			
		}
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(0,8,"Informacion solo para visualizacion de los trayectos que posee el PENSUM",0,0,'C',true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',11);
		$pdf->Ln();		
		$pdf->SetFont('Arial','',11);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();	
		$pdf->Ln();
		$pdf->Cell(0,8,$trayectos['pensum'][0]['nombre'],0,0,'C',true);

		$pdf->Output("Trayectos".$trayectos['pensum'][0]['nom_corto'].".pdf", 'I');
	}
	else{
		$pdf = new FPDF('p','mm','A4');

		$pdf->AddPage();
		$pdf->SetFont('Arial','B',11);
		$pdf->SetTextColor(0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetLeftMargin(15);
		$pdf->SetTopMargin(20);
		
		$pdf->Image('recursos/imgPropias/fotos/iut.png',20);
		$pdf->Image('recursos/imgPropias/fotos/head.png',70,10,200);
		
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0,10,"SE HA PRODUCIDO UN ERROR,",0,0,'C',true);
		$pdf->Ln();
		$pdf->Cell(0,10,"VERIFIQUE LA INFORMACIÓN DEL CURSO,",0,0,'C',true);
		$pdf->Ln();
		$pdf->Output("Error.pdf", 'D');
	}

?>
