<?php

	$estudiantes = Vista::obtenerDato('estudiante');
	$curso = Vista::obtenerDato("datocurso");
	
	$odf = new odf("modulos/curso/vista/odt/listaAsistencia.odt");

	$odf->setVars("titulo","LISTADO DE ESTUDIANTES DE ".$curso[0]['nombredep']." - PERIODO ".$curso[0]['periodo']." - TRAYECTO ".$curso[0]['num_trayecto']);
	
	$odf->setVars("materia", $curso[0]['nombreuni']);

	$odf->setVars("profesor", $curso[0]['nombredocente']);

	$odf->setVars("seccion", $curso[0]['seccion']);

	foreach($estudiantes as $est)
		$listaArticulos[] = array( 'cedula' => $est[$i]['cedula'], 'nombre' => $est[$i]['apellido1'].", ".$est[$i]['nombre1']);

	$articulo = $odf->setSegment('articles');

	foreach($listaArticulos as $elementos){
		$articulo->titreArticle($element['cedula']);
		$articulo->texteArticle($element['nombre']);
		$articulo->merge();
	}

	$odf->mergeSegment($articulo);

	$odf->exportAsAttachedFile("Lista de Asistencia ".$curso[0]['nombreuni'].".odt");
?>