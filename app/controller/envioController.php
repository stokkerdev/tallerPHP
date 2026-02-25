<?php

namespace App\Controller;

use App\Model\Envio;
use App\Model\Mensajera;

class EnvioController
{
    public function index()
    {
        $empresa = new Mensajera();

        /*
            $empresa->addEnvio(new Envio(1, "Bogotá", "Carlos", 10, 5000, "entregado"));
            $empresa->addEnvio(new Envio(2, "Medellín", "Ana", 5, 4000, "ruta"));
            $empresa->addEnvio(new Envio(3, "Bogotá", "Carlos", 7, 5000, "entregado"));
            $empresa->addEnvio(new Envio(4, "Cali", "Luis", 20, 3000, "entregado"));
            $empresa->addEnvio(new Envio(5, "Medellín", "Ana", 15, 4000, "ruta"));
            $empresa->addEnvio(new Envio(6, "Bogotá", "Carlos", 12, 5000, "entregado"));
     */
        $totalEntregados = $empresa->getCostoTotalEntregados();
        $ciudadMayorPeso = $empresa->ciudadMayorPeso();
        $mejorTransportista = $empresa->mejorTransportista();

        require __DIR__ . '/../View/envios.view.php';
    }
}