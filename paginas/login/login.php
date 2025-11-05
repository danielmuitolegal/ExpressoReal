<?php

// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start();

// inclui o banco de dados
include("../../bdd/database.php");

// variável pra caso a senha ou usuário estiver errado
$mensagem = "";
$_SESSION['nome'] = $nome;

// verificar se formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //pega a resposta do captcha
    $captcha = $_POST['g-recaptcha-response'] ?? '';

    // valida o captcha
    if (!$captcha) {
        $mensagem = "<p>Por favor, confirme o reCAPTCHA!</p>";
    } else {
        $secretKey = "6LeN5dYrAAAAAIbGgTTr65kqJ0dEj6XNwgQTCC2H"; // substitui pela secret key do Google
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha";
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            $mensagem = "<p>Falha na verificação do reCAPTCHA!</p>";
        } else {
            // joga as informação do formulário nas variáveis
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $senha = $_POST['password'];

            // seleciona os dados do banco mas ainda nao atribui a nenhuma variável
            $sql = "SELECT NomeUsuario, SenhaHash, EmailUsuario FROM usuario WHERE EmailUsuario = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($nome, $hash, $email);
                $stmt->fetch();

                // verifica a senha
                if (password_verify($senha, $hash)) {
                    $_SESSION['usuario_nome'] = $nome; // guarda o nome na sessão
                    header("Location: ../dashboard/dashboard.php"); // redireciona para página interna
                    exit();
                } else {
                    $mensagem = "Senha incorreta!";
                }
            } else {
                $mensagem = "Usuário não encontrado!";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4"> <!-- controla largura -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">

                        <h1 class="text-center mb-4">Entrar</h1>
                        <?php if ($mensagem != ""): ?>
                            <div class="alert alert-danger">
                                <?php echo $mensagem; ?>
                            </div>
                        <?php endif; ?>
                        <form id="formCadastro" action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Digite seu e-mail" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Digite sua senha" required autocomplete="new-password">
                            </div>
                            <div class="g-recaptcha m-2" data-sitekey="6LeN5dYrAAAAANP9T3IFdvM8WjtsltfDB1eLgW2h"></div>
                            <div>
                                <a href="../cadastro/cadastro.php">Não tenho uma conta</a>
                            </div>
                            <br>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg rounded-3">
                                    Entrar
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>