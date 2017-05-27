<?php

require 'slimapp.class.php';

$web = new SalaAsientos;
$web->setFuncionId(2);
$web->setSucursalId(1);
$web->setSalaId(2);
$asientos = $web->getDesocupados();

$web->debug($asientos);
