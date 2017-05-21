<?php

require 'slimapp.class.php';
// $web = new Sala;
$web->conexion();

$query = "SELECT * FROM funcion
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time)
    OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
$funciones = $web->fetchAll($query);

// echo $query;
// $web->debug($funciones);

$query = "SELECT DISTINCT pelicula.pelicula_id, titulo, descripcion, f_lanzamiento, lenguaje, duracion, poster
    FROM pelicula
    INNER JOIN funcion ON funcion.pelicula_id = pelicula.pelicula_id
    WHERE now() BETWEEN fecha AND fecha_fin AND
    (hora > (now()::time) OR
    (now()::time) < (hora_fin - ('00:30:0'::time)))
    ORDER BY titulo";
$peliculas = $web->fetchAll($query);

// echo $query;
// $web->debug($peliculas);

$query = "SELECT DISTINCT sala.sala_id, nombre, sucursal_id, numero_sala
    FROM sala
    INNER JOIN funcion ON funcion.sala_id = sala.sala_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time)
    OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
$salas = $web->fetchAll($query);

// echo $query;
// $web->debug($salas);

$query = "SELECT DISTINCT sucursal.sucursal_id, pais, ciudad, direccion, latitud, longitud
    FROM sucursal
    INNER JOIN sala ON sala.sucursal_id = sucursal.sucursal_id
    INNER JOIN funcion ON funcion.sala_id = sala.sala_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))
    ORDER BY sucursal.sucursal_id";
$sucursales = $web->fetchAll($query);

// echo $query;
// $web->debug($sucursales);

$datos = array(
  'peliculas'  => $peliculas,
  'funciones'  => $funciones,
  'sucursales' => $sucursales,
  'salas'      => $salas,
);

// $web->debug($datos);
$p = json_encode($datos);
echo $p;
