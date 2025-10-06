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
    <form action="salvar_sensor.php" method="POST">
        <h1>Gerenciamento de Sensores</h1>

        <!-- Mensagem de erro -->
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Mensagem de sucesso -->
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <label for="nome">Nome do Sensor:</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Sensor de Temperatura" maxlength="50" required>

        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" placeholder="Ex: Temperatura, Umidade..." maxlength="30" required>


        <br>

        <button type="submit" class="btn btn-outline-primary"><strong>Salvar</strong></button>
        <button type="reset" class="btn btn-outline-primary">Cancelar</button>
    </form>
</body>

</html>