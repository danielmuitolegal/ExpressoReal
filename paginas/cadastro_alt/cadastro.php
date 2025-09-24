<?php

// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start();

// variável pra caso a senha ou usuário estiver errado
$error = "";

// verificar se formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // joga as informação do formulário nas variáveis
    $user = $_POST['user'];
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $senha_confirm = $_POST['password_confirm'];

    if ($senha != $senha_confirm) {
        $error = "As duas senhas não coincidem";
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

        <!-- se a variável "error" não for vazia -->
        <?php if ($error != ""): ?>

            <!-- rodar o conteúdo dessa div -->
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <input type="text" placeholder="Digite seu usuário" id="user" name="user" required>
        <input type="email" placeholder="Digite seu e-mail" id="email" name="email" required>
        <br>
        <input type="password" placeholder="Digite sua senha" id="password" name="password" required>
        <input type="password" placeholder="Digite sua senha" id="password_confirm" name="password_confirm" required>
        <br>
        <button type="submit"><strong>Criar conta</strong></button>
    </form>
</body>

</html>