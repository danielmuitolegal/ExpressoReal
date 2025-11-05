<?php
// Endpoint para criar / editar / excluir inspeções via AJAX
header('Content-Type: application/json; charset=utf-8');

include_once('../../bdd/database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'mensagem' => 'Falha na conexão com o banco.']);
    exit;
}

// Ação padrão: criar (quando form do tipo POST sem action especificado)
$action = isset($_POST['action']) ? $_POST['action'] : 'create';

if ($action === 'create') {
    $mes = isset($_POST['mes']) ? trim($_POST['mes']) : '';
    $data = isset($_POST['data']) ? trim($_POST['data']) : null;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $cod = isset($_POST['cod_funcionario']) ? trim($_POST['cod_funcionario']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    if (!$mes || !$data || !$cod || !$status) {
        echo json_encode(['success' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
        exit;
    }

    $sql = "INSERT INTO inspecoes (mes, data, descricao, cod_funcionario, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssss", $mes, $data, $descricao, $cod, $status);
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        echo json_encode([
            'success' => true,
            'mensagem' => 'Inspeção adicionada com sucesso!',
            'row' => [
                'idInspecao' => (int)$id,
                'mes' => $mes,
                'data' => $data,
                'descricao' => $descricao,
                'cod_funcionario' => $cod,
                'status' => $status
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'mensagem' => 'Erro ao inserir: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

if ($action === 'delete') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if (!$id) {
        echo json_encode(['success' => false, 'mensagem' => 'ID inválido.']);
        exit;
    }
    $sql = "DELETE FROM inspecoes WHERE idInspecao = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'mensagem' => 'Inspeção excluída com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'mensagem' => 'Erro ao excluir: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

if ($action === 'edit') {
    $id = isset($_POST['idInspecao']) ? intval($_POST['idInspecao']) : 0;
    $mes = isset($_POST['mes']) ? trim($_POST['mes']) : '';
    $data = isset($_POST['data']) ? trim($_POST['data']) : null;
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $cod = isset($_POST['cod_funcionario']) ? trim($_POST['cod_funcionario']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';

    if (!$id || !$mes || !$data || !$cod || !$status) {
        echo json_encode(['success' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.']);
        exit;
    }

    $sql = "UPDATE inspecoes SET mes = ?, data = ?, descricao = ?, cod_funcionario = ?, status = ? WHERE idInspecao = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'mensagem' => 'Erro na preparação da query: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssssi", $mes, $data, $descricao, $cod, $status, $id);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'mensagem' => 'Inspeção atualizada com sucesso!',
            'row' => [
                'idInspecao' => $id,
                'mes' => $mes,
                'data' => $data,
                'descricao' => $descricao,
                'cod_funcionario' => $cod,
                'status' => $status
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'mensagem' => 'Erro ao atualizar: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Ação desconhecida
echo json_encode(['success' => false, 'mensagem' => 'Ação inválida.']);
$conn->close();
exit;
