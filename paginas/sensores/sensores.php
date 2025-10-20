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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../../imagens/logo.png" alt="logo" class="d-inline-block" width="38" height="30" loading="lazy"></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-3">
                        <a class="nav-link active" aria-current="page" href="../dashboard/">Home</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link active" aria-disabled="true" href="#">Rotas</a>
                    </li>
                    <li class="nav-item disabled">
                        <a class="nav-link active" aria-disabled="true" href="#">Manutenção</a>
                    </li>
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