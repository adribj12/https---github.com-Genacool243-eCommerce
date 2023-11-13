<?php

include('../modelos/imagenes.php');

header("Content-Type:Application/json");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo json_encode([
        'ok' => false,
        'msg' => 'Las consultas para ingresar géneros deben ser realizadas por el método POST.'
    ]);
} else {
    $estaDefinidoRuta = 0;

    if (!isset($_POST['ruta'])) {
        echo json_encode([
            'ok' => false,
            'msg' => 'Se debe especificar un valor en el campo "ruta".'
        ]);
    } else {
        $estaDefinidoRuta = 1;
    }

    if ($estaDefinidoRuta == 1) {
        echo añadirImagen($_POST['ruta']);
    }
}

?>