	<?php
session_start();

require("config/config.php");
require("classes/DAO/TesteDAO.class.php");
require("classes/DAO/PerguntaDAO.class.php");
require("classes/DAO/RespostaDAO.class.php");

if (!isset($_SESSION["usuario"]) || !isset($_GET["teste"])) {
	
	echo "
	<script>
		alert('Acesso não autorizado!');
		window.location.href = 'index.php';
	</script>
	";

	exit();

}

$codTeste = $_GET["teste"];
$testeDAO = new TesteDAO();
$nomeTeste = $testeDAO->getNome($codTeste);
?>

<!DOCTYPE html>

<html>

<?php include("head.php"); ?>

<body>

<?php include("menu.php"); ?>

<div class="centralizar" id="encadearPerguntasTeste">
	
	<h1 class="titulo">Encadear Perguntas:</h1>

	<div style="background: #F5F5F5; color: #333; padding: 10px; border-bottom: #333 solid 2px; border-top: #333 solid 2px;">
		<h3 style="margin: 0; padding: 0">Nome do teste: <?php echo $nomeTeste[0][0]; ?> </h3>
	</div>
	
	<?php

	$perguntaDAO = new PerguntaDAO();
	$perguntas = $perguntaDAO->listar_where_orderby("cod_item >= 1 and cod_tst = '$codTeste' ","tipo_perg");

	$perguntasSecDAO = new PerguntaDAO();
	$perguntas_secundarias = $perguntasSecDAO->listar_where_orderby("tipo_perg = 2 and cod_tst = '$codTeste'","cod_item");
	
	$respostaDAO = new respostaDAO();
	$respostas = $respostaDAO->listar_todas_teste($codTeste);
	?>
	
	<ul style="padding: 0; margin: 0;">
		<?php
		// PERGUNTAS
		for($i=0; $i < count($perguntas); $i++):
		?>
			
			<li style='margin-top: 20px;'>
			
				<!-- ID PERGUNTA -->
				<div style="background: #0A5555; color: #FFF; padding: 1% 0.5%">
					<b>ID pergunta:</b>
					<?= $perguntas[$i]["cod_item"]; ?>
				</div>

				<div style="background: #F5F5F5; display: block; width: 96%; padding: 0.1% 2%">

					<!-- TIPO PERGUNTA -->
					<p>
					<b>Tipo de pergunta: </b>
					<?php
						if($perguntas[$i]["tipo_perg"] == 1) echo "Primária";
						if($perguntas[$i]["tipo_perg"] == 2) echo "Secundária";
						?>
					</p>

					<!-- TEXTO PERGUNTA -->
					<p>
					<b>Texto pergunta:</b>
					<?= $perguntas[$i]["txt_perg"]; ?>
					</p>
					
					<!-- IMAGEM PERGUNTA -->
					<p>
					<b>Imagem pergunta:</b>
					<br/>
					<?php if($perguntas[$i]["img_perg"]): ?>
					<img src="<?= 'img/'.md5($codTeste).'/'.$perguntas[$i]["img_perg"]; ?>">
					<?php else: ?>
					<img style='width: 100px' src="<?= 'img/noimage.png' ?>">
					<?php endif; ?>
					</p>

					<!-- RESPOSTAS -->
					<p style="background: #5DB1B1; color: #FFF; padding: 5px">
						<b>RESPOSTAS:</b> <!--  27AFAF -->
					</p>

					<?php
					for($j=0; $j < count($respostas); $j++):
						// Se a resposta pertencer a pergunta
						if($respostas[$j]["cod_item"] == $perguntas[$i]["cod_item"]):
					?>
					
						<form name="encadear" id="encadear_<?= $j; ?>" method="post">
			
							<input type="hidden" name="cod_tst" value="<?= $codTeste; ?>">
							<input type=hidden name=cod_item value="<?= $respostas[$j]["cod_item"]; ?>"/>
							<input type=hidden name=cod_resp value="<?= $respostas[$j]["cod_resp"]; ?>"/>

							<ul style="list-style: none; padding: 0; margin: 0;">
								<li>
									<p style="background: #DDD; padding: 5px;">
										<b>ID resposta: </b>
										<?= $respostas[$j]["cod_resp"]; ?>
									</p>
									
									<p>
										<b>Texto resposta: </b>
										<?= $respostas[$j]["txt_resp"]; ?>
									</p>
										
									<p>
										<b>Imagem resposta: </b>
										<br/>
										<?php 
										if($respostas[$j]["img_resp"] != "" && $respostas[$j]["img_resp"] != NULL){
											$img = "img/".md5($codTeste)."/".$respostas[$j]["img_resp"];
										} else {
											$img = "img/noimage.png";
										}
										?>
										<img style="width: 100px" src="<?= $img; ?>">
									</p>
									
									<p>
									<b>Encadear pergunta: </b>
									<select name='prox' style='width: auto'>

										<option value=''>Selecione a pergunta</option>

										<?php
										
										/* Encadeia uma pergunta na resposta */
										for($k=0; $k < count($perguntas_secundarias); $k++):

										/* Lista todas as perguntas secundárias diferente da pergunta atual */
											if($perguntas_secundarias[$k]["cod_item"] != $perguntas[$i]["cod_item"]):
												
												/* Verifica se a pergunta secundária já está encadeada àquela reposta - e marca selecionado caso esteja */	
												if($perguntas_secundarias[$k]["cod_item"] == $respostas[$j]["prox_perg"]):
										?>
												<option selected="selected" value="<?= $perguntas_secundarias[$k]["cod_item"]; ?>">
													<?= $perguntas_secundarias[$k]["cod_item"]." - ".$perguntas_secundarias[$k]["txt_perg"]; ?>
												</option>
										<?php
												else: 
										?>
												<option value="<?= $perguntas_secundarias[$k]["cod_item"]; ?>">
													<?= $perguntas_secundarias[$k]["cod_item"]." - ".$perguntas_secundarias[$k]["txt_perg"]; ?>
												</option>
										<?php
												endif;
											endif;

										endfor;

										/* Verifica se a resposta está marcada como fim de encadeamento */
										if ($respostas[$j]["prox_perg"] === "0") {
											echo "<option selected='selected' value='0'>Fim encadeamento</option>";
										}  else {
											echo "<option value='0'>Fim encadeamento</option>";
										}
										?>										

									</select>
									<button style="width: auto" onclick="salvarEncadeamento('encadear_<?= $j; ?>')">Salvar</button>
									</p>
								</li>
							</ul>
						</form>
						
					<?php
						endif;
					endfor;
					?>
				</div>

			</li>
			

		<?php
		endfor;
		?>
	</ul>

</div>

<?php include("footer.php"); ?>

<script type="text/javascript">

	function salvarEncadeamento(form) {
		
		event.stopPropagation();
		event.preventDefault();

		var f = document.getElementById(form);	
		var cod_tst = f.elements.namedItem("cod_tst");

		
		if(cod_tst.value != "") {
	
			var cod_item = f.elements.namedItem("cod_item");
			var cod_resp = f.elements.namedItem("cod_resp");
			var prox = f.elements.namedItem("prox");
			
			if(prox.value != "") {

				var form_data = new FormData();
	    
				form_data.append('cod_tst',cod_tst.value);
		    	form_data.append('cod_item',cod_item.value);
		    	form_data.append("cod_resp",cod_resp.value);
		    	form_data.append("prox",prox.value);

		    	$.ajax({
					url: "salvarEncadeamento.php",
					type: 'POST',
					data: form_data,
					cache: false,
					contentType: false,
					processData: false,
					success: function(response) {
						alert("Salvo!");
						//window.location.href = '';
					}
		    	});

		    }

	  	}

	}

</script>

</body>

</html>