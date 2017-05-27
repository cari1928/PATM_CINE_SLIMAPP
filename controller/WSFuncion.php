<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL FUNCIONES, CON RESTRICCIÓN DE TIEMPO
 */
$app->get('/api/funcion/listado/app',
  function (Request $request, Response $response) {

    try {
      $web       = new Funcion;
      $funciones = $web->getListFunApp();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($funciones));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL FUNCIONES EN BASE A UNA PELÍCULA
 * SIN RESTRICCIÓN DE TIEMPO
 */
$app->get('/api/funcion/listado',
  function (Request $request, Response $response) {

    try {
      $funciones = array('status' => "token no valido");
      $web       = new Funcion;
      $web->setPeliculaId($request->getAttribute('idPeli'));
      $funciones = $web->getListado();

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($funciones));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE FUNCION, CON LÍMITE DE TIEMPO
 */
$app->get('/api/funcion/ver/app/{idFun}',
  function (Request $request, Response $response) {

    try {
      $web = new Funcion;
      $web->setFuncionId($request->getAttribute('idFun'));
      $sala = $web->getFuncionById();

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE FUNCION, SIN LÍMITE DE TIEMPO
 * Usado por la página
 */
$app->get('/api/funcion/ver/{idFun}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $funcion = array('status' => "ERROR-OBTENER-VALORES-O-TOKEN");
      if ($bitacora->validaToken()) {
        $web = new Funcion;
        $web->setFuncionId($request->getAttribute('idFun'));
        $funcion = $web->getFuncionById();
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($funcion));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * POST
 * Usado por la página
 */
$app->post('/api/funcion/add/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $funcion = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'pelicula_id' => $request->getParam('pelicula_id'),
          'sala_id'     => $request->getParam('sala_id'),
          'fecha'       => $request->getParam('fecha'),
          'hora'        => $request->getParam('hora'),
          'fecha_fin'   => $request->getParam('fecha_fin'),
          'hora_fin'    => $request->getParam('hora_fin'),
        );
        $web = new Funcion;
        $web->setDatos($datos);
        $funcion = $web->insFuncion();
      } else {
        $funcion = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($funcion));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * PUT UPDATE
 */
$app->put('/api/funcion/update/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $funcion = array('status' => "No se pudo actualizar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'funcion_id'  => $request->getParam('funcion_id'),
          'pelicula_id' => $request->getParam('pelicula_id'),
          'sala_id'     => $request->getParam('sala_id'),
          'fecha'       => $request->getParam('fecha'),
          'hora'        => $request->getParam('hora'),
          'fecha_fin'   => $request->getParam('fecha_fin'),
          'hora_fin'    => $request->getParam('hora_fin'),
        );
        $web = new Funcion;
        $web->setDatos($datos);
        $funcion = $web->updFuncion();
      } else {
        $funcion = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($funcion));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * DELETE
 */
$app->delete('/api/funcion/delete/{idFun}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $funcion = array('status' => "No se pudo eliminar");
      if ($bitacora->validaToken()) {
        $web = new Funcion;
        $web->setFuncionId($request->getAttribute('idFun'));
        $web->delFuncion();
        $funcion = array('status' => "Eliminado");
      } else {
        $funcion = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($funcion));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
