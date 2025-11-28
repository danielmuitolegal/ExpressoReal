
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre</title>

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
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="../dashboard/dashboard.php">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2"><a class="nav-link active" href="../dashboard/dashboard.php">Home</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="../itinerários/itinerários.php">Trens/Rotas</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="../manutenção/manutencao.php">Manutenção</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="../Sobre/sobre.php">Sobre</a></li>
        </ul>

        <form class="d-flex ms-3 me-3 my-2" role="search">
          <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
          <button class="btn btn-outline-dark" type="submit">Buscar</button>
        </form>

        <ul class="nav nav-pills ms-3 d-flex align-items-center">

          <li class="nav-item dropdown me-3 d-flex align-items-center">
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
            include '../dashboard/dropdown.php';
            ?>
          </li>
          <div class="d-flex align-items-center">
            <span class="navbar-text me-3">Olá, <?php echo $nome; ?>!</span>
            <a href="logout.php" class="btn btn-outline-dark btn-sm">Sair</a>
          </div>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTEÚDO PRINCIPAL -->
  <div class="container mt-4">

    <h1 class="text-center mb-4">Sobre o Projeto</h1>

    <div class="row g-4">

      <!-- OBJETIVO -->
      <div class="col-lg-6">
        <div class="card card-custom">
          <div class="section-title">OBJETIVO</div>
          <div class="card-body">
            <p>
              O objetivo deste sistema é fornecer uma plataforma completa para gestão ferroviária,
              permitindo controle de rotas, estações, trens, manutenção e visualização em mapa.
              Criado para fins educacionais, o projeto demonstra integração entre frontend,
              backend, APIs e banco de dados.
            </p>
          </div>
        </div>
      </div>

      <!-- INSTITUIÇÃO -->
      <div class="col-lg-6">
        <div class="card card-custom">
          <div class="section-title">INSTITUIÇÃO</div>
          <div class="card-body">
            <p>
              Desenvolvido como parte do curso da <strong>FIESC / SENAI – Unidade de Educação Profissional</strong>,
              orientado pelos professores do módulo de programação, IoT e desenvolvimento de sistemas.
            </p>
          </div>
        </div>
      </div>

      <!-- INTEGRANTES -->
      <div class="col-12">
        <div class="card card-custom">
          <div class="section-title">INTEGRANTES</div>
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item">Calebe Henrique Hogrefe</li>
              <li class="list-group-item">Sara Julia de Moraes</li>
              <li class="list-group-item">Andrey Felipe dos Santos</li>
              <li class="list-group-item">Daniel Melchioretto Schutz</li>
            </ul>
          </div>
        </div>
      </div>

    </div>

  </div>

</body>

</html>
