<?php
require_once "clases.php";
require_once "_dao.php";
$fecha="";
$mensaje = $_REQUEST["nuevoMensaje"];
$identificador=DAO::usuarioObtenerPorId("fran_95");    //mas o menos puede funcionar,
$identificador->getNombre();

DAO::agregarMensaje($fecha, $mensaje, $identificador);



?>