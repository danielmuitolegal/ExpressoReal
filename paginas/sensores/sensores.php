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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link active" aria-disabled="true" href="#">Rotas</a>
                    </li>
                    <li class="nav-item disabled">
                        <a class="nav-link active" aria-disabled="true" href="#">Manutenção</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <form action="salvar_sensor.php" method="POST">

        <!-- Nome do Sensor -->

        <section id="cadastro-sensores" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-4 text-primary">Cadastro de Sensores Ferroviários</h2>
                <form action="processa_sensor.php" method="POST" class="mx-auto" style="max-width: 600px;">


                    <!-- Nome do Sensor -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Sensor</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Sensor de Temperatura" maxlength="50" required>
                    </div>



                    <br>
                    <button type="submit" class="btn btn-outline-primary"><strong>Salvar</strong></button>
                    <button type="reset" class="btn btn-outline-primary">Cancelar</button>
                </form>
</body>

</html>