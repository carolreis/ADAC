<?php
	session_start();
	$_SESSION["nPerg"] = 1;

	require("config/config.php");
	require("classes/DAO/UsuarioDAO.class.php");
?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>

	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">Criar teste</h1>

	<form name="criarTeste" method="post" action="actionCadTeste.php" onsubmit="return validaTeste();" enctype="multipart/form-data" autocomplete="off">
	
		<label for="nome">Nome:</label><input type="text" name="nome" placeholder="Nome do Teste" autofocus required/>

		<label for="professor">Professor:</label>
			<select name="professor"">
				<option value="0">Selecione o professor</option>
			<?php 
				$usuarioDAO = new UsuarioDAO();
				$professores = $usuarioDAO->listar_professores();

				foreach ($professores as $professor):
			?>
				<option value="<?= $professor['cod_usuario']?>"><?= $professor['nm_usuario']; ?></option>
			<?php	
				endforeach;
			?>
			</select>

		<button type="submit" id="botao">Criar teste</button>

	</form>

<br/>

<?php include("footer.php"); ?>

</body>

</html>