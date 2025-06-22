<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>

<?php
	$_SESSION["nPerg"] = 1;
	$_SESSION["idQuestion"] = 1;
	echo "<div id='red'><h1>Pronto! Redirecionando...</h1>";
	echo"<img src=\"img/loading.gif\"></div>";
	echo"<meta http-equiv=\"refresh\" content=\"1;URL='painel.php'\">";
?>
</body>
</html>