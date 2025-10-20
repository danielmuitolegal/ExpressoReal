<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Inspeções</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .section-title {
            background-color: #555;
            color: white;
            padding: 8px 12px;
            border-radius: 5px 5px 0 0;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th {
            background-color: #eee;
        }

        .status-pendente {
            color: orange;
            font-weight: bold;
        }

        .status-realizada {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body class="p-4">
    <div class="container">

        <div class="card mb-4">
            <h2 class=" text-center section-title">TRENS EM MANUTENÇÃO</h2>
            <div class="card-body">
                <?php
                $trens = [
                    ["trem" => 192, "descricao" => "Revisão Elétrica", "cod_funcionario" => "000687"],
                    ["trem" => 218, "descricao" => "Troca de Freios", "cod_funcionario" => "000763"],
                    ["trem" => 401, "descricao" => "Inspeção Geral", "cod_funcionario" => "000926"],
                    ["trem" => 502, "descricao" => "Manutenção de Motor", "cod_funcionario" => "000453"],
                    ["trem" => 217, "descricao" => "Substituição de Rodas", "cod_funcionario" => "000210"],
                ];
                ?>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Trem</th>
                            <th>Descrição</th>
                            <th>Cód. Funcionário</th>
                        </tr>
                    </thead>

                    <?php
                    $sql = "SELECT * FROM trens";
                    $result = $conn->query($sql);
                    ?>

                    

                    <tbody>
                        <?php while ($t = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $t['trem'] ?></td>
                                <td><?= $t['descricao'] ?></td>
                                <td><?= $t['cod_funcionario'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <h2 class=" text-center section-title">CALENDÁRIOS DE INSPEÇÕES</h2>


            <div class="card-body">
                <?php
                $inspecoes = [
                    ["mes" => "Junho", "data" => "10/06/25", "cod_funcionario" => "000154", "status" => "Pendente"],
                    ["mes" => "Maio", "data" => "12/05/25", "cod_funcionario" => "000890", "status" => "Realizada"],
                    ["mes" => "Abril", "data" => "08/04/25", "cod_funcionario" => "000720", "status" => "Realizada"],
                ];
                ?>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Mês</th>
                            <th>Data</th>
                            <th>Cód. Funcionário</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inspecoes as $i): ?>
                            <tr>
                                <td><?= $i["mes"] ?></td>
                                <td><?= $i["data"] ?></td>
                                <td><?= $i["cod_funcionario"] ?></td>
                                <td>
                                    <?php if ($i["status"] == "Pendente"): ?>
                                        <span class="status-pendente"> <?= $i["status"] ?></span>
                                    <?php else: ?>
                                        <span class="status-realizada"> <?= $i["status"] ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <h2 class=" text-center section-title">ATUALIZAR INSPEÇÕES</h2>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label class="form-label">Mês*</label>
                        <input type="text" name="mes" class="form-control" placeholder="Ex: Junho" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data*</label>
                        <input type="date" name="data" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <input type="text" name="descricao" class="form-control" placeholder="Ex: Revisão completa">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status*</label>
                        <select name="status" class="form-select" required>
                            <option value="Pendente">Pendente</option>
                            <option value="Realizada">Realizada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cód. Funcionário*</label>
                        <input type="text" name="cod_funcionario" class="form-control" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success w-50">Salvar</button>
                        <button type="reset" class="btn btn-secondary w-50">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>