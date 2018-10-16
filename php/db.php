<?php

require_once('credenciales.php');

// Conexión a la BBDD
function DB_connection() {
    $db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_DATABASE);
    if (!$db) {
        echo "<p>Error de conexión</p>";
        echo "<p>Código: ".mysqli_connect_errno()."</p>";
        echo "<p>Mensaje: ".mysqli_connect_error()."</p>";
        return false;
    }

    // Establecer la codificación de los datos almacenados ("collation")
    mysqli_set_charset($db,"utf8");
    return $db;
}


// Desconexión de la BBDD
function DB_disconnection($db) {
    mysqli_close($db);
}


// Consulta para obtener listado de ciudades
function DB_query($db, $query, $select=true) {
    $res = mysqli_query($db, $query);
    if ($res !== false) {     // Si no hay error
        if ($select) {      // si la consulta es de tipo select
            if (mysqli_num_rows($res) > 0) {      // Si hay alguna tupla de respuesta
                $tabla = mysqli_fetch_all($res, MYSQLI_ASSOC);
                DB_htmlspecialchars($db, $tabla);
            } else {        // No hay resultados para la consulta
                $tabla = [];
            }
            mysqli_free_result($res);       // Liberar memoria de la consulta
        }
        else {
            $tabla = true;
        }
    } else {        // Error en la consulta
        $tabla = false;
    }
    return $tabla;
}


// Crea conexión con la BBDD, hace la consulta y desconecta
function DB_execute($query, $select=true) {
    $db = DB_connection();
    $result = DB_query($db, $query, $select);
    DB_disconnection($db);

    return $result;
}


// Escapa cualquier parámetro que se le pase por argumento para su correcto uso en BBDD.
// El primer argumento debe ser el enlace de conexión
function DB_escape(&...$args) {
    $db = $args[0];

    for ($i=1; $i<count($args); $i++){

        if ( is_array($args[$i]) )
            foreach ($args[$i] as $key => $value)
                $args[$i][$key] = mysqli_real_escape_string($db, $args[$i][$key]);
        else if (is_string($args[$i]))
            $args[$i] = mysqli_real_escape_string($db, $args[$i]);
    }
}


// Escapa cualquier string saliente de BBDD
function DB_htmlspecialchars($db, &$result) {
    for ($i=0; $i<count($result); $i++)
        foreach ($result[$i] as $key => $value)
            if (is_string($result[$i][$key]))
                $result[$i][$key] = htmlspecialchars($result[$i][$key]);
}

?>