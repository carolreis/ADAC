<?php session_start(); 
include("config/config.php"); 
include("classes/DAO/ConceitoDAO.class.php"); 

	$id = $_POST["varDado"];
	
	$conceitoObj = new ConceitoDAO();

	$excluir = $conceitoObj->excluir($id);
	
?>
