<?php

include("functions/phpmailer/class.phpmailer.php");
		
class ResultadoDAO extends db{

	function __construct(){
		parent::__construct();
	}

	function inserir($resultado){
		
		$sql = "
		INSERT INTO resultado 
		(cod_usuario, cod_tst, cod_conceito, score, motivo, cod_perg, cod_item, tempo) 
		VALUES (?,?,?,?,?,?,?,?)
		";
		
		$stmt = parent::prepare($sql);

		//temporary
		//por causa do usuario
		$query = parent::query("SET FOREIGN_KEY_CHECKS=0");

		$cod_usuario = $resultado->getCodUsuario();
		$cod_tst = $resultado->getCodTeste();
		$cod_conceito = $resultado->getCodConceito();
		$score = $resultado->getScore();
		$motivo = $resultado->getMotivo();
		$perg_id = $resultado->getPergId();
		$item_id = $resultado->getItemId();
		$timer = $resultado->getTimer();

		$stmt->bind_param("iiidiiii", $cod_usuario, $cod_tst, $cod_conceito, $score, $motivo, $perg_id, $item_id, $timer);
		
		if ($stmt->execute()) {
			$stmt->close();
			return true;
		} else {
			echo $stmt->error;
			$stmt->close();
			return false;
		}

	}

