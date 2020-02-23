<?php

require_once "../_requireOnces/requireOnces.php";


function sessionStartSiNoLoEsta()      //hace el session_start(),
{
    if(!isset($_SESSION)) {
        session_start();
    }
}

// Comprueba si hay sesión-usuario iniciada en la sesión-RAM.
function haySesionIniciada()
{

    sessionStartSiNoLoEsta();
    return isset($_SESSION['sesionIniciada']);
}

function vieneFormularioDeInicioDeSesion()
{
    return isset($_REQUEST['identificador']);
}

function vieneCookieRecuerdame()
{
    return isset($_COOKIE["identificador"]);
}

function garantizarSesion()
{
    sessionStartSiNoLoEsta();   //función de iniciar sesión que esta creadqa arriba.

    if (haySesionIniciada()) {
        // Si hay cookie de "recuérdame", la renovamos.
        if (vieneCookieRecuerdame()) {
            establecerCookieRecuerdame($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);
        }

        // >>> NO HACEMOS NADA MÁS. DEJAMOS QUE SE CONTINÚE EJECUTANDO EL PHP QUE NOS LLAMÓ... >>>
    } else { // NO hay sesión iniciada.
        if (vieneFormularioDeInicioDeSesion()) { // SÍ hay formulario enviado. Lo comprobaremos contra la BD.
            $usuario = DAO::usuarioObtenerPorIdentificadorContaseña($_REQUEST['identificador'], $_REQUEST['contrasenna']);

            if ($usuario) { // Si viene un usuario es que el inicio de sesión ha sido exitoso.
                anotarDatosSesionRam($usuario);

                if (isset($_REQUEST["recuerdame"])) { // Si han marcado el checkbox de recordar:
                    generarCookieRecuerdame($usuario);
                }
                // >>> Y DEJAMOS QUE SE CONTINÚE EJECUTANDO EL PHP QUE NOS LLAMÓ... >>>
            } else { // Si usuario es null, o no existe ese usuario o la contraseña no coincide.
                redireccionar("sesion-inicio.php?incorrecto=true");
            }
        } else if (vieneCookieRecuerdame()) {
            $usuario = DAO::usuarioObtenerPorIdentificadorYCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);

            if ($usuario) { // Si viene un usuario es que existe el usuario y coincide el código cookie. Daremos por iniciada la sesión.
                // Recuperar los datos adicionales del usuario que acaba de iniciar sesión.
                anotarDatosSesionRam($usuario);

                // Renovar la cookie (código y caducidad).
                generarCookieRecuerdame($usuario);
            } else { // Parecía que venía una cookie válida pero... No es válida o pasa algo raro.
                // Borrar la cookie mala que nos están enviando (si no, la enviarán otra vez, y otra, y otra...)
                borrarCookieRecuerdame($usuario->getIdentificador());

                // REDIRIGIR A INICIAR SESIÓN PARA IMPEDIR QUE ESTE USUARIO VISUALICE CONTENIDO PRIVADO.
                redireccionar("sesion-inicio.php");
            }
        } else { // NO hay ni sesión, ni cookie, ni formulario enviado.
            // REDIRIGIMOS PARA QUE NO SE VISUALICE CONTENIDO PRIVADO:
            redireccionar("sesion-inicio.php");
        }
    }
}

function establecerCookieRecuerdame($identificador, $codigoCookie)
{
    // Enviamos el código cookie al cliente, junto con su identificador.
    setcookie("identificador", $identificador, time() + 24*60*60); // Un mes sería: +30*24*60*60
    setcookie("codigoCookie", $codigoCookie, time() + 24*60*60); // Un mes sería: +30*24*60*60
}


function generarCookieRecuerdame($usuario)
{
    // Creamos un código cookie muy complejo (no necesariamente único).
    $codigoCookie = generarCadenaAleatoria(32); // Random...
    DAO::clienteGuardarCodigoCookie($usuario->getIdentificador(), $codigoCookie);

    // TODO Para una seguridad óptima convendriá anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.

    establecerCookieRecuerdame($usuario->getIdentificador(), $codigoCookie);
}

function borrarCookieRecuerdame($identificador)
{
    // Eliminamos el código cookie de nuestra BD.
    DAO::clienteGuardarCodigoCookie($identificador, null);

    setcookie("identificador", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
    setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
}

function anotarDatosSesionRam($usuario)         //guarda en sesión todos los datos de usuario.
{
    $_SESSION["sesionIniciada"] = "";
    $_SESSION["id"] = $usuario->getId();
    $_SESSION["identificador"] = $usuario->getIdentificador();
    $_SESSION["nombre"] = $usuario->getNombre();
    // TODO: Para implementar una superclase Usuario para Cliente y Administrador, aquí habría que añadir algo como esto: $_SESSION["tipoUsuario"] = "ADM" / "CLI";
}

function destruirSesionYCookies($identificador)
{

    session_destroy();

    borrarCookieRecuerdame($identificador);
}