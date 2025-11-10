<?php
include_once('../../bdd/database.php');
header('Content-Type: application/json; charset=utf-8');

function json_exit($arr) {
    echo json_encode($arr, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    // INSERIR ou ATUALIZAR
    if ($acao === 'inserir' || $acao === 'atualizar') {
        if (!empty($_POST['trem']) && !empty($_POST['descricao']) && !empty($_POST['cod_funcionario']) && !empty($_POST['statusTrensManut'])) {
            $trem = intval($_POST['trem']);
            $descricao = trim($_POST['descricao']);
            $cod_funcionario = trim($_POST['cod_funcionario']);
            $status = trim($_POST['statusTrensManut']);

            if ($acao === 'inserir') {
                $sql = "INSERT INTO trens_manutencao (trem, descricao, cod_funcionario, statusTrensManut)
                        VALUES (?, ?, ?, ?)";
            } else {
                $sql = "UPDATE trens_manutencao SET descricao=?, cod_funcionario=?, statusTrensManut=? WHERE trem=?";
            }

            $stmt = $conn->prepare($sql);
            if (!$stmt) json_exit(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);

            if ($acao === 'inserir') {
                $stmt->bind_param("isss", $trem, $descricao, $cod_funcionario, $status);
            } else {
                $stmt->bind_param("sssi", $descricao, $cod_funcionario, $status, $trem);
            }

            if ($stmt->execute()) {
                $stmt->close();
                json_exit([
                    'success' => true,
                    'mensagem' => $acao === 'inserir' ? 'Manutenção adicionada com sucesso!' : 'Manutenção atualizada com sucesso!'
                ]);
            } else {
                $stmt->close();
                json_exit(['success' => false, 'mensagem' => 'Erro ao salvar: ' . $conn->error]);
            }
        } else {
            json_exit(['success' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
        }
    }

    // EXCLUIR
    if ($acao === 'excluir') {
        $trem = intval($_POST['trem'] ?? 0);
        if ($trem <= 0) json_exit(['success' => false, 'mensagem' => 'Trem inválido para exclusão.']);

        $sql = "DELETE FROM trens_manutencao WHERE trem=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $trem);

        if ($stmt->execute()) {
            $stmt->close();
            json_exit(['success' => true, 'mensagem' => 'Trem removido com sucesso!']);
        } else {
            $stmt->close();
            json_exit(['success' => false, 'mensagem' => 'Erro ao excluir: ' . $conn->error]);
        }
    }
}

// GET: CARREGAR PARA EDIÇÃO
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['acao']) && $_GET['acao'] === 'editar' && isset($_GET['id'])) {
    $trem = intval($_GET['id']);
    $sql = "SELECT * FROM trens_manutencao WHERE trem=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trem);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result) {
        // Gera formulário HTML preenchido
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Editar Manutenção</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
            <div class="container mt-5">
                <div class="card p-4 shadow-sm">
                    <h3 class="mb-3">Editar Manutenção</h3>
                    <form action="crud_manutencao.php" method="POST">
                        <input type="hidden" name="acao" value="atualizar">
                        <div class="mb-3">
                            <label class="form-label">Trem</label>
                            <input type="number" name="trem" class="form-control" readonly value="<?php echo htmlspecialchars($result['trem']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <input type="text" name="descricao" class="form-control" value="<?php echo htmlspecialchars($result['descricao']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Código do Funcionário</label>
                            <input type="text" name="cod_funcionario" class="form-control" value="<?php echo htmlspecialchars($result['cod_funcionario']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="statusTrensManut" class="form-select" required>
                                <option value="Pendente" <?php echo $result['statusTrensManut'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                <option value="Realizada" <?php echo $result['statusTrensManut'] === 'Realizada' ? 'selected' : ''; ?>>Realizada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="manutencao.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    } else {
        echo "<p>Registro não encontrado.</p>";
        exit;
    }
}

// Se cair aqui, método inválido
json_exit(['success' => false, 'mensagem' => 'Método inválido.']);
?>
