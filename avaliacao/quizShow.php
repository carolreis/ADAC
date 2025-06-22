<?php
function quizShow($questao,$respostas)
{
	if($questao){

		$cod_pergunta = $questao["cod_item"];
		$img_perg = $questao["img_perg"];
		$txt_perg = $questao["txt_perg"];
		$tipo_perg = $questao["tipo_perg"];
		
?>
		<!-- CAIXA DA QUESTÃO -->
		<div id=question<?= $_SESSION["nQuestion"]; ?> class='cont'>

			<!-- CONTADOR  -->
			<div id="counter">0</div>

		<!-- MOSTRA PERGUNTA -->
			<h3 id='perguntaShow'><?= $txt_perg; ?></h3>

			<?php if($img_perg): ?>
				<img src="<?php echo '../painel/img/'.md5($_SESSION['codTst']).'/'.$img_perg; ?>"/>
			<?php endif; ?>
			
			<!-- FORMULÁRIO -->
			<form name='perguntas' method='post' action='' autocomplete='off'>
		
				<!-- CAIXA DE ALERTA -->
				<div id='alert'></div>
				
				<!-- RESPOSTAS -->
				<div id="respostas">
					<?php 
					foreach ($respostas as $resp) {
						
						$tipo_resp = $resp["tipo_resp"];
						
						// SE OBJETIVA
						if($tipo_resp == "0001"){ 
					?>
						
						<!--  TEXTO RESPOSTA -->
						<input type="radio" id="respInput" name="respInput" value="<?= $resp["cod_resp"]; ?>" />
						<label for="respInput"><?= $resp["txt_resp"]; ?></label>
						<br/>
						
						<!--  IMAGEM RESPOSTA -->
						<?php if($resp['img_resp']): ?>
							<label for="respInput"><img src="<?php echo '../painel/img/'.md5($_SESSION['codTst']).'/'.$resp['img_resp']; ?>"/></label>
							<br/>
						<?php endif; ?>

					<?php
						// SE DESCRITIVA
						}elseif($tipo_resp == "0010"){
					?>
						<!--  RESPOSTA DESCRITIVA -->
						<input name='respInput' type='number'></input>
					<?php
							}
						}
					?>
						<!-- TIPO DE RESPOSTA -->
						<input type='hidden' name='tipoResp' value="<?= $tipo_resp; ?>"/>
					<br/>
				</div>
				
				<div id="aguarde"><img src="img/loading.gif"></div>
				<button class='next'>Responder</button>

			</form>

		</div>
		<!-- END NA CAIXA DA QUESTÃO -->

		<!-- SCRIPT'S JAVASCRIPT -->
		<script>
		
		var seconds = 0;
		var el = document.querySelector("#counter");
		
		function counter() {	             
			seconds++;
			el.innerText = seconds;
		}   
		var sec = setInterval(counter, 1000);   

		
		/* AÇÃO DO BOTAO */
		$('.next').click(function(event)
		{	
			event.preventDefault();
			clearInterval(sec);
			
			$(this).hide();
			$('#aguarde').css('display','inline-block');
			
			var inputRespostas = document.perguntas.respInput;
			
			/* Se tiver respostas */
			if (inputRespostas) {	

				if (inputRespostas.value == '') {

					/* Se não tiver respondido a resposta */
					document.getElementById('alert').innerHTML = 'Responda a pergunta!';
					$(this).show();
					$('#aguarde').css('display','none');
					return 0;

				} else {

					$.post('action.php', 
		   				{
		   					respFlag: true,
	    					respInput: inputRespostas.value,
	    					tipoResp: document.perguntas.tipoResp.value,
	    					perg_id: <?= $questao['cod_item']; ?>,
	    					timer: seconds
	    				}, 
	    				function(result) {
				       		$('#a').html(result);
	    				}
	    			);
	    		}

			} else {

				/* Se não tiver respostas [pode acontecer caso a primaria nao tenha respostas] */
				$.post('action.php', 
		   			{
		   				respFlag: false
	    			}, 
	    			function(result) {
			       		$('#a').html(result);
	    			}
	    		);
			}
		}
		); 
		
		</script>
<?php
	}

}

?>
