<?php

class Teste{

	private $cod = null;
	private $nome = null;
	private $professor = null;
	private $conceitos = null;

	function __construct($nome, $professor){
		$this->nome = $nome;
		$this->professor = $professor;
	}

	function getCod(){
		return $this->cod;
	}

	function getNome(){
		return $this->nome;
	}

	function getProfessor(){
		return $this->professor;
	}

	function getConceitos(){
		return $this->conceitos;
	}	

	function setProfessor($professor){
		$this->professor = $professor;
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