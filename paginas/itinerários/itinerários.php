<?php
include '../../bdd/database.php';
session_start();
$nome = $_SESSION['nome'] ?? 'Usuário';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DADOS DA ROTA
    $numero_rota = $_POST['numero_rota'] ?? '';
    $numero_trem = $_POST['numero_trem'] ?? '';
    $nome_rota = $_POST['nome_rota'] ?? '';

    // PARADAS (arrays)
    $id_estacoes = $_POST['id_estacao'] ?? [];      // ex: [1,3,5]
    $datas_horas = $_POST['data_hora'] ?? [];      // ex: ['2025-10-27 11:11:09', ...]

    // validação básica da rota
    if (!$numero_rota || !$numero_trem || !$nome_rota) {
        echo "<p style='color:red;'>Preencha número da rota, número do trem e nome da rota.</p>";
    } else {
        // 1) criar rota
        $stmtRota = $conn->prepare("INSERT INTO rotas (num_trem, nome, distancia_km, tempo_estimado_min) VALUES (?, ?, ?, ?)");
        // calculos de exemplo para distância/tempo (ajuste conforme quiser)
        function calcularDistancia($lat1, $lon1, $lat2, $lon2)
        {
            $raioTerra = 6371; // km
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            return $raioTerra * $c;
        }

        // calcular distância total da rota
        $distancia_total = 0;
        for ($i = 0; $i < count($id_estacoes) - 1; $i++) {
            $stmt = $conn->prepare("SELECT latitude, longitude FROM estacoes WHERE id = ?");
            $stmt->bind_param("i", $id_estacoes[$i]);
            $stmt->execute();
            $res1 = $stmt->get_result()->fetch_assoc();

            $stmt->bind_param("i", $id_estacoes[$i + 1]);
            $stmt->execute();
            $res2 = $stmt->get_result()->fetch_assoc();

            if ($res1 && $res2) {
                $distancia_total += calcularDistancia(
                    $res1['latitude'],
                    $res1['longitude'],
                    $res2['latitude'],
                    $res2['longitude']
                );
            }
        }

        $distancia = round($distancia_total, 2);
        $tempo = round($distancia_total / 1.0);
        
        $stmtRota->bind_param("isdi", $numero_trem, $nome_rota, $distancia, $tempo);

        if (!$stmtRota->execute()) {
            echo "<p style='color:red;'>Erro ao criar rota: " . htmlspecialchars($stmtRota->error) . "</p>";
        } else {
            $id_rota = $conn->insert_id;
            echo "<p style='color:green;'>Rota '" . htmlspecialchars($nome_rota) . "' criada com sucesso (ID: $id_rota).</p>";

            // 2) inserir paradas vinculadas à rota
            $stmtCheck = $conn->prepare("SELECT nome, latitude, longitude FROM estacoes WHERE id = ?");
            $stmtInsert = $conn->prepare("INSERT INTO rota_estacoes (id_rota, id_estacao, ordem, data_hora) VALUES (?, ?, ?, ?)");

            $ordem = 1;
            for ($i = 0; $i < count($id_estacoes); $i++) {
                $id_estacao = (int)$id_estacoes[$i];
                $data_hora = $datas_horas[$i] ?? date('Y-m-d H:i:s');

                // checar existência da estação
                $stmtCheck->bind_param("i", $id_estacao);
                $stmtCheck->execute();
                $res = $stmtCheck->get_result();

                if ($res->num_rows === 0) {
                    echo "<p style='color:red;'>Erro: estação com ID $id_estacao não encontrada — parada ignorada.</p>";
                    continue;
                }

                $est = $res->fetch_assoc();
                $nome_estacao = $est['nome'];

                // inserir em rota_estacoes
                $stmtInsert->bind_param("iiis", $id_rota, $id_estacao, $ordem, $data_hora);
                if ($stmtInsert->execute()) {
                    echo "<p style='color:green;'>Parada adicionada: ({$ordem}) {$nome_estacao} — {$data_hora}</p>";
                    $ordem++;
                } else {
                    echo "<p style='color:red;'>Erro ao inserir parada ID $id_estacao: " . htmlspecialchars($stmtInsert->error) . "</p>";
                }
            } // fim foreach paradas

            echo "<p style='color:green; font-weight:bold;'>Rota '" . htmlspecialchars($nome_rota) . "' criada com suas paradas.</p>";
        }
    }
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
            <h4 class="mb-3">Criar nova rota</h4>
            <form id="rotaForm" method="POST">
                <div class="row g-2">
                    <div class="col-md-4"><input name="numero_rota" class="form-control" placeholder="Número da rota" required></div>
                    <div class="col-md-4"><input name="numero_trem" class="form-control" placeholder="Número do trem" required></div>
                    <div class="col-md-4"><input name="nome_rota" class="form-control" placeholder="Nome da rota" required></div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Paradas</label>
                    <div id="listaParadas" class="mb-2"></div>

                    <div class="row g-2">
                        <div class="col-md-4"><input type="number" id="idEstacao" class="form-control" placeholder="ID da estação"></div>
                        <div class="col-md-4"><input type="datetime-local" id="horaParada" class="form-control"></div>
                        <div class="col-md-4 d-grid"><button type="button" id="addParada" class="btn btn-secondary">Adicionar parada</button></div>
                    </div>
                </div>

                <button class="btn btn-secondary w-100 mt-3">Salvar Rota</button>
            </form>
        </div>
    </div>

    <script>
        const addBtn = document.getElementById('addParada');
        const listaParadas = document.getElementById('listaParadas');
        const idEstacao = document.getElementById('idEstacao');
        const horaParada = document.getElementById('horaParada');
        let contador = 0;

        addBtn.addEventListener('click', () => {
            const id = idEstacao.value.trim();
            const hora = horaParada.value;
            if (!id || !hora) return alert('Preencha ID da estação e horário.');

            contador++;

            // elementos ocultos que serão enviados no form
            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = 'id_estacao[]';
            hiddenId.value = id;

            const hiddenHora = document.createElement('input');
            hiddenHora.type = 'hidden';
            hiddenHora.name = 'data_hora[]';
            hiddenHora.value = hora.replace('T', ' ');

            // exibição
            const p = document.createElement('p');
            p.className = 'mb-1 text-secondary';
            p.textContent = `#${contador} - Estação ID ${id} — ${hora}`;
            listaParadas.appendChild(p);
            listaParadas.appendChild(hiddenId);
            listaParadas.appendChild(hiddenHora);

            idEstacao.value = '';
            horaParada.value = '';
        });
    </script>
</body>

</html>