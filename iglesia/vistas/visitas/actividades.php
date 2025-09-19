<?php 
include_once(__DIR__ . "/../../controladores/controladoractividad.php"); 
$controlador = new controladoractividad(); 
$actividades = $controlador->listaractividades();



?>

<link rel="stylesheet" href="/iglesia/recursos/css/actividades.css">

<div class="container py-5">
    <h2 class="text-center mb-5 fw-bold text-primary">
        <i class="bi bi-calendar-heart"></i> ¡Participa en Nuestras Actividades!
    </h2>

    <div class="row">
        <?php foreach ($actividades as $actividad): ?>
            <div class="col-md-4 mb-4">
                <div class="card activity-card h-100 border-0 shadow-sm">
                    
                    <!-- Imagen -->
                    <?php if (!empty($actividad['foto_link'])): ?>
                        <img src="/iglesia/recursos/imagenes/<?= basename($actividad['foto_link']) ?>" 
                             class="card-img-top rounded-top-3" 
                             alt="Imagen de la actividad">
                    <?php else: ?>
                        <div class="bg-light text-center p-5 rounded-top-3">Sin imagen</div>
                    <?php endif; ?>

                    <!-- Contenido -->
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title fw-bold text-dark mb-3"><?= htmlspecialchars($actividad['nombre']) ?></h5>
                        
                        <p class="mb-2 text-muted"><i class="bi bi-calendar-date"></i> <?= htmlspecialchars($actividad['fecha']) ?></p>
                        <p class="mb-2 text-muted"><i class="bi bi-clock"></i> <?= htmlspecialchars($actividad['hora']) ?></p>
                        <p class="mb-2 text-muted"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($actividad['lugar']) ?></p>

                        <div class="mt-2">
                            <span class="badge bg-success px-3 py-2"><i class="bi bi-cash-coin"></i> <?= htmlspecialchars($actividad['costo']) ?></span>
                            <span class="badge bg-info text-dark px-3 py-2"><i class="bi bi-people-fill"></i> <?= htmlspecialchars($actividad['tipo']) ?></span>
                        </div>

                        <div class="mt-auto pt-3 d-grid gap-2">
                            <button class="btn btn-outline-primary rounded-pill fw-semibold" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalActividad<?= $actividad['id'] ?>">
                                <i class="bi bi-info-circle"></i> Ver detalles
                            </button>
                            <button class="btn btn-outline-success rounded-pill fw-semibold scroll-to-calendar" 
                                    data-fecha="<?= htmlspecialchars($actividad['fecha']) ?>">
                                <i class="bi bi-calendar-event"></i> Ver en calendario
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalActividad<?= $actividad['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0 rounded-4">
                        <div class="modal-header bg-primary text-white rounded-top-4">
                            <h5 class="modal-title fw-bold"><i class="bi bi-calendar-event"></i> <?= htmlspecialchars($actividad['nombre']) ?></h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-6 text-center">
                                    <?php if (!empty($actividad['foto_link'])): ?>
                                        <img src="/iglesia/recursos/imagenes/<?= basename($actividad['foto_link']) ?>" 
                                             class="img-fluid rounded-3 shadow-sm border" 
                                             alt="Imagen de la actividad">
                                    <?php else: ?>
                                        <div class="bg-light text-muted p-5 rounded">Sin imagen</div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="bi bi-calendar-date text-primary"></i> <strong>Fecha:</strong> <?= htmlspecialchars($actividad['fecha']) ?></li>
                                        <li><i class="bi bi-clock text-primary"></i> <strong>Hora:</strong> <?= htmlspecialchars($actividad['hora']) ?></li>
                                        <li><i class="bi bi-geo-alt text-primary"></i> <strong>Lugar:</strong> <?= htmlspecialchars($actividad['lugar']) ?></li>
                                        <li><i class="bi bi-cash-coin text-success"></i> <strong>Costo:</strong> <?= htmlspecialchars($actividad['costo']) ?></li>
                                        <li><i class="bi bi-people-fill text-info"></i> <strong>Tipo:</strong> <?= htmlspecialchars($actividad['tipo']) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Sección Calendario -->
<div class="container py-5">
    <h3 class="text-center fw-bold text-primary mb-4">
        <i class="bi bi-calendar2-week"></i> Calendario de Actividades
    </h3>
    <div id='calendar' class="shadow-sm rounded p-3 bg-white"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'es',
        events: [
            <?php foreach ($actividades as $actividad): ?>
                {
                    title: "<?= htmlspecialchars($actividad['nombre']) ?>",
                    start: "<?= htmlspecialchars($actividad['fecha']) ?>",
                    url: "#modalActividad<?= $actividad['id'] ?>"
                },
            <?php endforeach; ?>
        ]
    });
    calendar.render();

    // Botón "Ver en calendario"
    document.querySelectorAll(".scroll-to-calendar").forEach(btn => {
        btn.addEventListener("click", function() {
            document.getElementById("calendar").scrollIntoView({ behavior: "smooth" });
            calendar.gotoDate(this.dataset.fecha);
        });
    });
});
</script>

