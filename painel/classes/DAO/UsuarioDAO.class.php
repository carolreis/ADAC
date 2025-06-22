<?php
class UsuarioDAO extends db {

	function __construct() {
		parent::__construct();
	}

	function inserir($usuario) {
		
		$sql = "
		INSERT INTO 
		usuario (nm_usuario, login_usuario, email_usuario, senha_usuario, atrib_usuario) 
		VALUES (?,?,?,?,?)
		";
		
		$stmt = parent::prepare($sql);

		$nome = $usuario->getNome();
		$login = $usuario->getLogin();
		$email = $usuario->getEmail();
		$atrib = $usuario->getAtrib();
		$senha = $usuario->getSenha();

		$stmt->bind_param("ssssi", $nome, $login, $email, $senha, $atrib);
		
		if ($stmt->execute()) {
			$stmt->close();
			return true;
		} else {
			echo $stmt->error;
			$stmt->close();
			return false;
		}

	}

	function listar_professores() {
		$select = parent::query("SELECT * FROM usuario WHERE atrib_usuario = 1");
		$resultado = parent::resultado();
		return $resultado;
	}

	function listar($id) {
		$select = parent::query("SELECT * FROM usuario WHERE cod_usuario = $id");
		return parent::resultado();
	}


	function alterar($usuario) {

		if ( !empty($usuario->getSenha()) ) {
			$sql = "UPDATE usuario SET nm_usuario = ?, login_usuario = ?, email_usuario = ?, senha_usuario = ? WHERE cod_usuario = ?";
			$stmt = parent::prepare($sql);
			$stmt->bind_param("ssssi",$usuario->getNome(), $usuario->getLogin(), $usuario->getEmail(), $usuario->getSenha(), $usuario->getCod());
		} else {
			$sql = "UPDATE usuario SET nm_usuario = ?, login_usuario = ?, email_usuario = ? WHERE cod_usuario = ?";
			$stmt = parent::prepare($sql);
			$stmt->bind_param("sssi",$usuario->getNome(), $usuario->getLogin(), $usuario->getEmail(), $usuario->getCod());
		}
		
		
		if($stmt->execute()){
			$stmt->close();
			return true;
		}else{
			echo $stmt->error;
			$stmt->close();
			return false;
		}
	}

	function excluir($id){
		$excluir  = parent::query("DELETE FROM usuario WHERE cod_usuario = $id");
		return parent::resultado();
	}

	function logar($login, $senha) {
		$login = trim(strtolower($login));
		$senha = trim(strtolower($senha));

		$select = parent::query("
			SELECT cod_usuario 
			FROM usuario 
			WHERE 
				LOWER(TRIM(login_usuario)) = '$login' AND
				LOWER(TRIM(senha_usuario)) = '$senha'
			");

		$resultado = parent::resultado();
		
		return $resultado;
	}

	function last_id() {
		 return parent::resultado_insert_id();
	}

	function existsUser($login){
		$login = trim($login);
		$select = parent::query("SELECT cod_usuario FROM usuario WHERE UPPER(login_usuario) = UPPER('$login') ");
		$resultado = parent::resultado();
		
		if($resultado){
			return true;
		}else{
			return false;
		}

	}

}