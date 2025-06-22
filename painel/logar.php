<?php
session_start();

require("config/config.php");
require("classes/DAO/UsuarioDAO.class.php");

$usuario = $_POST["login"];
$senha = $_POST["password"];

$usuarioDAO = new UsuarioDAO();
$logar = $usuarioDAO->logar($usuario, $senha);

if ($logar) {
	$_SESSION["usuario"] = trim(strtolower($usuario));
	header("Location: painel.php");
} else {
	header("Location: index.php?err=1");
}

?>