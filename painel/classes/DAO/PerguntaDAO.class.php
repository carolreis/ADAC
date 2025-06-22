<?php

class PerguntaDAO extends db{

	function __construct(){
		parent::__construct();
	}

	function inserir($pergunta){
		
		$sql = "INSERT INTO perguntas (cod_tst,img_perg,txt_perg) VALUES (?,?,?)";
		$stmt = parent::prepare($sql);

		$cod_tst = $pergunta->getCodTst();
		$img_perg = $pergunta->getImg();
		$txt_perg = $pergunta->getTxt();

		$stmt->bind_param("dss", $cod_tst, $img_perg, $txt_perg);
		
		if ($stmt->execute()) {
			$stmt->close();
			return true;
		} else {
			echo $stmt->error;
			$stmt->close();
			return false;
		}


	}

	function listar_todas(){
		$select = parent::query("SELECT * FROM perguntas");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar($id){
		$select = parent::query("SELECT * FROM perguntas WHERE cod_item = $id ");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar_where_orderby($where,$orderby){
		$select = parent::query("SELECT * FROM perguntas WHERE $where ORDER BY $orderby ");
		$resultado = parent::resultado();
		return $resultado;
	}

	function last_db_id(){
		$select = parent::query("SELECT * FROM perguntas ORDER BY cod_item ASC LIMIT 1");
		$resultado = parent::resultado();
		if(empty($resultado)){
			return 1;
		}else{
			return $resultado;
		}
	}
	
	function last_insert_id(){
		 return parent::resultado_insert_id();
	}

	function excluir($id){
		$delete = parent::query("DELETE FROM perguntas WHERE cod_item = $id");

		//deletar posterior

		/* try iy 
		SELECT 
	
	perguntas.cod_item as pergunta_codigo_item,
	item.cod_resp,
	item.cod_item as item_cod_item,
	item.prox_perg
	
 FROM perguntas
INNER JOIN item on item.prox_perg = perguntas.cod_item
HAVING perguntas.cod_item = item.prox_perg

		SELECT 
	perguntas.cod_item as pergunta_codigo_item	
	FROM perguntas
INNER JOIN item on item.prox_perg = perguntas.cod_item
	WHERE item.cod_item = 40

*/

//		return $delete;
	}
}