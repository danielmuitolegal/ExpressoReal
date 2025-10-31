<?php
session_start();

// Garante que a exclusão só ocorra se o usuário estiver logado
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: ../login/login.php");
    exit();
}

// Inicializa variáveis de feedback
$status = "danger"; 
$mensagem = "Erro: Parâmetros de exclusão incompletos ou desconhecidos."; 

// 1. Incluir o arquivo de conexão com o banco de dados
include_once('../../bdd/database.php');

// Verifica se os parâmetros 'tipo' e 'id' foram passados via URL (GET)
if (isset($_GET['tipo']) && isset($_GET['id'])) {
    $tipo = $_GET['tipo'];
    $id = $_GET['id'];
    
    $tabela = '';
    $coluna_id = '';

    // 2. Definir a tabela e a coluna ID com base no tipo
    switch ($tipo) {
        case 'manutencao':
            $tabela = 'trens_manutencao';
            $coluna_id = 'trem'; // Chave primária para trens
            break;
        case 'inspecao':
            $tabela = 'inspecoes';
            $coluna_id = 'idInspecao'; // Chave primária para inspeções
            break;
        default:
            // Caso o tipo seja inválido, mantém o status de erro
            goto end_of_script; // Pula para o final do script para o redirecionamento
    }

    // 3. Montar e executar a query de exclusão
    if (!empty($tabela) && !empty($coluna_id)) {
        // Usa prepared statement para prevenir SQL Injection
        // '?' é um placeholder para o valor que será passado no bind_param
        $stmt = $conn->prepare("DELETE FROM $tabela WHERE $coluna_id = ?");
        
        // Assume que o ID é um inteiro ('i')
        $stmt->bind_param("i", $id); 
        
        if ($stmt->execute()) {
            $status = "success";
            $mensagem = "Registro de $tipo (ID: $id) excluído com sucesso!";
        } else {
            $status = "danger";
            $mensagem = "Erro ao excluir o registro de $tipo: " . $conn->error;
        }

        $stmt->close();
    }
} else {
    // Parâmetros GET não encontrados, mantém a mensagem de erro inicial.
}


$conn->close();

// 4. Redirecionar de volta para a página de manutenção, enviando o status e a mensagem
header("Location: manutencao.php?status=" . urlencode($status) . "&msg=" . urlencode($mensagem));
exit();

?>