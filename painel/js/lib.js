function close(eClick, elm) {

	$(eClick).click(function() {

		$(elm).fadeOut();

	});

}

function open(eClick,elm) {

	$(eClick).click(function() {

		$(elm).fadeIn();

	});

}

function deleteImage(cod, cod_field, field, table, teste) {
	// código | campo de onde vem o codigo | campo da imagem | tabela

	var c = confirm("Deseja excluir a imagem?");
	
	if (c) {
	
		$.ajax({
			url: 'functions/deleteImage.php',
			type: 'POST',
			data: {
				'cod': cod,
				'cod_field': cod_field,
				'field': field,
				'table': table,
				'teste': teste
			},	
			async: false,
			success: function(response) {
				
				response = JSON.parse(response);
				if(response.error){
					
				}else{
					var imagem = document.querySelector(".currentImage");
					var elmh4 = document.createElement("h4");
					elmh4.setAttribute("style","color:#6c9a9a");
					var msg = document.createTextNode("Sem imagem cadastrada");
					elmh4.appendChild(msg);
					imagem.replaceWith(elmh4);					
				}
			}
		});
		
	}
}

function duplicarCampos() {
	
  	var clone = $('#origem').clone(true).appendTo('#destino');


	//var clone = document.getElementById("origem").cloneNode(true);
	
	var num = document.querySelectorAll("#origem .num");
	var numLength = num.length;
	var num = num[numLength-1].innerText;
	//var novoNum = clone.getElementsByTagName("count");
	var novoNum = $(clone).find("count");
	novoNum[0].innerText = parseInt(num) + 1;
	

	//var camposClonados = clone.getElementsByTagName("input");
	var camposClonados = $(clone).find("input");
	
	//var destino = document.getElementById("destino");
	//destino.appendChild(clone);
	
	for(i=0; i<camposClonados.length; i++) {
		camposClonados[i].value = '';
	}

	/*
	<div id="origem">
				Número de matrícula: <input type="text" name="matricula[]">
				Nome: <input type="text" name="nome[]">
				<span onclick='duplicarCampos()'> + </span>
			</div>

			<div id="destino"></div>

		*/
}

function validaTeste(){

	var n = document.criarTeste.nome;

	var ok;

	$.ajax({
		url: 'functions/existsTeste.php',
		type: 'POST',
		data: {'nome':n.value},
		async: false,
		success: function(response) {
			ok = response;
		}
	});
	
	if(ok){
		alert("Já existe teste com este nome! ");
		n.focus();
		return false;
	}

}

function checkUser(e,input){
	 
	var ok;

	$.ajax({
		url: 'functions/checkUser.php',
		type: 'POST',
		data: {'login':input.value},
		async: false,
		success: function(response) {
			ok = response;
		}
	});

	if(ok){
		alert("Já existe usuário com este nome! ");
		input.focus();
		return false;
	}

}

function excluir($arqAction) {

	$(".excluir").click(function() {

		var r = confirm("Deseja excluir?");

		if(r) {
			var dado = $(this).attr("id");

			$.post($arqAction, {varDado: dado}, function(result){
				alert('Excluído com sucesso!');window.location.href = '';
			});
		}

	});

}

function previewImage(imageSource, imagePreviewDest, widthImagem){

	var imgSrc = document.querySelector(imageSource);

	if (imgSrc.type == "file"){

		var reader = new FileReader();

		reader.onload = function(event) {

			var img = new Image();	

			img.onload = function() {

				var newWidth = document.querySelector(widthImagem).value;

				if(typeof newWidth === "undefined"){
					var newWidth = 800;
				}else if(newWidth > 800) {
					newWidth = 800;
				}

	    		var newHeight = (newWidth * this.naturalHeight) / this.naturalWidth;

				var canvas = document.querySelector(imagePreviewDest);
				var ctx = canvas.getContext("2d");

				canvas.width = newWidth;
				canvas.height = newHeight;

				ctx.drawImage(img,0,0,newWidth,newHeight);

			}

			img.src = event.target.result;
		
		}

		reader.readAsDataURL(imgSrc.files[0]);  

	}

}

function typeQuestion(elm) {

	var elmId = $(elm).attr("id");
	var v = $(elm).val();

	if(v == "1") //objective
	{
		$(".respObjective#"+elmId).show();
		$(".respValue#"+elmId).hide();
	}
	else if(v == "2") //value
	{
		$(".respValue#"+elmId).show();
		$(".respObjective#"+elmId).hide();
	}

}

function salvarQuestoes(urlAction, formName,event) {
	
	event.preventDefault();
	event.stopPropagation();
	
	/* VALORES */
	var f = document.getElementById(formName);

	var cod_tst = f.elements.namedItem("cod_tst");

	if(cod_tst.value != ""){
	
		var txt_perg =   f.elements.namedItem("txt_perg");
		//var widthImagem =   f.elements.namedItem("widthImagem");
		var certa_resp = f.elements.namedItem("certa_resp");
		/* RESTRIÇÕES */
		if (txt_perg.value == "") { alert("Escreva a pergunta!"); txt_perg.focus(); return false; }
		
		/* FORM */
		var form_data = new FormData();
    
		var img = $('#inputImagem')[0].files[0];

		form_data.append('cod_tst',cod_tst.value);
	    form_data.append('txt_perg',txt_perg.value);
	    form_data.append("img_perg",img);
	    form_data.append("certa_resp",certa_resp);
	    //form_data.append('widthImagem',widthImagem.value);

	    $.ajax({
			url: urlAction,
			type: 'POST',
			data: form_data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				console.log(response)
				//alert("Cadastrado com sucesso!");
				//window.location.href = '';
			}
	    });
	  }

}	    

function numbersOnly(elm) {

	$(elm).keydown(function(e) {

		if (e.which === 190 || e.which === 109 || e.which === 188 || e.which === 110 || e.which === 189) {
			return false; 
		}

	});

}

function positiveNumOnly(e, elm) {

	if ( 
		(elm.value == "" || (elm.selectionEnd == 1 || elm.selectionEnd == 0) ) 
		&& 
		(e.which == 48 || e.which == 96) 
	){
		return false;
	}

	if ( (e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105) || e.which == 8 || e.which == 46 ) {
		return true; 
	} else {
		return false;
	}

}

function confirmClose() {

	window.addEventListener("beforeunload", function (e) {
		(e || window.event).returnValue = null;
  		return null;
	});

}

function finalizarCad(xmlNome) {

	$.post(
		"verificaFinalizar.php", 
		{arq: xmlNome}, 
		function(result) {

			if (result == "true") {
				window.location.href = 'finalizar.php';
			} else {
				var c = confirm("É necessário cadastrar pelo menos 5 questões de cada nível!  Deseja cadastrar posteriormente? "+result);
				if(c) window.location.href = 'finalizar.php';
			}

		}

	);
	
}
	 
function isCanvasBlank(canvas) {
    var blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;

    return canvas.toDataURL() == blank.toDataURL();
}

function resizeIframe(obj) {
	obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

/* Excluir box de respostas */
function deletar(elm){

	var id = $(elm).attr("id");
	id = id.split("_");
	id = id[1];

	if(id != 1){
	
		var c = confirm("Deseja excluir essa resposta?");
			
		if(c){
			$(".criar-respostas_"+id).remove();
		}

	}else{
		alert("Você não pode excluir a primeira resposta!");
	}

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

/* PREVIEW TAMANHO DA IMAGEM */	
function alterarLargura(input){
	newWidth = $(input).prev("input#widthImagem").val();
	preview = $(input).next("img");
	$(preview).width(newWidth.trim());
}
