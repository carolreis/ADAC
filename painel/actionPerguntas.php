<?php 
	session_start();
	include("functions/lib.php");
	require("config/config.php");
	require("classes/Pergunta.class.php");
	require("classes/DAO/PerguntaDAO.class.php");

	$_SESSION["nPerg"]++;
	
	/********** Variáveis da Pergunta **********/
	$cod_tst = isset($_POST["cod_tst"]) ? $_POST["cod_tst"] : "";
	$txt_perg = isset($_POST["txt_perg"]) ? $_POST["txt_perg"] : "";
	$tipo_perg = isset($_POST["tipo_perg"]) ? $_POST["tipo_perg"] : "";

	/********** Variáveis das Respostas **********/
	$tipo_resp = isset($_POST["tipo_resp"]) ? $_POST["tipo_resp"] : "";
	/*** DESCRITIVA ***/
	$resposta = isset($_POST["resposta"]) ? $_POST["resposta"] : "";
	
	/*** OBJETIVA ***/
	
	//array
	$txt_resp = isset($_POST["txt_resp"]) ? $_POST["txt_resp"] : NULL;
	
	// int
	$quantResp = $txt_resp ? count($_POST["txt_resp"]) : 0;
		
	//array
	$certa_resp = isset($_POST["certa_resp"]) ? $_POST["certa_resp"] : array("");
	
	$conceito = isset($_POST["conceito"]) ? $_POST["conceito"] : NULL;


	/* 
	******************** UPLOAD DE IMAGEM - PERGUNTA ********************
	*/

	$novoNome = NULL; 				

 	/* Verifica se existe imagem */
 	if(isset($_FILES['imagem']['name']) && $_FILES["imagem"]["error"] == 0){
 	
 		$newWidth = isset($_POST["widthImagem"]) ? $_POST["widthImagem"] : '300'; // largura padrão é 300px
		if($newWidth == "") $newWidth = 300;

		$imagem = $_FILES["imagem"]["name"];
 		$imagem_tmp = $_FILES["imagem"]["tmp_name"];

 		$novoNome = upload_resize_image($imagem, $imagem_tmp, $newWidth, $cod_tst);

	}
	/* END - UPLOAD DE IMAGEM */


	/* 
	******************** UPLOAD DE IMAGEM - RESPOSTA ********************
	*/

	//array
	$img_resp = isset($_FILES["img_resp"]["name"]) ? $_FILES["img_resp"]["name"] : NULL;
	//array
 	$img_resp_tmp = isset($_FILES["img_resp"]["tmp_name"]) ? $_FILES["img_resp"]["tmp_name"] : NULL;
 	//array
 	$img_resp_error = isset($_FILES["img_resp"]["error"]) ? $_FILES["img_resp"]["error"] : 1;

 	//int
 	$nova_largura_resp = isset($_POST["largura_resp"]) ? $_POST["largura_resp"] : NULL; 

 	if (!$nova_largura_resp) {
 		for ($i=0; $i < $quantResp; $i++) {
 			$nova_largura_resp[$i] = 300; // 300px default 
 		}
 	} else {

 		foreach ($nova_largura_resp as $key => $largura) {
	 		if(empty($largura) || $largura <= 0) {
				$nova_largura_resp[$key] = 300; // 300px default
 			}
 		}
 	}

 	if($img_resp){

		for($i=0; $i < count($img_resp); $i++){
	 		
	 		$novo_nome_resp[$i] = NULL; 				

			/* Se existir imagem */
			if($img_resp[$i] != "" && $img_resp_error[$i] == 0){

				if($nova_largura_resp[$i] == "") $nova_largura_resp = 300;
		 	
		 		$novo_nome_resp[$i] = upload_resize_image($img_resp[$i], $img_resp_tmp[$i], $nova_largura_resp[$i], $cod_tst);
	 		
	 		}
	 	
		}

	}
	/* END - UPLOAD DE IMAGEM */


	/* 
	******************** UPLOAD DE TUDO NO BANCO DE DADOS ********************
	*/
	
	/* .......... SALVA PERGUNTA .......... */
	$db = new db();
	$db->query("
		INSERT INTO perguntas 
			(cod_tst, img_perg, txt_perg, tipo_perg) 
		VALUES 
			('".$cod_tst."', '".$novoNome."' ,'".$txt_perg."','".$tipo_perg."') 
	");

	$perg_id = $db->resultado_insert_id();

	/* .......... ADICIONA RESPOSTAS À PERGUNTA .......... */
	$db2 = new db();

	/* Se OBJETIVA */

	if($tipo_resp == "0001"){

		for($i=0; $i < $quantResp; $i++){

			/* Conceito Associado */
			if (!isset($conceito[$i])){
				echo "Você deve adicionar um conceito à todas as respostas! <br/> Redirecionando...";
				header("refresh:3; url=cadPerguntas.php?cod=".$cod_tst);
				exit();
			}

			/* Marcação de resposta correta */
			if ($certa_resp[0] == ($i+1)) {
				$certa = 1;
			} else { 
				$certa = 0;
			}


			$db2->query("
				INSERT INTO item 
					(cod_item, txt_resp, cod_conceito, certa_resp, tipo_resp, img_resp) 
				VALUES 
					('$perg_id','$txt_resp[$i]','$conceito[$i]','$certa','$tipo_resp', '$novo_nome_resp[$i]')
			");

		}

	} else if($tipo_resp == "0010") {
		
		/* se DESCRITIVA */

		/* Conceito Associado */
		if (!isset($conceito[0])){
			echo "<b>RESPOSTA NÃO CADASTRADA!</b> <br/> Você deve adicionar um conceito à todas as respostas! <br/> Redirecionando...";
			header("refresh:3; url=cadPerguntas.php?cod=".$cod_tst);
			exit();
		}

		$db2->query("
		INSERT INTO item 
			(cod_item, txt_resp, cod_conceito, certa_resp, tipo_resp) 
		VALUES 
			('$perg_id','$resposta','$conceito[0]','1','$tipo_resp')
		");

	}

/* END - UPLOAD NO BANCO DE DADOS */

header("Location: perguntas.php?teste=".$cod_tst);
