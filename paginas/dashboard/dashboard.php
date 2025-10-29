<?php
session_start();

if (!isset($_SESSION['usuario_nome'])) {
  header("Location: ../login/login.php");
  exit();
}

$nome = $_SESSION['usuario_nome'];
include '../dashboard/dropdown.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card-custom {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .section-title {
      font-weight: bold;
      color: #fff;
      background-color: #6c757d;
      border-radius: 15px 15px 0 0;
      padding: 10px 15px;
    }

    iframe {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .notification-badge {
      position: absolute;
      top: 0px;
      /* Ajusta verticalmente */
      right: 0px;
      /* Ajusta horizontalmente */
      padding: 3px 6px;
      border-radius: 50%;
      background: red;
      color: white;
      font-size: 10px;
    }

    .item-notificacao.nao-lida {
      background-color: #e7f3ff;
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
 <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mx-2"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Trens/Rotas</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="#">Manutenção</a></li>
            </ul>

            <form class="d-flex ms-3 me-3 my-2" role="search"> 
                <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">Buscar</button>
            </form>

            <ul class="nav nav-pills ms-3">
                
                <li class="nav-item dropdown">
                    <a class="nav-link bg-primary text-white position-relative"
                       href="#"
                       id="notificacoesDropdown"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="https://www.svgrepo.com/show/431413/alert.svg" alt="alerta" width="22">

                        <?php if (isset($_SESSION['notificacoes_count']) && $_SESSION['notificacoes_count'] > 0) : ?>
                            <span class="notification-badge position-absolute translate-middle badge rounded-circle bg-danger">
                                <?php echo $_SESSION['notificacoes_count']; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <?php 
                        // Note: O dropdown.php não pode ter o require_once 'database.php'; nem o $conn->close();
                        include '../dashboard/dropdown.php'; 
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

  <!-- CONTEÚDO PRINCIPAL -->
  <div class="container mt-4">
    <h1 class="text-center mb-4">Bem-vindo, <?php echo $nome . "!" ?></h1>

    <div class="row g-4">
      <div class="col-lg-7">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d28613.025616801246!2d-48.830873600000004!3d-26.3061504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-BR!2sbr!4v1760107365028!5m2!1spt-BR!2sbr"
          width="100%" height="450" allowfullscreen loading="lazy"></iframe>
      </div>

      <div class="col-lg-5 d-flex flex-column gap-3">
        <div class="card card-custom">
          <div class="section-title">ATUALMENTE A EXPRESSO REAL TEM:</div>
          <div class="card-body">
            <p class="mb-2">Cidades atendidas:</p>
            <p class="mb-2">Linhas ferroviárias:</p>
            <p class="mb-0">Trens físicos:</p>
          </div>
        </div>

        <div class="card card-custom">
          <div class="section-title">INDICADORES OPERACIONAIS:</div>
          <div class="card-body">
            <p class="mb-2">Pontualidade do dia:</p>
            <p class="mb-2">Consumo energético:</p>
            <p class="mb-0">Rotas com mais fluxo:</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
        
  </footer>
</body>

</html>