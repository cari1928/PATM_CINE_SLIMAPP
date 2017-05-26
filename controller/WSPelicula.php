<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL PELICULAS
 * necesario para que se queden los 'use'
 */
$app->get('/api/pelicula/listado',
  function (Request $request, Response $response) {
    try {
      $web       = new Pelicula;
      $peliculas = $web->getListadoP();
      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($peliculas));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET SINGLE PELICULA
 */
$app->get('/api/pelicula/ver/{idPeli}',
  function (Request $request, Response $response) {
    try {
      $pelicula = array('status' => "token no valido");
      $web      = new Pelicula;
      $web->setPeliculaId($request->getAttribute('idPeli'));
      $pelicula = $web->getPelicula();
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($pelicula));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * POST
 * Usado por la página
 */
$app->post('/api/pelicula/add/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $pelicula = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'titulo'        => $request->getParam('titulo'),
          'descripcion'   => $request->getParam('descripcion'),
          'f_lanzamiento' => $request->getParam('f_lanzamiento'),
          'lenguaje'      => $request->getParam('lenguaje'),
          'duracion'      => $request->getParam('duracion'),
          'poster'        => $request->getParam('poster'),
        );
        $web = new Pelicula;
        $web->setDatos($datos);
        $pelicula = $web->insPelicula();
      } else {
        $pelicula = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($pelicula));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * PUT UPDATE
 */
$app->put('/api/pelicula/update/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $pelicula = array('status' => "No se pudo actualizar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'pelicula_id'   => $request->getParam('pelicula_id'),
          'titulo'        => $request->getParam('titulo'),
          'descripcion'   => $request->getParam('descripcion'),
          'f_lanzamiento' => $request->getParam('f_lanzamiento'),
          'lenguaje'      => $request->getParam('lenguaje'),
          'duracion'      => $request->getParam('duracion'),
          'poster'        => $request->getParam('poster'),
        );
        $web = new Pelicula;
        $web->setDatos($datos);
        $pelicula = $web->updPelicula();
      } else {
        $pelicula = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($pelicula));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * DELETE
 */
$app->delete('/api/pelicula/delete/{idPel}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $pelicula = array('status' => "No se pudo eliminar");
      if ($bitacora->validaToken()) {
        $web = new Pelicula;
        $web->setPeliculaId($request->getAttribute('idPel'));
        $web->delPelicula();
        $pelicula = array('status' => "Eliminado");
      } else {
        $pelicula = array('status' => "token no valido");
      }
      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($pelicula));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });
