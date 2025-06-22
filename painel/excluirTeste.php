<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php 
include("head.php");
include("config/config.php"); 
include("classes/DAO/TesteDAO.class.php"); 
?>

<body>

<?php
	$id = $_POST["varDado"];
	
	$testeObj = new TesteDAO();

	$excluir = $testeObj->excluir($id);
	if($excluir) {
		unlink("img/".md5($id));
	}

?>

</body>

</html>