<?php
require_once "../_requireOnces/requireOnces.php";
$mensaje = $_REQUEST["id"];
DAO::borrarMensaje($mensaje);
header("Location:listado-muro.php");
?>