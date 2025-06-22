<?php

class Pergunta{

	private $cod = null;
	private $cod_tst = null;
	private $img_perg = null;
	private $txt_perg = null;

	function __construct($cod_tst, $img_perg = null, $txt_perg = null){
		$this->cod_tst = $cod_tst;
		$this->img_perg = $img_perg;
		$this->txt_perg = $txt_perg;
	}

	function getCod(){
		return $this->cod;
	}
	function getCotTst(){
		return $this->cod_tst;
	}
	function getImg(){
		return $this->img_perg;
	}
	function getTxt(){
		return $this->txt_perg;
	}

	function setCod($cod){
		$this->cod = $cod;
	}
	function setCodTst($cod_tst){
		$this->cod_tst = $cod_tst;
	}
	function setImg($img_perg){
		$this->img_perg = $img_perg;
	}
	function setTxt($txt_perg){
		$this->txt_perg = $txt_perg;
	}

}
?>