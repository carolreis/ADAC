<?php

class TesteDAO extends db{

	function __construct(){
		parent::__construct();
	}

	function inserir($teste){
		
		$sql = "INSERT INTO teste (nm_tst) VALUES (?)";
		$stmt = parent::prepare($sql);
		$nome = $teste->getNome();
		$stmt->bind_param("s",$nome);
		
		if($stmt->execute()){
			$stmt->close();
			return true;
		}else{
			echo $stmt->error;
			$stmt->close();
			return false;
		}


	}

	function listar_todos(){
		$select = parent::query("SELECT * FROM teste");
		$resultado = parent::resultado();
		return $resultado;
	}
	
	function listar_ativos() {
		$db = new db();
		$db->query("SELECT * FROM teste WHERE ativo = 1");
		return $db->resultado();
	}

	function getNome($id){
		$select = parent::query("SELECT nm_tst FROM teste WHERE cod_tst = $id");
		$resultado = parent::resultado();
		return $resultado;
	}

	function existsTest($nome){
		$nome = trim($nome);
		$select = parent::query("SELECT cod_tst FROM teste WHERE UPPER(nm_tst) = UPPER('$nome') ");
		$resultado = parent::resultado();
		
		if($resultado){
			return true;
		}else{
			return false;
		}

	}

	function getAtivo(){
		$select = parent::query("SELECT cod_tst FROM teste WHERE ativo = 1");
		return parent::resultado();
	}
	function last_id(){
		 return parent::resultado_insert_id();
	}

}