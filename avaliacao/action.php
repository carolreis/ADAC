<?php 
	session_start(); 
	if (!isset($_SESSION["cod_usuario"]) || !isset($_POST)) {
		header("Location: index.php");
		exit();
	}

include_once("quizShow.php");
include_once("config/config.php");
include_once("classes/DAO/PerguntaDAO.class.php");
include_once("classes/DAO/RespostaDAO.class.php");
include_once("classes/Resultado.class.php");
include_once("classes/DAO/ResultadoDAO.class.php");
error_reporting(0);
/* VARIÁVEIS DO FORMULÁRIO */

// se true = há respostas cadastradas para a pergunta
// se false = não há respostas cadastradas para aquela pergunta

$respFlag = $_POST["respFlag"];

if ($respFlag == "true") {

	/* ID da pergunta */
	$perg_id = $_POST["perg_id"];

	/* TIMER */
	$timer = empty($_POST["timer"]) ? 0 : $_POST["timer"] ;
	
	/*
	SE OJBETIVA:
		- respInput retorna o ID da resposta escolhida
	SE DESCRITIVA:
		- respInput retorna o valor digitado pelo usuário
	*/
	$respInput = $_POST["respInput"];

	/* 
		0001 = objetiva 
		0010 = descritiva
	*/
	$tipoResp = $_POST["tipoResp"];
	
	if ($tipoResp == '0001') {

		/* ID DA RESPOSTA [OBJETIVA] */
		$id_resposta = $respInput;

		/* verificar resposta certa [OBJETIVA] através do ID DA RESPOSTA */
		$respostaObj = new RespostaDAO();
		$bool_certa = $respostaObj->verificar_resposta_obj($id_resposta); // Retorna 0 (errada) ou 1 (certa)
		$respostaObj = null;

		//define score
		if ($bool_certa[0]["certa_resp"] == 1) {
			$score = 0;
		} else {
			$score = -1;
		}

	} else if ($tipoResp == '0010') {

		/* ID DA RESPOSTA DESCRITIVA */
		$r = new RespostaDAO();
		$id_resposta = $r->get_id_descritiva($perg_id);
		$id_resposta = $id_resposta[0][0];
		$r = NULL;

		/* verificar resposta certa [DESCRITIVA] através do TEXTO DA RESPOSTA */
		$respostaObj = new RespostaDAO();
		// retorna texto da resposta correta, p/ comparar c/ digitado
		$certa = $respostaObj->verificar_resposta_desc($id_resposta); 
		$respostaObj = null;

		//define score
		if( trim(strtolower($certa[0]["txt_resp"])) == trim(strtolower($respInput)) ){
			$score = 0;
		} else {
			$score = -1;
		}

	} else {
		echo "Tipo inválido de resposta cadastrado!";
		session_destroy();
		exit();
	}

	/* 
		BUSCA ID CONCEITO DA RESPOSTA CERTA 
		O score está associado ao cod_conceito 
		É o conceito associado à resposta CERTA
	*/

	$respostaObj = new RespostaDAO();

	//Busca através da PERGUNTA o conceito da RESPOSTA CERTA
	$conceito_resposta_certa = $respostaObj->get_id_conceito($perg_id); 
	$respostaObj = NULL;

	if (!$conceito_resposta_certa) {
		echo "Erro! Não há resposta correta cadastrada para esta pergunta!";
		session_destroy();
		exit();
	}
	/* 
		SE ERRAR, OBTER MOTIVO 
		Motivo: Conceito associado à resposta errada dada pelo usuário
	*/
	if ($score == -1) {
		$respostaObj = new RespostaDAO();
		$motivo = $respostaObj->listar_conceito($id_resposta); //id da resposta
		$respostaObj = NULL;
	} else {
		$motivo = NULL;
	}
		
	/* SALVA RESULTADO 
	Se o score for -1 [errou] = 
		O aluno não sabe o CONCEITO da RESPOSTA CERTA $conceito_resposta_certa, 
		e o motivo é o CONCEITO DA RESPOSTA MARCADA [ERRADA] $motivo
		

	Se o score for 0 = 
		O aluno sabe [acertou], então ele sabe o $conceito_resposta_certa
		Motivo é null
	*/

	$resultadoObj = new Resultado(
		$_SESSION["cod_usuario"], 
		$_SESSION["codTst"], 
		$conceito_resposta_certa[0]["cod_conceito"], 
		$motivo[0]["cod_conceito"], 
		$score,
		$perg_id,
		$id_resposta,
		$timer
	);

	$resultadoDAO = new ResultadoDAO();
	$inserir = $resultadoDAO->inserir($resultadoObj);

	/* PEGA ID DA PROXIMA PERGUNTA */
	$perguntasObj = new PerguntaDAO();
	$prox_pergunta_id = $perguntasObj->listar_proxima_id($id_resposta);

} // end if (respFlag)

