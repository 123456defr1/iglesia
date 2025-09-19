<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iglesia</title>
 <!-- Bootstrap 5 CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>



  <style>
    body {
      background-color: #f5f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar {
      background: linear-gradient(90deg, #6c63ff, #3f37c9);
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
      letter-spacing: 1px;
    }

    .nav-link {
      font-weight: 500;
      transition: color 0.3s ease-in-out;
    }

    .nav-link:hover {
      color: #ffd700 !important;
    }

    .form-select {
      border-radius: 20px;
      font-weight: 500;
      color: #3f37c9;
    }

    .container {
      background: #ffffff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
    }

    h1, h2, h3 {
      color: #3f37c9;
      font-weight: bold;
    }

    footer {
      margin-top: 30px;
      background: #3f37c9;
      color: #fff;
      padding: 15px;
      text-align: center;
      border-radius: 10px 10px 0 0;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      
      <a class="navbar-brand" href="index"> 
        <img src="ISOTIPO IGLESIA DE DIOS.png" alt="100" width="50"> Iglesia de Dios 
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="actividades"><i class="fa-solid fa-calendar-days"></i> Actividades</a></li>
          <li class="nav-item"><a class="nav-link" href="listado_himnos"><i class="fa-solid fa-music"></i> Himnos</a></li>
          <li class="nav-item"><a class="nav-link" href="estudios"><i class="fa-solid fa-book-open"></i> Estudios</a></li>
          <li class="nav-item"><a class="nav-link" href="radio"><i class="fa-solid fa-radio"></i> Radio</a></li>
        </ul>

        <!-- Select con ministerios -->
        <form class="d-flex">
          <select class="form-select" id="ministeriosSelect">
            <option value="">📖 Secciones...</option>
            <option value="infantil">🌱 Infantil</option>
            <option value="femenil">👩‍🦰 Femenil</option>
            <option value="jovenes">✨ Jóvenes</option>
          </select>
        </form>
      </div>

      <div class="d-flex align-items-center">
        <button class="btn btn-warning rounded-pill ms-2 fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
          <a href="login" class="btn btn-warning rounded-pill ms-2 fw-bold">
            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
          </a>
        </button>
      </div>
    </div>
</nav>


