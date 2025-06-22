<?php
session_start();

require("config/config.php");
require("classes/Teste.class.php");
require("classes/DAO/TesteDAO.class.php");

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
$nomeTeste = isset($_POST["nome"]) ? $_POST["nome"] : "";
$professor = !empty($_POST["professor"]) ? $_POST["professor"] : "";

if($nomeTeste == "" || $professor == ""){
	echo "<script>
			alert('Informe o nome do teste e o professor!');
			window.location.href = 'cadTeste.php';
		</script>";
	exit();
}

// Retorna um array de conceitos - to do
$conceitosArray = isset($_POST["conceito"]) ? $_POST["conceito"] : "";

/******************** SALVA NO BANCO ********************/
$testeObj = new Teste($nomeTeste, $professor);	
$testeDAO = new TesteDAO();
$testeDAO->inserir($testeObj);
$codTeste = $testeDAO->last_id();

header("Location: perguntas.php?teste=".$codTeste);

?>