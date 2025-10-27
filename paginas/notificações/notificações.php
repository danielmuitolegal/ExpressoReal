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
    <title>Gerenciamento de Notificações</title>
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





        body {
            background-color: #f8f9fa;
        }

        iframe {
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

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: 0.2s;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
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

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit">Buscar</button>
                </form>

                <ul class="nav nav-pills ms-3">
                    <li class="nav-item">
                        <a class="nav-link bg-primary text-white" href="#">
                            <img src="https://www.svgrepo.com/show/431413/alert.svg" alt="alerta" width="22">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO -->
    <div class="container mt-5">
        <div class="card card-custom p-4">
            <h1 class="text-center mb-4 text-dark">Gerenciamento de Notificações</h1>

            <form id="formNotificacao">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título da Notificação</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ex: Alerta de Manutenção" maxlength="80" required>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Notificação</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="Informativo">Informativo</option>
                        <option value="Urgente">Urgente</option>
                        <option value="Sistema">Sistema</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="msg" class="form-label">Mensagem</label>
                    <textarea id="msg" name="msg" class="form-control" rows="3" placeholder="Conteúdo da notificação" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Ex: usuario@exemplo.com" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-outline-secondary px-4">Cancelar</button>
                    <button type="submit" class="btn btn-secondary px-4">Salvar</button>
                </div>
            </form>

            <div id="mensagem" class="mt-4"></div>
        </div>
    </div>
</body>

</html>