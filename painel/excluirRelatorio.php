<?php
	
	include("config/config.php");
	include("classes/DAO/ResultadoDAO.class.php");

	$id = $_POST["varDado"];

	$r = new ResultadoDAO();
	$excluir = $r->excluir_relatorio($id);
 ?>