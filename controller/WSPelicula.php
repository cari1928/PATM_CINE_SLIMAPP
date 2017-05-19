<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SALAS
 * necesario para que se queden los 'use'
 */
$app->get('/api/pelicula/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $peliculas = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web       = new Pelicula;
        $peliculas = $web->getListadoP();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($peliculas));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL
 */
$app->get('/api/pelicula/ver/{idPeli}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $pelicula = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new Pelicula;
        $web->setPeliculaId($request->getAttribute('idPeli'));
        $pelicula = $web->getPelicula();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($pelicula));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
