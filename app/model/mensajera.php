<?php

namespace App\Model;

class Mensajera
{

    private $arregloEnvios = [];

    public function addEnvio($envio)
    {
        $this->arregloEnvios[] = $envio;
    }

    public function getEnvio()
    {

        return $this->arregloEnvios;
    }

    public function getCostoTotalEntregados()
    {
        $costoTotal = 0;

        foreach ($this->arregloEnvios as $envio) {
            if ($envio->getEstado() == 'entregado') {
                $costoTotal += $envio->getCostoTotal();
            }
        }

        return $costoTotal;
    }


    public function ciudadMayorPeso()
    {
        $pesos = [];

        foreach ($this->arregloEnvios as $envio) {
            $ciudad = $envio->getDestino();
            $pesos[$ciudad] = ($pesos[$ciudad] ?? 0) + $envio->getPeso();
        }

        arsort($pesos);

        return key($pesos);
    }


    public function mejorTransportista()
    {
        $conteo = [];

        foreach ($this->arregloEnvios as $envio) {
            if ($envio->getEstado() === "entregado") {
                $t = $envio->getTransportista();
                $conteo[$t] = ($conteo[$t] ?? 0) + 1;
            }
        }

        arsort($conteo);

        return key($conteo);
    }

    public function getCantidadEntregas($transportista)
    {
        $conteo = 0;

        foreach ($this->arregloEnvios as $envio) {
            if ($envio->getEstado() === "entregado" && $envio->getTransportista() === $transportista) {
                $conteo++;
            }
        }

        return $conteo;
    }


    public function getPesoTotalCiudad($ciudad)
    {
        $pesoTotal = 0;

        foreach ($this->arregloEnvios as $envio) {
            if ($envio->getDestino() === $ciudad) {
                $pesoTotal += $envio->getPeso();
            }
        }

        return $pesoTotal;
    }
}