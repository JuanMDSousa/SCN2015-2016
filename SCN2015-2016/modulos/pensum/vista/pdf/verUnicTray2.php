<?php
	$pensum = Vista::obtenerDato('pensum');

	if($pensum){
		
		$pdf = new FPDF('p','mm','A4');

		$pdf->AddPage();
		$pdf->SetFont('Arial','B',11);
		$pdf->SetTextColor(0);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetLeftMargin(15);
		$pdf->SetTopMargin(20);
		
		$pdf->Image('recursos/imgPropias/fotos/iut.png',20);
		$pdf->Image('recursos/imgPropias/fotos/head.png',70,10,200);		
		$pdf->Ln();			
		$pdf->SetFont('Arial','BI',12);
		$pdf->Cell(0,10,"",0,0,'C',false);
		$pdf->Ln();		
		$pdf->SetFillColor(255);
		$pdf->SetTextColor(0);		
		$pdf->Cell(190,5,"INFORMACIÓN DEL PENSUM",1,0,'C',true);		
		$pdf->Ln();	
		//ARMADA DE LA TABLA DE PENSUM
		$pdf->SetFont('Arial','',11);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Nombre del Pensum:",1,0,'C',true);	
		$pdf->SetFont('Arial','',11);	
		$pdf->Cell(150,5,$pensum->obtenerNombre(),1,0,'C',true);		
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Nombre Corto:",1,0,'C',true);
		$pdf->SetFont('Arial','',11);	
		$pdf->Cell(150,5,$pensum->obtenerNombreCorto(),1,0,'C',true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(40,5,"Observaciones:",1,0,'C',true);
		$pdf->SetFont('Arial','',11);	
		$pdf->Cell(150,5,$pensum->obtenerObservaciones(),1,0,'C',true);			
		
	
		//SEGUNDO TITULO DE PENSUM	

	
		
		$trayectos = $pensum->obtenerTrayectos();		
			for($i = 0; $i < count($trayectos); $i++){
				if($trayectos[$i]->obtenerCodigo() != NULL){					

						$pdf->SetFillColor(255);
						$pdf->SetTextColor(0);
						$pdf->Ln();
						$pdf->SetFont('Arial','BI',12);	
						$pdf->Cell(190,5,"TRAYECTO ".$trayectos[$i]->obtenerNumero()." / "."CERTIFICADO: ".$trayectos[$i]->obtenerCertificado()." / "."MINIMO DE CREDITO: ".$trayectos[$i]->obtenerMinCredito(),1,0,'C',true);			
						
								
						$pdf->SetFillColor(255);
						$pdf->SetTextColor(0);				
						$pdf->SetFont('Arial','BI',12);	
						$pdf->Ln();
						$pdf->Cell(190,5,"UNIDADES CURRICULARES DE TRAYECTO ".$trayectos[$i]->obtenerNumero(),1,0,'C',true);
						$pdf->SetFillColor(0);
						$pdf->SetTextColor(255);						
						$pdf->SetFont('Arial','',11);
						$pdf->SetFillColor(255,255,255);
						$pdf->SetTextColor(0);						
						$pdf->SetFont('Arial','B',10);
						$pdf->Ln();
						$pdf->Cell(85,5,"Nombre de la unidad curricular",1,0,'C',true);		
						$pdf->Cell(20,5,"C.U.Min",1,0,'C',true);
						$pdf->Cell(30,5,"Tipo",1,0,'C',true);
						$pdf->Cell(10,5,"HTA",1,0,'C',true);
						$pdf->Cell(10,5,"HTI",1,0,'C',true);
						$pdf->Cell(10,5,"U.C",1,0,'C',true);
						$pdf->Cell(10,5,"D.S",1,0,'C',true);
						$pdf->Cell(15,5,"N.A",1,0,'C',true);
						
					
					
																			
				}				
				$unidades = $trayectos[$i]->obtenerUnidades();				
				for($j = 0; $j < count($unidades); $j++){					
					if($unidades[$j]->obtenerNombre() != NULL){							
					$pdf->Ln();
					$pdf->SetFont('Arial','BI',8);					
					$pdf->Cell(85,5,$unidades[$j]->obtenerNombre(),1,0,'C',true);
					$pdf->SetFont('Arial','',11);
					$pdf->Cell(20,5,$unidades[$j]->obtenerCodUnidad(),1,0,'C',true);	
					$pdf->Cell(30,5,$unidades[$j]->obtenerTipo(),1,0,'C',true);
					$pdf->Cell(10,5,$unidades[$j]->obtenerHta(),1,0,'C',true);
					$pdf->Cell(10,5,$unidades[$j]->obtenerHti(),1,0,'C',true);
					$pdf->Cell(10,5,$unidades[$j]->obtenerUniCredito(),1,0,'C',true);
					$pdf->Cell(10,5,$unidades[$j]->obtenerDurSemana(),1,0,'C',true);
					$pdf->Cell(15,5,$unidades[$j]->obtenerNotMinima()."/".$unidades[$j]->obtenerNotMaxima(),1,0,'C',true);	
					
					}					
				}

			}	
			$pdf->Ln();	
			$pdf->Ln();				
			$pdf->SetFont('Arial','I',10);		
			$pdf->Cell(0,5,"Leyenda",0,0,'C',true);	
			$pdf->Ln();			
			$pdf->Cell(0,5,"C.U.Min = Codigo de unidad del ministerio",0,0,'C',true);	
			$pdf->Ln();	
			$pdf->Cell(0,5,"HTA = Horas de trabajo acompañado",0,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(0,5,"HTI = Horas de trabajo independiente",0,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(0,5,"U.C = Unidades de credito",0,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(0,5,"D.S = Duracion de semanas",0,0,'C',true);
			$pdf->Ln();
			$pdf->Cell(0,5,"N.A = Nota Minima y maxima Aprobatoria",0,0,'C',true);
			$pdf->Ln();
		$pdf->Output("Informacion curricular".$pensum->obtenerNombreCorto().".pdf", 'I');	
	}

?>
