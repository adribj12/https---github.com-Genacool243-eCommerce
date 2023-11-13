<?php

include('../modelos/usuarios.php');

header("Content-Type:Application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo json_encode([
        'ok' => false,
        'msg' => 'Las consultas para ingresar usuarios deben ser realizadas por el método POST.'
    ]);
} else {
    $estaDefinidoNombre = 0;
    $estaDefinidoEmail = 0;
    $estaDefinidoContrasena = 0;
    $estaDefinidoPais = 0;
    $estaDefinidoFechaDeNacimiento = 0;

    if (!isset($_POST['nombre'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "nombre".'
        ]);
    } else {
        $estaDefinidoNombre = 1;
    }

    if (!isset($_POST['email'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "email".'
        ]);
    } else {
        $estaDefinidoEmail = 1;
    }

    if (!isset($_POST['contrasena'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "contrasena".'
        ]);
    } else {
        $estaDefinidoContrasena = 1;
    }

    if (!isset($_POST['pais'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "pais".'
        ]);
    } else {
        $estaDefinidoPais = 1;
    }

    if (!isset($_POST['fechaDeNacimiento'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "fechaDeNacimiento".'
        ]);
    } else {
        $estaDefinidoFechaDeNacimiento = 1;
    }

    if (($estaDefinidoNombre == 1) && ($estaDefinidoEmail == 1) && ($estaDefinidoContrasena == 1) && ($estaDefinidoPais == 1) && ($estaDefinidoFechaDeNacimiento == 1)) {
        echo añadirUsuario($_POST['nombre'], $_POST['email'], $_POST['contrasena'], $_POST['pais'], $_POST['fechaDeNacimiento']);
    }
}

?>