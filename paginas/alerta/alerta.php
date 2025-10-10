<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Alertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="alerta.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h1 class=" text-center mb-4 text-secondary">Gerenciamento de Alerta</h1>

            <form id="formAlerta">

                <div class="mb-3">
                    <label for="nomeAlerta" class="form-label">Nome do Alerta</label>
                    <input type="text" class="form-control" id="nomeAlerta" name="nomeAlerta" placeholder="Ex: Alerta de Inundação" maxlength="50" required>
                </div>


                <div class="mb-3">
                    <label for="tipoAlerta" class="form-label">Tipo de Alerta</label>
                    <select class="form-select" id="tipoAlerta" name="tipoAlerta" required>
                        <option value="">Selecione...</option>
                        <option value="Climático">Climático</option>
                        <option value="Técnico">Técnico</option>
                        <option value="Segurança">Segurança</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="localizacao" class="form-label">Localização</label>
                    <input type="text" class="form-control" id="localizacao" name="localizacao" placeholder="Ex: KM 23, Linha A" maxlength="100" required>
                </div>


                <div class="mb-3">
                    <label for="prioridade" class="form-label">Nível de Prioridade</label>
                    <select class="form-select" id="prioridade" name="prioridade" required>
                        <option value="">Selecione...</option>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descreva o alerta..." maxlength="250" required></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-secondary">Salvar</button>
                </div>
            </form>



        </div>
    </div>


</body>

</html>