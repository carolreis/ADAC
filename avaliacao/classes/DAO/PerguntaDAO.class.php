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

	function listar_primarias(){
		$select = parent::query("
			SELECT * FROM perguntas 
			WHERE tipo_perg = 1 AND cod_tst = ".$_SESSION['codTst']."
			GROUP BY perguntas.cod_item
			");
		$resultado = parent::resultado();
		return $resultado;
	}
	
	function listar_proxima_id($id_resposta){
		$db = new db();
		$db->query("
			SELECT prox_perg 
			FROM item 
			WHERE cod_resp = $id_resposta			
		");

		$resultado = $db->resultado();
		return $resultado;
	}
	function listar_proxima($id){
		$db = new db();
		$db->query("
			SELECT 
				perguntas.cod_item,
				perguntas.cod_tst,
				perguntas.img_perg,
				perguntas.txt_perg,
				perguntas.tipo_perg
			FROM perguntas 
			WHERE perguntas.cod_item = $id AND cod_tst = ".$_SESSION['codTst']."
			GROUP BY perguntas.cod_item
		");
		$resultado = $db->resultado();
		return $resultado;
	}
	function listar($id){
		$select = parent::query("SELECT * FROM perguntas WHERE cod_item = $id AND cod_tst = ".$_SESSION['codTst']."");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar_where_orderby($where,$orderby){
		$select = parent::query("SELECT * FROM perguntas WHERE $where AND cod_tst = ".$_SESSION['codTst']." ORDER BY $orderby ");
		$resultado = parent::resultado();
		return $resultado;
	}

	function last_db_id(){
		$select = parent::query("SELECT * FROM perguntas WHERE cod_tst = ".$_SESSION['codTst']." ORDER BY cod_item ASC LIMIT 1");
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

}