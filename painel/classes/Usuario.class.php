<?php

class Usuario{

	private $cod_usuario	 = null;
	private $nm_usuario	 = null;
	private $email_usuario	 = null;
	private $login_usuario = null;
	private $senha_usuario = null;
	private $atrib_usuario	 = null;
	
	function __construct($login_usuario = null, $nm_usuario, $email_usuario, $senha_usuario ,$atrib_usuario = 1){
		$this->nm_usuario = $nm_usuario;
		$this->email_usuario = $email_usuario;
		$this->login_usuario = $login_usuario;
		$this->senha_usuario = $senha_usuario;
		$this->atrib_usuario = $atrib_usuario;
	}

	function getNome() {
		return $this->nm_usuario;
	}

	function getLogin() {
		return $this->login_usuario;
	}

	function getEmail() {
		return $this->email_usuario;
	}

	function getAtrib() {
		return $this->atrib_usuario;
	}

	function getCod() {
		return $this->cod_usuario;
	}

	function getSenha() {
		return $this->senha_usuario;
	}

	function setCod($cod) {
		$this->cod_usuario = $cod;
	}
	
	function setNome($nome){
		$this->nm_usuario = $nome;
	}

	function setLogin($login) {
		$this->login_usuario = $login;
	}

	function setEmail($email) {
		$this->email_usuario = $email;
	}

	function setAtrib($atrib) {
		$this->atrib_usuario = $atrib;
	}

	function setSenha($senha) {
		$this->senha_usuario = $senha;
	}

}
?>