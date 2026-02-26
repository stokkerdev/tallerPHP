<?php

namespace App\Controller;

use App\Model\Estudiante;
use App\Model\Carrera;
use App\Service\generarPDF;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UniversidadController
{
    private function inicializarCarreras()
    {
        if (isset($_SESSION['carreras']) && is_array($_SESSION['carreras'])) {
            return $_SESSION['carreras'];
        }

        $sistemas = new Carrera("Ingenieria de Sistemas");
        $edfisica = new Carrera("Educacion Física");
        $adminempresas = new Carrera("Administracion de empresas");
        $veterinaria = new Carrera("Veterinaria");

        $carreras = [$sistemas, $edfisica, $adminempresas, $veterinaria];


        $sistemas->addEstudiante(new Estudiante("Andres Santiago", 5));
        $sistemas->addEstudiante(new Estudiante("Alejandro", 1.6));
        $sistemas->addEstudiante(new Estudiante("Raul", 3));
        $sistemas->addEstudiante(new Estudiante("Pedro", 2));
        $sistemas->addEstudiante(new Estudiante("Picapiedra", 1.7));

        $edfisica->addEstudiante(new Estudiante("Pablo", 3.2));
        $edfisica->addEstudiante(new Estudiante("Pepa", 4.1));
        $edfisica->addEstudiante(new Estudiante("Pepito", 4.9));
        $edfisica->addEstudiante(new Estudiante("Alexander", 3.9));
        $edfisica->addEstudiante(new Estudiante("Arnold", 4.4));

        $adminempresas->addEstudiante(new Estudiante("Felipe", 2.2));
        $adminempresas->addEstudiante(new Estudiante("Federico", 4.2));
        $adminempresas->addEstudiante(new Estudiante("Fernando", 3.5));
        $adminempresas->addEstudiante(new Estudiante("Federica", 1.8));
        $adminempresas->addEstudiante(new Estudiante("Fabiola", 2.6));

        $veterinaria->addEstudiante(new Estudiante("Dawid", 1.1));
        $veterinaria->addEstudiante(new Estudiante("Diana", 3.9));
        $veterinaria->addEstudiante(new Estudiante("Diego", 4.5));
        $veterinaria->addEstudiante(new Estudiante("Domenica", 2.8));
        $veterinaria->addEstudiante(new Estudiante("Domenico", 3.2));

        $_SESSION['carreras'] = $carreras;

        return $carreras;
    }

    private function agregarEstudiante()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['calificacion'], $_POST['carrera'])) {
            $nombre = trim($_POST['nombre']);
            $calificacion = floatval($_POST['calificacion']);
            $nombreCarrera = trim($_POST['carrera']);

            if ($nombre === '' || $calificacion < 0 || $calificacion > 5) {
                $_SESSION['error'] = 'Datos inválidos.';
                return;
            }

            $carreras = $this->inicializarCarreras();

            foreach ($carreras as $carrera) {
                if ($carrera->getNombre() === $nombreCarrera) {
                    $nuevo = new Estudiante($nombre, $calificacion);
                    $carrera->addEstudiante($nuevo);
                    $_SESSION['carreras'] = $carreras;
                    $_SESSION['success'] = "Estudiante agregado correctamente.";
                    return;
                }
            }

            $_SESSION['error'] = 'Revisar que los datos esten bien ingresados';
        }
    }

    private function getCarreraMasDificil($carreras)
    {
        $carreraMasDificil = null;
        $promedioMinimo = PHP_FLOAT_MAX;

        foreach ($carreras as $carrera) {
            $promedio = $carrera->getPromedioCalEstudiantes();
            if ($promedio < $promedioMinimo) {
                $promedioMinimo = $promedio;
                $carreraMasDificil = $carrera;
            }
        }

        return $carreraMasDificil;
    }

    private function getMejoresEstudiantes($carreras)
    {
        $estudiantesDestacados = [];

        foreach ($carreras as $carrera) {
            $promedio = $carrera->getPromedioCalEstudiantes();
            $estudiantes = $carrera->getEstudiantes();
            if ($estudiantes) {
                foreach ($estudiantes as $estudiante) {
                    if ($estudiante->getCalificacionFinal() > $promedio) {
                        $estudiantesDestacados[] = ['estudiante' => $estudiante, 'carrera' => $carrera];
                    }
                }
            }
        }

        return $estudiantesDestacados;
    }

    public function descargarPDF()
    {
        $this->agregarEstudiante();
        $carreras = $this->inicializarCarreras();
        $carreraMasDificil = $this->getCarreraMasDificil($carreras);
        $estudiantesDestacados = $this->getMejoresEstudiantes($carreras);

        ob_start();
        require __DIR__ . '/../View/universidad.view.php';
        $html = ob_get_clean();

        $pdfGenerator = new generarPDF();
        $pdfGenerator->generarPDF($html, 'reporte_estudiantes.pdf');
    }

    public function index()
    {

        // Manejar descarga de PDF
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'descargar_pdf') {
            $this->descargarPDF();
            return;
        }

        // Manejar reinicio de datos (botón Reiniciar)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset') {
            unset($_SESSION['carreras']);
            $_SESSION['success'] = 'Datos reiniciados.';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        $this->agregarEstudiante();
        $carreras = $this->inicializarCarreras();
        $carreraMasDificil = $this->getCarreraMasDificil($carreras);
        $estudiantesDestacados = $this->getMejoresEstudiantes($carreras);
        require __DIR__ . '/../View/universidad.view.php';
    }
}
