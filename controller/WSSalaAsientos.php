<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * GET ALL SALA-ASIENTOS
 * MEDIANTE SALA_ID
 */
$app->get('/api/sala_asientos/listado/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setSalaId($request->getAttribute('idSala'));
        $asientos = $web->getListadoSA();
      }

      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL SALA-ASIENTOS
 * MEDIANTE FUNCION ID, SUCURSAL ID, SALA ID
 * usado por la página web
 */
$app->get('/api/sala_asientos/disponibles/{idFun}/{idSuc}/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setFuncionId($request->getAttribute('idFun'));
        $web->setSucursalId($request->getAttribute('idSuc'));
        $web->setSalaId($request->getAttribute('idSala'));
        $asientos = $web->getDesocupados();
      }
      return $response
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($asientos));
    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * GET ALL SALA-ASIENTOS
 * MEDIANTE FUNCION ID, SUCURSAL ID, SALA ID
 * usado por la página web
 */
$app->get('/api/sala_asientos/disponiblesApp/{idFun}/{idSuc}/{idSala}/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setFuncionId($request->getAttribute('idFun'));
        $web->setSucursalId($request->getAttribute('idSuc'));
        $web->setSalaId($request->getAttribute('idSala'));
        $asientos = $web->getDesocupadosApp();
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
 * MEDIANTE SALA ID Y ASIENTO ID
 */
$app->get('/api/sala_asientos/ver/{idSala}/{idAsi}/{idPer}/{token}',
  function (Request $request, Response $response) {

    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));

      $sala_asientos = array('status' => "token no valido");
      if ($bitacora->validaToken()) {
        $web = new SalaAsientos;
        $web->setSalaId($request->getAttribute('idSala'));
        $web->setAsientoId($request->getAttribute('idAsi'));
        $sala_asientos = $web->getSalaAsientos();
      }

      return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($sala_asientos));

    } catch (PDOException $e) {
      echo '{"error" : {"text" : ' . $e->getMessage() . '}}';
    }
  });

/**
 * POST
 * Usado por la página
 */
$app->post('/api/sala_asientos/add/{idPer}/{token}',
  function (Request $request, Response $response) {
    try {
      $bitacora = new Bitacora;
      $bitacora->setPersonaId($request->getAttribute('idPer'));
      $bitacora->setToken($request->getAttribute('token'));
      $sala = array('status' => "No se pudo insertar");
      if ($bitacora->validaToken()) {
        $datos = array(
          'columna'    => $request->getParam('columna'),
          'fila'       => $request->getParam('fila'),
          'sala_id'    => $request->getParam('sala_id'),
          'funcion_id' => $request->getParam('funcion_id'),
        );

        $web = new SalaAsientos;
        $web->setDatos($datos);
        $sala = $web->insAsiento();

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
$app->put('/api/sala_asientos/update/{idPer}/{token}',
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
$app->delete('/api/sala_asientos/delete/{idSuc}/{idPer}/{token}',
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
