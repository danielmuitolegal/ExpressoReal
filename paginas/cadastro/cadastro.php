<?php
// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start();

// incluir o arquivo do banco de dados
include("../../bdd/database.php");

// variável pra caso a senha ou usuário estiver errado
$mensagem = "";


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
            $senha = $_POST['password'];
            $senha_confirm = $_POST['password_confirm'];

            // requisitos minismos para senha segura
            if (strlen($senha) < 8) {
                $mensagem = "<p>A senha deve ter pelo menos 8 caracteres</p>";
            } else if (!preg_match('/[A-Z]/', $senha)) {
                $mensagem = "<p>A senha deve conter pelo menos uma letra maiúscula</p>";
            } else {
                // se a senha digitada no primeiro input NÃO for igual a do segundo
                if ($senha != $senha_confirm) {
                    $mensagem = "<p>As duas senhas não coincidem</p>";
                } else {        // se for

                    // guarda as informações do usuário
                    $user = $_POST['user'];
                    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

                    // deixa a senha do usuário criptografada
                    $hash = password_hash($senha, PASSWORD_BCRYPT);
                    $senha = "";

                    // insere os dados no banco SQL (esses ? vão ser ligados depois)
                    $sql = "INSERT INTO usuario (NomeUsuario, EmailUsuario, SenhaHash) values (?, ?, ?)";

                    // prepara o sql
                    $stmt = $conn->prepare($sql);

                    // liga as variáveis do forms no SQL
                    // "s" significa que a variável é uma string
                    $stmt->bind_param("sss", $user, $email, $hash);

                    // executa o comando la no banco
                    if ($stmt->execute()) {
                        $mensagem = "Sua conta foi criada $user, clique <a href='../login/login.php'>aqui</a> para voltar para a página de login";
                    } else {
                        $mensagem = "Ocorreu um erro, tente novamente mais tarde";
                    }
                }
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
    <title>Cadastrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="cadastro.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4"> <!-- controla largura -->
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">

                        <h1 class="text-center mb-4">Cadastro</h1>

                        <!-- Mensagem PHP -->
                        <?php if ($mensagem != ""): ?>
                            <div class="alert alert-warning text-center" role="alert">
                                <?php echo $mensagem; ?>
                            </div>
                        <?php endif; ?>

                        <form id="formCadastro" action="" method="POST">
                            <div class="mb-3">
                                <label for="user" class="form-label">Usuário</label>
                                <input type="text" class="form-control form-control-lg" id="user" name="user" placeholder="Crie seu usuário" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Digite seu e-mail" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Crie sua senha" required autocomplete="new-password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirmar senha</label>
                                <input type="password" class="form-control form-control-lg" id="password_confirm" name="password_confirm" placeholder="Repita sua senha" required autocomplete="new-password">
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LeN5dYrAAAAANP9T3IFdvM8WjtsltfDB1eLgW2h"></div>
                            
                            <div class="mb-3">
                                <a href="../cadastroAdmin/cadastroAdmin.php">Tenho um código de admin</a>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg rounded-3">
                                    Criar conta
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