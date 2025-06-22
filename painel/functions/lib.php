<?php

function upload_resize_image($imagem, $imagem_tmp, $newWidth, $cod_tst) {

	$extensao = strrchr($imagem, '.');
	$extensao = strtolower($extensao);
	$path = "img/".md5($cod_tst);

	/* Verifica extensão do arquivo */
	if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) { 
		
		/* Verifica se diretório existe */
		if(!file_exists($path)){
			mkdir($path);
		}
			
		$novoNome = md5(microtime()) . $extensao;
		
		$destino = $path."/".$novoNome;

		/* RESIZE */
		list ($naturalWidth, $naturalHeight, $type, $attr) = getimagesize($imagem_tmp);
					
		switch ($type) {
			case 1: 
				$src = imagecreatefromgif($imagem_tmp);
				break;
			case 2:
				$src = imagecreatefromjpeg($imagem_tmp);
				break;
			case 3:
				$src = imagecreatefrompng($imagem_tmp);
				break;
		}// end switch 

		/* Resize imagem */
		$newHeight = ($newWidth * $naturalHeight) / $naturalWidth;
		
		/* Cria imagem */
		$dst = imagecreatetruecolor($newWidth, $newHeight);
		imagealphablending($dst, false);
		imagesavealpha($dst, true);

		imagealphablending($src, true);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $naturalWidth, $naturalHeight);

		/*
		$trans_layer_overlay = imagecolorallocatealpha($dst, 220, 220, 220, 127);
		imagefill($dst, 0, 0, $trans_layer_overlay);
		imagecolortransparent ($dst, $trans_layer_overlay); // actually make it transparent


		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $naturalWidth, $naturalHeight);
		*/


		switch ($type) {
			case 1: 
    			if(!imagegif($dst,$destino)){
    				$novoNome = NULL;
    			}else{
    				return $novoNome;
    			}
	    		break;

			case 2:
				if(!imagejpeg($dst,$destino)){
					$novoNome = NULL;
				}else{
    				return $novoNome;
				}
				break;

			case 3:
				if(!imagepng($dst,$destino)){
					$novoNome = NULL;
				}else{
    				return $novoNome;
				}
	    		break;
		} // end switch

	}else{
		echo "Você poderá enviar apenas arquivos *.jpg;*.jpeg;*.gif;*.png";
	}

}