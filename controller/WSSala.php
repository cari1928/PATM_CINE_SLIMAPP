<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SALAS
 * necesario para que se queden los 'use'
 */
$app->get('/api/sala/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $salas = array('status' => "No se pudo obtener la lista");
      if ($bitacora->validaToken()) {
        $web   = new Sala;
        $salas = $web->getListadoS();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($salas));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL
 */
$app->get('/api/sala/ver/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sala = array('status' => "No se pudo obtener la sala");
      if ($bitacora->validaToken()) {
        $web = new Sala;
        $web->setSalaId($request->getAttribute('idSala'));
        $sala = $web->getSala();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
