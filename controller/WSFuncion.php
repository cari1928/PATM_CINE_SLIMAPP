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
$app->get('/api/funcion/listado/{idPeli}',
  function (Request $request, Response $response) {

    try {
      $funciones = array('status' => "token no valido");
      $web       = new Funcion;
      $web->setPeliculaId($request->getAttribute('idPeli'));
      $funciones = $web->getListadoF();

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
