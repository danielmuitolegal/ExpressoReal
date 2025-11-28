<?php
session_start();
include '../../bdd/database.php';

// Se não estiver logado, volta para o login
if (!isset($_SESSION['usuario_nome']) || !isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'];

// Buscar dados do usuário no banco
$query = "SELECT nome, email, telefone, foto FROM usuarios WHERE id = $usuario_id LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = [
        "nome" => $nome,
        "email" => "Não informado",
        "telefone" => "Não informado",
        "foto" => null
    ];
}

// Se não tiver foto, usa avatar padrão
$fotoPerfil = $user['foto'] ? "../../uploads/" . $user['foto'] : "https://www.svgrepo.com/show/382106/user-circle.svg";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Perfil</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card-custom {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .section-title {
      font-weight: bold;
      color: #fff;
      background-color: #6c757d;
      border-radius: 15px 15px 0 0;
      padding: 10px 15px;
    }

    .profile-photo {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="../dashboard/dashboard.php">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2"><a class="nav-link" href="../dashboard/dashboard.php">Home</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="../itinerários/itinerários.php">Trens/Rotas</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="../manutenção/manutencao.php">Manutenção</a></li>
          <li class="nav-item mx-2"><a class="nav-link" href="../sobre/sobre.php">Sobre</a></li>
          <li class="nav-item mx-2"><a class="nav-link active fw-bold" href="perfil.php">Meu Perfil</a></li>
        </ul>

        <div class="d-flex align-items-center">
          <span class="navbar-text me-3">Olá, <?php echo $nome; ?>!</span>
          <a href="../dashboard/logout.php" class="btn btn-outline-dark btn-sm">Sair</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- CONTEÚDO -->
  <div class="container mt-4">

    <h1 class="text-center mb-4">Meu Perfil</h1>

    <div class="row justify-content-center">
      <div class="col-lg-6">

        <div class="card card-custom">
          <div class="section-title">Informações do Usuário</div>

          <div class="card-body text-center">

            <!-- FOTO -->
            <img src="<?php echo $fotoPerfil; ?>" class="profile-photo mb-3">

            <!-- NOME -->
            <h3><?php echo htmlspecialchars($user['nome']); ?></h3>
            <p class="text-muted">Usuário do sistema</p>

            <hr>

            <!-- DADOS -->
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($user['telefone']); ?></p>

            <hr>

            <a href="editar_perfil.php" class="btn btn-primary w-100 mt-2">Editar Perfil</a>
            <a href="alterar_senha.php" class="btn btn-outline-secondary w-100 mt-2">Alterar Senha</a>

          </div>
        </div>

      </div>
    </div>

  </div>

</body>

</html>
