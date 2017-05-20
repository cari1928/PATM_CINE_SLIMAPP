<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL PELICULAS
 * necesario para que se queden los 'use'
 */
$app->get('/api/pelicula/listado',
  function (Request $request, Response $response) {

    try {
      $web       = new Pelicula;
      $peliculas = $web->getListadoP();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($peliculas));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE PELICULA
 */
$app->get('/api/pelicula/ver/{idPeli}',
  function (Request $request, Response $response) {

    try {
      $pelicula = array('status' => "token no valido");
      $web      = new Pelicula;
      $web->setPeliculaId($request->getAttribute('idPeli'));
      $pelicula = $web->getPelicula();

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($pelicula));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
