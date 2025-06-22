<?php
	
	include("config/config.php");
	include("classes/DAO/ResultadoDAO.class.php");

	$id = $_POST["varDado"];

	$respostaObj = new ResultadoDAO();
	$excluir = $respostaObj->excluir($id);
 ?>