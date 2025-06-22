<?php
require("../config/config.php");
require("../classes/DAO/TesteDAO.class.php");

$f = $_POST["nome"];

$testeObjDAO = new TesteDAO();
echo $testeObjDAO->existsTest($f);