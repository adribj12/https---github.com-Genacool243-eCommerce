<?php

include('conn.php');

header("Content-Type:Application/json");

function obtenerUsuarios($pagina, $cantidad) {
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
        $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios ORDER BY idUsuario ASC LIMIT ".(($pagina - 1) * $cantidad).", ".$cantidad.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idUsuario'],
                    'nombre' => $fila['nombreUsuario'],
                    'email' => $fila['email'],
                    'contrasena' => $fila['contrasena'],
                    'telefono' => $fila['telefono'],
                    'pais' => $fila['pais'],
                    'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                    'fotoDePerfil' => $fila['foto_de_perfil'],
                    'rango' => $fila['rango'],
                    'fechaDeCreacion' => $fila['fecha_de_creacion'],
                    'tema' => $fila['tema'],
                    'colorPreferido' => $fila['color_preferido']
                    ]);
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron resultados en la pagina '.$pagina.'.'
                ]);
            } else {
                return json_encode($resultados);
            }
        }
    }

    if ($esCorrectoPagina == 0 && $esCorrectoCantidad == 1) {
        $consulta = mysqli_query(CONN, "SELECT * FROM Usuaros ORDER BY idUsuario ASC LIMIT ".$cantidad.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idUsuario'],
                    'nombre' => $fila['nombreUsuario'],
                    'email' => $fila['email'],
                    'contrasena' => $fila['contrasena'],
                    'telefono' => $fila['telefono'],
                    'pais' => $fila['pais'],
                    'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                    'fotoDePerfil' => $fila['foto_de_perfil'],
                    'rango' => $fila['rango'],
                    'fechaDeCreacion' => $fila['fecha_de_creacion'],
                    'tema' => $fila['tema'],
                    'colorPreferido' => $fila['color_preferido']
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
        $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios ORDER BY idUsuario ASC;");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idUsuario'],
                    'nombre' => $fila['nombreUsuario'],
                    'email' => $fila['email'],
                    'contrasena' => $fila['contrasena'],
                    'telefono' => $fila['telefono'],
                    'pais' => $fila['pais'],
                    'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                    'fotoDePerfil' => $fila['foto_de_perfil'],
                    'rango' => $fila['rango'],
                    'fechaDeCreacion' => $fila['fecha_de_creacion'],
                    'tema' => $fila['tema'],
                    'colorPreferido' => $fila['color_preferido']
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

function obtenerUsuariosPorID($id) {
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
                $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios WHERE idUsuario = ".$id.";");
                if ($consulta == false) {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
                } else {
                    while ($fila = mysqli_fetch_assoc($consulta)) {
                        array_push($resultados, [
                            'id' => $fila['idUsuario'],
                            'nombre' => $fila['nombreUsuario'],
                            'email' => $fila['email'],
                            'contrasena' => $fila['contrasena'],
                            'telefono' => $fila['telefono'],
                            'pais' => $fila['pais'],
                            'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                            'fotoDePerfil' => $fila['foto_de_perfil'],
                            'rango' => $fila['rango'],
                            'fechaDeCreacion' => $fila['fecha_de_creacion'],
                            'tema' => $fila['tema'],
                            'colorPreferido' => $fila['color_preferido']
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

function modificarUsuario($id, $campo, $valor) {
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
                $consulta = mysqli_query(CONN, "SELECT * FROM Usuario WHERE idUsuario = ".$id.";");
                if ($consulta == false) {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
                } else {
                    while ($fila = mysqli_fetch_assoc($consulta)) {
                        array_push($resultados, [
                            'id' => $fila['idUsuario'],
                            'nombre' => $fila['nombreUsuario'],
                            'email' => $fila['email'],
                            'contrasena' => $fila['contrasena'],
                            'telefono' => $fila['telefono'],
                            'pais' => $fila['pais'],
                            'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                            'fotoDePerfil' => $fila['foto_de_perfil'],
                            'rango' => $fila['rango'],
                            'fechaDeCreacion' => $fila['fecha_de_creacion'],
                            'tema' => $fila['tema'],
                            'colorPreferido' => $fila['color_preferido']
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
                            $campo = "nombreUsuario";
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'email':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($campo)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de email el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            if (!preg_match("~([a-zA-Z0-9!#$%&'*+-/=?^_`{|}~])@([a-zA-Z0-9-]).([a-zA-Z0-9]{2,4})~", $valor)) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'El valor especificado para el campo email no es valido.'
                                ]);
                            } else {
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                    break;
                case 'contrasena':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($campo)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de contrasena el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $campo = "nombreUsuario";
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'telefono':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de telefono el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            if (!preg_match("/^\+[1-9]\d{1,14}$/", $valor)) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'El valor especificado para el campo telefono no es valido.'
                                ]);
                            } else {
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                    break;
                case 'pais':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($campo)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de pais el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'fechaDeNacimiento':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de fecha de nacimiento el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $fechaSeparada = explode('-', $valor);
                            $año = $fechaSeparada[0];
                            $mes   = $fechaSeparada[1];
                            $dia  = $fechaSeparada[2];
                            if (!checkdate($mes, $dia, $año)) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'El valor especificado debe ser una fecha valida en formato YYYY-MM-DD.'
                                ]);
                            } else {
                                $campo = "fecha_de_nacimiento";
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                case 'fotoDePerfil':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($campo)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de fotoDePerfil el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $campo = "foto_de_perfil";
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'rango':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (!is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de rango el valor especificado en "valor" debe ser de tipo numérico.'
                            ]);
                        } else {
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'fechaDeCreacion':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de fecha de creación el valor especificado en "valor" debe ser de tipo texto.'
                            ]);
                        } else {
                            $fechaSeparada = explode('-', $valor);
                            $año = $fechaSeparada[0];
                            $mes   = $fechaSeparada[1];
                            $dia  = $fechaSeparada[2];
                            if (!checkdate($mes, $dia, $año)) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'El valor especificado debe ser una fecha valida en formato YYYY-MM-DD.'
                                ]);
                            } else {
                                $campo = "fecha_de_creacion";
                                $esCorrectoCampo = 1;
                                $esCorrectoValor = 1;
                            }
                        }
                    }
                case 'tema':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (!is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de tema el valor especificado en "valor" debe ser de tipo numérico.'
                            ]);
                        } else {
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
                case 'colorPreferido':
                    if (!isset($valor)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'Es obligatorio especificar un valor para "valor".'
                        ]);
                    } else {
                        if (!is_numeric($valor)) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'Si se quiere modificar el campo de colorPreferido el valor especificado en "valor" debe ser de tipo numérico.'
                            ]);
                        } else {
                            $campo = "color_preferido";
                            $esCorrectoCampo = 1;
                            $esCorrectoValor = 1;
                        }
                    }
                    break;
            }
        }
    }

    if (($esCorrectoId == 1) && ($esCorrectoCampo == 1) && ($esCorrectoValor == 1)) {
        $consulta = mysqli_query(CONN, "UPDATE Usuarios SET ".$campo." = '".$valor."' WHERE idUsuario = ".$id.";");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios WHERE idUsuario = ".$id.";");
            if ($consulta == false) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'La consulta MySQL tuvo un error.'
                ]);
            } else {
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    array_push($resultados, [
                        'id' => $fila['idUsuario'],
                        'nombre' => $fila['nombreUsuario'],
                        'email' => $fila['email'],
                        'contrasena' => $fila['contrasena'],
                        'telefono' => $fila['telefono'],
                        'pais' => $fila['pais'],
                        'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                        'fotoDePerfil' => $fila['foto_de_perfil'],
                        'rango' => $fila['rango'],
                        'fechaDeCreacion' => $fila['fecha_de_creacion'],
                        'tema' => $fila['tema'],
                        'colorPreferido' => $fila['color_preferido']
                        ]);
                }

                return json_encode($resultados);
            }
        }
    }
}

