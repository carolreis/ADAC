<?php

class ConceitosTeste{

	private $cod_conceito = null;
	private $cod_tst = null;

	function __construct($cod_tst, $cod_conceito){
		$this->cod_tst = $cod_tst;
		$this->cod_conceito = $cod_conceito; //array
	}

	function getCodConceito(){
		return $this->cod_conceito;
	}

	function getCodTeste(){
		return $this->cod_tst;
	}

	function setCodTeste($cod){
		$this->cod_tst = $cod;
	}
	function setCodConceito($cod){
		$this->cod_conceito = $cod;
	}

	//retorna quantidade de conceitos no array
	function countConceitos(){
		return count($this->cod_conceito); 
	}
}
?>