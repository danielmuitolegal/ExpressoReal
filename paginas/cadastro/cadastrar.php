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

if (strlen($senha) < 8) {
    $_SESSION['erro'] = "A senha deve ter pelo menos 8 caracteres.";
    header("Location: ../cadastro/cadastro.php");
    exit;
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

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['erro'] = "E-mail já cadastrado. Use outro.";
    header("Location: ../cadastro/cadastro.php");
    exit;
}

$hashed_password = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Faça login.";
    header("Location: ../login/login.php");
} else {
    $_SESSION['erro'] = "Erro no cadastro. Tente novamente.";
    header("Location: ../cadastro/cadastro.php");
}

 if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario['nome'];
            header("Location: ../painel/painel.php");
            exit;
        } else {
            $_SESSION['erro'] = "Senha incorreta.";{
            header("Location: ../login/login.php");
            exit;
        }
    }   
    
    else 
    
    {
        $_SESSION['erro'] = "Usuário não encontrado.";
        header("Location: ../login/login.php");
        exit;
    }

if (password_verify($senha, $hashed_password)) {
    // A senha corresponde ao hash
} else {
    // A senha não corresponde ao hash
}
$stmt->close();
$conn->close();
