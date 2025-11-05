<?php
include '../../bdd/database.php';
session_start();
$nome = $_SESSION['nome'] ?? 'Usuário';

// ⚙️ Quando o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero_rota'])) {
    $nomeRota = $_POST['numero_rota'];
    $numTrem = $_POST['numero_trem'];
    $descricao = $_POST['descricao'];
    $codFunc = $_POST['cod_funcionario'];

    // paradas: nome da estação
    $paradas = $_POST['paradas'] ?? [];
    $horarios = $_POST['horarios'] ?? []; // formato igual às paradas (índices correspondem)

    // 🧮 Exemplo de distância e tempo (pode mudar)
    $distancia = count($paradas) * 100;
    $tempo = count($paradas) * 60;

    // 1️⃣ Inserir rota principal
    $stmt = $conn->prepare("INSERT INTO rotas (num_trem, nome, distancia_km, tempo_estimado_min) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isdi", $numTrem, $nomeRota, $distancia, $tempo);
    $stmt->execute();
    $idRota = $conn->insert_id;

    // 2️⃣ Inserir paradas associadas
    $ordem = 1;
    $stmtEstacao = $conn->prepare("SELECT id, latitude, longitude FROM estacoes WHERE nome = ?");
    $stmtInsert = $conn->prepare("INSERT INTO rota_estacoes (id_rota, id_estacao, ordem) VALUES (?, ?, ?)");

    foreach ($paradas as $i => $nomeEstacao) {
        $dataHora = $horarios[$i] ?? date('Y-m-d H:i:s');

        // Buscar ID e coordenadas da estação
        $stmtEstacao->bind_param("s", $nomeEstacao);
        $stmtEstacao->execute();
        $result = $stmtEstacao->get_result();
        $estacao = $result->fetch_assoc();

        if ($estacao) {
            $idEstacao = $estacao['id'];
            // Inserir na tabela rota_estacoes
            $stmtInsert->bind_param("iii", $idRota, $idEstacao, $ordem);
            $stmtInsert->execute();

            // Atualiza a data/hora da parada diretamente na estação
            $conn->query("UPDATE estacoes SET data_criacao = '$dataHora' WHERE id = $idEstacao");
            $ordem++;
        }
    }

    unset($_SESSION['paradas_temp']);

    echo "<script>
        alert('Rota salva com sucesso!');
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('listaParadas').innerHTML = '';
            document.getElementById('rotaForm').reset();
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
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
            // Note: O dropdown.php não pode ter o require_once 'database.php'; nem o $conn->close();
            include '../dashboard/dropdown.php';
            ?>
          </li>
          <div class="d-flex align-items-center">
            <span class="navbar-text me-3">Olá, <?php echo $nome; ?>!</span>
            <a href="dashboard/dashbord.php" class="btn btn-outline-dark btn-sm">Sair</a>
          </div>
        </ul>
      </div>
    </div>
  </nav>

    <!-- CONTEÚDO -->
    <div class="container mt-5">
        <div class="card p-4">
            <h1 class="text-center text-secondary">GERENCIAMENTO DE ITINERÁRIOS</h1>
            <h4 class="text-center text-secondary mb-3">CRIAR NOVAS ROTAS</h4>

            <form id="rotaForm" method="POST">
                <input type="text" name="numero_rota" class="form-control" placeholder="Número da rota:" required>
                <input type="text" name="numero_trem" class="form-control mt-3" placeholder="Número do trem:" required>

                <div id="paradasContainer" class="mt-3">
                    <label class="text-secondary">Paradas:</label>
                    <div id="listaParadas"></div>

                    <div class="input-group mt-2">
                        <input type="text" id="novaParada" class="form-control" placeholder="Nome da estação">
                        <input type="datetime-local" id="horaParada" class="form-control">
                        <button type="button" id="addParada" class="btn btn-secondary">Adicionar parada</button>
                    </div>
                </div>

                <input type="text" name="descricao" class="form-control mt-3" placeholder="Descrição:" required>
                <input type="text" name="cod_funcionario" class="form-control mt-3" placeholder="Cód. Funcionário:" required>

                <button type="submit" class="btn btn-secondary w-100 mt-3">Salvar Rota</button>
            </form>
        </div>
    </div>

    <script>
        const addBtn = document.getElementById('addParada');
        const listaParadas = document.getElementById('listaParadas');
        const novaParada = document.getElementById('novaParada');
        const horaParada = document.getElementById('horaParada');

        addBtn.addEventListener('click', () => {
            const parada = novaParada.value.trim();
            const horario = horaParada.value;
            if (parada === '' || horario === '') return alert('Preencha o nome da estação e o horário.');

            const hiddenNome = document.createElement('input');
            hiddenNome.type = 'hidden';
            hiddenNome.name = 'paradas[]';
            hiddenNome.value = parada;

            const hiddenHora = document.createElement('input');
            hiddenHora.type = 'hidden';
            hiddenHora.name = 'horarios[]';
            hiddenHora.value = horario;

            const item = document.createElement('p');
            item.textContent = `#${listaParadas.children.length / 2 + 1} - ${parada} (${horario})`;
            item.classList.add('text-secondary');

            listaParadas.appendChild(item);
            listaParadas.appendChild(hiddenNome);
            listaParadas.appendChild(hiddenHora);

            novaParada.value = '';
            horaParada.value = '';
        });
    </script>
</body>


</html>