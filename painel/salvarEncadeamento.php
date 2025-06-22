<?php
session_start();

require("config/config.php");

if (!isset($_SESSION["usuario"])) {
	
	echo "
	<script>
		alert('Acesso não autorizado!');
		window.location.href = 'index.php';
	</script>
	";

	exit();

}

$cod_tst = $_POST["cod_tst"];
$cod_item = $_POST["cod_item"]; 
$cod_resp = $_POST["cod_resp"];
$prox = $_POST["prox"];
// if($prox == 0){
// 	$prox = NULL;
// }

$db = new db();
$db->query("UPDATE item SET prox_perg = '$prox' WHERE cod_resp = '$cod_resp' AND cod_item = '$cod_item' ");
// echo $db->_error();
?>