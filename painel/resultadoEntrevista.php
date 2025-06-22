<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>
	<?php 
		include("menu.php"); 
		$id_teste = isset($_GET["teste"]) ? $_GET["teste"] : NULL;
		$id_usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : NULL;

	?>

	<div class="centralizar">

	<h1 class="titulo">Relatório para Entrevista</h1>

<?php 

	require("config/config.php");
	require("classes/DAO/ResultadoDAO.class.php");
	
	$resultados = new resultadoDAO($id_teste, $id_usuario);
	$relatorio = $resultados->relatorioEntrevista();

	echo "
	<h3 style='text-align:center;'>
		<a href='resultados.php?tipo=3' /> 
			<img style='display:inline; vertical-align: middle' src='img/voltar.png' title='Voltar'> 
		</a>
	</h3>
	";

	echo "<div class='icon-bar'> 
		<img src='img/printer.png' title='Imprimir'>
		<a href='downloadCSV.php'><img src='img/downloadIcon.png' title='Download CSV'></a>
	</div>";

	echo '<table class=resultados>';

		echo '<tr>
				<th width=\'10%\'>Teste</th>
				<th  width=\'10%\'>ID Aluno</th>
				<th width=\'20%\'>Nome Aluno</th>
				<th  width=\'5%\'>ID Pergunta</th>
				<th  width=\'5%\'>ID Conceito</th>
				<th width=\'30%\'>Conceito</th>
				<th  width=\'10%\'>Resposta</th>
				<th  width=\'10%\'>Tempo</th>
			</tr>';
	
		for ($j=0; $j < count($relatorio); $j++) {
			echo '<tr class=resultado_sequencia>';
				echo "<td> {$relatorio[$j][0]} </td>"; // Teste
				echo "<td> {$relatorio[$j][1]} </td>"; // Id usuario
				echo "<td> {$relatorio[$j][2]} </td>"; // nome usuario
				echo "<td> {$relatorio[$j][3]} </td>"; // id pergunta
				echo "<td> {$relatorio[$j][4]} </td>"; // id conceito
				echo "<td> {$relatorio[$j][5]} </td>"; // nome conceito
				echo "<td> {$relatorio[$j][6]} </td>"; // resposta
				if ($relatorio[$j][7] == "0") {
					echo "<td> - </td>"; // tempo
				} else {
					echo "<td> ". gmdate("H:i:s", $relatorio[$j][7]) ." </td>"; // tempo
				}
			echo '</tr>';
		}
	echo '</table>
		</td>
	</tr>
	';
	
	
echo "</table>"; // fecha table do ultimo usuario

include("footer.php"); 

?>

</body>

<script type="text/javascript">
	excluir("excluirResultado.php");
</script>

</html>