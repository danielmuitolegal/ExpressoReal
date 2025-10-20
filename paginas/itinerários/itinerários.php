<?php

// inicia sessão, precisa disso pra "guardar" quem tá fazendo login
session_start();

// inclui o banco de dados
include("../../bdd/database.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Itinerários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="itinerarios.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h1 class=" text-center mb-4 text-secondary">GERENCIAMENTO DE ITINERÁRIOS</h1>

            <form id="formItinerario">

        </div>
        <div class="mb-3">
            </textarea>
        </div>

        </form>
        <h4 class="text-center text-secondary mb-3">ITINERÁRIOS CADASTRADOS</h4>

        <form id="formNotificacao">


            <div class="mb-3">
                <label for="tipo" class="form-label">Origem</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="São Paulo">São Paulo </option>
                    <option value="Joinville">Joinville</option>
                    <option value="Rio de Janeiro">Rio de Janeiro</option>
                    <option value="Porto Alegre">Porto Alegre</option>
                    <option value="Salvador">Salvador</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Destino</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="Curitiba">Curitiba </option>
                    <option value="Blumenau">Blumenau</option>
                    <option value="Belo Horizonte">Belo Horizonte</option>
                    <option value="Florianópolis">Florianópolis</option>
                    <option value="Recife">Recife</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Trem</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="320">320</option>
                    <option value="515">515</option>
                    <option value="410">410</option>
                    <option value="220">220</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Dias</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="Segunda a Quarta">Segunda a Quarta</option>
                    <option value="Ter, Qui, Sex">Ter, Qui, Sex</option>
                    <option value="Sex, Sáb">Sex, Sáb</option>
                    <option value="Dom, Seg">Dom, Seg</option>
                    <option value="Seg, Qua">Seg, Qua</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Status</label>
                <select id="tipo" name="tipo" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
        </form>

        <button type="submit" class="btn btn-secondary w-300">Salvar Itinerário</button>
        <div class="mb-3 mt-4">
            </textarea>
        </div>
        <h4 class=" text-center text-secondary mb-3">CRIAR NOVAS ROTAS</h4>
        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Número da rota:"
            maxlength="80" required>

        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Número do trem:"
            maxlength="80" required>
        
        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Paradas:"
            maxlength="80" required>
    

    </div>

 </div>