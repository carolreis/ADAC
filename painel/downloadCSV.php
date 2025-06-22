<?php session_start();

	require("config/config.php");
	require("classes/DAO/ResultadoDAO.class.php");
	
	$resultados = new resultadoDAO();
	$relatorio = $resultados->relatorioEntrevista();

	$csvArray = array();

	for ($j=0; $j < count($relatorio); $j++) {
		array_push($csvArray, array(
			trim($relatorio[$j][0]),
			trim($relatorio[$j][1]),
			trim($relatorio[$j][2]),
			trim($relatorio[$j][3]),
			trim($relatorio[$j][4]),
			trim($relatorio[$j][5]),
			trim($relatorio[$j][6]),
			trim(gmdate("H:i:s", $relatorio[$j][7]))
		));
	}

	$headers = array(); 
	for ($i=1; $i < count($relatorio[0]); $i+=2) {     
       array_push($headers, array_keys($relatorio[0])[$i]);
	} 

	$filename = "relatorioEntrevista.csv";

	header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    $f = fopen('php://output', 'w');
    
    fputcsv($f, $headers, ';'); 

    foreach ($csvArray as $line) {
        fputcsv($f, $line, ';');
    }
