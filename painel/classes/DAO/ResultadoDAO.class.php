<?php

class ResultadoDAO extends db {

	public $id_teste = null;
	public $id_usuario = null;

	function __construct($id_teste = null, $id_usuario = null) {
		parent::__construct();
		
		if($id_teste) { $this->id_teste = $id_teste; }
		if($id_usuario) { $this->id_usuario = $id_usuario; }

	}

	function listar_nomes($cod_teste = null) {

		$db = new db();

		$select = $db->query("
			SELECT 
				usuario.cod_usuario,
				usuario.nm_usuario
			FROM resultado
			INNER JOIN usuario ON resultado.cod_usuario = usuario.cod_usuario
			WHERE resultado.cod_tst = $this->id_teste
			GROUP BY usuario.cod_usuario
		");

		return $db->resultado();

	}

	function listar($cod_teste = null, $cod_usuario = null) {

		$db = new db();

		$select = $db->query("

			SELECT
				usuario.nm_usuario,
				usuario.email_usuario,
				resultado.cod_usuario,
				resultado.cod_perg,
				(CASE item.certa_resp WHEN 1 THEN 0 ELSE -1 END) as score
			FROM resultado
			INNER JOIN item ON resultado.cod_item = item.cod_resp
			INNER JOIN conceito c ON resultado.cod_conceito = c.cod_conceito
			INNER JOIN teste ON resultado.cod_tst = teste.cod_tst
			INNER JOIN usuario ON resultado.cod_usuario = usuario.cod_usuario
			WHERE resultado.cod_tst = $this->id_teste AND resultado.cod_usuario = $this->id_usuario;
		");

		return $db->resultado();
	}


	function consolidado($cod_teste = null, $cod_usuario = null) {

		if(!isset($cod_teste)) $cod_teste = $this->id_teste;
		if(!isset($cod_usuario)) $cod_usuario = $this->id_usuario;

		$db = new db();
		$select = $db->query("
			SELECT
               c.nm_conceito as conceito,
               SUM(
                 CASE item.certa_resp WHEN 1 THEN 0 ELSE -1 END) as score
            FROM resultado
            INNER JOIN item ON resultado.cod_item = item.cod_resp
            INNER JOIN conceito c on item.cod_conceito = c.cod_conceito
            WHERE resultado.cod_usuario = $cod_usuario
            GROUP BY c.cod_conceito
            ORDER by c.nm_conceito
		");
		return $db->resultado();
	}

	/* Usado em relatorio.php, relatorioPrinter.php */
	function listar_sequencia($codTeste = null, $usuario = null) {

		$db = new db();

		$select = $db->query("
		SELECT 
			resultado.cod_resultado,
			resultado.cod_perg,
			perguntas.txt_perg as pergunta,
			item.txt_resp as resposta,
			item.img_resp,
			conceito.nm_conceito,
			perguntas.img_perg,
			resultado.tempo,
			(CASE item.certa_resp WHEN 1 THEN 0 ELSE -1 END) as score
		FROM
			resultado
		LEFT JOIN perguntas ON resultado.cod_perg = perguntas.cod_item
		LEFT JOIN item ON resultado.cod_item = item.cod_resp
		INNER JOIN usuario ON resultado.cod_usuario = usuario.cod_usuario
		INNER JOIN conceito ON item.cod_conceito = conceito.cod_conceito
		WHERE resultado.cod_usuario = $this->id_usuario AND resultado.cod_tst = $this->id_teste
		ORDER BY resultado.cod_resultado ASC
		");

		return $db->resultado();
		
	}

	function contagemDeErrosAcertos() {
		$db = new db();
		$db->query("SELECT 
		perguntas.cod_item AS cod_pergunta,
	    COUNT(IF((CASE item.certa_resp WHEN 1 THEN 0 ELSE - 1 END)=0, 1, NULL)) as certo,
	    COUNT(IF((CASE item.certa_resp WHEN 1 THEN 0 ELSE - 1 END)=-1, 1, NULL)) as errado
		FROM resultado
		INNER JOIN perguntas ON resultado.cod_perg = perguntas.cod_item
		INNER JOIN item ON resultado.cod_item = item.cod_resp
		WHERE resultado.cod_tst = $this->id_teste
		GROUP BY cod_pergunta");
		return $db->resultado();
	}

	function relatorioEntrevista() {
		$db = new db();
		$db->query("SELECT 
			t.nm_tst as 'Teste',
			u.cod_usuario as 'ID Usuário',
		    u.nm_usuario AS 'Nome Usuário',
		    r.cod_perg AS 'ID Pergunta',
		    c.cod_conceito as 'ID Conceito',
		    c.nm_conceito as 'Nome Conceito',
		    IF(i.certa_resp = 1, 'CERTA', r.cod_item) as Resposta,
		    r.tempo as 'Tempo'
			FROM resultado r 
		    INNER JOIN perguntas p ON p.cod_item = cod_perg
		    INNER JOIN item i ON i.cod_resp = r.cod_item
			INNER JOIN usuario u ON u.cod_usuario = r.cod_usuario
			INNER JOIN teste t ON t.cod_tst = r.cod_tst
		    INNER JOIN conceito c ON c.cod_conceito = i.cod_conceito
			ORDER BY t.nm_tst, r.cod_usuario
		");
		return $db->resultado();
	}
	function excluir($id) {
		$db = new db();
		$delete = $db->query("DELETE FROM resultado WHERE cod_resultado = $id");
		return $db->resultado();
	}

	function excluir_relatorio($id) {
		$db = new db();
		$select = $db->query("DELETE FROM resultado WHERE cod_usuario = $id");
		echo $db->resultado();
	}


}