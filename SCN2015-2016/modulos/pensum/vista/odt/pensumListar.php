<?php

	//extracción de la información
	$pensums = $this->obtenerDato('pensums');
	$patron = $this->obtenerDato("patron");
	$nbArch = $this->obtenerNombreArchivoDestino(); //extraer el nombre de archivo destino

	/**
	 * Tutoriel file
	 * Description : Merging a Segment within an array
	 * You need PHP 5.2 at least
	 * You need Zip Extension or PclZip library
	 *
	 * @copyright  GPL License 2008 - Julien Pauli - Cyril PIERRE de GEYER - Anaska (http://www.anaska.com)
	 * @license    http://www.gnu.org/copyleft/gpl.html  GPL License
	 * @version 1.3
	 */


	// Make sure you have Zip extension or PclZip library loaded
	// First : include the librairy

	$odf = new odf("modulos/instituto/vista/odt/listaPensums.odt");


	$odf->setVars('titre', 'Lista de Pensums');
	$message = "Patron de busqueda: '$patron'";
	$odf->setVars('message', $message);

	foreach( $pensums as $ins)
		$listeArticles[] = array( 'titre' => $ins->obtenerNombreCorto(), 'texte' => $ins->obtenerNombre());

	$article = $odf->setSegment('articles');

	foreach($listeArticles AS $element) {
		$article->titreArticle($element['titre']);

		$article->texteArticle($element['texte']);
		$article->merge();
	}
	$odf->mergeSegment($article);

	// We export the file
	$odf->exportAsAttachedFile($nbArch); 
?>
