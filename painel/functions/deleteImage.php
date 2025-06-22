<?php
require("../config/config.php");

$cod = $_POST["cod"]; 
$cod_field = $_POST["cod_field"];
$field = $_POST["field"];
$table = $_POST["table"];
$teste = $_POST["teste"];

$db = new db();

$imgQuery = $db->query("SELECT $field FROM $table WHERE $cod_field = $cod");
$resultado = $db->resultado();
$imagem = $resultado[0][$field];

$db = null;

$db = new db();

$excluirImagem = $db->query("UPDATE $table SET $field = '' WHERE $cod_field = $cod");

$retorno = array(
	'error' => $db->error()
);

if(!$db->error()) {
	unlink("../img/".md5($teste)."/".$imagem);
}

echo json_encode($retorno);