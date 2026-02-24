<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\UniversidadController;

$controller = new UniversidadController();
$controller->index();