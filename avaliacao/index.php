<?php
/* VERIFICA VERSÃO DO PHP */

if (version_compare(PHP_VERSION, "5.4.4") < 0)
{
    echo 'Requer pelo menos o PHP 5.6. <br>' . PHP_EOL;
    echo "Versão atual: ".PHP_VERSION;
    exit(1);
}
    session_start();
    if (isset($_SESSION["cod_usuario"]) && isset($_SESSION["codTst"])) {
		header("Location: start.php");
		exit();
	}
?>

<!DOCTYPE html>

<html>

<head>
	<title>ADAC</title>
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, user-scalable=no" initial-scale=1/>
	<meta charset="UTF-8"/>
	<link rel="shortcut icon" type="image/png" href="img/icon.png"/>
</head>

<body id='bodyComecar'>


		<div class="caixa-tabela">

			<div class="caixa-tabela-center">
			
				<div id="comecar">

				<form method="post" name="login">

					<div class="t">Avaliação Diagnóstica Auxiliada por Computador</div>
					
					<div class="f">

						<label for="nome">Nome:</label> <input type="text" name="nome" autofocus />
						<br/>
						<label for="email">E-mail:</label> <input type="email" name="email"/>
						<br/>
						<br/>
						<label for="teste">Escolha o teste:</label> 
						<select name="teste">

							<?php
							include ("config/config.php"); 
							include ("classes/DAO/TesteDAO.class.php"); 

							$testeDAO = new TesteDAO();
							$resultado = $testeDAO->listar_ativos();
							if (empty($resultado)) {
								echo "<option value='0'>";
								echo "Não há testes ativos!";
								echo "</option>";
							} else {
								foreach ($resultado as $value) {
									echo "<option value='".$value["cod_tst"]."'>";
									echo $value["nm_tst"];
								}
							}
							?>
						</select>

						<div id="aviso">
							<p>Lembre-se que isso é uma auto-avaliação e o resultado final depende diretamente das suas respostas. 
							<br/>LEMBRE-SE de não "chutar" uma resposta. 
							<br/>Responda usando o seu conhecimento, e se não souber como ou o que fazer, selecione as opções adequadas.</p>
						</div>

						<input type="button" value="Começar" onclick="salvarUsuario(event)">

					</form>

					</div>

				</div>

			</div>

		</div>


<script type="text/javascript">

	function salvarUsuario(event) {
		event.preventDefault();
		
		var nome = document.login.nome;
		var email = document.login.email;
		var teste = document.login.teste;
		
		var regExpEmail = /^[\w+.]+@\w+\.\w{2,}(?:\.\w{2})?$/;
    
		if (nome.value == "") {
			alert("Preencha o campo nome!");
			nome.focus();
			return false;
		}

		if (email.value == "" || !regExpEmail.test(email.value)	) {
			alert("Preencha o campo e-mail corretamente!");
			email.focus();
			return false;
		}

		if (teste.value == 0) {
			alert("Não há testes ativos!");
			return false;
		}

		$.ajax({
			url: 'salvarUsuario.php',
			type: 'POST',
			data: {
				'nome':document.login.nome.value,
				'email':document.login.email.value,
				'teste':document.login.teste.value
			},
			async: false,
			success: function(response) {
				window.location.href = 'start.php'
			}
		});

	}
	
</script>

</body>
</html>