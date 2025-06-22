<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>
	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">Testes cadastrados</h1>
<!--	<p>Arquivos em <span style="color: #FF0000">VERMELHO</span>: Faltam questões a serem cadastradas!</p>-->

<?php 

	require("config/config.php");
	require("classes/DAO/TesteDAO.class.php");

	$testeDAO = new TesteDAO();
	$testes = $testeDAO->listar_todos();
	
	echo 
	"
	<table>

			<tr>
				<th class='action_column'>Ativo</th>
				<th>Nome arquivo</th>
				<th class='action_column'>Ações</th>
			</tr>
	";
	for($i=0; $i < count($testes); $i++){

		$cod_tst = $testes[$i]["cod_tst"];
		$nome_teste = $testes[$i]["nm_tst"];
		$ativo = $testes[$i]["ativo"];

		echo 
		"
			<tr class='listFiles'>
				<td class='action_column'>
		
		";
		if($ativo == 1){
			echo "<input type=checkbox id=$cod_tst style='width:auto; margin-left: 5px' name='ativar' onclick='ativarTeste(this)' checked='checked'/>";
		}else{
			echo "<input type=checkbox id=$cod_tst style='width:auto; margin-left: 5px' name='ativar' onclick='ativarTeste(this)'/>";
		}
		echo
		"
				</td>
				<td>
					<a href=perguntas.php?teste=".$cod_tst.">
						<p>".$nome_teste."</p>
					</a>
				</td>
				<td class='action_column'>
					<a href=perguntas.php?teste=".$cod_tst."><span class='editar'><img src='img/edit4.png'/></span></a>
					<span class='excluir' id='$cod_tst'> <img src='img/delete3.png'/> </span>  
				</td>
			</tr>
		</span>
		";

	}
	echo "</table>";
		
include("footer.php"); 

?>
</body>

<script type="text/javascript">
	excluir("excluirTeste.php");

	function ativarTeste(elm){
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

</html>