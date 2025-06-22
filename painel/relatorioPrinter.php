<?php session_start(); ?>

<!DOCTYPE html>

<html id="print">

<?php include("head.php"); ?>

<body>

<?php 
		
	$id_teste = $_GET["teste"];
	$id_usuario = $_GET["usuario"];
	
	require("config/config.php");
	require("classes/DAO/ResultadoDAO.class.php");
	
	$resultados = new resultadoDAO($id_teste, $id_usuario);
	$listar_resultado = $resultados->listar();
	$sequencia = $resultados->listar_sequencia();
	$consolidado = $resultados->consolidado();
	$resultados = null;

	echo "<table class='resultados'>";
			
		echo "<tr>";
			echo "<td colspan=4> Nome usuário: ".$listar_resultado[0]["nm_usuario"]."</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=4> E-mail: ".$listar_resultado[0]["email_usuario"]."</td>";
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
						<th>Conceito:</th>
					</tr>
		";
					
		for ($j=0; $j < count($sequencia); $j++) {

		 	if ($sequencia[$j]["score"] === "-1") {

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
			echo $sequencia[$j]["nm_conceito"];
			echo "</td>";
			
			echo "</tr>";

			}

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

	window.onload = function() {
		var headstr = 
			'<head>' +
			'<title>ADAC</title>' +
			'<link rel="stylesheet" href="css/jquery-ui.css" />' +
			'<link rel="stylesheet" href="css/font-awesome.min.css" />' +
			'<link rel="stylesheet" type="text/css" href="css/style.css"/>' +
			'<link rel="shortcut icon" type="image/png" href="img/icon.png"/>' +
			'<meta name="viewport" width="device-width" initial-scale="1"/>' +
			'<meta charset="utf-8"/>' +
			'</head>' +
			'<body>';

			var footstr = "</body>";
			var newstr = document.getElementById('print').innerHTML;
			document.body.innerHTML = headstr+newstr+footstr;
			window.print();
	}

</script>

</html>