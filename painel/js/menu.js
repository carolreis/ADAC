function toggleMenu(classe_mobile, classe_submenu) {
	
	// Show e Hide submenu
	$("."+classe_mobile).attr('id','0');
	
	var teste = $("."+classe_mobile).attr('id');
	
	$("."+classe_submenu).hide(); // colocar na media query TAMBEM
	$("."+classe_mobile).click(function(){
		var x = $(this).attr('id');
			if(x==1){
				$("."+classe_submenu).hide();
				$(this).attr('id', '0'); 
			}else{
				$("."+classe_submenu).show();
				$(this).attr('id', '1');
			}
	});
}