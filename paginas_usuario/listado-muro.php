<?php

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

    <?//php foreach ($mensajes as $fila) { ?>
        <table>
            <tr id="columnasNombres">
                <td>Usuario</td>
                <td>Mensaje</td>
                <td>Fecha</td>
            </tr>
            <br>
            <tr>
                <td> <?php // echo $fila["identificador"]; ?> pepe</td>
                <td> <?php // echo $fila["texto"]; ?>texto ejemplo </td>
                <td> <?php // echo $fila["fecha"]; ?> 20/01/2019 </td>
            </tr>
        </table>
    <? //php } ?>
</div>
<div class="fromMensajes" style="margin-top: 5px">
    <form>
        <input type="text" name="texto">
        <input type="submit" value="enviar">
    </form>
</div>

<div>
    <a href="cerrar-sesion.php">cerrar sesion actual</a>
</div>