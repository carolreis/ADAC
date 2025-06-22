var current = 1;

	$("#duplicar").click(function(){

		current++;
		var clone = $("#origem").clone();
		$(clone).attr("class","criar-respostas_"+current);
		$(clone).find(".num").text(current);
		$(clone).find(".certa_resp").val(current);
		$(clone).find(".delete").attr("id","delete_"+current);
		$(clone).find(".adicionar").attr("id","adicionar_"+current);
		$(clone).find(".conceito").attr("id","conceito_"+current);
		$(clone).find(".conceitos").attr("id","conceitos_"+current);

		/* Verifica se tem alguma reposta marcada como correta */
		var c = document.querySelectorAll(".certa_resp");

		var certaRespChecked = 0;

		[].forEach.call(c, function(div) {
		    if(div.checked){
				certaRespChecked = div.value
		    }
		});

		clone.appendTo("#destino");

		/* Limpa inputs */
		
		/* Zera os inputs - MAS NÃO OS RADIO */
		$(".criar-respostas_"+current+" input:not([type=radio])").each(function(){
    		$(this).val("");
		});

		/* Desmarca TODOS os inputs */
		$(".criar-respostas_"+current+" input[type='radio']").each(function(){
    		$(this).prop('checked',false);
		});

		/* Aplica checked ao input radio novamente */
		if(certaRespChecked) {	
			$(".criar-respostas_"+certaRespChecked+" input[type='radio']").prop('checked', true);
		}
		
		$(".criar-respostas_"+current+" .larguraImagem").prop("value","300");
		$(".criar-respostas_"+current+" .previewImage").attr("src","img/noimage.png");
		$(".criar-respostas_"+current+" .previewImage").removeAttr("style");
		$(".criar-respostas_"+current+" textarea").each(function(){
    		$(this).val("");
		});
		
	})
