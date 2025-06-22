<?php

class Usuario{

	private $nm_usuario	 = null;
	private $email_usuario	 = null;
	private $atrib_usuario	 = null;
	
	function __construct($nm_usuario, $email_usuario, $atrib_usuario){
		$this->nm_usuario = $nm_usuario;
		$this->email_usuario = $email_usuario;
		$this->atrib_usuario = $atrib_usuario;
	}

	function getNome(){
		return $this->nm_usuario;
	}

	function getEmail(){
		return $this->email_usuario;
	}

	function getAtrib(){
		return $this->atrib_usuario;
	}

	function setNome($nome){
		$this->nm_usuario = $nome;
	}
	function setEmail($email){
		$this->email_usuario = $email;
	}
	function setAtrib($atrib){
		$this->atrib_usuario = $atrib;
	}
}
?>