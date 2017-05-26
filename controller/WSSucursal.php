<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SUCURSALES, con un LÍMITE DE TIEMPO
 */
$app->get('/api/sucursal/listado/app',
  function (Request $request, Response $response) {

    try {
      $web        = new Sucursal;
      $sucursales = $web->getListApp();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursales));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL SUCURSALES, SIN un LÍMITE DE TIEMPO
 */
$app->get('/api/sucursal/listado/app/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursales = array('status' => "No se pudo obtener la sucursal");
      if ($bitacora->validaToken()) {
        $web        = new Sucursal;
        $sucursales = $web->getListado();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursales));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL SUCURSALES, sin un LÍMITE DE TIEMPO
 * usado por la página web
 */
$app->get('/api/sucursal/listado/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora();
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursales = array('status' => "No se pudieron obtener las sucursales");
      if ($bitacora->validaToken()) {
        $web        = new Sucursal;
        $sucursales = $web->getListado();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursales));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL CON LÍMITE DE TIEMPO
 */
$app->get('/api/sucursal/ver/{idSuc}',
  function (Request $request, Response $response) {

    try {
      $web = new Sucursal;
      $web->setSucursalId($request->getAttribute('idSuc'));
      $sucursal = $web->getSucursalApp();

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursal));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE SUCURSAL SIN LÍMITE DE TIEMPO
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

/**
 * POST
 */
$app->post('/api/sucursal/add/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursal = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'pais'      => $request->getParam('pais'),
          'ciudad'    => $request->getParam('ciudad'),
          'direccion' => $request->getParam('direccion'),
          'latitud'   => $request->getParam('latitud'),
          'longitud'  => $request->getParam('longitud'),
        );

        $web = new Sucursal;
        $web->setDatos($datos);
        $sucursal = $web->insSucursal();

      } else {
        $sucursal = array('status' => "token no valido");
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursal));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * PUT UPDATE
 */
$app->put('/api/sucursal/update/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursal = array('status' => "No se pudo actualizar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'sucursal_id' => $request->getParam('sucursal_id'),
          'pais'        => $request->getParam('pais'),
          'ciudad'      => $request->getParam('ciudad'),
          'direccion'   => $request->getParam('direccion'),
          'latitud'     => $request->getParam('latitud'),
          'longitud'    => $request->getParam('longitud'),
        );

        $web = new Sucursal;
        $web->setDatos($datos);
        $sucursal = $web->updSucursal();

      } else {
        $sucursal = array('status' => "token no valido");
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursal));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * DELETE
 */
$app->delete('/api/sucursal/delete/{idSuc}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sucursal = array('status' => "No se pudo eliminar");
      if ($bitacora->validaToken()) {
        $web = new Sucursal;
        $web->setSucursalId($request->getAttribute('idSuc'));
        $web->delSucursal();
        $sucursal = array('status' => "Eliminado");

      } else {
        $sucursal = array('status' => "token no valido");

      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sucursal));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
