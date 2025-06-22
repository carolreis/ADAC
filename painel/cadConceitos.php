<?php
	session_start();

	require("config/config.php");
	require("classes/DAO/ConceitoDAO.class.php");
?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>

	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">Cadastrar Conceitos</h1>

	<form name="cadConceitos" method="post" action="actionCadConceitos.php" enctype="multipart/form-data" autocomplete="off">
	
		<label for="conceito">Conceito:</label><input type="text" name="conceito" placeholder="Nome do Conceito" autofocus required/>

		<button type="submit" id="botao">Cadastrar</button>

	</form>

	<h3>Conceitos Cadastrados:</h3>

	<table>

		<tr>
			<th>ID</th>
			<th>Conceito</th>
			<th>Ações</th>
		</tr>

		<?php 
			$conceitoDAO = new ConceitoDAO();
			$conceitos = $conceitoDAO->listar_todos();
		
			$linhas = $conceitoDAO->linha();

			if($linhas == 0):
		?> 

		<tr>
			<td colspan=3><p class='aviso'>Não há conceitos cadastrados!</p></td>
		</tr>

		<?php else:	?>
			<?php for($i=0; $i < $linhas; $i++): ?>
				<tr class='listFiles'>
					<td class='id_column'> <?= $conceitos[$i]["cod_conceito"]; ?> </td>
					<td> <?= $conceitos[$i]["nm_conceito"]; ?> </td>
					<td class="action_column" align=center>
						<span class='editar'>
							<a href="editarConceito.php?id=<?= $conceitos[$i]["cod_conceito"]; ?>" >
								<img src='img/edit4.png'/>
							</a>
						</span>
						<span class='excluir' id="<?= $conceitos[$i]["cod_conceito"]; ?>">
							<img src='img/delete3.png'/>
						</span>  
					</td>
				</tr>
			<?php endfor; ?>
		<?php endif; ?>

	</table>

<br/>

<?php include("footer.php"); ?>
<script type="text/javascript">
	excluir("excluirConceito.php");
</script>

</body>

</html>