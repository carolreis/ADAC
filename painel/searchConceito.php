<?php 	
	require("config/config.php");
	require("classes/DAO/ConceitoDAO.class.php");
	
	$pesq = $_GET['term'];

	$conceitoObj = new ConceitoDAO();
	$conceitos = $conceitoObj->listar_nome($pesq);

	$dados = array();


	foreach ($conceitos as $c){
		$dados[] = array(
			'value' => $c["nm_conceito"],
			'cod' => $c["cod_conceito"],
		);
	}
	
	echo json_encode($dados);
