<?php

class Conceito{

	private $cod = null;
	private $nome = null;

	function __construct($nome){
		$this->nome = $nome;
	}

	function getCod(){
		return $this->cod;
	}

	function getNome(){
		return $this->nome;
	}

	function setNome($nome){
		$this->nome = $nome;
	}
	function setCod($cod){
		$this->cod = $cod;
	}
}
?>