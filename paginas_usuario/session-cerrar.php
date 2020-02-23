<?php
require_once "_sesiones.php";
require_once "_clases.php";
require_once "_dao.php";
//$usuarioSesion=$_SESSION["identificador"];

destruirSesionYCookies($_SESSION["identificador"]);

redireccionar("sesion-inicio.php");

?>

<html>
<body>
<p>Sesion de <?= $usuario ?> ha finalizado sesion correctamente</p>
</body>
</html>
