<?php
require_once "clases.php";
require_once "_dao.php";
$mensaje = $_REQUEST["id"];
DAO::borrarMensaje($mensaje);
header("Location:listado-muro.php");
?>