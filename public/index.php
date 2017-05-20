<?php

require '../vendor/autoload.php';
require '../slimapp.class.php';

$configuration = [
  'settings' => [
    'displayErrorDetails' => true,
  ],
];
$c   = new \Slim\Container($configuration);
$app = new \Slim\App($c);

//funciona!!!
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
  "path"   => "/api",
  "secure" => false,
  "users"  => [
    "root" => "root",
  ],
  "error"  => function ($request, $response, $arguments) {
    $data            = [];
    $data["status"]  = "error";
    $data["message"] = $arguments["message"];
    return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
  },
]));

//routes
// require "../controller/WSEmpleado.php";
// require "../controller/WSLocal.php";
// require "../controller/WSCategoria.php";
require "../controller/WSFuncion.php";
require "../controller/WSCompra.php";
require "../controller/WSAsientosReservados.php";
require "../controller/WSSalaAsientos.php";
require "../controller/WSPelicula.php";
require "../controller/WSSala.php";
require "../controller/WSSucursal.php";

$app->run();
