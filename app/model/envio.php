<?php

namespace App\Model;

class Envio
{
    private $id;
    private $destino;
    private $transportista;
    private $peso;
    private $precioxkilo;
    private $estado;

    public function __construct($id, $destino, $transportista, $peso, $precioxkilo, $estado)
    {
        $this->id = $id;
        $this->destino = $destino;
        $this->transportista = $transportista;
        $this->peso = $peso;
        $this->precioxkilo = $precioxkilo;
        $this->estado = $estado;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function getTransportista()
    {
        return $this->transportista;
    }

    public function getPeso()
    {
        return $this->peso;
    }

    public function getCostoTotal()
    {
        return $this->peso * $this->precioxkilo;
    }

    public function getEstado()
    {
        return $this->estado;
    }
}