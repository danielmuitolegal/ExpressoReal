<?php
// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start();

// variável pra caso a senha ou usuário estiver errado
$mensagem = "";

// verificar se formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // joga as informação do formulário nas variáveis
    $senha = $_POST['password'];
    $senha_confirm = $_POST['password_confirm'];

    // requisitos minismos para senha segura
    if (strlen($senha) < 8) {
        $mensagem = "A senha deve ter pelo menos 8 caracteres.";
    } else if (!preg_match('/[A-Z]/', $senha)) {
        $mensagem = "A senha deve conter pelo menos uma letra maiúscula.";
    } else {
        // se a senha digitada no primeiro input NÃO for igual a do segundo
        if ($senha != $senha_confirm) {
            $mensagem = "<p>As duas senhas não coincidem</p>";
        } else {        // se for

            // guarda as informações do usuário
            $user = $_POST['user'];
            $email = $_POST['email'];

            // deixa a senha do usuário criptografada
            $hash = password_hash($senha, PASSWORD_BCRYPT);

            $mensagem = "Sua conta foi criada $user, clique <a href='../login/login.php'>aqui</a> para fazer login";

            
        }
    }
}


?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="cadastro.css">
    <script src="cadastro.js"></script>
</head>

<body>
    <form id="formCadastro" action="" method="POST">
        <h1>Cadastro</h1>

        <!-- se a variável "mensagem" não for vazia -->
        <?php if ($mensagem != ""): ?>

            <!-- rodar o conteúdo dessa div -->
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        <input type="text" placeholder="Crie seu usuário" id="user" name="user" required>
        <input type="email" placeholder="Digite seu e-mail" id="email" name="email" required>
        <br>
        <input type="password" placeholder="Crie sua senha" id="password" name="password" required>
        <input type="password" placeholder="Repita sua senha" id="password_confirm" name="password_confirm" required>
        <br>
        <button type="submit"><strong>Criar conta</strong></button>
    </form>
</body>

</html>