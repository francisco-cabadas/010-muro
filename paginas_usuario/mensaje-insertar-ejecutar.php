<?php
require_once "clases.php";
require_once "_dao.php";
$mensaje = $_REQUEST["nuevoMensaje"];
DAO::agregarMensaje("fran", $mensaje, null);
header("Location:listado-muro.php");

?>