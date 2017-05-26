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
 * Usado por la página
 */
$app->get('/api/sala/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora();
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $salas = array('status' => "No se pudieron obtener las salas");
      if ($bitacora->validaToken()) {
        $web   = new Sala;
        $salas = $web->getListado();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($salas));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SALA, CON LÍMITE DE TIEMPO
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
$app->get('/api/sala/ver/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora();
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sala = array('status' => "No se pudieron obtener las sucursales");
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

/**
 * POST
 * Usado por la página
 */
$app->post('/api/sala/add/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sala = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'nombre'      => $request->getParam('nombre'),
          'num_filas'   => $request->getParam('num_filas'),
          'num_cols'    => $request->getParam('num_cols'),
          'sucursal_id' => $request->getParam('sucursal_id'),
          'numero_sala' => $request->getParam('numero_sala'),
        );

        $web = new Sala;
        $web->setDatos($datos);
        $sala = $web->insSala();

      } else {
        $sala = array('status' => "token no valido");
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * PUT UPDATE
 */
$app->put('/api/sala/update/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sala = array('status' => "No se pudo actualizar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'sala_id'     => $request->getParam('sala_id'),
          'nombre'      => $request->getParam('nombre'),
          'num_filas'   => $request->getParam('num_filas'),
          'num_cols'    => $request->getParam('num_cols'),
          'sucursal_id' => $request->getParam('sucursal_id'),
          'numero_sala' => $request->getParam('numero_sala'),
        );
        $web = new Sala;
        $web->setDatos($datos);
        $sala = $web->updSala();
      } else {
        $sala = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * DELETE
 */
$app->delete('/api/sala/delete/{idSuc}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $sala = array('status' => "No se pudo eliminar");
      if ($bitacora->validaToken()) {
        $web = new Sala;
        $web->setSalaId($request->getAttribute('idSuc'));
        $web->delSala();
        $sala = array('status' => "Eliminado");
      } else {
        $sala = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
