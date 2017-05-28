<?php

require 'slimapp.class.php';

$web   = new Especial;
$datos = $web->getListFunApp();
$web->debug($datos);
