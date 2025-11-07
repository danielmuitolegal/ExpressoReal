<?php
// Arquivo: dropdown.php - CORRIGIDO

// 1. Inclui o database.php.
// Ele define $conn (a variável de conexão que usaremos)
require_once '../../bdd/database.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: ../login/login.php");
    exit();
}

$nome = $_SESSION['usuario_nome'];

// Removidas as linhas de $servidor, $usuario, $senha, $banco e a criação do mysqli($conexao)

// Busca as notificações não lidas primeiro!
$sql = "SELECT idNotificacoes, tipo_acao, mensagem_curta, data_criacao, lida 
        FROM notificacoes 
        ORDER BY lida ASC, data_criacao DESC 
        LIMIT 10"; 

// 💥 USAMOS $conn para executar a query!
$resultado = $conn->query($sql); 

// Adicionei uma checagem de erro de query para ser mais útil que a checagem de conexão.
if ($resultado === false) {
    echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificacoesDropdown" style="width: 350px;">';
    echo '<li><div class="dropdown-item">Erro na Query SQL: ' . $conn->error . '</div></li>';
    echo '</ul>';
    $conn->close();
    exit;
}

$tem_notificacao = $resultado->num_rows > 0;
$nao_lidas_count = 0; // Para contar e mostrar no ícone

// Início do Dropdown Menu do Bootstrap
echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificacoesDropdown" style="width: 350px;">';

if ($tem_notificacao) {
    while($notif = $resultado->fetch_assoc()) {
        
        $classe_lida = $notif['lida'] ? '' : 'nao-lida';
        if (!$notif['lida']) $nao_lidas_count++;
        $classe_tipo = htmlspecialchars($notif['tipo_acao']);
        
        $icone = (strpos($classe_tipo, 'alerta') !== false) ? '🚨' : 
                 ((strpos($classe_tipo, 'finalizada') !== false) ? '✅' : 
                 ((strpos($classe_tipo, 'atualizada') !== false) ? '📝' : '💬'));
        
        $data_formatada = date('H:i d/m', strtotime($notif['data_criacao']));

        // O item do dropdown. Usamos 'dropdown-item'
        echo '<li class="dropdown-item item-notificacao ' . $classe_lida . ' ' . $classe_tipo . '">';
        echo '  <div style="display: flex; align-items: center;">';
        echo '      <span class="icone" style="font-size: 18px; margin-right: 10px;">' . $icone . '</span>';
        echo '      <div style="flex-grow: 1;">';
        echo '          <p style="margin: 0; font-size: 13px; line-height: 1.3;">' . htmlspecialchars($notif['mensagem_curta']) . '</p>';
        echo '          <small style="color: #888; font-size: 10px;">' . $data_formatada . '</small>';
        echo '      </div>';
        // O ponto de novo
        if (!$notif['lida']) {
            echo '      <span class="ponto-novo" style="width: 8px; height: 8px; background-color: #405de6; border-radius: 50%; margin-left: 10px;"></span>';
        }
        echo '  </div>';
        echo '</li>';
    }
    // Link para ver todas as notificações
    echo '<li><hr class="dropdown-divider"></li>';
    echo '<li><a class="dropdown-item text-center text-primary" href="#">Ver todas as notificações</a></li>';
    
} else {
    echo '<li><div class="dropdown-item text-muted text-center">Nenhuma notificação nova.</div></li>';
}

echo '</ul>';

// Define a variável de contagem para ser usada no Dashboard.php
$_SESSION['notificacoes_count'] = $nao_lidas_count; 
?>