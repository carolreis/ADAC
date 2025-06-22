<?php

class Resultado{

	private $cod_resultado = null;
	private $cod_usuario = null;
	private $cod_tst = null;
	private $cod_conceito = null;
	private $motivo = null;
	private $score = null;
	private $certeza_score = null;
	private $timer = null;

	function __construct($cod_usuario, $cod_tst, $cod_conceito, $motivo, $score, $perg_id, $item_id, $timer){
		$this->cod_usuario = $cod_usuario;
		$this->cod_tst = $cod_tst;
		$this->cod_conceito = $cod_conceito;
		$this->motivo = $motivo;
		$this->score = $score;
		$this->perg_id = $perg_id; // id da pergunta
		$this->item_id = $item_id; // id da resposta
		$this->timer = $timer;
	}

	function getPergId(){
		return $this->perg_id;
	}
	function getCodUsuario(){
		return $this->cod_usuario;
	}
	function getCodResultado(){
		return $this->cod_resultado;
	}
	function getCodTeste(){
		return $this->cod_tst;
	}	
	function getCodConceito(){
		return $this->cod_conceito;
	}	
	function getScore(){
		return $this->score;
	}	
	function getMotivo(){
		return $this->motivo;
	}	
	function getItemId(){
		return $this->item_id;
	}
	function getTimer(){
		return $this->timer;
	}	
	
	function setPergId($perg_id){
		$this->perg_id = $perg_id;
	}
	function setMotivo($motivo){
		$this->motivo = $motivo;
	}
	function setCodUsuario($cod_usuario){
		$this->cod_usuario = $cod_usuario;
	}
	function setCodResultado($cod_resultado){
		$this->cod_resultado = $cod_resultado;
	}
	function setCodTeste($cod_tst){
		$this->cod_tst = $cod_tst;
	}	
	function setCodConceito($cod_conceito){
		$this->cod_conceito = $cod_conceito;
	}	
	function setScore($score){
		$this->score = $score;
	}	
	function setItemId($id){
		$this->item_id = $id;
	}
	function setTimer($timer){
		$this->timer = $timer;
	}	
	

}
?>