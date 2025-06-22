<?php
	
	include("config/config.php");
	include("classes/DAO/RespostaDAO.class.php");

	$id = $_POST["varDado"];

	$respostaObj = new RespostaDAO();
	if($excluir = $respostaObj->excluir($id)){
		echo "teste: ".$excluir["teste"];
		echo "<br>imagem: ".$excluir["imagem"];
		unlink("img/".$excluir["teste"]."/".$excluir["imagem"]);
	}

 ?>