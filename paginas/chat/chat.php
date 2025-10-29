<?php

// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start();

// inclui o banco de dados
include("../../bdd/database.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

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