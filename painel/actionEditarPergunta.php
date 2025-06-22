<?php 
	session_start();
	include("functions/lib.php");
	require("config/config.php");
	require("classes/Pergunta.class.php");
	require("classes/DAO/PerguntaDAO.class.php");

	/********** Variáveis da Pergunta **********/
	$cod_tst = isset($_POST["cod_tst"]) ? $_POST["cod_tst"] : "";
	$cod_perg = isset($_POST["cod_perg"]) ? $_POST["cod_perg"] : "";
	$txt_perg = isset($_POST["txt_perg"]) ? $_POST["txt_perg"] : "";
	$tipo_perg = isset($_POST["tipo_perg"]) ? $_POST["tipo_perg"] : "";

	/********** Variáveis das Respostas **********/
	$tipo_resp = isset($_POST["tipo_resp"]) ? $_POST["tipo_resp"] : "";
	
	/*** DESCRITIVA ***/
	$resposta = isset($_POST["resposta"]) ? $_POST["resposta"] : "";
	
	/*** OBJETIVA ***/
	
	//array
	$txt_resp = isset($_POST["txt_resp"]) ? $_POST["txt_resp"] : NULL;
	
	//int
	$quantResp = $txt_resp ? count($_POST["txt_resp"]) : 0;
	
	//array
	$certa_resp = isset($_POST["certa_resp"]) ? $_POST["certa_resp"] : array("");

	$conceito = isset($_POST["conceito"]) ? $_POST["conceito"] : NULL;
	

	/* 
	******************** UPLOAD DE IMAGEM - PERGUNTA ********************
	*/

	$novoNome = NULL; 				
 	
 	if(isset($_FILES['imagem']['name']) && $_FILES["imagem"]["error"] == 0){

 		$newWidth = isset($_POST["widthImagem"]) ? $_POST["widthImagem"] : '300';
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

			if($img_resp[$i] != "" && $img_resp_error[$i] == 0) {

				if($nova_largura_resp[$i] == "") $nova_largura_resp = 300;
	 	
	 			$novo_nome_resp[$i] = upload_resize_image($img_resp[$i], $img_resp_tmp[$i], $nova_largura_resp[$i], $cod_tst);
 			
 			}
 		}
 	}
	
	/* END - UPLOAD DE IMAGEM */


	/* 
	******************** UPLOAD DE TUDO NO BANCO DE DADOS ********************
	*/
	
	/* .......... ATUALIZA PERGUNTA .......... */
	$db = new db();

	if($novoNome){
		$db->query("UPDATE perguntas SET img_perg = '$novoNome', txt_perg = '$txt_perg', tipo_perg = '$tipo_perg' WHERE cod_tst = '$cod_tst' AND cod_item = '$cod_perg'");
	}else{
		$db->query("UPDATE perguntas SET txt_perg = '$txt_perg', tipo_perg = '$tipo_perg' WHERE cod_tst = '$cod_tst' AND cod_item = '$cod_perg'");
	}

	$perg_id = $cod_perg;

	
	/* .......... ADICIONA RESPOSTAS À PERGUNTA .......... */
	$db2 = new db();

		/* Se OBJETIVA */

	if($tipo_resp == "0001"){

		for($i=0; $i < $quantResp; $i++){

			/* Conceito Associado */
			if (!isset($conceito[$i])){
				echo "Você deve adicionar um conceito à todas as respostas! <br/> Redirecionando...";
				header("refresh:3; url=editarPergunta.php?perg=".$cod_tst);
				exit();
			}

			/* Marcação de resposta correta */
			if($certa_resp[0] == ($i+1)){
				$certa = 1;
				$db2->query("UPDATE item SET certa_resp = 0 WHERE cod_item = $perg_id");
			}else{
				$certa = 0;
			}


			$db2->query("
				INSERT INTO item 
					(cod_item, txt_resp, cod_conceito, certa_resp, tipo_resp, img_resp) 
				VALUES 
					('$perg_id','$txt_resp[$i]','$conceito[$i]','$certa','$tipo_resp', '$novo_nome_resp[$i]')
			");

			/* Salva os conceitos */
			$db3 = new db();
			$db3->query("INSERT INTO conceitosteste (cod_conceito,cod_tst) VALUES ('$conceito[$i]',$cod_tst) ");

		}

	} else if($tipo_resp == "0010") {
		
		/* se DESCRITIVA */
		
		/* Conceito Associado */
		if (!isset($conceito[0])){
			echo "<b>RESPOSTA NÃO CADASTRADA!</b> <br/> Você deve adicionar um conceito à todas as respostas! <br/> Redirecionando...";
			header("refresh:3; url=editarPergunta.php?perg=".$cod_perg);
			exit();
		}

		$db2->query("
		INSERT INTO item 
			(cod_item, txt_resp, cod_conceito, certa_resp, tipo_resp) 
		VALUES 
			('$perg_id','$resposta','$conceito[0]','1','$tipo_resp')
		");

		/* Salva o conceito */
		$db3 = new db();
		$db3->query("INSERT INTO conceitosteste (cod_conceito,cod_tst) VALUES ('$conceito[0]',$cod_tst) ");

	}

/* END - UPLOAD NO BANCO DE DADOS */

@header("Location: perguntas.php?teste=$cod_tst");