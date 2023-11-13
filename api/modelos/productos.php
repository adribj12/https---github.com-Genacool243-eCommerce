<?php

include('conn.php');

header("Content-Type:Application/json");

function obtenerProductos($pagina, $cantidad) {
    $resultados = [];

    $esCorrectoPagina = 0;
    $esCorrectoCantidad = 0;

    if (isset($pagina)) {
        if (!is_numeric($pagina)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "pagina" debe ser de tipo numérico.'
            ]);
        } else {
            if ($pagina <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "pagina" debe ser mayor o igual a 1.'
                ]);
            } else {
                $esCorrectoPagina = 1;
            }
        }
    }

    if (isset($cantidad)) {
        if (!is_numeric($cantidad)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "cantidad" debe ser de tipo numérico.'
            ]);
        } else {
            if ($cantidad <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "cantidad" debe ser mayor o igual a 1.'
                ]);
            } else {
                $esCorrectoCantidad = 1;
            }
        }
    }

    if ($esCorrectoPagina == 1 && $esCorrectoCantidad == 1) {
        $consulta = mysqli_query(CONN, "SELECT * FROM Productos ORDER BY idProducto ASC LIMIT ".(($pagina - 1) * $cantidad).", ".$cantidad.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idProducto'],
                    'nombre' => $fila['nombreProducto'],
                    'descripcion' => $fila['descripcion'],
                    'steamId' => $fila['steamId'],
                    'precio' => $fila['precio'],
                    'trailer' => $fila['trailer'],
                    'fechaDeSalida' => $fila['fecha_de_salida']
                    ]);
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron resultados en la página '.$pagina.'.'
                ]);
            } else {
                return json_encode($resultados);
            }
        }
    }

    if ($esCorrectoPagina == 0 && $esCorrectoCantidad == 1) {
        $consulta = mysqli_query(CONN, "SELECT * FROM Productos ORDER BY idProducto ASC LIMIT ".$cantidad.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idProducto'],
                    'nombre' => $fila['nombreProducto'],
                    'descripcion' => $fila['descripcion'],
                    'steamId' => $fila['steamId'],
                    'precio' => $fila['precio'],
                    'trailer' => $fila['trailer'],
                    'fechaDeSalida' => $fila['fecha_de_salida']
                    ]);
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron resultados en la base de datos.'
                ]);
            } else {
                return json_encode($resultados);
            }
        }
    }

    if (($esCorrectoPagina == 1 && $esCorrectoCantidad == 0) || ($esCorrectoPagina == 0 && $esCorrectoCantidad == 0)) {
        $consulta = mysqli_query(CONN, "SELECT * FROM Productos ORDER BY idProducto ASC;");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idProducto'],
                    'nombre' => $fila['nombreProducto'],
                    'descripcion' => $fila['descripcion'],
                    'steamId' => $fila['steamId'],
                    'precio' => $fila['precio'],
                    'trailer' => $fila['trailer'],
                    'fechaDeSalida' => $fila['fecha_de_salida']
                    ]);
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron productos en la base de datos.'
                ]);
            } else {
                return json_encode($resultados);
            }
        }
    }
}

function obtenerProductosPorID($id) {
    $resultados = [];

    if (!isset($id)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "id".'
        ]);
    } else {
        if (!is_numeric($id)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "id" debe ser de tipo numérico.'
            ]);
        } else {
            if ($id <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "id" debe ser mayor o igual a 1.'
                ]);
            } else {
                $consulta = mysqli_query(CONN, "SELECT * FROM Productos WHERE idProducto = ".$id.";");
                if ($consulta == false) {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
                } else {
                    while ($fila = mysqli_fetch_assoc($consulta)) {
                        array_push($resultados, [
                            'id' => $fila['idProducto'],
                            'nombre' => $fila['nombreProducto'],
                            'descripcion' => $fila['descripcion'],
                            'steamId' => $fila['steamId'],
                            'precio' => $fila['precio'],
                            'trailer' => $fila['trailer'],
                            'fechaDeSalida' => $fila['fecha_de_salida']
                            ]);
                    }

                    if (empty($resultados)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'No se encontraron productos con la id '.$id.'.'
                        ]);
                    } else {
                        return json_encode($resultados);
                    }
                }
            }
        }
    }
}

