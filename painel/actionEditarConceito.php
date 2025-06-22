<?php 
	session_start();
	include("functions/lib.php");
	require("config/config.php");
	require("classes/Conceito.class.php");
	require("classes/DAO/ConceitoDAO.class.php");

	$conceito = isset($_POST["conceito"]) ? $_POST["conceito"] : "";
	$cod_conceito = isset($_POST["codigo"]) ? $_POST["codigo"] : 0;
	
	$conceitoObj = new Conceito($conceito);
	$conceitoObj->setCod($cod_conceito);

	$conceitoDAO = new ConceitoDAO();
	$conceitoDAO->alterar($conceitoObj);

	echo "
		<script>
			alert('Conceito alterado com sucesso!');
			window.location.href = 'cadConceitos.php'
		</script>
	";
