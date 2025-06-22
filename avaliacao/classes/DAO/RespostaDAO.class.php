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

		$select = parent::query("
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
	
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar_todas_pergunta($id){
		//$id = da pergunta
		// cod_item = cod da perg
		$select = parent::query("SELECT * FROM item WHERE cod_item = $id ");
		return $resultado = parent::resultado();
	}

	function verificar_resposta_obj($id){
		$select = parent::query("SELECT certa_resp FROM item WHERE cod_resp = $id");
		return $resultado = parent::resultado();
	}
	function verificar_resposta_desc($id){
		$select = parent::query("SELECT txt_resp FROM item WHERE cod_resp = $id");
		return $resultado = parent::resultado();
	}

	function listar_conceito($id){
		$select = parent::query("
			SELECT conceito.cod_conceito FROM item
			INNER JOIN conceito ON conceito.cod_conceito = item.cod_conceito
			WHERE item.cod_resp = $id
			");
		return $resultado = parent::resultado();
	}

	//Retorna conceito associado a resposta correta da pergunta
	function get_id_conceito($perg_id){
		$select = parent::query("SELECT cod_conceito FROM item WHERE cod_item = $perg_id AND certa_resp = 1");
		return $resultado = parent::resultado();
	}

	function get_id_descritiva($id_pergunta){
		$select = parent::query("SELECT cod_resp FROM item WHERE cod_item = $id_pergunta"); //adicionar AND tipo_perg = 0010 ?
		return $resultado = parent::resultado();
	}

}