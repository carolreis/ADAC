<?php 
	session_start();
	include("functions/lib.php");
	require("config/config.php");
	require("classes/Pergunta.class.php");
	require("classes/DAO/PerguntaDAO.class.php");

	$cod_tst = isset($_POST["cod_tst"]) ? $_POST["cod_tst"] : "";
	$cod_perg = isset($_POST["cod_perg"]) ? $_POST["cod_perg"] : 0;
	$cod_resp = isset($_POST["cod_resp"]) ? $_POST["cod_resp"] : "";
	$tipo_resp = isset($_POST["tipo_resp"]) ? $_POST["tipo_resp"] : "";
	$resposta = isset($_POST["resposta"]) ? $_POST["resposta"] : "";
	
	/* Objetiva */
	$txt_resp = isset($_POST["txt_resp"]) ? $_POST["txt_resp"] : "";
	$conceito = isset($_POST["conceito"]) ? $_POST["conceito"] : 0;
	
	/* 
	******************** UPLOAD DE IMAGEM - RESPOSTA ********************
	*/

	$imagem = isset($_FILES["img_resp"]["name"]) ? $_FILES["img_resp"]["name"] : "";
 	$imagem_tmp = isset($_FILES["img_resp"]["tmp_name"]) ? $_FILES["img_resp"]["tmp_name"] : "";
 	
 	$newWidth = isset($_POST["largura_resp"]) ? $_POST["largura_resp"] : '500';
	if($newWidth == "") $newWidth = 500;

	$novoNome = NULL; 				

 	if(isset($_FILES['img_resp']['name']) && $_FILES["img_resp"]["error"] == 0){

 		$novoNome = upload_resize_image($imagem, $imagem_tmp, $newWidth, $cod_tst);

	}
	
	/* END - UPLOAD DE IMAGEM */


	/* 
	******************** UPLOAD DE TUDO NO BANCO DE DADOS ********************
	*/
	
	/* .......... ATUALIZA RESPOSTA .......... */
	$db2 = new db();

		/* Se OBJETIVA */

	if($tipo_resp == "0001"){
		if($novoNome){
			$db2->query("
				UPDATE item 
				SET 
					tipo_resp = '$tipo_resp',
					img_resp = '$novoNome',
					txt_resp = '$txt_resp',
					cod_conceito = '$conceito'
				WHERE 
					cod_resp = '$cod_resp'
			");
		}else{
			$db2->query("
				UPDATE item 
				SET 
					tipo_resp = '$tipo_resp',
					txt_resp = '$txt_resp',
					cod_conceito = '$conceito'
				WHERE 
					cod_resp = '$cod_resp'
			");
		}

		/* Salva os conceitos */
		//$db3 = new db();
		//$db3->query("INSERT INTO conceitosteste (cod_conceito,cod_tst) VALUES ('$conceito',$cod_tst) ");


	}else{
		
		/* se DESCRITIVA */

		$db2->query("
		UPDATE item 
			SET 
				tipo_resp = '$tipo_resp',
				txt_resp = '$txt_resp',
				cod_conceito = '$conceito',
				certa_resp = '1'
			WHERE 
				cod_resp = '$cod_resp'
		");

		/* Salva o conceito */
		//$db3 = new db();
		//$db3->query("INSERT INTO conceitosteste (cod_conceito,cod_tst) VALUES ('$conceito',$cod_tst) ");

	}

/* END - UPLOAD NO BANCO DE DADOS */

@header("Location: editarPergunta.php?perg=$cod_perg");