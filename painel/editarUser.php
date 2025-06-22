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

	<h1 class="titulo">Editar Usuário</h1>

	<?php 
		$id = $_GET["id"];
		$userObj = new UsuarioDAO();
		$users = $userObj->listar($id);
	?>
	<form name="login" method="post" action="actionEditarUser.php" onsubmit="return checkUser(event,this.loginSave)" autocomplete="off">
	
	<input type="hidden" name="cod" value="<?= $users[0]['cod_usuario']; ?>" />
	<input type="hidden" name="loginDb" value="<?= $users[0]['login_usuario']; ?>" />

	<label for="nome">Nome:</label>
	<input type="text" name="nome" placeholder="Nome do Usuário" value="<?= $users[0]['nm_usuario'] ?>" required="required" />

	<br/>
	
	<label for="email">E-mail:</label>
		<input type="email" name="email" placeholder="E-mail do professor" value="<?= $users[0]['email_usuario'] ?>" required="required" />
	
	<label for="login">Login:</label><input type="text" name="loginSave" placeholder="Login do usuário" value="<?= $users[0]['login_usuario']?>" required="required" />

	<br/>
	
	<label for="password">Senha:</label><input type="password" name="passwordSave" placeholder="Senha do usuário" />
	
	<br/>
	<br/>
	
	<button id="botao">Editar</button>
		
</form>

<?php include("footer.php"); ?>

</body>

</html>