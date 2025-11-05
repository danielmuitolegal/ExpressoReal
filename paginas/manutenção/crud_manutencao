<?php
// Endpoint para criar / editar / excluir trens em manutenção via AJAX
header('Content-Type: application/json; charset=utf-8');

include_once('../../bdd/database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'mensagem' => 'Falha na conexão com o banco.']);
    exit;
}

// Detecta ação: create / edit / delete (padrão create)
$action = isset($_POST['action']) ? $_POST['action'] : 'create';

if ($action === 'create') {
    $trem = isset($_POST['trem']) ? intval($_POST['trem']) : 0;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $cod = isset($_POST['cod_funcionario']) ? trim($_POST['cod_funcionario']) : '';
    $status = isset($_POST['statusTrensManut']) ? trim($_POST['statusTrensManut']) : '';

    if (!$trem || !$descricao || !$cod || !$status) {
        echo json_encode(['success' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
        exit;
    }

    $sql = "INSERT INTO trens_manutencao (trem, descricao, cod_funcionario, statusTrensManut) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("isss", $trem, $descricao, $cod, $status);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'mensagem' => 'Manutenção adicionada com sucesso!',
            'row' => [
                'trem' => $trem,
                'descricao' => $descricao,
                'cod_funcionario' => $cod,
                'statusTrensManut' => $status
            ]
        ]);
    } else {
        // possivelmente chave primária duplicada
        echo json_encode(['success' => false, 'mensagem' => 'Erro ao inserir: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

if ($action === 'delete') {
    $trem = isset($_POST['trem']) ? intval($_POST['trem']) : 0;
    if (!$trem) {
        echo json_encode(['success' => false, 'mensagem' => 'Trem inválido.']);
        exit;
    }
    $sql = "DELETE FROM trens_manutencao WHERE trem = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $trem);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'mensagem' => 'Registro de manutenção excluído com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'mensagem' => 'Erro ao excluir: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

if ($action === 'edit') {
    // trem_old é o identificador atual (antes da edição) — primary key atual
    $trem_old = isset($_POST['trem_old']) ? intval($_POST['trem_old']) : 0;
    $trem = isset($_POST['trem']) ? intval($_POST['trem']) : 0;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $cod = isset($_POST['cod_funcionario']) ? trim($_POST['cod_funcionario']) : '';
    $status = isset($_POST['statusTrensManut']) ? trim($_POST['statusTrensManut']) : '';

    if (!$trem_old || !$trem || !$descricao || !$cod || !$status) {
        echo json_encode(['success' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
        exit;
    }

    // Atualiza registro. Permitimos alterar o número do trem (PK) — cuidado com duplicidade.
    $sql = "UPDATE trens_manutencao SET trem = ?, descricao = ?, cod_funcionario = ?, statusTrensManut = ? WHERE trem = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("isssi", $trem, $descricao, $cod, $status, $trem_old);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'mensagem' => 'Manutenção atualizada com sucesso!',
            'old_trem' => $trem_old,
            'row' => [
                'trem' => $trem,
                'descricao' => $descricao,
                'cod_funcionario' => $cod,
                'statusTrensManut' => $status
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'mensagem' => 'Erro ao atualizar: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Ação inválida
echo json_encode(['success' => false, 'mensagem' => 'Ação inválida.']);
$conn->close();
exit;
