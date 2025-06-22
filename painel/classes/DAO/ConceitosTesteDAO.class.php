<?php

class ConceitosTesteDAO extends db {

	function __construct() {
		parent::__construct();
	}

	function inserir($conceito) {
		
		$quantidadeConceitos = $conceito->countConceitos();
		$arrayConceitos = $conceito->getCodConceito();
		$cod = $conceito->getCodTeste();

		
		for($i=0; $i < $quantidadeConceitos; $i++) {
			$stmt = parent::query("INSERT INTO conceitosteste (cod_tst, cod_conceito) VALUES ('$cod','$arrayConceitos[$i]')");
		}
		
	}

	function last_id() {
		 return parent::resultado_insert_id();
	}

}