	function listar($cod_usuario) {
	
		$db = new db();
		$select = $db->query("SELECT
			nm_usuario,
				c.nm_conceito as conceito_certa,
        		cm.nm_conceito as motivo_desc,
        		resultado.motivo,
        		resultado.cod_conceito,
				(SELECT SUM(score) FROM resultado WHERE cod_usuario = $cod_usuario) as score_total,
				score,
				resultado.cod_tst,
				resultado.cod_usuario,
				resultado.cod_perg as cod_pergunta,
				resultado.cod_item as cod_resposta,
      			perguntas.txt_perg as pergunta,
  				item.txt_resp as resposta,
  				item.certa_resp as correta
			FROM resultado
			INNER JOIN conceito c ON resultado.cod_conceito = c.cod_conceito
      		LEFT JOIN conceito cm ON resultado.motivo = cm.cod_conceito
			INNER JOIN teste ON resultado.cod_tst = teste.cod_tst
			INNER JOIN usuario ON resultado.cod_usuario = usuario.cod_usuario
        	INNER JOIN perguntas ON resultado.cod_perg = perguntas.cod_item
			INNER JOIN item ON resultado.cod_item = item.cod_resp
			WHERE resultado.cod_usuario = $cod_usuario
		");
		return $db->resultado();
	}

	function consolidado($cod_teste = null, $cod_usuario = null) {

		if(!isset($cod_teste)) $cod_teste = $this->id_teste;
		if(!isset($cod_usuario)) $cod_usuario = $this->id_usuario;
		
		$db = new db();
		$select = $db->query("
			SELECT
				c.nm_conceito AS conceito,
				nm_usuario,
				SUM(CASE item.certa_resp
					WHEN 1 THEN 0
					ELSE - 1
				END) AS score
			FROM
				adac.resultado
					INNER JOIN
				usuario ON usuario.cod_usuario = $cod_usuario
					INNER JOIN
				item ON resultado.cod_item = item.cod_resp
					INNER JOIN
				conceito c ON item.cod_conceito = c.cod_conceito
			WHERE
				resultado.cod_usuario = $cod_usuario
			GROUP BY c.cod_conceito
			ORDER BY c.nm_conceito
		");

		return $db->resultado();
	}	

	function listar_sequencia($codTeste = null, $usuario = null) {
		
		$db = new db();

		$select = $db->query("
		SELECT 
			resultado.cod_resultado,
			resultado.cod_perg,
			perguntas.txt_perg as pergunta,
			item.txt_resp as resposta,
			item.img_resp,
			perguntas.img_perg,
			resultado.tempo,
			resultado.score
		FROM
			resultado
		LEFT JOIN perguntas ON resultado.cod_perg = perguntas.cod_item
		LEFT JOIN item ON resultado.cod_item = item.cod_resp
		INNER JOIN usuario ON resultado.cod_usuario = usuario.cod_usuario
		WHERE resultado.cod_usuario = $usuario AND resultado.cod_tst = $codTeste
		ORDER BY resultado.cod_resultado ASC
		");

		return $db->resultado();

	}
	function getEmailData($cod_teste, $cod_usuario) {
		$db = new db();
		$select = $db->query("
			SELECT
				usuarioAluno.email_usuario AS email_aluno,
			 	usuarioProfessor.email_usuario AS email_professor
			FROM resultado
			INNER JOIN teste ON resultado.cod_tst = teste.cod_tst
			LEFT JOIN usuario AS usuarioProfessor ON usuarioProfessor.cod_usuario = teste.professor
			INNER JOIN usuario AS usuarioAluno ON resultado.cod_usuario = usuarioAluno.cod_usuario
			WHERE resultado.cod_usuario = $cod_usuario AND resultado.cod_tst = $cod_teste
			");
		return $db->resultado();
	}

	function enviarEmail($resultado, $cod_teste, $cod_usuario) {

		if($resultado[0]) {

			/***** DADOS PARA ENVIO DE EMAIL */
			$getEmailData = $this->getEmailData($cod_teste, $cod_usuario);
			
			if($getEmailData) {
				// $emailProfessor = $getEmailData[0]["email_professor"];
				$emailProfessor = $getEmailData[0]["email_professor"];
				$emailAluno = $getEmailData[0]["email_aluno"];
			}
			
			/*** Enviar e-mail para ALUNO */

			/* Montar mensagem */
			$dados = "
			<p>Nome aluno: ".$resultado[0]["nm_usuario"]."</p>
			<p>E-mail aluno: ".$emailAluno."</p>

			<table>
			<tr>
				<th style='text-align: left'>Conceito:</th>
				<th style='text-align: left'>Score:</th>
			</tr>
			";
			
			$linhas = "";

			for($i = 0; $i < count($resultado); $i++) {
				$linhas .= 
				"<tr>
					<td> ".$resultado[$i]["conceito"]." </td>
					<td> ".$resultado[$i]["score"]." </td>
				</tr>";
			}
			
			$dados .= $linhas;
			$dados .= "</table>";

			$mensagem = wordwrap($dados."", 90, "<br>", 1);
			
			/* Enviar */
			$host = 'ssl://smtp.gmail.com';
			$username = 'username@email.com';
			$password = 'password';

			try {
				$mail = new PHPMailer(true);
				$mail->Host = $host;
				// $mail->Port = '587';
				$mail->Port = 465;
				$mail->Username = $username;
				$mail->Password = $password;
				$mail->SMTPKeepAlive = true;
				$mail->Mailer = "smtp";
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->AuthType = "PLAIN";
				$mail->CharSet = 'utf-8';
				$mail->SMTPDebug = 0;
				$mail->From = $username;
				$mail->Sender = $username;
				$mail->FromName = "ADAC";
				$mail->AddAddress($emailAluno);
				$mail->IsHTML(true);
				$mail->Subject  = "ADAC - Resultado";
				$mail->Body = $mensagem;
				$mail->AltBody = "Resultado ADAC";
				$mail->Send();
				$mail->ClearAllRecipients();
				$mail->ClearAttachments();
			} catch (phpmailerException $e) {
			 	echo $e->errorMessage();
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			/* Montar Mensagem */
			/* Enviar */
			try {
				$mail = new PHPMailer(true);
				$mail->Host = $host;
				// $mail->Port = '587';
				$mail->Port = 465;
				$mail->Username = $username;
				$mail->Password = $password;
				$mail->SMTPKeepAlive = true;
				$mail->Mailer = "smtp";
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->AuthType = "PLAIN";
				$mail->CharSet = 'utf-8';
				$mail->SMTPDebug = 0;
				$mail->From = $username;
				$mail->Sender = $username;
				$mail->FromName = "ADAC";
				$mail->AddAddress($emailProfessor);
				$mail->IsHTML(true);
				$mail->Subject  = "ADAC - Resultado";
				$mail->Body = $mensagem;
				$mail->AltBody = "Resultado ADAC";
				$mail->Send();
				$mail->ClearAllRecipients();
				$mail->ClearAttachments();
			} catch (phpmailerException $e) {
			 	echo $e->errorMessage();
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

	function emProgresso($user, $test) {

		$db = new db();
		$db->query("SELECT count(cod_resultado) FROM resultado WHERE cod_usuario = $user AND cod_tst = $test");
		$count = $db->resultado();
		
		if ($count[0][0] == 0) {
			return false;
		} else {
			return true;
		}

	}
	function getUltimoResultado($user, $test) {
		$db = new db();
		$db->query("SELECT * FROM resultado WHERE cod_usuario = $user AND cod_tst = $test ORDER BY cod_resultado DESC LIMIT 1");
		return $db->resultado();
	}
}