function modificarProducto($id, $campo, $valor) {
    $resultados = [];

    $esCorrectoId = 0;
    $esCorrectoCampo = 0;
    $esCorrectoValor = 0;

    if (!isset($id)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "id".'
        ]);
    } else {
        if (!is_numeric($id)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "id" debe ser de tipo numérico.'
            ]);
        } else {
            if ($id <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "id" debe ser mayor o igual a 1.'
                ]);
            } else {
                $consulta = mysqli_query(CONN, "SELECT * FROM Productos WHERE idProducto = ".$id.";");
                if ($consulta == false) {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
                } else {
                    while ($fila = mysqli_fetch_assoc($consulta)) {
                        array_push($resultados, [
                            'id' => $fila['idProducto'],
                            'nombre' => $fila['nombreProducto'],
                            'descripcion' => $fila['descripcion'],
                            'steamId' => $fila['steamId'],
                            'precio' => $fila['precio'],
                            'trailer' => $fila['trailer'],
                            'fechaDeSalida' => $fila['fecha_de_salida']
                            ]);
                    }

                    if (empty($resultados)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'No se encontraron productos con la id '.$id.'.'
                        ]);
                    } else {
                        unset($resultados);
                        $resultados = [];

                        $esCorrectoId = 1;
                    }
                }
            }
        }
    }

    if (!isset($campo)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "campo".'
        ]);
    } else {
        if (is_numeric($campo)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "campo" debe ser de tipo texto.'
            ]);
        } else {
            switch ($campo) {
                default:
                    return json_encode([
                        'ok' => false,
                        'msg' => 'El valor especificado en "campo" debe ser alguno de los campos de los que se busca modificar su valor.'
                    ]);
                    break;
                case 'nombre':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($campo)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de nombre el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $campo = "nombreProducto";
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'descripcion':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($campo)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de descripcion el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'steamId':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (!is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de precio el valor especificado en "valor" debe ser de tipo numérico.'
                            ]);
                        } else {
                            if ($valor <= 0) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'Si se quiere modificar el campo de precio el valor especificado en "valor" debe ser mayor o igual a 1.'
                                ]);
                            } else {
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                    break;
                case 'precio':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (!is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de precio el valor especificado en "valor" debe ser de tipo numérico.'
                            ]);
                        } else {
                            if ($valor <= 0) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'Si se quiere modificar el campo de precio el valor especificado en "valor" debe ser mayor o igual a 1.'
                                ]);
                            } else {
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                    break;
                case 'trailer':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        $esCorrectoCampo = 1;
                        $esCorrectoValor = 1;
                    }
                case 'fechaDeSalida':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de fecha de salida el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $fechaSeparada = explode('-', $valor);
                            $año = $fechaSeparada[0];
                            $mes   = $fechaSeparada[1];
                            $dia  = $fechaSeparada[2];
                            if (!checkdate($mes, $dia, $año)) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'El valor especificado debe ser una fecha válida en formato YYYY-MM-DD.'
                                ]);
                            } else {
                                $campo = "fecha_de_salida";
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                    break;
            }
        }
    }

    if (($esCorrectoId == 1) && ($esCorrectoCampo == 1) && ($esCorrectoValor == 1)) {
        $consulta = mysqli_query(CONN, "UPDATE Productos SET ".$campo." = '".$valor."' WHERE idProducto = ".$id.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            $consulta = mysqli_query(CONN, "SELECT * FROM Productos WHERE idProducto = ".$id.";");
            if ($consulta == false) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'La consulta MySQL tuvo un error.'
                ]);
            } else {
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    array_push($resultados, [
                        'id' => $fila['idProducto'],
                        'nombre' => $fila['nombreProducto'],
                        'descripcion' => $fila['descripcion'],
                        'steamId' => $fila['steamId'],
                        'precio' => $fila['precio'],
                        'trailer' => $fila['trailer'],
                        'fechaDeSalida' => $fila['fecha_de_salida']
                        ]);
                }

                return json_encode($resultados);
            }
        }
    }
}

