<?php

require 'slimapp.class.php';
$web = new Funcion;
$web->setFuncionId(1);
$funcion = $web->getFuncionById();

$web = new Pelicula;
$web->setPeliculaId($funcion[0]['pelicula_id']);
$funcion['pelicula'] = $web->getSimplePelicula();

$web = new Sala;
$web->setSalaId($funcion[0]['sala_id']);
$funcion['sala'] = $web->getSala();

$web->debug($funcion);
