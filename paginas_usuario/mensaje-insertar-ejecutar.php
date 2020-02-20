<?php
require_once "_clases.php";
require_once "_dao.php";
$mensaje = $_REQUEST["nuevoMensaje"];
DAO::agregarMensaje("peter", $mensaje, null);  //añadir sesion para el identificador
//header("Location:listado-muro.php");
//$usuario = $_SESSION["nuevoMensaje"]; //IMPLEMENTAR
$usuario= DAO::usuarioObtenerPorIdentificador("fran"); //poner session en

?>

<html>
<body>
<p><?=$usuario->getIdentificador() ?> ha creado un nuevo mensaje</p>
<br>
<a href='listado-muro.php'>volver a la lista</a>
</body>
</html>