<?php

require_once "_clases.php";
require_once "_dao.php";

$mensajes = DAO::mensajeObtenerTodos();             //llamo a la función obtener todos para sacar todos los mensajes como un objeto, y poder llamarlos con getMensaje etc

?>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        #columnasNombres {

            font-size: 20px;
            color: mediumblue;
            text-decoration: underline;
        }

        .contenidoMensajes {
            width: 100%;
        }

        table {

            width: 100%;
            border: 2px solid black;
            border-collapse: collapse;
        }

        table tr, td {
            height: auto;
            width: 30%;
        }

    </style>
</head>
<body>


<div class="contenidoMensajes">

    <?php foreach ($mensajes as $mensaje) { ?>                           <!-- mensajes de la variable con la funcion de arriba, recorre el array que nos da la función mensajeObtenerTodos(), y le asigno a cada tr su valor get...   -->
        <table>
            <tr id="columnasNombres">
                <td>Usuario</td>
                <td>Mensaje</td>
                <td>Fecha</td>
                <td><a href="mensaje-borrar-ejecutar.php?id=<?=$mensaje->getId() ?>">Borrar Mensaje</a></td>

            </tr>
            <br>
            <tr>
                <td>
                    <?= $mensaje->getIdentificador() ?>

                </td>
                <td>
                    <?= $mensaje->getMensaje() ?>
                </td>
                <td>
                    <?= $mensaje->getFecha() ?>
                </td>

            </tr>
            <?php } ?>
        </table>
</div>
<p>Insertar mensaje</p>
<div class="fromMensajes" style="margin-top: 5px">
    <form action="mensaje-insertar-ejecutar.php" method="get">
        <input type="text" name="nuevoMensaje">
        <input type="submit" value="enviar">
    </form>
</div>


<div>
   <!-- <a href="cerrar-sesion.php">cerrar sesion actual</a> -->
</div>
</body>
</html>