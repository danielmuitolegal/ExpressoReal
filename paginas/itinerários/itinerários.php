<?php
include '../../bdd/database.php';
session_start();
$nome = $_SESSION['nome'] ?? 'Usuário';

// CRIAÇÃO DE ROTAS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_rota'])) {
    $numero_rota = $_POST['numero_rota'] ?? '';
    $numero_trem = $_POST['numero_trem'] ?? '';
    $nome_rota = $_POST['nome_rota'] ?? '';
    $id_estacoes = $_POST['id_estacao'] ?? [];
    $datas_horas = $_POST['data_hora'] ?? [];

    if (!$numero_rota || !$numero_trem || !$nome_rota) {
        echo "<p style='color:red;'>Preencha número da rota, número do trem e nome da rota.</p>";
    } elseif (empty($id_estacoes)) {
        echo "<p style='color:red;'>Adicione pelo menos uma parada.</p>";
    } else {
        $ids_string = implode(',', array_map('intval', $id_estacoes));
        $check = $conn->query("SELECT id FROM estacoes WHERE id IN ($ids_string)");
        if ($check->num_rows !== count($id_estacoes)) {
            echo "<p style='color:red;'>Erro: uma ou mais estações informadas não existem.</p>";
            exit();
        }

        $stmtRota = $conn->prepare("INSERT INTO rotas (num_trem, nome, distancia_km, tempo_estimado_min) VALUES (?, ?, ?, ?)");

        function calcularDistancia($lat1, $lon1, $lat2, $lon2)
        {
            $raioTerra = 6371;
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            return $raioTerra * $c;
        }

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
        $tempo = round($distancia_total);

        $stmtRota->bind_param("isdi", $numero_trem, $nome_rota, $distancia, $tempo);
        if ($stmtRota->execute()) {
            $id_rota = $conn->insert_id;
            echo "<p style='color:green;'>Rota '" . htmlspecialchars($nome_rota) . "' criada com sucesso (ID: $id_rota).</p>";

            $stmtCheck = $conn->prepare("SELECT nome FROM estacoes WHERE id = ?");
            $stmtInsert = $conn->prepare("INSERT INTO rota_estacoes (id_rota, id_estacao, ordem) VALUES (?, ?, ?)");

            $ordem = 1;
            for ($i = 0; $i < count($id_estacoes); $i++) {
                $id_estacao = (int)$id_estacoes[$i];
                $data_hora = $datas_horas[$i] ?? date('Y-m-d H:i:s');

                $stmtCheck->bind_param("i", $id_estacao);
                $stmtCheck->execute();
                $res = $stmtCheck->get_result()->fetch_assoc();
                $nome_estacao = $res['nome'];

                $stmtInsert->bind_param("iii", $id_rota, $id_estacao, $ordem);
                if ($stmtInsert->execute()) {
                    echo "<p style='color:green;'>Parada adicionada: ({$ordem}) {$nome_estacao} — {$data_hora}</p>";
                    $ordem++;
                }
            }
            echo "<p style='color:green;font-weight:bold;'>Rota criada com sucesso!</p>";
        }
    }
}

// GERENCIAMENTO DE ROTAS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    if ($acao === 'excluir_rota') {
        $idRota = intval($_POST['id_rota']);
        $conn->query("DELETE FROM rota_estacoes WHERE id_rota = $idRota");
        $conn->query("DELETE FROM rotas WHERE id = $idRota");
        $msgPainel = "🗑️ Rota $idRota excluída com sucesso!";
    } elseif ($acao === 'excluir_parada') {
        $idParada = intval($_POST['id_parada']);
        $conn->query("DELETE FROM rota_estacoes WHERE id = $idParada");
        $msgPainel = "❌ Parada removida!";
    } elseif ($acao === 'editar_parada') {
        $idParada = intval($_POST['id_parada']);
        $novaOrdem = intval($_POST['nova_ordem']);
        $conn->query("UPDATE rota_estacoes SET ordem = $novaOrdem WHERE id = $idParada");
        $msgPainel = "✏️ Parada $idParada atualizada (nova ordem $novaOrdem).";
    }
}

$estacoesRota = [];
if (isset($_GET['id_rota'])) {
    $idRota = intval($_GET['id_rota']);
    $sql = "SELECT re.id AS id_parada, e.nome AS nome_estacao, re.ordem
            FROM rota_estacoes re
            JOIN estacoes e ON re.id_estacao = e.id
            WHERE re.id_rota = $idRota
            ORDER BY re.ordem";
    $estacoesRota = $conn->query($sql);
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

        <!-- FORMULÁRIO DE CRIAÇÃO -->
        <div class="card p-4 mb-5">
            <h4>Criar nova rota</h4>
            <form method="POST">
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

                <button class="btn btn-primary w-100 mt-3">Salvar Rota</button>
            </form>
        </div>

        <!-- PAINEL DE GERENCIAMENTO -->
        <div class="card p-4">
            <h4>Gerenciar Rotas</h4>

            <?php if (isset($msgPainel)) echo "<div class='alert alert-info'>$msgPainel</div>"; ?>

            <form method="GET" class="mb-3">
                <label class="form-label">Digite o ID da rota:</label>
                <div class="input-group">
                    <input type="number" name="id_rota" class="form-control" required>
                    <button type="submit" class="btn btn-dark">Buscar</button>
                </div>
            </form>

            <?php if (isset($idRota)): ?>
                <h6>Estações da rota #<?= $idRota ?></h6>
                <?php if ($estacoesRota && $estacoesRota->num_rows > 0): ?>
                    <table class="table table-striped mt-3">
                        <tr>
                            <th>ID Parada</th>
                            <th>Estação</th>
                            <th>Ordem</th>
                            <th>Ações</th>
                        </tr>
                        <?php while ($row = $estacoesRota->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id_parada'] ?></td>
                                <td><?= htmlspecialchars($row['nome_estacao']) ?></td>
                                <td><?= $row['ordem'] ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id_parada" value="<?= $row['id_parada'] ?>">
                                        <input type="number" name="nova_ordem" placeholder="Nova ordem" class="form-control form-control-sm d-inline" style="width:90px;">
                                        <button class="btn btn-warning btn-sm" name="acao" value="editar_parada"><i class="fas fa-pencil-alt"></i></button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id_parada" value="<?= $row['id_parada'] ?>">
                                        <button class="btn btn-danger btn-sm" name="acao" value="excluir_parada"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>

                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir essa rota inteira?');">
                        <input type="hidden" name="id_rota" value="<?= $idRota ?>">
                        <button class="btn btn-danger w-100" name="acao" value="excluir_rota">Excluir rota completa</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning mt-3">Nenhuma parada encontrada para essa rota.</div>
                <?php endif; ?>
            <?php endif; ?>
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

            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = 'id_estacao[]';
            hiddenId.value = id;

            const hiddenHora = document.createElement('input');
            hiddenHora.type = 'hidden';
            hiddenHora.name = 'data_hora[]';
            hiddenHora.value = hora.replace('T', ' ');

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