function añadirUsuario($nombre, $email, $contrasena, $pais, $fechaDeNacimiento) {
    $resultados = [];

    $esCorrectoNombre = 0;
    $esCorrectoEmail = 0;
    $esCorrectoContrasena = 0;
    $esCorrectoPais = 0;
    $esCorrectoFechaDeNacimiento = 0;


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

    if (!isset($email)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "email".'
        ]);
    } else {
        if (is_numeric($email)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "email" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoEmail = 1;
        }
    }

    if (!isset($contrasena)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "contrasena".'
        ]);
    } else {
        if (is_numeric($contrasena)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "contrasena" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoContrasena = 1;
        }
    }

    if (!isset($pais)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "pais".'
        ]);
    } else {
        if (is_numeric($pais)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "pais" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoPais = 1;
        }
    }

    if (!isset($fechaDeNacimiento)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "fechaDeNacimiento".'
        ]);
    } else {
        if (is_numeric($fechaDeNacimiento)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "fechaDeNacimiento" debe ser de tipo texto.'
            ]);
        } else {
            $fechaSeparada = explode('-', $fechaDeNacimiento);
            $añoNacimiento = $fechaSeparada[0];
            $mesNacimiento   = $fechaSeparada[1];
            $diaNacimiento  = $fechaSeparada[2];
            if (!checkdate($mesNacimiento, $diaNacimiento, $añoNacimiento)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'El valor especificado debe ser una fecha valida en formato YYYY-MM-DD.'
                ]);
            } else {
                $esCorrectoFechaDeNacimiento = 1;
            }
        }
    }

    if (($esCorrectoNombre == 1) && ($esCorrectoEmail == 1) && ($esCorrectoContrasena == 1) && ($esCorrectoPais == 1) && ($esCorrectoFechaDeNacimiento == 1)) {
        $consulta = mysqli_query(CONN, "INSERT INTO Usuarios (nombreUsuario, email, contrasena, telefono, pais, fecha_de_nacimiento, foto_de_perfil, rango, fecha_de_creacion, tema, color_preferido) VALUES ('".$nombre."', '".$email."', '".$contrasena."', NULL, '".$pais."', '".$añoNacimiento."-".$mesNacimiento."-".$diaNacimiento."', NULL, 0, CURDATE(), 0, 0);");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios ORDER BY idUsuario DESC LIMIT 0, 1;");
            if ($consulta == false) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'La consulta MySQL tuvo un error.'
                ]);
            } else {
                while ($fila = mysqli_fetch_assoc($consulta)) {
                    array_push($resultados, [
                        'id' => $fila['idUsuario'],
                        'nombre' => $fila['nombreUsuario'],
                        'email' => $fila['email'],
                        'contrasena' => $fila['contrasena'],
                        'telefono' => $fila['telefono'],
                        'pais' => $fila['pais'],
                        'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                        'fotoDePerfil' => $fila['foto_de_perfil'],
                        'rango' => $fila['rango'],
                        'fechaDeCreacion' => $fila['fecha_de_creacion'],
                        'tema' => $fila['tema'],
                        'colorPreferido' => $fila['color_preferido']
                        ]);
                }

                return json_encode($resultados);
            }
        }
    }
}

