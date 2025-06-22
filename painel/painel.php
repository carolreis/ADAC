<?php
session_start();

unset($_POST);
$_SESSION["idQuestion"] = 1;
$_SESSION["nPerg"] = 1;
?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>
	<?php include("menu.php"); 
	?>

	<div class="centralizar">
		
		<a href="resultados.php?tipo=1">
			<div class="painel_menu">
				<img src="img/report.png"/>
				<p>Relatório</p>
			</div>
		</a>

		<a href="resultados.php?tipo=3">
			<div class="painel_menu">
				<img src="img/report4.png"/>
				<p>Relatórios Entrevistas</p>
			</div>
		</a>

		<a href="resultados.php?tipo=2">
			<div class="painel_menu">
				<img src="img/chart.png"/>
				<p>Gráficos</p>
			</div>
		</a>

	</div>

<?php include("footer.php"); ?>
</body>	
</html>