/* Se o teste não chegou ao fim */
/* se o respFlag for false, vai para o else */
if (
	$respFlag &&
	isset($prox_pergunta_id[0]["prox_perg"]) && 
	$prox_pergunta_id[0]["prox_perg"] != 0 && 
	$prox_pergunta_id[0]["prox_perg"] != ""
	) 
{

	//Define id 
	$id = $prox_pergunta_id[0][0];
	$perguntasObj = null;

	// LISTAR DADOS DA PROXIMA PERGUNTA
	$perguntasObj = new PerguntaDAO();
	$prox_pergunta = $perguntasObj->listar_proxima($id);

	// LISTAR RESPOSTAS DA PROXIMA PERGUNTA
	$respostasObj = new RespostaDAO();
	$respostas = $respostasObj->listar_todas_pergunta($id);

	$_SESSION["nQuestion"]++;
	
	quizShow($prox_pergunta[0],$respostas); 

} else {

	$resultadoFinal = new ResultadoDAO();
	$listar_resultado = $resultadoFinal->consolidado($_SESSION["codTst"], $_SESSION["cod_usuario"]);
	$sequencia = $resultadoFinal->listar_sequencia($_SESSION["codTst"], $_SESSION["cod_usuario"]);

	echo "<h2>Você finalizou o teste! </h2>";
	
	if ($listar_resultado) 
	{
		echo "<p>Um e-mail será enviado a você com os resultados: </p>";
		
		echo "<table class='resultados' style='width: 100%'>";
		echo "
			<tr>
				<td colspan='3'>
					<b>Nome usuário: </b>"
					.$listar_resultado[0]["nm_usuario"].
				"</td>
			</tr>
			";

		/* Mostrar relatório consolidado */

		echo "
		<tr>
			<td><b>Score</b></td>
			<td colspan='3'><b>Conceito</b></td>
		</tr>
		";
		for ($i=0; $i < count($listar_resultado); $i++) {
			echo "
			<tr>
				<td>".$listar_resultado[$i]["score"]."</td>
				<td colspan='3'>".$listar_resultado[$i]["conceito"]."</td>
			</tr>
			";
		}
		echo "</table>";
		/* Mostrar relatório sequencial */

		
		echo "<table class='resultados' style='width: 100%'>";
		echo "
		<tr>
			<td><b>Pergunta</b></td>
			<td><b>Resposta</b></td>
			<td><b>Tempo</b></td>
		</tr>
		";

		for ($j=0; $j < count($sequencia); $j++) {

			echo "<tr class='resultado_sequencia'>";
				
				echo "<td>";
					echo "<p>".$sequencia[$j]["pergunta"]."</p>";
					if (!empty($sequencia[$j]["img_perg"])) {
						echo "<img src='../painel/img/".md5($_SESSION["codTst"])."/".$sequencia[$j]["img_perg"]."' />";
						echo"</br>";
					}
				echo "</td>";
				
				echo "<td>";
					echo "<p>".$sequencia[$j]["resposta"]."</p>";
					if (!empty($sequencia[$j]["img_resp"])) {
						echo "<img src='../painel/img/".md5($_SESSION["codTst"])."/".$sequencia[$j]["img_resp"]."' />";
						echo"</br>";
					}

					if ($sequencia[$j]["score"] === "0") {
						echo "<img src='img/right.png'>";
					} else if ($sequencia[$j]["score"] === "-1") {
						echo "<img src='img/wrong.png'>";
					}

				echo "</td>";

				echo "<td align='center' class='id_column'>";
					echo gmdate("H:i:s", $sequencia[$j]["tempo"]);
				echo "</td>";

				
			echo "</tr>";

		}
		
		/* Fim relatório sequencial */

		echo "</table>";

		$resultadoFinal->enviarEmail($listar_resultado, $_SESSION["codTst"], $_SESSION["cod_usuario"]);
	}
	
	session_destroy();

}

?>
