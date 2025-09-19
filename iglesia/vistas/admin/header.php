
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<!-- HEADER (navbar) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php?url=dashboard_admin">
      <i class="bi bi-speedometer2"></i> Admin Iglesia
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Personas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="personasDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-people-fill"></i> usuarioss
          </a>
          <ul class="dropdown-menu" aria-labelledby="personasDropdown">
            <li><a class="dropdown-item" href="lista_usuario">Lista de usuarios</a></li>
            <li><a class="dropdown-item" href="agregar_usuario">Agregar usuario</a></li>
            <li><a class="dropdown-item" href="miembros">Miembros</a></li>
            <li><a class="dropdown-item" href="visitantes">Visitantes</a></li>
            <li><a class="dropdown-item" href="reportes_personas">Reportes</a></li>
          </ul>
        </li>

        <!-- Actividades -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="actividadesDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-calendar-event"></i> Actividades
          </a>
          <ul class="dropdown-menu" aria-labelledby="actividadesDropdown">
            <li><a class="dropdown-item" href="todas_actividade">Todas las Actividades</a></li>
            <li><a class="dropdown-item" href="nueva_actividad">Nueva Actividad</a></li>
            <li><a class="dropdown-item" href="convenciones">Convenciones</a></li>
            <li><a class="dropdown-item" href="inscripciones">Inscripciones</a></li>
          </ul>
        </li>

        <!-- Grupos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="gruposDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-collection"></i> Grupos
          </a>
          <ul class="dropdown-menu" aria-labelledby="gruposDropdown">
            <li><a class="dropdown-item" href="listar_grupo">Lista de Grupos</a></li>
            <li><a class="dropdown-item" href="crearGrupo">Crear Grupo</a></li>
            <li><a class="dropdown-item" href="gestionar_miembros">Gestionar Miembros</a></li>
          </ul>
        </li>

        <!-- Finanzas -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="finanzasDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-cash-coin"></i> Finanzas
          </a>
          <ul class="dropdown-menu" aria-labelledby="finanzasDropdown">
            <li><a class="dropdown-item" href="registro_pagos">Registro de Pagos</a></li>
            <li><a class="dropdown-item" href="registrar_pago">Registrar Pago</a></li>
            <li><a class="dropdown-item" href="reportes_financieros">Reportes Financieros</a></li>
            <li><a class="dropdown-item" href="metodos_pago">Métodos de Pago</a></li>
          </ul>
        </li>

        <!-- Himnos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="himnosDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-music-note-list"></i> Himnos
          </a>
          <ul class="dropdown-menu" aria-labelledby="himnosDropdown">
           
            <li><a class="dropdown-item" href="agregar_himno">Agregar Himno</a></li>
            <li><a class="dropdown-item" href="listarhimnario">Listar Himnos</a></li>
          </ul>
        </li>

        <!-- Sistema -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="sistemaDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear-fill"></i> Sistema
          </a>
          <ul class="dropdown-menu" aria-labelledby="sistemaDropdown">
            <li><a class="dropdown-item" href="listar_personas">Listar personas</a></li>
            <li><a class="dropdown-item" href="agregar_persona">Agregar persona</a></li>
            <li><a class="dropdown-item" href="persona_inscripcion">Persona Inscripcion</a></li>
          </ul>
        </li>

      </ul>

      <!-- Perfil -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" 
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario']['nombre']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilDropdown">
            <li><a class="dropdown-item" href="perfil">Perfil</a></li>
            <li><a class="dropdown-item" href="configuracion">Configuración</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout">Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
