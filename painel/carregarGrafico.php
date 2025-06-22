<?php
	require("config/config.php");
	require("classes/DAO/ResultadoDAO.class.php");

	$id_teste = isset($_POST["id_teste"]) ? $_POST["id_teste"] : 3;
	$resultados = new resultadoDAO($id_teste);
	$contagemDeErrosAcertos = $resultados->contagemDeErrosAcertos();

	$retorno = array('grafico' => 
		array(
			'perguntas' => array(),
			'dados' => array(
				array('name' => 'Erros',  'data' => array(), 'stack' => 'female'), 
				array('name' => 'Acertos', 'data' => array(), 'stack' => 'male')
			))
	);

	for($i=0; $i < count($contagemDeErrosAcertos); $i++) {
		array_push($retorno['grafico']['perguntas'], $contagemDeErrosAcertos[$i]['cod_pergunta']);
		array_push($retorno['grafico']['dados'][0]['data'], $contagemDeErrosAcertos[$i]['errado']);
		array_push($retorno['grafico']['dados'][1]['data'], $contagemDeErrosAcertos[$i]['certo']);
	}

	echo json_encode($retorno);

