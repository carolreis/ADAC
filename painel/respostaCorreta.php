<?php

include("config/config.php");
include("classes/DAO/RespostaDAO.class.php");

$id = $_POST["id"];

$RespostaDAO = new RespostaDAO();
$marcarCorreta = $RespostaDAO->ativar($id);