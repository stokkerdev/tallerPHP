<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sistema de envios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h1 class="text-center mb-4">Sistema de envios</h1>


        <?php if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                <form method="POST" style="margin:0">
                    <input type="hidden" name="action" value="reset">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Reiniciar datos</button>
                </form>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger d-flex justify-content-between align-items-center">
                <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                <form method="POST" style="margin:0">
                    <input type="hidden" name="action" value="reset">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Reiniciar datos</button>
                </form>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>



        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                Agregar Envio
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">ID</label>
                        <input type="text" name="id" class="form-control" required
                            value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Destino</label>
                        <input type="text" name="destino" class="form-control" required
                            value="<?= isset($_POST['destino']) ? htmlspecialchars($_POST['destino']) : '' ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Transportador</label>
                        <input type="text" name="transportador" class="form-control" required
                            value="<?= isset($_POST['transportador']) ? htmlspecialchars($_POST['transportador']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Peso del paquete (Kg)</label>
                        <input type="text" name="peso" class="form-control" required
                            value="<?= isset($_POST['peso']) ? htmlspecialchars($_POST['peso']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Precio por Kilo</label>
                        <input type="text" name="precio" class="form-control" required
                            value="<?= isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : '' ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="Entregado" <?= (isset($_POST['estado']) && $_POST['estado'] === 'Entregado') ? 'selected' : '' ?>>Entregado</option>
                            <option value="En camino" <?= (isset($_POST['estado']) && $_POST['estado'] === 'En camino') ? 'selected' : '' ?>>En camino</option>
                            <option value="Pendiente" <?= (isset($_POST['estado']) && $_POST['estado'] === 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                        </select>
                    </div>


                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Agregar</button>
                    </div>

                </form>
            </div>
        </div>


        <!-- lista completa de envíos -->
        <div class="card shadow mt-4 mb-4">
            <div class="card-header bg-secondary text-white">Envíos registrados</div>
            <div class="card-body">
                <?php if (empty($envios)): ?>
                    <p class="text-center">No hay envíos registrados.</p>
                <?php else: ?>
                    <table class="table table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Destino</th>
                                <th>Transportista</th>
                                <th>Peso (Kg)</th>
                                <th>Costo total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($envios as $envio): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($envio->getId()) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($envio->getDestino()) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($envio->getTransportista()) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($envio->getPeso()) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($envio->getCostoTotal()) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($envio->getEstado()) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

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
                    <h2 class="text-secondary"><?= $ciudadMayorPeso ?> : <?= $pesoTotalCiudadMayorPeso ?> Kg</h2>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-secondary text-white">
                Transportista con más entregas exitosas:

            </div>
            <div class="card-body">

                <?php if (empty($mejorTransportista)): ?>
                    <p class="text-center">No hay envios registrados.</p>
                <?php else: ?>
                    <h2 class="text-secondary"><?= $mejorTransportista ?> : <?= $entregasMejorTransportista ?></h2>
                <?php endif; ?>
            </div>
        </div>



    </div>

</body>

</html>