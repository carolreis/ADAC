<?php

class RespostaDAO extends db{

	function __construct(){
		parent::__construct();
	}

	function listar_todas(){
		$select = parent::query("

		");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar_todas_teste($cod_teste){

/*
		$select = parent::query("
			SELECT * FROM item 
			INNER JOIN perguntas ON item.cod_item = perguntas.cod_item
			INNER JOIN conceito ON item.cod_conceito = conceito.cod_conceito
			WHERE perguntas.cod_tst = '46' AND tipo_perg = 2
			");
		$resultado = parent::resultado();
		return $resultado;

		*/

		$db = new db();

		$select = $db->query("
			SELECT 
				item.cod_resp,
				item.img_resp,
				item.cod_item,
				item.txt_resp,
				item.prox_perg,
				pr.cod_item as cod_perg,
				pr.cod_tst,
				pr.tipo_perg,
				pergunta_encadeada.cod_item as cod_perg_enc,
				pergunta_encadeada.txt_perg as txt_perg_enc
			FROM item 
			LEFT JOIN perguntas pr ON item.cod_item = pr.cod_item
			LEFT JOIN perguntas pergunta_encadeada ON item.prox_perg = pergunta_encadeada.cod_item
			WHERE pr.cod_tst = $cod_teste
		");
	
		$resultado = $db->resultado();
		return $resultado;
	}

	function listar_todas_pergunta($id){
		//$id = da pergunta
		// cod_item = cod da perg
		$select = parent::query("SELECT conceito.nm_conceito, item.* FROM item INNER JOIN conceito ON item.cod_conceito = conceito.cod_conceito WHERE cod_item = $id ");
		return $resultado = parent::resultado();
	}

	function excluir($id){
		$select = parent::query("SELECT img_resp, cod_tst FROM item INNER JOIN perguntas ON item.cod_item = perguntas.cod_item  WHERE cod_resp = $id");
		$imagem = parent::resultado();

		$delete = parent::query("DELETE FROM item WHERE cod_resp = $id");
		
		$retorno = array('teste' => md5($imagem[0]["cod_tst"]), 'imagem' => $imagem[0]["img_resp"]);
		
		return $retorno;
	}

	function ativar($id){
		$pergunta = parent::query("SELECT cod_item FROM item WHERE cod_resp = $id");
		$id_pergunta = parent::resultado();
		$id_pergunta = $id_pergunta[0][0];

		$d = parent::query("UPDATE item SET certa_resp = 0 WHERE cod_item = $id_pergunta");
		$m = parent::query("UPDATE item SET certa_resp = 1 WHERE cod_resp = $id");
		return $m;	
	}

	function listar($id){
		$select = parent::query("
			SELECT 
				item.*, 
				perguntas.cod_tst,
				perguntas.cod_item as cod_perg,
				conceito.nm_conceito
			FROM item
			INNER JOIN perguntas ON item.cod_item = perguntas.cod_item 
			INNER JOIN conceito ON item.cod_conceito = conceito.cod_conceito
			WHERE item.cod_resp = $id");
		return parent::resultado();
	}

	
}