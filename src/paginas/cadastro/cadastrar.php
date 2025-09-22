<?PHP
SESSION_START();
include('database.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = "Formato de e-mail inválido.";
        header("Location: ../cadastro/cadastro.php");
        exit;
    }
}

if (!preg_match("/[0-9]/", $senha)) {
    $_SESSION['erro'] = "A senha deve conter pelo menos um número.";
    header("Location: ../cadastro/cadastro.php");
    exit;
}

if (!preg_match("/[A-Z]/", $senha)) {
    $_SESSION['erro'] = "A senha deve conter pelo menos uma letra maiúscula.";
    header("Location: ../cadastro/cadastro.php");
    exit;
}
