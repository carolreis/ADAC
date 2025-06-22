<?php

class ConceitoDAO extends db{

	function __construct(){
		parent::__construct();
	}

	function inserir($conceito){
		
		$sql = "INSERT INTO conceito (nm_conceito) VALUES (?)";
		$stmt = parent::prepare($sql);
		$stmt->bind_param("s",$conceito->getNome());
		
		if($stmt->execute()){
			$stmt->close();
			return true;
		}else{
			echo $stmt->error;
			$stmt->close();
			return false;
		}


	}

	function listar_nome($nome){
		$select = parent::query("SELECT * FROM conceito WHERE nm_conceito LIKE '%".trim($nome,"'")."%'");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar_id($id) {
		$select = parent::query("SELECT * FROM conceito WHERE cod_conceito = $id ");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar_todos(){
		$select = parent::query("SELECT * FROM conceito");
		$resultado = parent::resultado();
		return $resultado;
	}

	function existsTest($nome){
		$nome = trim($nome);
		$select = parent::query("SELECT cod_conceito FROM conceito WHERE UPPER(nm_conceito) = UPPER('$nome') ");
		$resultado = parent::resultado();
		
		if($resultado){
			return true;
		}else{
			return false;
		}

	}

	function excluir($cod) {
		$excluir = parent::query("DELETE FROM conceito WHERE cod_conceito = $cod");
	}

	function last_id(){
		 return parent::resultado_insert_id();
	}

	function alterar($conceito) {

		$sql = "UPDATE conceito SET nm_conceito = ? WHERE cod_conceito = ? ";
		$stmt = parent::prepare($sql);
		$stmt->bind_param("si",$conceito->getNome(),$conceito->getCod());
		
		if($stmt->execute()){
			$stmt->close();
			return true;
		}else{
			echo $stmt->error;
			$stmt->close();
			return false;
		}
	}

}