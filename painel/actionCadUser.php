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

$login = isset($_POST["loginSave"]) ? $_POST["loginSave"] : "";
$nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$pwd = isset($_POST["passwordSave"]) ? $_POST["passwordSave"] : "";

$usuarioDAO = new UsuarioDAO();

/* Verificar se usuário já existe! */
if($usuarioDAO->existsUser($login)){
	echo "
	<script type='text/javascript'>
		alert('Já existe usuário com este login!');
		window.location.href = 'cadUser.php';
	</script>
	";	
	exit();
}

$usuario = new Usuario($login, $nome, $email, $pwd);

if ($usuarioDAO->inserir($usuario)) {
	echo "
	<script type='text/javascript'>
		alert('Cadastrado com sucesso!');
		window.location.href = 'cadUser.php';
	</script>
	";
}
?>
</body>
</html>
