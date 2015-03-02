<?php
	
	$estudiantes = Vista::obtenerDatos();
	$leyenda = Vista::obtenerDato("leyenda");

	if(isset($estudiantes['estudiante'])){
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
		$pdf->Cell(0,10,"ACTA DE NOTAS",0,0,'C',true);
		$pdf->Ln();
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Instituto",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['insti'],1,0,'C',true);
		$pdf->Ln();

		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Carrera",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['nombrepensum'],1,0,'C',true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Periodo Académico",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['periodo']." - ".($estudiantes['estudiante'][0]['periodo'] +1),1,0,'C',true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Trayecto/Año",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['num_trayecto'],1,0,'C',true);
		$pdf->Ln();

		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Unidad Curricular",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['nombreuni'],1,0,'C',true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Unidades de Crédito",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['uni_credito'],1,0,'C',true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Nota Aprobatoria",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['not_min_aprobatoria']."/".$estudiantes['estudiante'][0]['not_maxima'],1,0,'C',true);
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(40,7,"Profesor",1,0,'C',true);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(130,7,$estudiantes['estudiante'][0]['nombredocente'],1,0,'C',true);
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
		$pdf->Cell(0,5,"NOTAS",0,0,'C',true);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetFont('Arial','B',11);

		
		$pdf->Cell(15,10,"#",1,0,'C',true);
		$pdf->Cell(35,10,"Cédula",1,0,'C',true);
		$pdf->Cell(55,10,"Apellidos y Nombre",1,0,'C',true);
		$pdf->Cell(25,10,"Asistencia",1,0,'C',true);
		$pdf->Cell(15,10,"Nota",1,0,'C',true);
		$pdf->Cell(25,10,"Res.",1,0,'C',true);
		$pdf->Ln();

		$pdf->SetFont('Arial','',10);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0);
		
		for($i=0;$i<count($estudiantes['estudiante']);$i++){
			$pdf->Cell(15,8,$i+1,1,0,'C',true);
			$pdf->Cell(35,8,$estudiantes['estudiante'][$i]['cedula'],1,0,'C',true);
			$pdf->Cell(55,8,$estudiantes['estudiante'][$i]['nombreestudiante'],1,0,'C',true);
			$pdf->Cell(25,8,$estudiantes['estudiante'][$i]['por_asistencia']."%",1,0,'C',true);
			$pdf->Cell(15,8,$estudiantes['estudiante'][$i]['nota'],1,0,'C',true);
			
			$nota += $estudiantes['estudiante'][$i]['nota'];

			if($estudiantes['estudiante'][$i]['codestado'] == 'A'){
				$pdf->Cell(25,8,$estudiantes['estudiante'][$i]['codestado'],1,0,'C',true);
				$conta++;
			}
			else if(($estudiantes['estudiante'][$i]['codestado'] == 'N')&&($estudiantes['estudiante'][$i]['codestado'] == 'E')){
				$pdf->Cell(25,8,$estudiantes['estudiante'][$i]['codestado'],1,0,'C',true);
				$contr++;
			}
			else
				$pdf->Cell(25,8,$estudiantes['estudiante'][$i]['codestado'],1,0,'C',true);
			$pdf->Ln();
		}
		$cadena = "";

		$pdf->SetFont('Arial','',10);
		if($leyenda != NULL){
			for($j = 0; $j < count($leyenda); $j++){
				if(($j == 0)||($cadena == ""))				
					$cadena .= $leyenda[$j]['codigo']." = ".$leyenda[$j]['nombre'].".";
				else
					$cadena .= "       ".$leyenda[$j]['codigo']." = ".$leyenda[$j]['nombre'].".";
				if((($j % 3  == 0)&&($j != 0))||(($j+1) == count($leyenda))){
					$pdf->Cell(0,5,$cadena,0,0,'',true);					
					$pdf->Ln();
					$cadena = "";
				}
			}
		}			

		$pdf->SetFont('Arial','B',11);
		$pdf->Ln();
		$pdf->Cell(0,8,"Datos Estadísticos",0,0,'C',true);
		$pdf->Ln();
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0,8,"Promedio: ".$nota/$i."                     Aprobados: ".$conta."/".$i." - ".$conta/$i*(100)."%                     Reprobados: ".$contr."/".$i." - ".$contr/$i*(100)."%",0,0,'C',true);
		$pdf->SetFont('Arial','',11);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(0,8,"______________________________",0,0,'C',true);
		$pdf->Ln();
		$pdf->Cell(0,8,"Prof. ".$estudiantes['estudiante'][0]['nombredocente'],0,0,'C',true);
		$pdf->Ln();
		$pdf->Cell(0,8,"C.I. ".$estudiantes['estudiante'][0]['ceduladoc'],0,0,'C',true);

		$pdf->Output("Acta de Notas_".$estudiantes['estudiante'][0]['nombreuni'].".pdf", 'I');
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
