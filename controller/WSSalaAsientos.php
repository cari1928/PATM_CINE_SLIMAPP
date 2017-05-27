<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SALA-ASIENTOS
 */
$app->get('/api/sala_asientos/listado/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setSalaId($request->getAttribute('idSala'));
        $asientos = $web->getListadoSA();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL SALA-ASIENTOS
 * usado por la página web
 */
$app->get('/api/sala_asientos/disponibles/{idSuc}/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setSucursalId($request->getAttribute('idSuc'));
        $web->setSalaId($request->getAttribute('idSala'));
        $asientos = $web->getDesocupados();
      }
      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SALA-ASIENTO
 */
$app->get('/api/sala_asientos/ver/{idSala}/{idAsi}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sala_asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setSalaId($request->getAttribute('idSala'));
        $web->setAsientoId($request->getAttribute('idAsi'));
        $sala_asientos = $web->getSalaAsientos();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala_asientos));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
