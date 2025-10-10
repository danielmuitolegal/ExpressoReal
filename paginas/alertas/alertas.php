<?php
// Exemplo de array de alertas (pode vir do banco de dados)
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas Ferroviários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-5 text-danger">Alertas Ferroviários</h2>

    <div class="row g-4">
        <?php foreach($alertas as $alerta): ?>
        <div class="col-md-6">
            <div class="card shadow-sm border-<?= $alerta['tipo'] == 'Crítico' ? 'danger' : ($alerta['tipo'] == 'Aviso' ? 'warning' : 'info') ?> mb-3">
                <div class="card-header bg-<?= $alerta['tipo'] == 'Crítico' ? 'danger text-white' : ($alerta['tipo'] == 'Aviso' ? 'warning text-dark' : 'info text-white') ?> fw-bold">
                    <?= $alerta['titulo'] ?>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $alerta['descricao'] ?></p>
                    <p class="text-muted mb-0"><small>Data do alerta: <?= $alerta['data'] ?></small></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
