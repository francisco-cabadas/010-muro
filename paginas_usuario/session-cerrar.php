<?php
require_once "../_requireOnces/requireOnces.php";

sessionStartSiNoLoEsta();

$usuarioSesion=DAO::usuarioObtenerPorIdentificador($_SESSION["identificador"]);

destruirSesionYCookies($usuarioSesion->getIdentificador());


?>

<html>
<body>
<p>Sesion de <?= $usuarioSesion->getIdentificador() ?> con apellido <?= $usuarioSesion->getApellidos() ?>   ha finalizado sesion correctamente</p>
<a href="session-inicio.php">Volver a inicio de sesión</a>
</body>
</html>
