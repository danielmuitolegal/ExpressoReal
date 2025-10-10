<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Notificações</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="notificações.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h1 class="text-center mb-4 text-dark">Gerenciamento de Notificações</h1>

            <form id="formNotificacao">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título da Notificação</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ex: Alerta de Manutenção"
                        maxlength="80" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Notificação</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="Informativo">Informativo</option>
                        <option value="Urgente">Urgente</option>
                        <option value="Sistema">Sistema</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dataEnvio" class="form-label">Data de Envio</label>
                    <input type="date" id="dataEnvio" name="dataEnvio" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="Ex: usuario@exemplo.com" required>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-secondary">Salvar</button>
                </div>
            </form>
            <div id="mensagem" class="mt-4"></div>
        </div>
    </div>
</body>