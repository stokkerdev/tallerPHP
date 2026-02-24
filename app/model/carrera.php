<?php

namespace App\Model;

class Carrera
{
    private $nombre;
    private $estudiantes;


    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->estudiantes = [];
    }

    public function getNombre()
    {
        return $this->nombre;

    }

    public function getestudiantes()
    {
        return $this->estudiantes;
    }

    public function addEstudiante($estudiante)
    {
        $this->estudiantes[] = $estudiante;
        $estudiante->setCarrera($this);
    }

    public function getPromedioCalEstudiantes()
    {

        $sumatoria = 0;

        if ($this->estudiantes) {
            $cantidadEstudiantes = count($this->estudiantes);
        } else {
            return 0;
        }
        $cantidadEstudiantes = count($this->estudiantes);
        $promedio = 0;

        foreach ($this->estudiantes as $estudiante) {
            $sumatoria += $estudiante->getCalificacionFinal();
        }

        $promedio = $sumatoria / $cantidadEstudiantes;
        return $promedio;
    }

    /*c. Listar los nombres de los estudiantes que tienen una calificacion superioir al promedio de su
  respectiva carrera */

    public function mejoresEstudiantes()
    {
        $prom = $this->getPromedioCalEstudiantes();
        foreach ($this->estudiantes as $estudiante) {
            if ($estudiante->getCalificacionFinal() > $prom) {
                echo "El estudiante " . $estudiante->getNombre() . " tiene una calificación superior al promedio de su carrera " . $estudiante->getCarrera()->getNombre() . " con la nota " . $estudiante->getCalificacionFinal() . "<br>";
            }
        }

    }

}