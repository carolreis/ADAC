<?php

	require_once("config/config.php");
	require_once("classes/Pergunta.class.php");
	require_once("classes/DAO/PerguntaDAO.class.php");

	$loginDigitado = $_POST["login"];

	$userDAO= new UsuarioDAO();
	echo $userDAO->existsUser($loginDigitado);