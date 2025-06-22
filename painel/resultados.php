<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php
	include("head.php"); 
	$tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : 1; 
?>

<body>
	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">
	<?php
		switch ($tipo) {
			case 1:
				echo "Relatório";
				break;
			case 2:
				echo "Gráficos";
				break;
			case 3:
				echo "Relatórios Entrevista";
				break;
			default:
				echo "Relatório";
				break;
		}
	?>
	
	</h1>

	<h3 style='text-align:center;'>
		<a href='painel.php' /> 
			<img style='display:inline; vertical-align: middle' src='img/voltar.png' title='Voltar'> 
		</a>	
	</h3>		

<?php 

	require("config/config.php");
	require("classes/DAO/TesteDAO.class.php");

	$testeDAO = new TesteDAO();
	$testes = $testeDAO->listar_todos();
	
	echo "<table>";

	for($i=0; $i < count($testes); $i++){

		$cod_tst = $testes[$i]["cod_tst"];
		$nome_teste = $testes[$i]["nm_tst"];

		switch ($tipo) {
			case 1:
				$url = "resultadoTeste.php";
				break;
			case 2:
				$url = "grafico.php";
				break;
			case 3:
				$url = "resultadoEntrevista.php";
				break;
			default:
				$url = "resultadoTeste.php";
				break;
		}

		echo 
		"
		<tr class='listFiles'>
			<td>
				<a href=".$url."?teste=".$cod_tst.">
					<img src='img/look.png'> &emsp; 
					".$nome_teste."
				</a>
			</td>
		</tr>
		";

	}
	echo "</table>";
		
include("footer.php"); 

?>
</body>

<script type="text/javascript">
	//excluir("excluirTeste.php");
</script>

</html>