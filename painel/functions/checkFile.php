<?php

	require_once("config/config.php");
	require_once("classes/Pergunta.class.php");
	require_once("classes/DAO/PerguntaDAO.class.php");
		
	$f = $_POST["file"];

	$testeObjDAO = new TesteDAO();
	echo $testeObjDAO->existsTest($f);