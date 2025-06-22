<?php
	session_start();
	
	include_once("config/config.php");
	include_once("classes/Usuario.class.php");
	include_once("classes/DAO/UsuarioDAO.class.php");

	/* Cadastra usuário */
	$nome = $_POST["nome"];
	$email = $_POST["email"];

	$usuarioObj = new Usuario($nome, $email, 2);
	$usuarioDAO = new usuarioDAO();
	$inserir = $usuarioDAO->inserir($usuarioObj);

	$_SESSION["cod_usuario"] = $usuarioDAO->last_id();
	$_SESSION["codTst"] = $_POST["teste"];
	