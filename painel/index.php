<!DOCTYPE html>
<html>
<?php include("head.php"); ?><body>

<div class="centralizar">
<div id="login">

	<form name="login" method="post" action="logar.php" autocomplete="off">
		
		<h1>PAINEL ADMINISTRATIVO</h1>
	
		<label for="login">Login:</label>
		<input type="text" name="login" autofocus="autofocus" required="required">
		
		<br/>
		
		<label for="password">Senha:</label>
		<input type="password" name="password" required="required">

		<br/><br/>

		<input type="submit" value="Entrar">
	
		<?php
		
		$err = isset($_GET["err"]) ? $_GET["err"] : false;
		
		if ($err) {
			echo"<h4>Usuário ou senha inválidos</h4>";
		}

		?>

	</form>

</div>
</div>

</body>
</html>