<?php

/******************** CABEÇALHO ********************/
$nameFile = isset($_POST["nomeArquivo"]) ? str_replace(" ","",$_POST["nomeArquivo"]) : "";
$content = isset($_POST["fContent"]) ? $_POST["fContent"] : "";
$release = isset($_POST["fRelease"]) ? $_POST["fRelease"] : "";
$entity = isset($_POST["fEntity"]) ? $_POST["fEntity"] : "";

/********** CRIA XML **********/
$dom = new DOMDocument("1.0", "UTF-8");

$dom->preserveWhiteSpace = true;
$dom->formatOutput = true;

/********** TAG QUIZ **********/
$root = $dom->createElement("Quiz");
$rootAttribute2 = $dom->createAttribute('Content');
$rootAttribute3 = $dom->createAttribute('release');
$rootAttribute4 = $dom->createAttribute('entity');
$rootAttribute2->value = $content;
$rootAttribute3->value = $release;
$rootAttribute4->value = $entity;

$root->appendChild($rootAttribute2);
$root->appendChild($rootAttribute3);
$root->appendChild($rootAttribute4);

	/***** TAG QUESTIONS *****/
	$questions = $dom->createElement("Questions");

	$root->appendChild($questions);
	$dom->appendChild($root);

/******************** ADICIONA PERGUNTAS ********************/

	//$_SESSION["nPerg"]++;
	//$questionId = $_SESSION["idQuestion"];
	$contador = count($_POST["counter"]);
	

	for($i=0; $i < $contador; $i++) {

		$questionLevel = isset($_POST["level"][$i]) ? $_POST["level"][$i] : "";
		$questionTimeLimit = isset($_POST["time"][$i]) ? $_POST["time"][$i] : "";
		$questionContent = isset($_POST["content"][$i]) ? $_POST["content"][$i] : "";
		$questionText = isset($_POST["question"][$i]) ? $_POST["question"][$i] : "";
		$questionMod = isset($_POST["mod"][$i]) ? $_POST["mod"][$i] : "";
		$questionTextwrong = isset($_POST["textWrong"][$i]) ? $_POST["textWrong"][$i] : "";
	 	
	 	if ($questionMod == 1) {
	 		
	 		$questionMod = "objective";
			
			$opcoesObjetivas = array(
	 			$_POST["answer1"][$i],
	 			$_POST["answer2"][$i],
	 			$_POST["answer3"][$i],
	 			$_POST["answer4"][$i],
	 			$_POST["answer5"][$i]
	 		);
	 		
	 		$respostaObjetiva = isset($_POST["rightAnswer"]) ? $_POST["rightAnswer"] : "";

	 	} else if($questionMod == 2) {
	 		
	 		$questionMod = "value";

			$respostaDescritiva = isset($_POST["answer"][$i]) ? $_POST["answer"][$i] : "";
			
	 	}

		/***** TAG QUESTION *****/
		$question = $dom->createElement('Question');
		
		/*question attributes*/
		$questionAttribute1 = $dom->createAttribute('id');
		$questionAttribute1->appendChild($dom->createTextNode($i+1));
		
		$questionAttribute2 = $dom->createAttribute('level');
		$questionAttribute2->appendChild($dom->createTextNode($questionLevel));

		$questionAttribute3 = $dom->createAttribute('mod');
		$questionAttribute3->appendChild($dom->createTextNode($questionMod));

		$questionAttribute4 = $dom->createAttribute('timelimit');
		$questionAttribute4->appendChild($dom->createTextNode($questionTimeLimit));

		$questionAttribute5 = $dom->createAttribute('Content');
		$questionAttribute5->appendChild($dom->createTextNode($questionContent));

		$question->appendChild($questionAttribute1);
		$question->appendChild($questionAttribute2);
		$question->appendChild($questionAttribute3);
		$question->appendChild($questionAttribute4);
		$question->appendChild($questionAttribute5);

		/***** TAG TEXT *****/
		$text = $question->appendChild($dom->createElement('Text', $questionText));
		
		/***** TAG ANSWERS *****/
		$answers = $dom->createElement('Answers',"");

			/***** TAG ANSWER *****/

			if ($questionMod == "objective") {

				for ( $j=0; $j<5; $j++ ) {
					
					$answer = $answers->appendChild(clone $dom->createElement('Answer', $opcoesObjetivas[$j]));
					
					$answerAttribute = $dom->createAttribute('right');
					
					/* Resposta objetiva é o indice de qual resposta está certa */	
					if ($respostaObjetiva == $j+1) {

						$answerAttribute->value = 'true';

					} else {

						$answerAttribute->value = 'false';

					}

					$answer->appendChild($answerAttribute);

				}

			} else {
								
				$answer = $question->appendChild(clone $dom->createElement('Answer', $respostaDescritiva));
				$answerAttribute = $dom->createAttribute('right');
				$answerAttribute->value = 'true';
				$answer->appendChild($answerAttribute);
				$answers->appendChild($answer);
			
			}

		$question->appendChild($answers);

		$textwrong = $question->appendChild(clone $dom->createElement('Textwrong',$questionTextwrong));

		$img = isset($_POST["oldImageBase64"][$i]) ? $_POST["oldImageBase64"][$i] : "";
		
		
		if ($img  != "") {
			$image = $question->appendChild($dom->createElement('Image',$img));
		}else{
			$image = $question->appendChild($dom->createElement('Image',''));
		}

		$text = $question->appendChild($dom->createElement('Text', $questionText));
		$questions->appendChild(clone $question);

/***** CRIA ARQUIVO *****/

	gc_collect_cycles($dom);
	$dom->saveXML();
	$dom->save("testes/".$nameFile);
	echo "
	<script>
	alert('Editado com sucesso!');
	</script>
	";
	header("Location: listarEditarTeste.php?xml=".$nameFile);

}

?>