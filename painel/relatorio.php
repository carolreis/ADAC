<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>
	<?php 
		include("menu.php"); 
		$id_teste = $_GET["teste"];
		$id_usuario = $_GET["usuario"];
	?>

	<div class="centralizar">

	<h1 class="titulo">Resultado da avaliação diagnóstica</h1>

<?php 

	require("config/config.php");
	require("classes/DAO/ResultadoDAO.class.php");
	
	$resultados = new resultadoDAO($id_teste, $id_usuario);
	$listar_resultado = $resultados->listar();
	$sequencia = $resultados->listar_sequencia();
	$consolidado = $resultados->consolidado();
	$resultados = null;

	echo "
	<h3 style='text-align:center;'>
		<a href='resultadoTeste.php?teste=$id_teste' /> 
			<img style='display:inline; vertical-align: middle' src='img/voltar.png' title='Voltar'> 
		</a>
	</h3>
	";
		
	echo "<table class='resultados'>";
		echo "<tr>";
		echo "<td colspan=4 align=center> <b>Nome:</b> ".$listar_resultado[0]["nm_usuario"]." | <b>E-mail:</b> ".$listar_resultado[0]["email_usuario"]. "</td>";
		echo "</tr>";
		
		echo "
		<tr>
			<th style='text-align: left'>Conceito:</th>
			<th style='text-align: left'>Score:</th>
		</tr>
		";
		for($i=0; $i < count($consolidado); $i++) {
			echo "
			<tr>
				<td>".$consolidado[$i]["conceito"]."</td>
				<td>".$consolidado[$i]["score"]."</td>
			</tr>
			";
		}
		
		echo "
		<tr>
			<td colspan='5'>
				<table>
					<tr>
						<th>ID:</th>
						<th>Pergunta:</th>
						<th>Resposta:</th>
						<th>Tempo:</th>
						<th>Ação:</th>
					</tr>
		";
					
		for ($j=0; $j < count($sequencia); $j++) {

		echo "<tr class='resultado_sequencia'>";
			
			echo "<td>".$sequencia[$j]["cod_perg"]."</td>";
			
			echo "<td>";
				echo "<p>".$sequencia[$j]["pergunta"]."</p>";
				if(!empty($sequencia[$j]["img_perg"])) {
					echo "<img src='img/".md5($id_teste)."/".$sequencia[$j]["img_perg"]."' />";
					echo"</br>";
				}
			echo "</td>";
			
			echo "<td>";
				echo "<p>\"".$sequencia[$j]["resposta"]."\"</p>";
				if(!empty($sequencia[$j]["img_resp"])) {
					echo "<img src='img/".md5($id_teste)."/".$sequencia[$j]["img_resp"]."' />";
					echo"</br>";
				}

				if($sequencia[$j]["score"] === "0") {
					echo "<img src='img/right.png'>";
				} else if ($sequencia[$j]["score"] === "-1") {
					echo "<img src='img/wrong.png'>";
				}

			echo "</td>";
			
			echo "<td align='center' class='id_column'>";
				echo gmdate("H:i:s", $sequencia[$j]["tempo"]);
			echo "</td>";

			echo "<td align='center' class='id_column'>";
				echo "<span class='excluir' id='".$sequencia[$j]["cod_resultado"]."'><img src='img/delete3.png'/>";
			echo "</td>";
		
		echo "</tr>";

		}

	echo "	</table>
		</td>
	</tr>
	";
	
	
echo "</table>"; // fecha table do ultimo usuario

include("footer.php"); 

?>

</body>

<script type="text/javascript">
	excluir("excluirResultado.php");
</script>

</html>