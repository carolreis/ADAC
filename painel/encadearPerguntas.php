<?php session_start(); ?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>
	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">Escolha o teste:</h1>

<?php 

	require("config/config.php");
	require("classes/DAO/TesteDAO.class.php");

	$testeDAO = new TesteDAO();
	$testes = $testeDAO->listar_todos();
	
	for($i=0; $i < count($testes); $i++){

		$cod_tst = $testes[$i]["cod_tst"];
		$nome_teste = $testes[$i]["nm_tst"];

		echo 
		"<span class='listFiles' style='display: block'>
			<a href=encadearPerguntaTeste.php?teste=".$cod_tst."><p>".$nome_teste."</p></a>
		</span>
		";

	}
		
include("footer.php"); 

?>
</body>

<script type="text/javascript">
	//excluir("excluirTeste.php");
</script>

</html>