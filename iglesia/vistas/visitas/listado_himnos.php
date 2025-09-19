<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controladorhimno.php");

$controlador = new ControladorHimno();
$himnos = $controlador->listarHimnos();
?>

<div class="container py-4">
  <div class="card shadow-lg rounded-4 border-3">
    <div class="card-header bg-primary text-white text-center py-4">
      <h1 class="h3 mb-0">📖 Listado de Himnos</h1>
    </div>

    <!-- Buscador -->
    <div class="card-body bg-light">
      <label for="search" class="form-label fw-bold h5">🔍 Buscar Himno:</label>
      <div class="input-group mb-3">
        <span class="input-group-text">🎵</span>
        <input type="text" id="search" class="form-control form-control-lg"
          placeholder="Escriba el número o nombre del himno..."
          aria-describedby="search-help">
      </div>
      <small id="search-help" class="form-text text-muted">
        Puede buscar por número (ejemplo: 123) o por nombre del himno
      </small>
    </div>

    <!-- Tabla -->
    <div class="table-responsive px-3">
      <table id="tablaHimnos" class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>📊 Número</th>
            <th>🎵 Nombre del Himno</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($himnos as $himno): ?>
          <tr tabindex="0"
              data-numero="<?= htmlspecialchars($himno['numero']) ?>"
              data-nombre="<?= htmlspecialchars($himno['nombre']) ?>"
              data-letra="<?= htmlspecialchars($himno['letra']) ?>">
            <td>
              <span class="badge bg-primary rounded-pill fs-5 px-3 py-2">
                <?= htmlspecialchars($himno['numero']) ?>
              </span>
            </td>
            <td class="fw-bold"><?= htmlspecialchars($himno['nombre']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="himnoModal" tabindex="-1" aria-labelledby="himnoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
    <div class="modal-content rounded-4 border-3 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="himnoModalLabel">🎵 Detalle del Himno</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>📊 Número:</strong> <span id="modal-numero"></span></p>
        <p><strong>🎵 Nombre:</strong> <span id="modal-nombre"></span></p>
        <hr>
        <p class="fw-bold">📝 Letra del Himno:</p>
        <div id="modal-letra" 
     class="border rounded p-3 bg-light text-center fs-3 fs-md-4 fs-lg-3"
     style="max-height: 70vh; overflow-y: auto; white-space: pre-wrap;">
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">✅ Cerrar</button>
      </div>
    </div>
  </div>
</div>



<script>
    document.querySelectorAll('#tablaHimnos tbody tr').forEach(row => {
  row.addEventListener('click', () => {
    // Llenar el modal con datos
    document.getElementById('modal-numero').textContent = row.dataset.numero;
    document.getElementById('modal-nombre').textContent = row.dataset.nombre;
    document.getElementById('modal-letra').textContent = row.dataset.letra;

    // Mostrar modal
    let modal = new bootstrap.Modal(document.getElementById('himnoModal'));
    modal.show();
  });
});

</script>