<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h1 class="text-center mb-4">Sistema de Gestión Académica</h1>
        <?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
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

        <!-- ingreso de estudiantes -->

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                Agregar Estudiante
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Calificación</label>
                        <input type="number" step="0.1" min="0" max="5" name="calificacion" class="form-control" required value="<?= isset($_POST['calificacion']) ? htmlspecialchars($_POST['calificacion']) : '' ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Carrera</label>
                        <select name="carrera" class="form-select" required>
                            <?php foreach ($carreras as $carrera): ?>
                                <option value="<?= $carrera->getNombre() ?>" <?= (isset($_POST['carrera']) && $_POST['carrera'] === $carrera->getNombre()) ? 'selected' : '' ?>>
                                    <?= $carrera->getNombre() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Agregar</button>
                    </div>

                </form>
            </div>
        </div>


        <!-- ========================= -->
        <!-- 2️⃣ TABLA ESTUDIANTES -->
        <!-- ========================= -->

        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                Lista de Estudiantes
            </div>
            <div class="card-body">

                <?php
                // contar estudiantes totales
                $totalEstudiantes = 0;
                foreach ($carreras as $c) {
                    $totalEstudiantes += count($c->getEstudiantes());
                }
                ?>

                <?php if ($totalEstudiantes === 0): ?>
                    <div class="text-center text-muted">No hay estudiantes registrados.</div>
                <?php else: ?>
                <table class="table table-striped table-hover">
                    <thead class="table-secondary">
                        <tr>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carreras as $carrera): ?>
                            <?php foreach ($carrera->getEstudiantes() as $estudiante): ?>
                                <tr>
                                    <td><?= htmlspecialchars($estudiante->getNombre()) ?></td>
                                    <td><?= htmlspecialchars($carrera->getNombre()) ?></td>
                                    <td><?= htmlspecialchars($estudiante->getCalificacion()) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>

            </div>
        </div>


        <!-- ========================= -->
        <!-- 3️⃣ PROMEDIOS -->
        <!-- ========================= -->

        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                Promedio por Carrera
            </div>
            <div class="card-body">

                <div class="row">
                    <?php foreach ($carreras as $carrera): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <h5><?= htmlspecialchars($carrera->getNombre()) ?></h5>
                                    <h3 class="text-primary">
                                        <?= number_format($carrera->getPromedioCalEstudiantes(), 2) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

        <div class="alert alert-danger shadow">
            <h5 class="mb-0">
                Carrera con mayor dificultad académica:
                <strong><?= $carreraMasDificil ? htmlspecialchars($carreraMasDificil->getNombre()) . " (Promedio: " . number_format($carreraMasDificil->getPromedioCalEstudiantes(), 2) . ")" : "Sin datos" ?></strong>
            </h5>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header bg-warning">
                Estudiantes con calificación superior al promedio de su carrera
            </div>
            <div class="card-body">

                <?php if (empty($estudiantesDestacados)): ?>
                    <div class="text-center text-muted">No hay estudiantes que superen el promedio de su carrera.</div>
                <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($estudiantesDestacados as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= htmlspecialchars($item['estudiante']->getNombre()) ?> - 
                            <?= htmlspecialchars($item['carrera']->getNombre()) ?>
                            <span class="badge bg-success">
                                <?= htmlspecialchars($item['estudiante']->getCalificacionFinal()) ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

            </div>
        </div>

    </div>

</body>

</html>
