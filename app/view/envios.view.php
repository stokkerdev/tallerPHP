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
        <div class="card-body">
            <h4>Total ingresos por envíos entregados:</h4>
            <h2 class="text-success">$<?= number_format($totalEntregados) ?></h2>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h4>Ciudad con mayor peso recibido:</h4>
            <h2 class="text-primary"><?= $ciudadMayorPeso ?></h2>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <h4>Transportista con más entregas exitosas:</h4>
            <h2 class="text-danger"><?= $mejorTransportista ?></h2>
        </div>
    </div>

</div>

</body>
</html>