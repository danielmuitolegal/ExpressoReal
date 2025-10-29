<?php
session_start();
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: ../login/login.php");
    exit();
}
$usuario = $_SESSION['usuario_nome'];
?>

<div id="chat-container" style="position: fixed; bottom: 20px; right: 20px; width: 300px; border: 1px solid #ccc; border-radius: 10px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.2); z-index: 9999;">
    <div id="chat-header" style="background: #405de6; color: white; padding: 10px; border-radius: 10px 10px 0 0; cursor: pointer;">
        💬 Suporte
    </div>
    <div id="chat-body" style="height: 300px; overflow-y: auto; padding: 10px; display: none;"></div>
    <div id="chat-footer" style="display: none; border-top: 1px solid #ccc; padding: 5px;">
        <input type="text" id="mensagem" placeholder="Digite uma mensagem..." style="width: 80%; border: none; outline: none;">
        <button id="enviar" style="width: 18%; background: #405de6; color: white; border: none; border-radius: 5px;">Enviar</button>
    </div>
</div>
<script>
// Toggle chat visibility
document.getElementById('chat-header').addEventListener('click', function() {
    const body = document.getElementById('chat-body');
    const footer = document.getElementById('chat-footer');
    if (body.style.display === 'none') {
        body.style.display = 'block';
        footer.style.display = 'block';
    } else {
        body.style.display = 'none';
        footer.style.display = 'none';
    }
});



// Função para carregar mensagens
function carregarMensagens() {
    fetch('carregar_mensagens.php')
    .then(res => res.text())
    .then(data => {
        document.getElementById('chat-body').innerHTML = data;
        document.getElementById('chat-body').scrollTop = document.getElementById('chat-body').scrollHeight;
    });
}
carregarMensagens();
setInterval(carregarMensagens, 3000);

// Enviar mensagem
document.getElementById('enviar').addEventListener('click', function() {
    const msg = document.getElementById('mensagem').value.trim();
    if (msg === '') return;
    fetch('enviar_mensagem.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'mensagem=' + encodeURIComponent(msg)
    }).then(() => {
        document.getElementById('mensagem').value = '';
        carregarMensagens();
    });
});
</script>
<?php

session_start();
require_once '../../bdd/database.php';

if (!isset($_SESSION['usuario_nome'])) exit;

$remetente = $_SESSION['usuario_nome'];
$destinatario = 'Admin'; // Pode alterar para um sistema dinâmico depois
$mensagem = trim($_POST['mensagem'] ?? '');

if ($mensagem !== '') {
    $stmt = $conn->prepare("INSERT INTO mensagens (remetente, destinatario, mensagem) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $remetente, $destinatario, $mensagem);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
