<?php
	
	$file = $_POST["arq"];

	$xml = simplexml_load_file("testes/".$file);
	$quant = $xml->Questions->Question;
	
	$level1 = 0;
	$level2 = 0;
	$level3 = 0;
	$level4 = 0;
	$level5 = 0;

	for ( $i=0; $i < count($xml->Questions->Question); $i++) {
		
		switch ($xml->Questions->Question[$i]->attributes()["level"]) {

			case '1': 
				$level1++;
				break;
			case '2':
				$level2++;
				break;
			case '3':
				$level3++;
				break;
			case '4':
				$level4++;
				break;
			case '5':
				$level5++;
				break;
				
		}

	}

	if($level1 >= 5 && $level2 >= 5 && $level3 >= 5 && $level4 >= 5 && $level5 >= 5) {
		echo "true";
	}else{
		echo "
		Nível 1: $level1 | Nível 2: $level2 | Nível 3: $level3 | Nível 4: $level4 | Nível 5: $level5";
	}
					
?>