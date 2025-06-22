<?php

class Teste{

	private $cod = null;
	private $nome = null;
	private $conceitos = null;
	private $ativo = null;

	function __construct($nome){
		$this->nome = $nome;
	}

	function getCod(){
		return $this->cod;
	}

	function getNome(){
		return $this->nome;
	}

	function getConceitos(){
		return $this->conceitos;
	}	
	function getAtivo(){
		return $this->ativo;
	}
	function setAtivo($ativo){
		$this->ativo = $ativo;
	}
	function setNome($nome){
		$this->nome = $nome;
	}
	function setCod($cod){
		$this->cod = $cod;
	}
	function setConceitos($conceitos){
		$this->conceitos = $conceitos;
	}
}
?>