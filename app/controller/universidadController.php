<?php

/*Usando los conocimientos adquiridos hasta el momento en la materia, crear una aplicación en
PHP que realice las siguientes operaciones:
1. Dado un arreglo de estudiantes donde cada uno tiene nombre, calificación final y carrera,
realiza las siguientes operaciones en PHP:
a. Calcular el promedio de calificaciones por cada carrera.
b. Determinar cuál es la carrera que tiene el promedio de calificaciones más bajo (la
de mayor dificultad académica).
c. Listar los nombres de los estudiantes que tienen una calificacion superioir al promedio de su
respectiva carrera */
namespace App\Controller;

use App\Model\Estudiante;
use App\Model\Carrera;


class UniversidadController
{
    public function index()
    {

        $sistemas = new Carrera("Ingenieria de Sistemas");
        $edfisica = new Carrera("Educacion Física");
        $adminempresas = new Carrera("Administracion de empresas");
        $veterinaria = new Carrera("Veterinaria");

        $carreras = [$sistemas, $edfisica, $adminempresas, $veterinaria];

        $estudiante1 = new Estudiante("Andres Santiago", 5);
        $estudiante2 = new Estudiante("Alejandro", 1.6);
        $estudiante3 = new Estudiante("Raul", 3);
        $estudiante4 = new Estudiante("Pedro", 2);
        $estudiante5 = new Estudiante("Picapiedra", 1.7);

        $estudiante6 = new Estudiante("Pablo", 3.2);
        $estudiante7 = new Estudiante("Pepa", 4.1);
        $estudiante8 = new Estudiante("Pepito", 4.9);
        $estudiante9 = new Estudiante("Alexander", 3.9);
        $estudiante10 = new Estudiante("Arnold", 4.4);

        $estudiante11 = new Estudiante("Felipe", 2.2);
        $estudiante12 = new Estudiante("Federico", 4.2);
        $estudiante13 = new Estudiante("Fernando", 3.5);
        $estudiante14 = new Estudiante("Federica", 1.8);
        $estudiante15 = new Estudiante("Fabiola", 2.6);

        $estudiante16 = new Estudiante("Dawid", 1.1);
        $estudiante17 = new Estudiante("Diana", 3.9);
        $estudiante18 = new Estudiante("Diego", 4.5);
        $estudiante19 = new Estudiante("Domenica", 2.8);
        $estudiante20 = new Estudiante("Domenico", 3.2);

        $sistemas->addEstudiante($estudiante1);
        $sistemas->addEstudiante($estudiante2);
        $sistemas->addEstudiante($estudiante3);
        $sistemas->addEstudiante($estudiante4);
        $sistemas->addEstudiante($estudiante5);

        $edfisica->addEstudiante($estudiante6);
        $edfisica->addEstudiante($estudiante7);
        $edfisica->addEstudiante($estudiante8);
        $edfisica->addEstudiante($estudiante9);
        $edfisica->addEstudiante($estudiante10);

        $adminempresas->addEstudiante($estudiante11);
        $adminempresas->addEstudiante($estudiante12);
        $adminempresas->addEstudiante($estudiante13);
        $adminempresas->addEstudiante($estudiante14);
        $adminempresas->addEstudiante($estudiante15);

        $veterinaria->addEstudiante($estudiante16);
        $veterinaria->addEstudiante($estudiante17);
        $veterinaria->addEstudiante($estudiante18);
        $veterinaria->addEstudiante($estudiante19);
        $veterinaria->addEstudiante($estudiante20);
        /*
                //a. Calcular el promedio de calificaciones por cada carrera.

                foreach ($carreras as $carrera) {
                    echo "El promedio de calificaciones de la carrera " . $carrera->getNombre() . " es: " . $carrera->getPromedioCalEstudiantes() . "<br>";
                }

                //b. Determinar cuál es la carrera que tiene el promedio de calificaciones más bajo (la de mayor dificultad académica).
                $flag = 5;
                $carreraHardcore = null;

                foreach ($carreras as $carrera) {
                    if ($carrera->getPromedioCalEstudiantes() < $flag) {
                        $carreraHardcore = $carrera;
                        $flag = $carreraHardcore->getPromedioCalEstudiantes();
                    }
                }
                echo "La carrera con el promedio de calificaciones más bajo es: " . $carreraHardcore->getNombre() . " con un promedio de: " . $carreraHardcore->getPromedioCalEstudiantes() . "<br>";


                //c. Listar los nombres de los estudiantes que tienen una calificacion superioir al promedio de su
                //respectiva carrera 

                foreach ($carreras as $carrera) {
                    $carrera->mejoresEstudiantes();
                }

                */

        require __DIR__ . '/../View/universidad.view.php';
    }

}