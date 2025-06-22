<?php

class UsuarioDAO extends db {

	function __construct() {
		parent::__construct();
	}

	function inserir($usuario) {
		
		$sql = "INSERT INTO usuario (nm_usuario, email_usuario, atrib_usuario) VALUES (?,?,?)";
		$stmt = parent::prepare($sql);

		$nome = $usuario->getNome();
		$email = $usuario->getEmail();
		$atrib = $usuario->getAtrib();

		$stmt->bind_param("ssi", $nome, $email, $atrib);
		
		if ($stmt->execute()) {
			$stmt->close();
			return true;
		} else {
			echo $stmt->error;
			$stmt->close();
			return false;
		}

	}

	function last_id() {
		 return parent::resultado_insert_id();
	}

}