<?php

include("config/config.php");
include("classes/DAO/TesteDAO.class.php");

$testeId = $_POST["id"];

$testeDAO = new testeDAO();
$ativar = $testeDAO->ativar($testeId);