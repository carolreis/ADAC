<?php
	session_start();
	
	require("config/config.php");
	require("classes/DAO/ConceitoDAO.class.php");
?>

<!DOCTYPE html>

<html>

<?php 
	include("head.php");

	$cod = $_GET["id"];
	$conceitoDAO = new ConceitoDAO();
	$conceito = $conceitoDAO->listar_id($cod);
?>


<body>

	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">Editar Conceito</h1>

	<form name="cadConceitos" method="post" action="actionEditarConceito.php" enctype="multipart/form-data" autocomplete="off">
		
		<input type="hidden" name="codigo" value="<?= $conceito[0]['cod_conceito']; ?>">
		<label for="conceito">Conceito:</label><input type="text" name="conceito" value="<?= $conceito[0]['nm_conceito']; ?>" placeholder="Nome do Conceito" autofocus required/>

		<button type="submit" id="botao">Alterar</button>

	</form>

<br/>

<?php include("footer.php"); ?>

</body>

</html>