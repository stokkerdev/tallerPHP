<?php

namespace App\Controller;

use App\Model\Envio;
use App\Model\Mensajera;
use App\Service\generarEmail;


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class EnvioController
{
    private function inicializarEnvios()
    {
        if (isset($_SESSION['envios']) && is_array($_SESSION['envios'])) {
            return $_SESSION['envios'];
        }

        $envios = [];
        /*
        $envios[] = new Envio(1, "Bogotá", "Carlos", 10, 5000, "entregado");
        $envios[] = new Envio(2, "Medellín", "Ana", 5, 4000, "ruta");
        $envios[] = new Envio(3, "Bogotá", "Carlos", 7, 5000, "entregado");
        $envios[] = new Envio(4, "Cali", "Luis", 20, 3000, "entregado");
        $envios[] = new Envio(5, "Medellín", "Ana", 15, 4000, "ruta");
        $envios[] = new Envio(6, "Bogotá", "Carlos", 12, 5000, "entregado");
*/
        $_SESSION['envios'] = $envios;
        return $envios;
    }

    private function agregarEnvio()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['destino'], $_POST['transportador'], $_POST['peso'], $_POST['precio'], $_POST['estado'])) {
            $id = intval($_POST['id']);
            $destino = trim($_POST['destino']);
            $transportador = trim($_POST['transportador']);
            $peso = floatval($_POST['peso']);
            $precio = floatval($_POST['precio']);
            $estado = trim($_POST['estado']);

            // Validaciones
            if ($destino === '' || $transportador === '' || $peso <= 0 || $precio <= 0) {
                $_SESSION['error'] = 'Los datos ingresados no son válidos.';
                return;
            }

            $envios = $this->inicializarEnvios();

            // Convertir el estado a minúsculas para consistencia
            $estadoNormalizado = strtolower($estado);
            if ($estadoNormalizado === 'en camino') {
                $estadoNormalizado = 'ruta';
            }

            $nuevoEnvio = new Envio($id, $destino, $transportador, $peso, $precio, $estadoNormalizado);
            $envios[] = $nuevoEnvio;
            $_SESSION['envios'] = $envios;
            $_SESSION['success'] = 'Envío agregado correctamente.';
            return;
        }
    }

    private function construirEmpresa($envios)
    {
        $empresa = new Mensajera();
        foreach ($envios as $envio) {
            $empresa->addEnvio($envio);
        }
        return $empresa;
    }

    public function enviarEmail()
    {
        $this->agregarEnvio();
        $envios = $this->inicializarEnvios();
        $empresa = $this->construirEmpresa($envios);

        $totalEntregados = $empresa->getCostoTotalEntregados();
        $ciudadMayorPeso = $empresa->ciudadMayorPeso();
        $pesoTotalCiudadMayorPeso = $empresa->getPesoTotalCiudad($ciudadMayorPeso);


        $mejorTransportista = $empresa->mejorTransportista();
        $entregasMejorTransportista = $empresa->getCantidadEntregas($mejorTransportista);

        ob_start();
        require __DIR__ . '/../View/envios.view.php';
        $htmlContent = ob_get_clean();

        $emailService = new generarEmail();
        $emailService->sendReport('stokkerma@gmail.com', 'Reporte de Envíos', $htmlContent);
    }

    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enviar_email') {
            $this->enviarEmail();
            return;
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset') {
            unset($_SESSION['envios']);
            $_SESSION['success'] = 'Datos reiniciados.';
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        $this->agregarEnvio();
        $envios = $this->inicializarEnvios();
        $empresa = $this->construirEmpresa($envios);

        $totalEntregados = $empresa->getCostoTotalEntregados();
        $ciudadMayorPeso = $empresa->ciudadMayorPeso();
        $pesoTotalCiudadMayorPeso = $empresa->getPesoTotalCiudad($ciudadMayorPeso);


        $mejorTransportista = $empresa->mejorTransportista();
        $entregasMejorTransportista = $empresa->getCantidadEntregas($mejorTransportista);

        require __DIR__ . '/../View/envios.view.php';
    }
}