function añadirProducto($nombre, $descripcion, $steamId, $precio, $trailer, $fechaDeSalida) {
    $resultados = [];

    $esCorrectoNombre = 0;
    $esCorrectoDescripcion = 0;
    $esCorrectoSteamId = 0;
    $esCorrectoPrecio = 0;
    $esCorrectoTrailer = 0;
    $esCorrectoFechaDeSalida = 0;

    if (!isset($nombre)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "nombre".'
        ]);
    } else {
        if (is_numeric($nombre)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "nombre" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoNombre = 1;
        }
    }

    if (!isset($descripcion)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "descripcion".'
        ]);
    } else {
        if (is_numeric($descripcion)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "descripcion" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoDescripcion = 1;
        }
    }

    if (!isset($steamId)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "steamId".'
        ]);
    } else {
        if (!is_numeric($steamId)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "steamId" debe ser de tipo numérico.'
            ]);
        } else {
            if ($steamId <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "steamId" debe ser mayor o igual a 1.'
                ]);
            } else {
                $esCorrectoSteamId = 1;
            }
        }
    }

    if (!isset($precio)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "precio".'
        ]);
    } else {
        if (!is_numeric($precio)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "precio" debe ser de tipo numérico.'
            ]);
        } else {
            if ($precio <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "precio" debe ser mayor o igual a 1.'
                ]);
            } else {
                $esCorrectoPrecio = 1;
            }
        }
    }

    if (!isset($trailer)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "trailer".'
        ]);
    } else {
        $esCorrectoVendedor = 1;
    }
    

    if (!isset($fechaDeSalida)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "fechaDeSalida".'
        ]);
    } else {
        if (is_numeric($fechaDeSalida)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "fechaDeSalida" debe ser de tipo texto.'
            ]);
        } else {
            $fechaSeparada = explode('-', $fechaDeSalida);
            $año = $fechaSeparada[0];
            $mes   = $fechaSeparada[1];
            $dia  = $fechaSeparada[2];
            if (!checkdate($mes, $dia, $año)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "fechaDeSalida" debe ser una fecha válida.'
                ]);
            } else {
                $esCorrectoFechaDeSalida = 1;
            }
        }
    }

    if (($esCorrectoNombre == 1) && ($esCorrectoDescripcion == 1) && ($esCorrectoSteamId == 1) &&($esCorrectoPrecio == 1) && ($esCorrectoTrailer == 1) && ($esCorrectoFechaDeSalida == 1)) {
        $consulta = mysqli_query(CONN, "INSERT INTO Productos (nombreProducto, descripcion, steamId, precio, trailer, fecha_de_salida) VALUES ('".$nombre."', '".$descripcion."', ".$steamId.", ".$precio.", ".$trailer.", '".$año."-".$mes."-".$dia."');");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            $consulta = mysqli_query(CONN, "SELECT * FROM Productos ORDER BY idProducto DESC LIMIT 0, 1;");
            if ($consulta == false) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'La consulta MySQL tuvo un error.'
                ]);
            } else {
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    array_push($resultados, [
                        'id' => $fila['idProducto'],
                        'nombre' => $fila['nombreProducto'],
                        'descripcion' => $fila['descripcion'],
                        'steamId' => $fila['steamId'],
                        'precio' => $fila['precio'],
                        'trailer' => $fila['trailer'],
                        'fechaDeSalida' => $fila['fecha_de_salida']
                        ]);
                }

                return json_encode($resultados);
            }
        }
    }
}

