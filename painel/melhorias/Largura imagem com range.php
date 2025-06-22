<input 
			type="range" 
			name="widthImagem" 
			id="widthImagem" 
			value='200' 
			max='500'  
			min='50'
			onchange="alterarLargura(this)"
		/><span style="display: block">50</span>
		
		<!-- Visualizar Tamanho 
		<button type="button" id="btnPreview" onclick="alterarLargura(this)">Visualizar Tamanho</button>
		-->
        <img id="preview" src="img/noimage.png" alt="your image" />

        function alterarLargura(input){
		//newWidth = $(input).prev("input#widthImagem").val();
		newWidth = $(input).val();
		span = $(input).next("span").text(newWidth);
		preview = $(input).next("span").next("img");
		$(preview).width(newWidth);
	}
		