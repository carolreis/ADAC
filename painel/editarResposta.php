<?php session_start(); ?>

<!DOCTYPE html>

<html>

	<?php 
	include("head.php");
	include("menu.php");
	require("config/config.php");
	require("classes/DAO/RespostaDAO.class.php");
	require("classes/DAO/ConceitoDAO.class.php");
	?>

<body>

<?php $resp = $_GET["resp"]; ?>

<div class="centralizar">

	<h1>Editar Resposta</h1>
	
	<form name="respostas" id="respostas" action="actionEditarResposta.php" method="post"  enctype="multipart/form-data" autocomplete="off">
	
		<?php
			$respostaObj = new RespostaDAO();
			$resposta = $respostaObj->listar($resp)[0];
		?>

		<input type="hidden" name="cod_tst" value="<?= $resposta['cod_tst']; ?>">
		<input type="hidden" name="cod_resp" value="<?= $resposta['cod_resp']; ?>">
	
		<!-- ............... RESPOSTA ............... -->

		<!-- Tipo de Resposta -->
		<label for="tipo_resp">Tipo de resposta:</label>
		<select name="tipo_resp">
			<?php if($resposta["tipo_resp"] == "0001"): ?>
				<option value="0001" selected="selected">Objetiva</option>
				<option value="0010">Descritiva</option>
			<?php else: ?>
				<option value="0001">Objetiva</option>
				<option value="0010" selected="selected">Descritiva</option>
			<?php endif; ?>
		</select>
	
		<script type="text/javascript">
			$("select[name=tipo_resp]").change(function(){
				if($(this).val() == "0001"){
					$("#objetiva").show();
					$("#descritiva").hide();
				}else{
					$("#objetiva").hide();
					$("#descritiva").show();
				}
			})
			
		</script>
		
		<!-- RESPOSTAS OBJETIVAS -->
		<div id="objetiva" 
		<?php 
			if($resposta["tipo_resp"] == "0001") echo "style='display: block'"; 
			else echo "style='display: none'"; 
		?> 
		>
		<?php if($resposta["tipo_resp"] == "0001"): ?>
			<!-- Duplica Respostas em #destino -->
			<div id="destino">

				<div id="origem" class="criar-respostas">
					
					<!-- Número da Resposta -->
					<label class="id_resposta">Resposta <count class="num"><?= $resposta["cod_resp"]; ?></count>:</label>
										
					<!-- Texto da Resposta -->
					<label>Texto Resposta: </label><textarea name="txt_resp"><?= $resposta["txt_resp"]; ?></textarea>
					<input type="text" name="cod_perg" value="<?= $resposta['cod_perg']; ?>" hidden>

					<!-- Conceitos -->
					
					<label for="conceitos"><font color='red'>* Conceito Associado:</font></label>
					<select name="conceito">
						<option value="<?= $resposta['cod_conceito']?>"><?= $resposta['nm_conceito']?></option>
						<?php 
							$conceitosObj = new ConceitoDAO();
							$conceitos = $conceitosObj->listar_todos();
							$quant_conceitos = $conceitosObj->linha();
							for( $i=0; $i < $quant_conceitos; $i++ ){
								if($conceitos[$i]["cod_conceito"] != $resposta['cod_conceito']) {
									echo "<option value='".$conceitos[$i]["cod_conceito"]."'>".$conceitos[$i]["nm_conceito"]."</option>";	
								}
							}

						?>
					</select>
					<br/>

					<!-- Imagem da Resposta -->
	
					<label>Imagem Resposta:
					<img 
						src='img/delete3.png' 
						style="vertical-align: middle;" 
						onclick="
							deleteImage(
								'<?= $resposta['cod_resp']; ?>', 
								'cod_resp', 
								'img_resp', 
								'item',
								<?= $resposta['cod_tst']; ?>
							)
						"
					> 
					</label>
								
					<?php
					if($resposta["img_resp"] == ""){
						echo "<h4 style='color:#6c9a9a'>Sem imagem cadastrada.</h4>";
					}else{
						$img = md5($resposta["cod_tst"])."/".$resposta["img_resp"];
						echo "<img class='currentImage' src='img/".$img."' />"; 
					}

					?>

					<input type="file" id="imagem_resp" onchange="readURL(this)" name="img_resp"/>

					<!-- Largura da Imagem -->
		    		<label>Largura imagem (px):</label>
	    			<input class="larguraImagem" type="text" name="largura_resp" id="widthImagem" value="300" />
    				<button class="botaoPreviewImagem" type="button" id="btnPreview" onclick="alterarLargura(this)">Visualizar Tamanho</button>

					<!-- Visualizar Imagem -->
		    		<img id="preview" src="img/noimage.png" alt="your image" style="width: 300px" />


				</div>

				<!-- duplica aqui -->
								
			</div>
			<?php endif; ?>
		</div>

		<!-- RESPOSTA DESCRITIVA -->
		<div id="descritiva" 
		<?php 
			if($resposta["tipo_resp"] == "0010") echo "style='display: block'"; 
			else echo "style='display: none'"; 
		?> 
		>
		<?php if($resposta["tipo_resp"] == "0010"): ?>
				
			<input type="text" name="txt_resp" placeholder="Resposta correta" value="<?= $resposta['txt_resp']; ?>" />

			<!-- Conceitos -->
			
			<label for="conceitos"><font color='red'>* Conceito Associado:</font></label>
			<select name="conceito">
				<option value="<?= $resposta['cod_conceito']?>"><?= $resposta['nm_conceito']?></option>
				<?php 
					$conceitosObj = new ConceitoDAO();
					$conceitos = $conceitosObj->listar_todos();
					$quant_conceitos = $conceitosObj->linha();
					for( $i=0; $i < $quant_conceitos; $i++ ){
						if($conceitos[$i]["cod_conceito"] != $resposta['cod_conceito']) {
							echo "<option value='".$conceitos[$i]["cod_conceito"]."'>".$conceitos[$i]["nm_conceito"]."</option>";	
						}
					}

				?>
			</select>
			<br/>

		<?php endif; ?>

		</div>
		<input type="submit" id="cadQuestao" value="Alterar pergunta"/>
		
	</form>

</div>

<?php include("footer.php"); ?>

</body>

<script type="text/javascript">
excluir("excluirResposta.php");

/* ALTERA LARGURA DA IMAGEM PARA VISUALIZAÇÃO */
	function alterarLargura(input){
		newWidth = $(input).prev("input#widthImagem").val();
		preview = $(input).next("img");
		$(preview).width(newWidth);
	}
		
/* MOSTRA IMAGEM CARREGADA */
	function readURL(input) {
		preview = $(input).nextAll().next("img");
		
		if (input.files && input.files[0]) {
    		var reader = new FileReader();

	    	reader.onload = function(e) {
	    		$(preview).attr('src', e.target.result);
	    	}

    		reader.readAsDataURL(input.files[0]);
  		}
	}

</script>
</html>