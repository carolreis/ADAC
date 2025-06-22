<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>
	<?php 
		include("menu.php"); 
		$idTeste = $_GET["teste"];
	?>

	<div class="centralizar">

	<h1 class="titulo">Resultado da avaliação diagnóstica</h1>

	<h3 style='text-align:center;'>
		<a href='resultados.php?tipo=1' /> 
			<img style='display:inline; vertical-align: middle' src='img/voltar.png' title='Voltar'> 
		</a>
	</h3>
<?php 

	require("config/config.php");
	require("classes/DAO/ResultadoDAO.class.php");
	require("classes/DAO/TesteDAO.class.php");
	
	$resultados = new ResultadoDAO($idTeste);
	$nomes = $resultados->listar_nomes();

	$teste = new TesteDAO();
	$nome_teste = $teste->getNome($idTeste);

	echo "<h3>Teste: ".$nome_teste[0][0]."</h3>";

	if(count($nomes) == 0){
		echo "<h3>Não há resultados ainda!</h3>";
	} else {

		echo "<table>";
		echo "<tr>";
		echo "<th colspan='2'>Respondentes:</th>";
		echo "</tr>";

		for($i=0; $i < count($nomes); $i++) {
			echo "<tr class='listFiles'>";
				echo "<td>";

					echo "<a target='_blank' href='relatorioPrinter.php?teste=".$idTeste."&usuario=".$nomes[$i][0]."'>";
					echo "<img src='img/printer.png'>&emsp;";
					echo "</a>";

					echo "<a href='relatorio.php?teste=".$idTeste."&usuario=".$nomes[$i][0]."'>";
					echo "<img src='img/look.png'>&emsp; ".$nomes[$i][1];
					echo "</a>";


				echo "</td>";
				echo "<td class='action_column'>";
					echo "<span class='excluir' id='".$nomes[$i][0]."'><img src='img/delete3.png'/>";
				echo "</td>";
			echo "</tr>";
		}

	}

	echo "</table>"; // fecha table do ultimo usuario

include("footer.php"); 

?>

</body>

<script type="text/javascript">
	excluir("excluirRelatorio.php");
</script>

</html>