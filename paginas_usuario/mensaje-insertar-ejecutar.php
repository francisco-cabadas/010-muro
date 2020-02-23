<?php

require_once "../_requireOnces/requireOnces.php";

garantizarSesion();

$usuario= DAO::usuarioObtenerPorIdentificador($_SESSION["identificador"]);
$mensaje = $_REQUEST["nuevoMensaje"];
DAO::agregarMensaje($usuario->getIdentificador(), $mensaje, null);

?>

<html>
<body>
<p><?=$usuario->getIdentificador() ?> ha creado un nuevo mensaje</p>
<br>
<a href='listado-muro.php'>volver a la lista</a>
</body>
</html>