<?php

include('../modelos/usuarios.php');

header("Content-Type:Application/json");

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    echo json_encode([
        'ok' => false,
        'msg' => 'Las consultas para eliminar usuarios deben ser realizadas por el método GET.'
    ]);
} else {
    $estaDefinidoUsername = 0;
    $estaDefinidoContrasena = 0;

    if (!isset($_GET['username'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "username".'
        ]);
    } else {
        $estaDefinidoUsername = 1;
    }

    if (!isset($_GET['contrasena'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "contrasena".'
        ]);
    } else {
        $estaDefinidoContrasena = 1;
    }

    if (($estaDefinidoUsername == 1) && ($estaDefinidoContrasena == 1)) {
        echo iniciarSesion($_GET['username'], $_GET['contrasena']);
    }
}

?>