<?php
session_start();
require("config/config.php");
require("classes/Usuario.class.php");
require("classes/DAO/UsuarioDAO.class.php");

if (!isset($_SESSION["usuario"])) {
	
	echo "
	<script>
		alert('Acesso não autorizado!');
		window.location.href = 'index.php';
	</script>
	";

	exit();

}

?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>

	<?php include("menu.php"); ?>

	<div class="centralizar">

	<h1 class="titulo">Criar novo usuário</h1>

	<form name="login" method="post" action="actionCadUser.php" onsubmit="return checkUser(event,this.loginSave)" autocomplete="off">
	
	<label for="nome">Nome:</label>
	<input type="text" name="nome" placeholder="Nome do Usuário" required="required" />

	<br/>
	
	<label for="email">E-mail:</label>
		<input type="email" name="email" placeholder="E-mail do professor" required="required" />
	
	<label for="login">Login:</label><input type="text" name="loginSave" placeholder="Login do usuário" required="required" />

	<br/>
	
	<label for="password">Senha:</label><input type="password" name="passwordSave" placeholder="Senha do usuário" required="required" />

	<br/>
	<br/>
	
	<button id="botao">Cadastrar</button>
		
</form>

<br/>

<hr/>

<h1>Usuários já cadastrados:</h1>

<?php

$usuarioDAO = new UsuarioDAO();
$listar = $usuarioDAO->listar_professores();
?>

<table>
	<tr>
		<th>ID:</th>
		<th>Nome:</th>
		<th>Login:</th>
		<th>E-mail:</th>
		<th>Ações:</th>
	</tr>

<?php 
if($listar){
	foreach ($listar as $usuario): ?>
		<tr class="listFiles">
			<td class="id_column"><?= $usuario["cod_usuario"]; ?></td>
			<td><?= $usuario["nm_usuario"]; ?></td>
			<td><?= $usuario["login_usuario"]; ?></td>
			<td><?= $usuario["email_usuario"]; ?></td>
			<td class="action_column">
				<a href='editarUser.php?id=<?= $usuario['cod_usuario']; ?>'><span class='editar'><img src='img/edit4.png'/></span></a>
				<span class='excluir' id='<?= $usuario['cod_usuario']; ?>' > <img src='img/delete3.png'/> </span>  
			</td>
		</tr>
	<?php 
	endforeach; 
}
?>
</table>

<br/>

<script type="text/javascript">
	excluir("excluirUser.php");
</script>

<?php include("footer.php"); ?>

</body>

</html>