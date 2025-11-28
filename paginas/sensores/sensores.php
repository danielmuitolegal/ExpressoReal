<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // incluir o arquivo do banco de dados
    include("../../bdd/database.php");

    // pegar os dados do formulário
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $status = $_POST['status'];

    // inserir os dados no banco SQL
    $sql = "INSERT INTO sensor (NomeSensor, TipoSensor, StatusSensor) VALUES (?, ?, ?)";

    // prepara o sql
    $stmt = $conn->prepare($sql);

    // liga as variáveis do forms no SQL
    $stmt->bind_param("sss", $nome, $tipo, $status);

    // executa o comando la no banco
    if ($stmt->execute()) {
        // redireciona para a mesma página com uma mensagem de sucesso
        header("Location: sensores.php?success=1");
        exit();
    } else {
        echo "Erro ao cadastrar sensor: " . $stmt->error;
    }
}
session_start();

include("../../bdd/database.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Sensores</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="../dashboard/dashboard.php">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2"><a class="nav-link active" href="../dashboard/dashboard.php">Home</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="../itinerários/itinerários.php">Trens/Rotas</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="../manutenção/manutencao.php">Manutenção</a></li>
        </ul>

        <form class="d-flex ms-3 me-3 my-2" role="search">
          <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
          <button class="btn btn-outline-dark" type="submit">Buscar</button>
        </form>

        <ul class="nav nav-pills ms-3 d-flex align-items-center">

          <li class="nav-item dropdown me-3 d-flex align-items-center">
            <a class="nav-link bg-primary text-white position-relative"
              href="#"
              id="notificacoesDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <img src="https://www.svgrepo.com/show/431413/alert.svg" alt="alerta" width="22">


              <?php if (isset($_SESSION['notificacoes_count']) && $_SESSION['notificacoes_count'] > 0) : ?>
                <span class="notification-badge position-absolute translate-middle badge rounded-circle bg-danger">
                  <?php echo $_SESSION['notificacoes_count']; ?>
                </span>
              <?php endif; ?>
            </a>


            <?php
            include '../dashboard/dropdown.php';
            ?>
          </li>
          <div class="d-flex align-items-center">
            <span class="navbar-text me-3">Olá, <?php echo $nome; ?>!</span>
            <a href="logout.php" class="btn btn-outline-dark btn-sm">Sair</a>
          </div>
        </ul>
      </div>
    </div>
  </nav>
    

    <!-- Nome do Sensor -->

    <section id="cadastro-sensores" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4 text-secundary">Cadastro de Sensores Ferroviários</h2>
            <form action="sensores.php" method="POST" class="mx-auto" style="max-width: 600px;">


                <!-- Nome do Sensor -->
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Sensor</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Sensor de Temperatura" maxlength="50" required>
                </div>

                <!-- Tipo do Sensor -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Ex: Temperatura, Umidade..." maxlength="30" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="" selected disabled>Selecione o status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="manutencao">Em Manutenção</option>
                    </select>
                </div>

                <br>
                <button type="submit" class="btn btn-dark"><strong>Cadastrar sensor</strong></button>

            </form>

        </div>
    </section>
</body>

</html>