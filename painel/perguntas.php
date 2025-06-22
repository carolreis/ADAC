	<?php
session_start();

require("config/config.php");
require("classes/DAO/TesteDAO.class.php");
require("classes/DAO/PerguntaDAO.class.php");

if (!isset($_SESSION["usuario"]) || !isset($_GET["teste"])) {
	
	echo "
	<script>
		alert('Acesso não autorizado!');
		window.location.href = 'index.php';
	</script>
	";

	exit();

}

$codTeste = $_GET["teste"];
$testeDAO = new TesteDAO();
$nomeTeste = $testeDAO->getNome($codTeste);
?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>

<?php include("menu.php"); ?>

<div class="centralizar">
	
	<br/>	
	
	<div style="background: #EEE; color: #333; padding: 10px; border-bottom: #333 solid 2px; border-top: #333 solid 2px;">
		<h3 style="margin: 0; padding: 0">Nome do teste: <?php echo $nomeTeste[0][0]; ?> </h3>
	</div>
	
	<br/>	

	<a href="cadPerguntas.php?cod=<?php echo $codTeste; ?>">
		<button class='btn'>
			<span style='display: inline; vertical-align: middle;'>Inserir perguntas </span>
			<img src='img/addWhite.png' style="display: inline; vertical-align: middle; width: 18px" />
		</button>
	</a>

	<?php

	$perguntaDAO = new PerguntaDAO();
	$perg_primarias = $perguntaDAO->listar_where_orderby("tipo_perg = 1 AND cod_tst = '$codTeste' ","cod_item");
	$perguntaDAO = null;
	
	$perguntaDAO = new PerguntaDAO();
	$perg_secundarias = $perguntaDAO->listar_where_orderby("tipo_perg = 2 AND cod_tst = '$codTeste'  ","cod_item");

	// $sem_resposta_certa = array();

	// for($i=0; $i<count($perg_primarias); $i++){
	// 	if($perg_primarias[$i]["certa_resp"] === "0") {
	// 		array_push($sem_resposta_certa, $perg_primarias[$i]["cod_item"]);
	// 	}
	// }
	// for($i=0; $i<count($perg_secundarias); $i++){
	// 	if($perg_secundarias[$i]["certa_resp"] === "0") {
	// 		array_push($sem_resposta_certa, $perg_secundarias[$i]["cod_item"]);
	// 	}
	// }

	// if(!$sem_resposta_certa){
	// 	echo "<table>";
	// 	echo "<tr><th>Perguntas sem respostas corretas marcadas</th></tr>";
	// 	for($i=0; $i<count($sem_resposta_certa); $i++){
	// 		echo "<tr>";
	// 			echo "<td>";
	// 				echo "<p class='aviso'>Não há perguntas primárias cadastradas!</p>";
	// 			echo "</td>";
	// 		echo "</tr>";
	// 	}
	// 	echo "</table>";
	// }

	?>
	<h3>Perguntas cadastradas:</h3>
	
	<h4>Primárias:</h4>
	
	<?php

	echo "
	<table class='listarPerguntas'>
		<tr>
			<th class='id_column'>ID</th>
			<th colspan='2'>Pergunta</th>
			<th class='action_column'>Ações</th>
		</tr>
	";

	$quantPrimaria = count($perg_primarias);

	if($quantPrimaria == 0){
		echo "
		<tr>
			<td colspan=3><p class='aviso'>Não há perguntas primárias cadastradas!</p></td>
		</tr>
		";
	}

	for($i=0; $i < $quantPrimaria; $i++){

		if(!empty($perg_primarias[$i]["img_perg"])){
			$img_primarias = md5($perg_primarias[$i]["cod_tst"])."/".$perg_primarias[$i]["img_perg"];
		}else{
			$img_primarias = "noimage.png";
		}

		echo "			
		<tr class='listFiles'>
			
			<td class='id_column'>".$perg_primarias[$i]["cod_item"]."</td>

			<td class='img_column'><img src='img/".$img_primarias."' /></td>

			<td class='txt_column'>".$perg_primarias[$i]["txt_perg"]."</td>
			
			<td class='action_column'>
				<span class='editar'>
					<a href='editarPergunta.php?perg=".$perg_primarias[$i]['cod_item']."'>
						<img src='img/edit4.png'/>
					</a>
				</span>
				<span class='excluir' id=".$perg_primarias[$i]['cod_item'].">
					<img src='img/delete3.png'/>
				</span>  
			</td>
		";
	}

	echo "</table>";

	?>
	
	<hr/>

	<h4>Secundárias:</h4>
	
	<?php

	echo "
	<table class='listarPerguntas'>
		<tr>
			<th class='id_column'>ID</th>
			<th colspan='2'>Pergunta</th>
			<th class='action_column'>Ações</th>
		</tr>
	";

	$quantSecundaria = count($perg_secundarias);

	if($quantSecundaria == 0){
		echo "
		<tr>
			<td colspan=3><p class='aviso'>Não há perguntas secundárias cadastradas!</p></td>
		</tr>
		";
	}
	
	for($i=0; $i < $quantSecundaria; $i++){

		if(!empty($perg_secundarias[$i]["img_perg"])){
			$img_secundarias = md5($perg_secundarias[$i]["cod_tst"])."/".$perg_secundarias[$i]["img_perg"];
		}else{
			$img_secundarias = "noimage.png";
		}
		
		echo "
		<tr class='listFiles'>
			<td class='id_column'>".$perg_secundarias[$i]["cod_item"]."</td>

			<td class='img_column'><img src='img/".$img_secundarias."' /></td>
			
			<td class='txt_column'>".$perg_secundarias[$i]["txt_perg"]."</td>

			<td class='action_column'>
				<span class='editar'>
					<a href='editarPergunta.php?perg=".$perg_secundarias[$i]['cod_item']."'>
						<img src='img/edit4.png'/>
					</a>
				</span>
				<span class='excluir' id=".$perg_secundarias[$i]['cod_item'].">
					<img src='img/delete3.png'/>
				</span>
			</td>
		</tr>
		";
	}
	echo "</table>";

	include("footer.php"); 

		?>

<script type="text/javascript">
	excluir("actionExcluirPergunta.php");
	function respostaCorreta(elm){
		//var currentradio= $("input[name='ativar']:checked")[0];
		//console.log(currentradio);
		var testeId = $(elm).attr("id");
		var c = confirm("Deseja ativar este teste?");

		if(c){
			$.post('ativarTeste.php', {
				id: testeId
			}, function(result){});
		//	$(elm).attr("checked","checked");
		}

	}
</script>

</div>

</body>

</html>