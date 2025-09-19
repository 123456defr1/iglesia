<?php
include_once(__DIR__ . "/../../controladores/controladoractividad.php");
$controlador = new controladoractividad();
$actividades = $controlador->listaractividades();
?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Todas las Actividades</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Directiva</th>
                            <th>Costo</th>
                            <th>Tipo</th>
                            <th>Lugar</th>
                            <th>Foto</th>
                            <th>Creado por</th>
                            <th>Acciones</th>
                        </tr>   
                    </thead>
                    <tbody>
                        <?php foreach ($actividades as $actividad): ?>
                            <tr>
                                <td><?= $actividad['id'] ?></td>
                                <td><?= $actividad['nombre'] ?></td>
                                <td><?= $actividad['fecha'] ?></td>
                                <td><?= $actividad['hora'] ?></td>
                                <td><?= $actividad['directiva'] ?></td>
                                <td><?= $actividad['costo'] ?></td>
                                <td><?= $actividad['tipo'] ?></td>
                                <td><?= $actividad['lugar'] ?></td>
                                <td style="width:100px;">
                                    <?php if (!empty($actividad['foto_link'])): ?>
                                        <img src="/iglesia/recursos/imagenes/<?= basename($actividad['foto_link']) ?>" 
                                             class="img-fluid rounded shadow-sm border" 
                                             alt="Imagen de la actividad">
                                    <?php else: ?>
                                        <div class="bg-light text-muted p-2 rounded text-center small">Sin imagen</div>
                                    <?php endif; ?>
                                </td>
                                <td><?= $actividad['creado_por'] ?></td>
                                <td>
                                    <a href="editar_actividad?id=<?= $actividad['id'] ?>" class="btn btn-sm btn-outline-primary mb-1 w-100">Editar</a>
                                    <a href="eliminar_actividad?id=<?= $actividad['id'] ?>" class="btn btn-sm btn-outline-danger w-100">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
