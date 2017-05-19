<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SALA-ASIENTOS
 * necesario para que se queden los 'use'
 */
$app->get('/api/asientos_reservados/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web      = new AsientosReservados;
        $asientos = $web->getListadoAR();
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
$app->get('/api/asientos_reservados/ver/{idSala}/{idAsi}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $asientos_reservados = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new AsientosReservados;
        $web->setClienteId($request->getAttribute('idPer'));
        $web->setSalaId($request->getAttribute('idSala'));
        $web->setAsientoId($request->getAttribute('idAsi'));
        $asientos_reservados = $web->getAsientoReservado();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos_reservados));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
