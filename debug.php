<?php

require 'slimapp.class.php';
$web   = new Sala;
$datos = array(
  'sala_id'   => 1,
  'pais'      => $request->getParam('pais'),
  'ciudad'    => $request->getParam('ciudad'),
  'direccion' => $request->getParam('direccion'),
  'latitud'   => $request->getParam('latitud'),
  'longitud'  => $request->getParam('longitud'),
);
$web->setDatos($datos);
$sala = $web->updSala();
$web->debug($sala);
