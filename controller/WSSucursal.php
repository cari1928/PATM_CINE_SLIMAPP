<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SUCURSALES
 * necesario para que se queden los 'use'
 */
$app->get('/api/sucursal/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursales = array('status' => "No se pudo obtener la lista");
      if ($bitacora->validaToken()) {
        $web        = new Sucursal;
        $sucursales = $web->getListadoS();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursales));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL
 */
$app->get('/api/sucursal/ver/{idSuc}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursal = array('status' => "No se pudo obtener la sucursal");
      if ($bitacora->validaToken()) {
        $web = new Sucursal;
        $web->setSucursalId($request->getAttribute('idSuc'));
        $sucursal = $web->getSucursal();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursal));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
