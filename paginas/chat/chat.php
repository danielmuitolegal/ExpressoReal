<?php
if (!isset($_SESSION['usuario_nome'])) {
    exit();
}
$usuario = $_SESSION['usuario_nome'];
?>

<!-- ABA DO CHAT (serve como botão e janela) -->
<div id="chat-container"
    style="position: fixed; bottom: 0; right: 25px; width: 300px; border: 1px solid #ccc;
    border-radius: 10px 10px 0 0; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.2);
    z-index: 1050;">

    <!-- Cabeçalho/aba que abre e fecha -->
    <div id="chat-header"
        style="background: #405de6; color: white; padding: 10px;
        border-radius: 10px 10px 0 0; cursor: pointer; text-align: center;">
        💬 Suporte
    </div>

    <!-- Corpo e rodapé (inicialmente escondidos) -->
    <div id="chat-body"
        style="height: 300px; overflow-y: auto; padding: 10px; display: none;"></div>

    <div id="chat-footer"
        style="display: none; border-top: 1px solid #ccc; padding: 5px;">
        <input type="text" id="mensagem" placeholder="Digite uma mensagem..."
            style="width: 80%; border: none; outline: none;">
        <button id="enviar"
            style="width: 18%; background: #405de6; color: white; border: none; border-radius: 5px;">
            Enviar
        </button>
    </div>
</div>

<script>
    const chatHeader = document.getElementById('chat-header');
    const chatBody = document.getElementById('chat-body');
    const chatFooter = document.getElementById('chat-footer');

    // Clique na aba "Suporte" abre/fecha o chat
    chatHeader.addEventListener('click', () => {
        const visivel = chatBody.style.display === 'block';
        chatBody.style.display = visivel ? 'none' : 'block';
        chatFooter.style.display = visivel ? 'none' : 'block';
    });

    // Função de carregar mensagens
    function carregarMensagens() {
        fetch('carregar_mensagens.php')
            .then(res => res.text())
            .then(data => {
                chatBody.innerHTML = data;
                chatBody.scrollTop = chatBody.scrollHeight;
            });
    }

    carregarMensagens();
    setInterval(carregarMensagens, 3000);

    // Envio de mensagens
    document.getElementById('enviar').addEventListener('click', function () {
        const msg = document.getElementById('mensagem').value.trim();
        if (msg === '') return;
        fetch('enviar_mensagem.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'mensagem=' + encodeURIComponent(msg)
        }).then(() => {
            document.getElementById('mensagem').value = '';
            carregarMensagens();
        });
    });
</script>
