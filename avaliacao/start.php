<?php 
	session_start(); 
	if (!isset($_SESSION["cod_usuario"]) || !isset($_SESSION["codTst"])) {
		header("Location: index.php");
		exit();
	}
	$teste = $_SESSION["codTst"];
	$user = $_SESSION["cod_usuario"];
?>
<!DOCTYPE html>

<html>

<head>

	<title>ADAC</title>
	
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, user-scalable=no" initial-scale=1/>
	<meta charset="UTF-8"/>
	<link rel="shortcut icon" type="image/png" href="img/icon.png"/>

</head>

<?php 

	include_once("config/config.php");
	include_once("classes/DAO/PerguntaDAO.class.php");
	include_once("classes/DAO/RespostaDAO.class.php");
	include_once("classes/DAO/ResultadoDAO.class.php");
	
	$_SESSION["nQuestion"] = 1;
	$_SESSION["score"] = 0;
?>

<body>

<?php

include_once("quizShow.php");

$initialized = false;
$id_perg = NULL;

if(!$initialized) {

	$ResultadoDAO = new ResultadoDAO();
	
	/* Verifica se o teste está em progresso */
	if (!$ResultadoDAO->emProgresso($user, $teste)) {
		$perguntasObj = new PerguntaDAO();
		$perguntas = $perguntasObj->listar_primarias();
		$perguntasObj = NULL;
		
		shuffle($perguntas);
		
		$pergunta = isset($perguntas[0]) ? $perguntas[0] : NULL;
		$id_perg = isset($pergunta["cod_item"]) ? $pergunta["cod_item"] : NULL;
		
		if (!isset($id_perg)) {
			echo "<h3>Não há pergunta primária cadastrada!</h3>";
			session_destroy();
			exit();
		}


	} else {

		$resultado = $ResultadoDAO->getUltimoResultado($user, $teste);
		
		if (isset($resultado[0]["cod_item"])) {
			$perguntasObj = new PerguntaDAO();
			$prox_pergunta_id = $perguntasObj->listar_proxima_id($resultado[0]["cod_item"]);
			$pergunta = $perguntasObj->listar_proxima($prox_pergunta_id[0][0]);
			$pergunta = isset($pergunta[0]) ? $pergunta[0] : NULL;
			$id_perg = isset($pergunta["cod_item"]) ? $pergunta["cod_item"] : NULL;
			$_SESSION["nQuestion"]++;
		}
	}

	$respostasObj = new RespostaDAO();
	$respostas = $respostasObj->listar_todas_pergunta($id_perg);
	
	/* CRIA CAIXA PARA QUESTÕES */
	echo "<div id=a>";

		quizShow($pergunta, $respostas);

	echo "</div>";
	
	$initialized = true;
}

?>

</body>
</html>