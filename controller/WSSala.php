<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SALAS, CON UN LÍMITE DE TIEMPO
 * necesario para que se queden los 'use'
 */
$app->get('/api/sala/listado/app',
  function (Request $request, Response $response) {

    try {
      $web   = new Sala;
      $salas = $web->getListApp();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($salas));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL SALAS, SIN UN LÍMITE DE TIEMPO
 * necesario para que se queden los 'use'
 */
$app->get('/api/sala/listado',
  function (Request $request, Response $response) {

    try {
      $web   = new Sala;
      $salas = $web->getListado();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($salas));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL, CON LÍMITE DE TIEMPO
 */
$app->get('/api/sala/ver/app/{idSala}',
  function (Request $request, Response $response) {

    try {
      $web = new Sala;
      $web->setSalaId($request->getAttribute('idSala'));
      $sala = $web->getSalaApp();

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL, SIN LÍMITE DE TIEMPO
 */
$app->get('/api/sala/ver/{idSala}',
  function (Request $request, Response $response) {

    try {
      $web = new Sala;
      $web->setSalaId($request->getAttribute('idSala'));
      $sala = $web->getSala();

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
