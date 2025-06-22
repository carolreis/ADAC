<?php session_start(); ?>

<!DOCTYPE html>

<html>

	<?php 
	include("head.php");
	include("menu.php");
	require("config/config.php");
	require("classes/DAO/PerguntaDAO.class.php");
	require("classes/DAO/RespostaDAO.class.php");
	require("classes/DAO/ConceitoDAO.class.php");
	?>

<body>

	<script type="text/javascript">

function respostaCorreta(elm){
	var respId = $(elm).attr("id");
	var c = confirm("Deseja marcar como resposta correta?");

	if(c){
		$.post('respostaCorreta.php', {
			id: respId
		}, function(result){});
	}

}
	</script>

<?php $perg = $_GET["perg"]; ?>

<div class="centralizar">

	<h1>Editar Pergunta</h1>
	
	<form name="perguntas" id="perguntas" action="actionEditarPergunta.php" method="post" onsubmit="return verificar();"  enctype="multipart/form-data" autocomplete="off">
		
		<!-- ............... PERGUNTA ............... -->

		<?php
		
		$perguntaDAO = new PerguntaDAO();
		$pergunta = $perguntaDAO->listar($perg);

		$cod = $pergunta[0]["cod_tst"];
		?>

		<!-- Código do Teste -->
		<input type="hidden" name="cod_tst" value="<?= $cod; ?>"/>
		<input type="hidden" name="cod_perg" value="<?= $perg; ?>"/>

		<!-- Tipo de Pergunta -->
		<label for="tipo_perg">Tipo de Pergunta:</label>
		<select name="tipo_perg">
			<option value="1" <?php if($pergunta[0]["tipo_perg"] == 1) echo "selected=selected"; ?> >Primária</option>
			<option value="2" <?php if($pergunta[0]["tipo_perg"] == 2) echo "selected=selected"; ?> >Secundária</option>
		</select>

		<!-- Pergunta -->
		<label for="txt_perg">Pergunta:</label>
		<textarea name="txt_perg" placeholder="Descrição do conteúdo da questão" required="required"><?= $pergunta[0]["txt_perg"]; ?></textarea>
	
		<br/>
		
		<!-- Imagem -->
		<label>Imagem:
		<img 
			src='img/delete3.png' 
			style="vertical-align: middle;" 
			onclick="
				deleteImage(
					'<?= $perg; ?>', 
					'cod_item', 
					'img_perg', 
					'perguntas',
					'<?= $cod; ?>'
				)
			"
		> 
		</label>

		<?php
			if($pergunta[0]["img_perg"] == ""){
				echo "<h4 style='color:#6c9a9a'>Sem imagem cadastrada.</h4>";
			}else{
				$img = md5($pergunta[0]["cod_tst"])."/".$pergunta[0]["img_perg"];
				echo "<img class='currentImage' src='img/".$img."' />"; 
			}
		?>

		<input type="file" id="inputImagem" name="imagem" onchange="readURL(this)" />
		<!-- Largura Imagem -->
    	<label>Largura nova imagem (px):</label>
		
			<!-- 
				!!! ATENÇÃO !!!
				Não mover input/button/img de lugar \/
				A função alterarLargura pega os dados com os elementos nesta posição no DOM
			-->

		<input type="number" class="larguraImagem" min="1" name="widthImagem" id="widthImagem" value='300'/>
		
		<!-- Visualizar Tamanho -->
		<button type="button" class="botaoPreviewImagem" id="btnPreview" onclick="alterarLargura(this)">Visualizar Tamanho</button>
        <img id="preview" src="img/noimage.png" alt="your image" class="previewImage" />
        
        <hr/>
        
		<!-- ............... RESPOSTAS EXISTENTES ............... -->
		<div id="listar_respostas">
		
			<label>Respostas Cadastradas: </label>
			
			<br/>

			<table>
				<tr>
					<th class="id_column">ID:</th>
					<th colspan>Imagem:</th>
					<th colspan>Resposta:</th>
					<th class="action_column">Ações</th>
					<th class="action_column">Resposta Correta</th>
				</tr>

			<?php
			
			$respostaDAO = new RespostaDAO();
			$respostas = $respostaDAO->listar_todas_pergunta($perg);
			$quantRespostas = count($respostas);

			foreach ($respostas as $r) {
				
				if(!empty($r["img_resp"])){
					$img_respostas = md5($cod)."/".$r["img_resp"];
				}else{
					$img_respostas = "noimage.png";
				}
				echo "
					<tr class=listFiles>
						<td rowspan='2' align='center'>".$r['cod_resp']."</td>
						<td class='img_column'><img src='img/".$img_respostas."' /></td>
						<td>".$r['txt_resp']."</td>
						<td rowspan='2' align=center>
							<a href='editarResposta.php?resp=".$r['cod_resp']."'>
								<span class='editar'> <img src='img/edit4.png'/> </span>
							</a>
							<span class='excluir' id='".$r['cod_resp']."'> <img src='img/delete3.png'/></span>
						</td>
						<td rowspan='2'>
				";
				if($r["certa_resp"]){
					echo"<input id='".$r['cod_resp']."' type=radio checked=checked name='rc' onclick='javascript: respostaCorreta(this)' />";
				}else{
					echo"<input id='".$r['cod_resp']."' type=radio name='rc' onclick='javascript: respostaCorreta(this)' />";
				}
				echo "
						</td>
					</tr>
					<tr class=listFiles>
						<td colspan='2'><b>Conceito: </b>".$r['nm_conceito']."</td>
					</tr>
				";
			}

			echo "</table>";

			if($quantRespostas == 0){
				echo "<span class=aviso>Não há respostas cadastradas!</span>";
			}

			?>

		</div>
		<!-- ............... RESPOSTAS ............... -->

		<br/>
		<br/>
		<hr/>

		<!-- Adicionar Nova -->
		<label>
			Inserir Novas Respostas:
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
					<label>* Texto Resposta: </label><textarea name="txt_resp[]"></textarea>
					
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
		    			<input type="number" name="largura_resp[]" class="larguraImagem" min="1" id="widthImagem" value="300" />
	    				<button type="button" class="botaoPreviewImagem" id="btnPreview" onclick="alterarLargura(this)">Visualizar Tamanho</button>

						<!-- Visualizar Imagem -->
			    		<img class="previewImage" src="img/noimage.png" alt="your image" />

				</div>

				<!-- duplica aqui -->
								
			</div>

		</div>

		<!-- RESPOSTA DESCRITIVA -->
		<div id="descritiva">
				
			<input type="text" name="resposta" placeholder="Resposta correta" />
		
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
		<input type="submit" id="cadQuestao" value="Alterar pergunta"/>
		
	</form>

</div>

<?php include("footer.php"); ?>

</body>

<script type="text/javascript">
excluir("excluirResposta.php");

/* VERIFICAR */	
function verificar(){
	
	var tipo_resposta = $("select[name=tipo_resp]").val();
	
	/* Se objetiva */
	if(tipo_resposta == "0001") {

		/* Verifica texto resposta 
		txt_resposta_ok = true;

		$("#objetiva textarea").each(function(){
			if($(this).attr("name") == "txt_resp[]"){
				if($(this).val() == ""){
	    			txt_resposta_ok = false;
	    		}
			}
		})

		img_ok = new Array(true);

		document.querySelectorAll("input[name='img_resp[]").forEach(function(el) {
			console.log(el.files);
			if (el.files.length == 0) {
				img_ok.push(false);
			}
		});
		
		console.log(img_ok);
		console.log(img_ok.filter(function(elm){ return elm; }));

		if(!txt_resposta_ok || img_ok.filter(function(elm){ return elm; }) ){
			alert("Você precisa preencher um TEXTO ou escolher uma IMAGEM para cada pergunta!");
			return false;
		}
		*/

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