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

/**
 * POST
 * Usado por la página
 */
$app->post('/api/asientos_reservados/add/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $asientos_reservados = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'cliente_id' => $request->getParam('cliente_id'),
          'asiento_id' => $request->getParam('asiento_id'),
          'sala_id'    => $request->getParam('sala_id'),
          'funcion_id' => $request->getParam('funcion_id'),
        );
        $web = new AsientosReservados;
        $web->setDatos($datos);
        $asientos_reservados = $web->insAsientos();
      } else {
        $asientos_reservados = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos_reservados));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * PUT UPDATE
 */
$app->put('/api/asientos_reservados/update/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $asientos_reservados = array('status' => "No se pudo actualizar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'asientos_reservados_id' => $request->getParam('asientos_reservados_id'),
          'pelicula_id'            => $request->getParam('pelicula_id'),
          'sala_id'                => $request->getParam('sala_id'),
          'fecha'                  => $request->getParam('fecha'),
          'hora'                   => $request->getParam('hora'),
          'fecha_fin'              => $request->getParam('fecha_fin'),
          'hora_fin'               => $request->getParam('hora_fin'),
        );
        $web = new Funcion;
        $web->setDatos($datos);
        $asientos_reservados = $web->updFuncion();
      } else {
        $asientos_reservados = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos_reservados));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * DELETE
 */
$app->delete('/api/asientos_reservados/delete/{idFun}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $asientos_reservados = array('status' => "No se pudo eliminar");
      if ($bitacora->validaToken()) {
        $web = new Funcion;
        $web->setFuncionId($request->getAttribute('idFun'));
        $web->delFuncion();
        $asientos_reservados = array('status' => "Eliminado");
      } else {
        $asientos_reservados = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos_reservados));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
