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
		$pdf->SetFillColor(0);
		$pdf->SetTextColor(255);		
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

						$pdf->SetFillColor(0);
						$pdf->SetTextColor(255);
						$pdf->Ln();
						$pdf->SetFont('Arial','BI',12);	
						$pdf->Cell(190,5,"TRAYECTO ".$trayectos[$i]->obtenerNumero()." / ".$trayectos[$i]->obtenerCertificado(),1,0,'C',true);		
						$pdf->Ln();
						$pdf->SetFont('Arial','',11);
						$pdf->SetFillColor(255,255,255);
						$pdf->SetTextColor(0);						
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Certificado:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);	
						$pdf->Cell(150,5,$trayectos[$i]->obtenerCertificado(),1,0,'C',true);
						$pdf->Ln();
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Min Credito:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);	
						$pdf->Cell(150,5,$trayectos[$i]->obtenerMinCredito(),1,0,'C',true);						
						$pdf->SetFillColor(0);
						$pdf->SetTextColor(255);				
						$pdf->SetFont('Arial','BI',12);	
						$pdf->Ln();
						$pdf->Cell(190,5,"UNIDADES CURRICULARES DE TRAYECTO ".$trayectos[$i]->obtenerNumero(),1,0,'C',true);
					
					
																			
				}				
				$unidades = $trayectos[$i]->obtenerUnidades();				
				for($j = 0; $j < count($unidades); $j++){					
					if($unidades[$j]->obtenerNombre() != NULL){							
						$pdf->SetFillColor(0);
						$pdf->SetTextColor(255);				
						$pdf->SetFont('Arial','I',10);	
						$pdf->Ln();
						$pdf->Cell(190,5,$unidades[$j]->obtenerNombre(),1,0,'L',true);	
						$pdf->Ln();
						$pdf->SetFont('Arial','',11);
						$pdf->SetFillColor(255,255,255);
						$pdf->SetTextColor(0);						
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Codigo del ministerio:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerCodUnidad(),1,0,'C',true);
						$pdf->Ln();
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Tipo:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerTipo(),1,0,'C',true);
						$pdf->Ln();
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Horas T.A:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerHta(),1,0,'C',true);
						$pdf->Ln();
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Horas T.I:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerHti(),1,0,'C',true);
						$pdf->Ln();
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Unidades de Credito",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerUniCredito(),1,0,'C',true);
						$pdf->Ln();										
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Duracion Semanas:",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerDurSemana(),1,0,'C',true);
						$pdf->Ln();
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,5,"Nota Min/Max Aprob",1,0,'C',true);
						$pdf->SetFont('Arial','',11);
						$pdf->Cell(150,5,$unidades[$j]->obtenerNotMinima()."/".$unidades[$j]->obtenerNotMaxima(),1,0,'C',true);
							
					}
				}
			}
		
		$pdf->Output("Informacion curricular".$pensum->obtenerNombreCorto().".pdf", 'I');
	
	}
?>