function eliminarProducto($id) {
    $resultados = [];

    if (!isset($id)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "id".'
        ]);
    } else {
        if (!is_numeric($id)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "id" debe ser de tipo numérico.'
            ]);
        } else {
            if ($id <= 0) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado en "id" debe ser mayor o igual a 1.'
                ]);
            } else {
                $consulta = mysqli_query(CONN, "SELECT * FROM Productos WHERE idProducto = ".$id.";");
                if ($consulta == false) {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
                } else {
                    while ($fila = mysqli_fetch_assoc($consulta)) {
                        array_push($resultados, [
                            'id' => $fila['idProducto'],
                            'nombre' => $fila['nombreProducto'],
                            'descripcion' => $fila['descripcion'],
                            'steamId' => $fila['steamId'],
                            'precio' => $fila['precio'],
                            'trailer' => $fila['trailer'],
                            'fechaDeSalida' => $fila['fecha_de_salida']
                            ]);
                    }

                    if (empty($resultados)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'No se encontraron productos con la id '.$id.'.'
                        ]);
                    } else {
                        unset($resultados);
                        $resultados = [];
                        $consulta = mysqli_query(CONN, "DELETE FROM Productos WHERE idProducto = ".$id.";");
                        if ($consulta == false) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'La consulta MySQL tuvo un error.'
                            ]);
                        } else {
                            $consulta = mysqli_query(CONN, "SELECT * FROM Productos WHERE idProducto = ".$id.";");
                            if ($consulta == false) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'La consulta MySQL tuvo un error.'
                                ]);
                            } else {
                                while ($fila = mysqli_fetch_assoc($consulta)) {
                                    array_push($resultados, [
                                        'id' => $fila['idProducto'],
                                        'nombre' => $fila['nombreProducto'],
                                        'descripcion' => $fila['descripcion'],
                                        'steamId' => $fila['steamId'],
                                        'precio' => $fila['precio'],
                                        'trailer' => $fila['trailer'],
                                        'fechaDeSalida' => $fila['fecha_de_salida']
                                        ]);
                                }

                                if (!empty($resultados)) {
                                    return json_encode([
                                        'ok' => false,
                                        'msg' => 'No se pudo eliminar el producto de id '.$id.'.'
                                    ]);
                                } else {
                                    return json_encode([
                                        'ok' => true,
                                        'msg' => 'Se eliminó el producto de id '.$id.' con éxito.'
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function buscarProductos($busqueda, $filtro) {
    $resultados = [];

    $esCorrectoBusqueda = 0;
    $esCorrectoFiltro = 0;

    if (!isset($busqueda)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "busqueda".'
        ]);
    } else {
        $esCorrectoBusqueda = 1;
    }

    if (!isset($filtro)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "filtro".'
        ]);
    } else {

        switch ($filtro) {
            case 0:
                $filterQuery = "ORDER BY nombreProducto ASC";
                break;
            case 1:
                $filterQuery = "ORDER BY fecha_de_salida DESC";
                break;
        }

        $esCorrectoFiltro = 1;
    }

    if (($esCorrectoBusqueda == 1) && ($esCorrectoFiltro == 1)) {
        $consulta = mysqli_query(CONN, "SELECT * FROM Productos WHERE nombreProducto LIKE '%".$busqueda."%' ".$filterQuery.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idProducto'],
                    'nombre' => $fila['nombreProducto'],
                    'descripcion' => $fila['descripcion'],
                    'steamId' => $fila['steamId'],
                    'precio' => $fila['precio'],
                    'trailer' => $fila['trailer'],
                    'fechaDeSalida' => $fila['fecha_de_salida']
                    ]);
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron resultados en la base de datos.'
                ]);
            } else {
                return json_encode($resultados);
            }
        }
    }
}

function obtenerProductoPorGenero($nombreGenero) {
    $resultados = [];

    if (!isset($nombreGenero)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "nombreGenero".'
        ]);
    } else {
        $consulta = mysqli_query(CONN, "SELECT * FROM relaciongeneros LEFT OUTER JOIN productos ON relaciongeneros.producto productos.idProducto WHERE relaciongeneros.genero = '".$nombreGenero."' ORDER BY relaciongeneros.producto ASC");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            $consulta = mysqli_query(CONN, "SELECT * FROM relaciongeneros LEFT OUTER JOIN productos ON relaciongeneros.producto = productos.idProducto WHERE relaciongeneros.genero = '".$nombreGenero."' ORDER BY relaciongeneros.producto ASC");
            if ($consulta == false) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
            } else {
                if (is_numeric($nombreGenero)) { 
                    return json_encode([
                        'ok' => false,
                        'msg' => 'El valor especificado en "nombre" debe ser de tipo texto.'
                    ]);
                } else {
                    $esCorrectoNombre = 1;
                }
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron géneros con el nombre '.$nombreGenero.'.'
                ]);
            } else {
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    array_push($resultados, [
                        'id' => $fila['idGenero'],
                        'nombre' => $fila['nombreGenero']
                        ]);
                }
                return json_encode($resultados);
            }
        }

    if (empty($resultados)) {
        return json_encode([
            'ok' => false,
            'msg' => 'No se encontraron géneros con el nombre '.$nombreGenero.'.'
        ]);
    } else {
        while ($fila = mysqli_fetch_assoc($consulta)) {
            array_push($resultados, [
                'id' => $fila['idGenero'],
                'nombre' => $fila['nombreGenero']
            ]);
        }
        return json_encode($resultados);
    }

    }
}
        
        
?>