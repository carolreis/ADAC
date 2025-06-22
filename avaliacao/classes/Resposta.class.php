<?php

class Resposta{

	private $cod_resp = null;
	private $cod_item = null; // cod perg
	private $txt_resp = null;
	private $img_perg = null;
	private $cod_conceito = null;
	private $dom_conceito = null;
	private $certa_resp = null;
	private $prox_perg = null;
	private $tipo_resp = null;

	function __construct(
		$cod_item,
		$txt_resp = null,
		$img_resp = null,
		$cod_conceito,
		$dom_conceito = null,
		$certa_resp,
		$tipo_resp
	){
		$this->cod_item = $cod_item
		$this->txt_resp = $txt_resp;
		$this->img_resp = $img_resp;
		$this->cod_conceito = $cod_conceito;
		$this->dom_conceito = $dom_conceito;
		$this->certa_resp = $certa_resp;
		$this->tipo_resp = $tipo_resp;
	}

}
?>