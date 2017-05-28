<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL FUNCIONES, CON RESTRICCIÓN DE TIEMPO
 */
$app->get('/api/especial/listado/app',
  function (Request $request, Response $response) {

    try {
      $web   = new Especial;
      $datos = $web->getListFunApp();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($datos));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL ASIENTOS SALAS Y RESERVADOS, CON RESTRICCIÓN DE TIEMPO
 */
$app->get('/api/especial/listado/asientos/app/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $pelicula = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $web   = new Especial;
        $datos = $web->getListFunApp();
      }
      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($datos));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
