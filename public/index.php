<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\UniversidadController;
use App\Controller\EnvioController;

$modulo = $_GET['punto'] ?? 'estudiantes';

switch ($modulo) {
    case 'envios':
        $controller = new EnvioController();
        break;

    default:
        $controller = new UniversidadController();
        break;
}

$controller->index();