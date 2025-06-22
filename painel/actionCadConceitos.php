<?php
session_start();

require("config/config.php");
require("classes/Conceito.class.php");
require("classes/DAO/ConceitoDAO.class.php");

if (!isset($_SESSION["usuario"])) {
	
	echo "
	<script>
		alert('Acesso não autorizado!');
		window.location.href = 'index.php';
	</script>
	";

	exit();

}

/******************** PEGA VALORES DO FORM ********************/
$conceito = isset($_POST["conceito"]) ? $_POST["conceito"] : "";

if($conceito == ""){
	echo "<script>alert('Informe o conceito');</script>";
	header("Location: cadConceito.php");
	exit();
}

/******************** SALVA NO BANCO ********************/
$conceitoObj = new Conceito($conceito);	
$conceitoDAO = new ConceitoDAO();
$conceitoDAO->inserir($conceitoObj);
?>

<script type="text/javascript">
	alert('Cadastrado com sucesso!');
	window.location.href = 'cadConceitos.php';
</script>
