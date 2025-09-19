<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/iglesia/controladores/controlador_grupo.php");
include_once(__DIR__ . "/../../controladores/controladorusuario.php");
$controlador = new controlador_grupo();
$usuario = verificarSesion();
verificarRol(['admin']);



if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $creado_por = $_SESSION['usuario']['id'];
    $controlador->nuevoGrupo($nombre, $descripcion, $creado_por);
    $resultado = $controlador->nuevoGrupo($nombre, $descripcion, $creado_por);
    if ($resultado['status'] == 'success') {
        echo "<div class='alert alert-success mt-3'>Grupo creado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error al crear el grupo.</div>";
    }
    

}
?>

<body class="bg-light">
    

  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4 rounded-4" style="max-width: 500px; width: 100%;">
      <h2 class="text-center mb-4 text-primary">Crear Grupo</h2>
      <form method="post">
        
        <!-- Nombre -->
        <div class="mb-3">
          <label for="nombre" class="form-label fw-bold">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escribe el nombre del grupo" required>
        </div>
        
        <!-- Descripción -->
        <div class="mb-3">
          <label for="descripcion" class="form-label fw-bold">Descripción</label>
          <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Agrega una breve descripción..." required></textarea>
        </div>
        
        <!-- Botones -->
        <div class="d-grid gap-2">
          <button type="submit" name="guardar" class="btn btn-primary btn-lg">
            Guardar
          </button>
          <a href="index.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
        </div>
        
      </form>
    </div>
  </div>



