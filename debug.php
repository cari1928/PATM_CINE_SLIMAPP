<?php

require 'slimapp.class.php';
$web = new Sala;
$web->conexion();
$query = "SELECT DISTINCT sala.sala_id, nombre, sucursal_id, numero_sala
FROM sala
INNER JOIN funcion ON funcion.sala_id = sala.sala_id
WHERE (now()::time) < (hora_fin - ('00:30:0'::time)))";
$salas = $web->fetchAll($query);

echo $query;
$web->debug($salas);
