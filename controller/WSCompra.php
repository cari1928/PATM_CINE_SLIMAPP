<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL COMPRAS
 * necesario para que se queden los 'use'
 */
$app->get('/api/compra/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $compras = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web     = new Compra;
        $compras = $web->getListadoC();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($compras));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL COMPRAS BY CLIENTE_ID
 * necesario para que se queden los 'use'
 */
$app->get('/api/compra/listado/cliente/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $compras = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new Compra;
        $web->setClienteId($request->getAttribute('idPer'));
        $compras = $web->getListadoById();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($compras));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE COMPRA
 */
$app->get('/api/compra/ver/{idCom}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $compra = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new Compra;
        $web->setCompraId($request->getAttribute('idCom'));
        $web->setClienteId($request->getAttribute('idPer'));
        $compra = $web->getCompra();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($compra));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * POST ADD COMPRA
 */
$app->post('/api/compra/add/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $compra = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'cliente_id'  => $request->getParam('cliente_id'),
          'funcion_id'  => $request->getParam('funcion_id'),
          'fecha'       => $request->getParam('fecha'),
          'empleado_id' => $request->getParam('empleado_id'),
          'total'       => $request->getParam('total'),
          'entradas'    => $request->getParam('entradas'),
          'tipo_pago'   => $request->getParam('tipo_pago'),
        );

        $web = new Compra;
        $web->setDatos($datos);
        $compra = $web->insCompra();

      } else {
        $compra = array('status' => "token no valido");
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($compra));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * PUT UPDATE COMPRA
 */
$app->put('/api/compra/update/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $compra = array('status' => "No se pudo actualizar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'compra_id'   => $request->getParam('compra_id'),
          'cliente_id'  => $request->getParam('cliente_id'),
          'funcion_id'  => $request->getParam('funcion_id'),
          'fecha'       => $request->getParam('fecha'),
          'empleado_id' => $request->getParam('empleado_id'),
          'total'       => $request->getParam('total'),
          'entradas'    => $request->getParam('entradas'),
          'tipo_pago'   => $request->getParam('tipo_pago'),
        );

        $web = new Compra;
        $web->setDatos($datos);
        $compra = $web->updCompra();

      } else {
        $compra = array('status' => "token no valido");
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($compra));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * DELETE COMPRA
 */
$app->delete('/api/compra/delete/{idCom}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $compra = array('status' => "No se pudo eliminar");
      if ($bitacora->validaToken()) {
        $web = new Compra;
        $web->setCompraId($request->getAttribute('idCom'));
        $web->delCompra();
        $compra = array('status' => "Eliminado");

      } else {
        $compra = array('status' => "token no valido");

      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($compra));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
