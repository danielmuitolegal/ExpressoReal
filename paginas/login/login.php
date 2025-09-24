<?php

// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start(); 

// variáveis exemplo
$usuarioValido = "macaco@gmail.com";
$senhaValida = "macacada";

// variável pra caso a senha ou usuário estiver errado
$error = "";

// verificar se formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // joga as informação do formulário nas variáveis
    $email = $_POST['email'];
    $senha = $_POST['password'];


    // caso os dados do formulário forem de acordo
    if ($email === $usuarioValido && $senha === $senhaValida) {
        
        // guarda o email na sessão que foi iniciada lááá em cima
        $_SESSION['usuario'] = $email;

        echo "<h1>Bem-vindo, $email!</h1>";
        exit(); // php para de processar qalquer coisa abaixo dessa linha
    } else {
        $error = "Email ou senha inválidos";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <form action="login.php" method="POST">
        <h1>Login</h1>

        <!-- se a variável "error" não for vazia -->
        <?php if($error != ""): ?>

            <!-- rodar o conteúdo dessa div -->
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <input type="email" placeholder="Digite seu e-mail" id="email" name="email" required>
        <input type="password" placeholder="Digite sua senha" id="password" name="password" required>
        <br>
        <button type="submit"><strong>Entrar</strong></button>
    </form>
</body>

</html>