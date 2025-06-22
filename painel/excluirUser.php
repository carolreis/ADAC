<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php 
	include("head.php"); 
	include("config/config.php"); 
	include("classes/DAO/UsuarioDAO.class.php"); 
?>

?>

<body>

<?php
	
	$id = $_POST["varDado"];
	
	$userObj = new UsuarioDAO();

	$excluir = $userObj->excluir($id);

?>
</body>
</html>