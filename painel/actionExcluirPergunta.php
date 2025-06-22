<?php
		session_start();
	
	include("functions/lib.php");

	require("config/config.php");
	
	require("classes/DAO/PerguntaDAO.class.php");

	$id = $_POST["varDado"];

	$perguntaDAO = new PerguntaDAO();
	$excluir = $perguntaDAO->excluir($id);
	
?>