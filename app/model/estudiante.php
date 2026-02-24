<?php

namespace App\Model;

class Estudiante
{
    private $nombre;
    private $calificacionFinal;
    private $carrera;

    public function __construct($nombre, $calificacionFinal)
    {
        $this->nombre = $nombre;
        $this->calificacionFinal = $calificacionFinal;

    }

    public function getNombre()
    {
        return $this->nombre;

    }

    public function getCalificacionFinal()
    {
        return $this->calificacionFinal;

    }

    public function getCarrera()
    {
        return $this->carrera;

    }

    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;
    }
    public function getCalificacion()
    {
        return $this->getCalificacionFinal();
    }

}
