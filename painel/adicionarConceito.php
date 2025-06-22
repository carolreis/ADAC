<?php

require("config/config.php");

$nome = $_POST["conceito"];

$db = new db();
$db->query("INSERT INTO conceito (nm_conceito) VALUES ('".$nome."') ");
echo $db->resultado_insert_id();