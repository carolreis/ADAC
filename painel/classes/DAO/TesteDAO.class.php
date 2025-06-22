<?php

class TesteDAO extends db{

	function __construct(){
		parent::__construct();
	}

	function inserir($teste){
		
		$sql = "INSERT INTO teste (nm_tst, professor) VALUES (?,?)";
		$stmt = parent::prepare($sql);
		$nome = $teste->getNome();
		$professor = $teste->getProfessor();
		$stmt->bind_param("sd", $nome, $professor);
		
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

	function excluir($id){
		$excluir  = parent::query("DELETE FROM teste WHERE cod_tst = $id");
		return parent::resultado();
	}

	function last_id(){
		 return parent::resultado_insert_id();
	}

	function ativar($id) {
		$db = new db();
		$db->query("SELECT ativo FROM teste WHERE cod_tst = $id ");
		$status = $db->resultado();

		if ($status[0][0] == 0) {
			$ativar = $db->query("UPDATE teste SET ativo = 1 WHERE cod_tst = $id");
		} else {
			$desativar = $db->query("UPDATE teste SET ativo = 0 WHERE cod_tst = $id");
		}			
	}

}