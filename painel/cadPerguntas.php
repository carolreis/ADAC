<?php session_start(); ?>

<!DOCTYPE html>

<html>

	<?php 
	include("head.php");
	include("menu.php");
	require("config/config.php");
	require("classes/DAO/ConceitoDAO.class.php");
	?>

<body>

<?php $cod = $_GET["cod"]; ?>

<div class="centralizar">

	<h1>Inserir Questões </h1>
	
	<form name="perguntas" id="perguntas" action="actionPerguntas.php" method="post" onsubmit="return verificar()" enctype="multipart/form-data" autocomplete="off">
		
		<!-- ............... PERGUNTA ............... -->

		<!-- Código do Teste -->
		<input type="hidden" name="cod_tst" value="<?= $cod; ?>"/>

		<!-- Tipo de Pergunta -->
		<label for="tipo_perg">* Tipo de Pergunta:</label>
		<select name="tipo_perg">
			<option value="1">Primária</option>
			<option value="2">Secundária</option>
		</select>

		<!-- Pergunta -->
		<label for="txt_perg">* Pergunta:</label>
		<textarea name="txt_perg" placeholder="Descrição do conteúdo da questão" required></textarea>
	
		<br/>
		
		<!-- Imagem -->
		<label>Imagem:</label>
		<input type="file" id="inputImagem" name="imagem" onchange="readURL(this)" />

		<!-- Largura Imagem -->
    	<label>Largura imagem (px):</label>
		<input type="text" class="larguraImagem" name="widthImagem" id="widthImagem" value="300" oninput="return positiveNumOnly(event, this)" />

		<!-- Visualizar Tamanho -->
		<button type="button" class="botaoPreviewImagem" id="btnPreview" onclick="alterarLargura(this)">Visualizar Tamanho</button>
        <img id="preview" src="img/noimage.png" alt="your image" class="previewImage" />
        
        <hr/>
        
		<!-- ............... RESPOSTAS ............... -->

		<!-- Adicionar Nova -->
		<label>
			Respostas:
			<img style="display: inline; width: 20px; vertical-align: middle;" src="img/add.png" id="duplicar" />
		</label>

		<!-- Tipo de Resposta -->
		<label for="tipo_resp">Tipo de resposta:</label>
		<select name="tipo_resp">
			<option value="0" selected="selected">Adicionar Posteriormente</option>
			<option value="0001">Objetiva</option>
			<option value="0010">Descritiva</option>
		</select>
	
		<script type="text/javascript">
			$("select[name=tipo_resp]").change(function(){
					
				if($(this).val() == "0001"){
					$("#objetiva").show();
					$("#descritiva").hide();
				}else if($(this).val() == "0010"){
					$("#objetiva").hide();
					$("#descritiva").show();
				}else{
					$("#objetiva").hide();
					$("#descritiva").hide();
				}
			})
		</script>
		
		<!-- RESPOSTAS OBJETIVAS -->
		<div id="objetiva">
		
			<!-- Duplica Respostas em #destino -->
			<div id="destino">

				<div id="origem" class="criar-respostas_1">
					
					<!-- Número da Resposta -->
					<label class="id_resposta">
						Resposta <count class="num">1</count>:
						<span class='delete' id='delete_1' onclick="deletar(this)"><img src='img/delete3.png'/></span>
					</label>
					
					<!-- Resposta Certa -->
					<label>
						Resposta certa:
						<input style="width: auto;" type="radio" class="certa_resp" name="certa_resp[]" value="1" />
					</label>

					<!-- Texto da Resposta -->
					<label>Texto Resposta: </label><textarea name="txt_resp[]"></textarea>
					

					<!-- Conceitos -->
					
					<label for="conceitos"><font color='red'>* Conceito Associado:</font></label>
					<select name="conceito[]">
						<option value="0">Selecione o Conceito</option>
						<?php 
							$conceitosObj = new ConceitoDAO();
							$conceitos = $conceitosObj->listar_todos();
							$quant_conceitos = $conceitosObj->linha();
							for( $i=0; $i < $quant_conceitos; $i++ ){
								echo "<option value='".$conceitos[$i]["cod_conceito"]."'>".$conceitos[$i]["nm_conceito"]."</option>";	
							}

						?>
					</select>
					<br/>

					<!-- Imagem da Resposta -->
						
						<label>Imagem Resposta:</label><input type="file" id="imagem_resp" onchange="readURL(this)" name="img_resp[]"/>

						<!-- Largura da Imagem -->
			    		<label>Largura imagem (px):</label>
		    			<input type="text" class="larguraImagem" name="largura_resp[]" id="widthImagem" value="300" />
	    				<button type="button" class="botaoPreviewImagem" id="btnPreview" onclick="alterarLargura(this)">Visualizar Tamanho</button>

						<!-- Visualizar Imagem -->
			    		<img id="preview" src="img/noimage.png" class="previewImage" />


				</div>

				<!-- duplica aqui -->
								
			</div>

		</div>

		<!-- RESPOSTA DESCRITIVA -->
		<div id="descritiva">
			<input type="text" name="resposta" placeholder="Resposta correta"/>

			<!-- Conceitos -->
					
			<label for="conceitos"><font color='red'>* Conceito Associado:</font></label>
			<select name="conceito[]">
				<option value="0">Selecione o Conceito</option>
				<?php 
					$conceitosObj = new ConceitoDAO();
					$conceitos = $conceitosObj->listar_todos();
					$quant_conceitos = $conceitosObj->linha();
					for( $i=0; $i < $quant_conceitos; $i++ ){
						echo "<option value='".$conceitos[$i]["cod_conceito"]."'>".$conceitos[$i]["nm_conceito"]."</option>";	
					}

				?>
			</select>
			<br/>
		
		</div>

		<input type="submit" id="cadQuestao" value="Criar pergunta"/>
		
	</form>