function eliminarUsuario($id) {
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
                $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios WHERE idUsuario = ".$id.";");
                if ($consulta == false) {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'La consulta MySQL tuvo un error.'
                    ]);
                } else {
                    while ($fila = mysqli_fetch_assoc($consulta)) {
                        array_push($resultados, [
                            'id' => $fila['idUsuario'],
                            'nombre' => $fila['nombreUsuario'],
                            'email' => $fila['email'],
                            'contrasena' => $fila['contrasena'],
                            'telefono' => $fila['telefono'],
                            'pais' => $fila['pais'],
                            'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                            'fotoDePerfil' => $fila['foto_de_perfil'],
                            'rango' => $fila['rango'],
                            'fechaDeCreacion' => $fila['fecha_de_creacion'],
                            'tema' => $fila['tema'],
                            'colorPreferido' => $fila['color_preferido']
                            ]);
                    }

                    if (empty($resultados)) {
                        return json_encode([
                            'ok' => false,
                            'msg' => 'No se encontraron usuarios con la id '.$id.'.'
                        ]);
                    } else {
                        unset($resultados);
                        $resultados = [];
                        $consulta = mysqli_query(CONN, "DELETE FROM Usuarios WHERE idUsuario = ".$id.";");
                        if ($consulta == false) {
                            return json_encode([
                                'ok' => false,
                                'msg' => 'La consulta MySQL tuvo un error.'
                            ]);
                        } else {
                            $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios WHERE idUsuario = ".$id.";");
                            if ($consulta == false) {
                                return json_encode([
                                    'ok' => false,
                                    'msg' => 'La consulta MySQL tuvo un error.'
                                ]);
                            } else {
                                while ($fila = mysqli_fetch_assoc($consulta)) {
                                    array_push($resultados, [
                                        'id' => $fila['idUsuario'],
                                        'nombre' => $fila['nombreUsuario'],
                                        'email' => $fila['email'],
                                        'contrasena' => $fila['contrasena'],
                                        'telefono' => $fila['telefono'],
                                        'pais' => $fila['pais'],
                                        'fechaDeNacimiento' => $fila['fecha_de_nacimiento'],
                                        'fotoDePerfil' => $fila['foto_de_perfil'],
                                        'rango' => $fila['rango'],
                                        'fechaDeCreacion' => $fila['fecha_de_creacion'],
                                        'tema' => $fila['tema'],
                                        'colorPreferido' => $fila['color_preferido']
                                        ]);
                                }

                                if (!empty($resultados)) {
                                    return json_encode([
                                        'ok' => false,
                                        'msg' => 'No se pudo eliminar el usuario de id '.$id.'.'
                                    ]);
                                } else {
                                    return json_encode([
                                        'ok' => true,
                                        'msg' => 'Se eliminó el usuario de id '.$id.' con éxito.'
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

function iniciarSesion($username, $contrasena) {
    $resultados = [];

    $esCorrectoUsername = 0;
    $esCorrectoContrasena = 0;

    if (!isset($username)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "username".'
        ]);
    } else {
        if (is_numeric($username)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "username" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoUsername = 1;
        }
    }

    if (!isset($contrasena)) {
        return json_encode([
            'ok' => false,
            'msg' => 'Es obligatorio especificar un valor para "contrasena".'
        ]);
    } else {
        if (is_numeric($contrasena)) {
            return json_encode([
                'ok' => false,
                'msg' => 'El valor especificado en "contrasena" debe ser de tipo texto.'
            ]);
        } else {
            $esCorrectoContrasena = 1;
        }
    }

    if (($esCorrectoUsername == 1) && ($esCorrectoContrasena == 1)) {
        $consulta = mysqli_query(CONN, "SELECT * FROM Usuarios WHERE nombreUsuario = '".$username."';");
        if ($consulta == false) {
            return json_encode([
                'ok' => false,
                'msg' => 'La consulta MySQL tuvo un error.'
            ]);
        } else {
            while ($fila = mysqli_fetch_assoc($consulta)) {
                array_push($resultados, [
                    'id' => $fila['idUsuario'],
                    'rango' => $fila['rango'],
                    'username' => $fila['nombreUsuario'],
                    'contrasena' => $fila['contrasena']
                    ]);
            }

            if (empty($resultados)) {
                return json_encode([
                    'ok' => false,
                    'msg' => 'No se encontraron usuarios con el nombre de usuario '.$username.'.'
                ]);
            } else {
                if ($resultados[0]['contrasena'] == $contrasena) {
                    return json_encode([
                        'ok' => true,
                        'info' => [
                            'id' => $resultados[0]['id'],
                            'rango' => $resultados[0]['rango']
                        ]
                    ]);
                } else {
                    return json_encode([
                        'ok' => false,
                        'msg' => 'No se pudo iniciar sesión, contraseña incorrecta.'
                    ]);
                }
            }
        }
    }
}

?>