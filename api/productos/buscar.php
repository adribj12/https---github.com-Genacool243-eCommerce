<?php

include('../modelos/productos.php');

header("Content-Type:Application/json");

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    echo json_encode([
        'ok' => false,
        'msg' => 'Las consultas para obtener productos deben ser realizadas por el método GET.'
    ]);
} else {
    if (isset($_GET['busqueda']) && isset($_GET['filtro'])) {
        echo buscarProductos($_GET['busqueda'], $_GET['filtro']);
    }
}

?>