<?php
session_start();

if (!isset($_SESSION['usuario_nome'])) {
  header("Location: ../login/login.php");
  exit();
}

$nome = $_SESSION['usuario_nome'];
include '../dashboard/dropdown.php';
include '../chat/chat.php';
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

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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
      <a class="navbar-brand" href="../dashboard/dashboard.php">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2"><a class="nav-link active" href="../dashboard/dashboard.php">Home</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="../itinerários/itinerários.php">Trens/Rotas</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="../manutenção/manutencao.php">Manutenção</a></li>
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
    <h1 class="text-center mb-4">Bem-vindo, <?php echo $nome; ?>!</h1>

    <div class="row g-4">
      <!-- MAPA -->
      <div class="col-lg-7">
        <div id="map" style="width: 100%; height: 450px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"></div>
      </div>

      <!-- ESTATÍSTICAS E ROTAS -->
      <div class="col-lg-5 d-flex flex-column gap-3">
        <!-- ESTATÍSTICAS -->
        <div class="card card-custom">
          <div class="section-title">ATUALMENTE A EXPRESSO REAL TEM:</div>
          <div class="card-body" id="stats-container">
            <p class="mb-2">Cidades atendidas: <span id="cities-count"></span></p>
            <p class="mb-2">Linhas ferroviárias: <span id="routes-count"></span></p>
            <p class="mb-0">Trens físicos: <span id="trains-count"></span></p>
          </div>
        </div>

        <!-- ROTAS -->
        <div class="card card-custom">
          <div class="section-title">ROTAS</div>
          <div class="card-body" id="routes-container">
            <p>Carregando rotas...</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const map = L.map('map').setView([-23.55, -46.63], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    async function carregarDados() {
      const estacoesRes = await fetch('../../api/api.php?action=get_stations');
      const estacoes = await estacoesRes.json();

      const rotasRes = await fetch('../../api/api.php?action=get_routes');
      const rotas = await rotasRes.json();

      // Atualiza estatísticas
      const cidadesUnicas = [...new Set(estacoes.map(e => e.endereco.trim().toLowerCase()))];
      document.getElementById('cities-count').innerText = cidadesUnicas.length;
      document.getElementById('routes-count').innerText = rotas.length;
      document.getElementById('trains-count').innerText = 5; // ou outro valor vindo da API

      // Adiciona marcadores das estações no mapa
      estacoes.forEach(e => {
        L.marker([parseFloat(e.latitude), parseFloat(e.longitude)]).addTo(map)
          .bindPopup(`<b>${e.nome}</b><br>${e.endereco}`);
      });

      // Desenha rotas no mapa
      rotas.forEach(r => {
        if (r.estacoes.length > 1) {
          const pontos = r.estacoes.map(e => [parseFloat(e.latitude), parseFloat(e.longitude)]);
          L.polyline(pontos, {
              color: 'blue',
              weight: 3
            })
            .addTo(map)
            .bindPopup(`<b>${r.nome}</b><br>${r.distancia_km} km`);
        }
      });
    }

    carregarDados();
  </script>
</body>

</html>