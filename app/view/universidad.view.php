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

        <!-- ingreso de estudiantes -->


        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                Agregar Estudiante
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Calificación</label>
                        <input type="number" step="0.1" min="0" max="5" name="calificacion" class="form-control"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Carrera</label>
                        <select name="carrera" class="form-select" required>
                            <?php foreach ($carreras as $carrera): ?>
                                <option value="<?= $carrera->getNombre() ?>">
                                    <?= $carrera->getNombre() ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-success w-100">
                            Agregar
                        </button>
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

                            <?php if ($carrera->getEstudiantes() !== null): ?>
                                <?php foreach ($carrera->getEstudiantes() as $estudiante): ?>
                                    <tr>
                                        <td>
                                            <?= $estudiante->getNombre() ?>
                                        </td>
                                        <td>
                                            <?= $carrera->getNombre() ?>
                                        </td>
                                        <td>
                                            <?= $estudiante->getCalificacion() ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No hay estudiantes registrados en esta carrera.
                                    </td>
                                </tr>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>


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
                                    <h5><?= $carrera->getNombre() ?></h5>
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
                        <?php if ($carreraMasDificil): ?>
                            <strong>Carrera más difícil: <?= $carreraMasDificil->getNombre() ?></strong>
                        <?php else: ?>
                            <strong>No hay carreras registradas</strong>
                        <?php endif; ?>
            </h5>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header bg-warning">
                Estudiantes con calificación superior al promedio de su carrera
            </div>
            <div class="card-body">

                <ul class="list-group">
                    <?php foreach ($carreras as $carrera): ?>
                        <?php
                        $promedio = $carrera->getPromedioCalEstudiantes();
                        if ($carrera->getEstudiantes() !== null):
                            foreach ($carrera->getEstudiantes() as $estudiante):
                                if ($estudiante->getCalificacionFinal() > $promedio):
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <?= $estudiante->getNombre() ?> -
                                        <?= $carrera->getNombre() ?>
                                        <span class="badge bg-success">
                                            <?= $estudiante->getCalificacionFinal() ?>
                                        </span>
                                    </li>
                                    <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>

    </div>

</body>

</html>