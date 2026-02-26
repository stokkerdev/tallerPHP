<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Gestión de Envíos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h1 class="text-center mb-4">Sistema de Mensajería</h1>

        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                Total ingresos por envíos entregados
            </div>
            <div class="card-body">
                <h2 class="text-success">$<?= number_format($totalEntregados) ?></h2>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                Ciudad con mayor peso recibido
            </div>

            <div class="card-body">
                <?php if (empty($ciudadMayorPeso)): ?>
                    <p class="text-center">No hay envios registrados.</p>
                <?php else: ?>
                    <h2 class="text-primary"><?= $ciudadMayorPeso ?></h2>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                Transportista con más entregas exitosas:

            </div>
            <div class="card-body">

            <?php if (empty($mejorTransportista)): ?>
                    <p class="text-center">No hay envios registrados.</p>
                <?php else: ?>
                    <h2 class="text-primary"><?= $mejorTransportista ?></h2>
                <?php endif; ?>
            </div>
        </div>

    </div>

</body>

</html>