</div>

<?php include("footer.php"); ?>

</body>

<script type="text/javascript">

/* VERIFICAR */	
function verificar(){
	
	var tipo_resposta = $("select[name=tipo_resp]").val();
	
	/* Se objetiva */
	if(tipo_resposta == "0001") {

		certa_resp_ok = false;
		/* Verifica resposta certa */
		$("#objetiva input[type='radio'] ").each(function(){
			if($(this).attr("name") == "certa_resp[]"){
				if($(this).prop("checked")){
	    			certa_resp_ok = true;
	    		}
			}
		})

		if(!certa_resp_ok){
			alert("ATENÇÃO! Você não escolheu uma resposta correta. Pode adicioná-la posteriormente através do 'Editar'. ");
		}

		/*txt_resposta_ok = true;

		/* Verifica texto resposta
		$("#objetiva textarea").each(function(){
			if($(this).attr("name") == "txt_resp[]"){
				if($(this).val() == ""){
	    			txt_resposta_ok = false;
	    		}
			}
		})

		/*if(!txt_resposta_ok){
			alert("Preencha o texto de todas respostas!");
			return false;
		}*/

		conceito_ok = true;
		/* Verifica conceitos resposta */
		$("#objetiva select").each(function(){
			if($(this).attr("name") == "conceito[]"){
				if($(this).val() == "0"){
		    		conceito_ok = false;
	    		}
	    	}
		})

		if(!conceito_ok){
			alert("Adicione um conceito para todas as respostas!");
			return false;
		}

		
	} else if (tipo_resposta == "0010"){

	    txt_resposta_ok = true;
		/* Verifica texto resposta */
		$("#descritiva input").each(function(){
			if($(this).attr("name") == "resposta"){
				if($(this).val() == ""){
	    			txt_resposta_ok = false;
	    		}
			}
		})

		if(!txt_resposta_ok){
			alert("Preencha o texto da resposta!");
			return false;
		}


		conceito_ok = true;
		/* Verifica conceitos resposta */
		$("#descritiva select").each(function(){
			if($(this).attr("name") == "conceito[]"){
				if($(this).val() == "0"){
		    		conceito_ok = false;
	    		}
	    	}
		})

		if(!conceito_ok){
			alert("Adicione um conceito para todas as respostas!");
			return false;
		}

	}

	return true;
}

</script>

<script type="text/javascript" src="js/clonarPerguntas.js"></script>

</html>