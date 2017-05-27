<?php

require 'slimapp.class.php';

$web->conexion();

$datos = array(
  'cliente_id'  => 27,
  'funcion_id'  => 6,
  'empleado_id' => 8,
  'total'       => 60,
  'entradas'    => 1,
  'tipo_pago'   => "Tarjeta",
);

$web = new Compra;
$web->setDatos($datos);
$compra = $web->insCompra();

$web->debug($compra);
