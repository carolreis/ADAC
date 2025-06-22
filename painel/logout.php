<?php
	session_start();
	unset($_SESSION["usuario"]);
	session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.php"); ?>
</head>
<body>

<?php	
	echo "<div id='red'><h1>Saindo...</h1>";
	echo"<img src=\"img/loading.gif\"></div>";
	echo"<meta http-equiv='refresh' content='1;index.php'>";

?>
</body>
</html>
