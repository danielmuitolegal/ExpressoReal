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
  <title>Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="../dashboard/dashboard.php">
      <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy" class="me-2">
      Expresso Real
    </a>

 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mx-2"><a class="nav-link" href="../itinerários/itinerários.php">Trens/Rotas</a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="../manutenção/manutencao.php">Manutenção</a></li>
            </ul>

            <form class="d-flex ms-3 me-3 my-2" role="search"> 
                <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">Buscar</button>
            </form>

            <ul class="nav nav-pills ms-3">
                
                <li class="nav-item dropdown">
                    <a class="nav-link bg-primary text-white position-relative"
                       href="../dashboard/dropdown.php"
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
                        // Note: O dropdown.php não pode ter o require_once 'database.php'; nem o $conn->close();
                        include '../dashboard/dropdown.php'; 
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
                    <option value="Inati-=-=-vo">Inativo</option>
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

        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Horários:"
            maxlength="80" required>

        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Descrição:"
            maxlength="80" required>

        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Cód. Funcionario:"
            maxlength="80" required>
        <button type="submit" class="btn btn-secondary w-300 mt-3">Salvar Rota</button>

        <div class="mb-3 mt-4">
            </textarea>
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>

                        <th>ÚLTIMOS TRENS PARTIDOS</th>,

                        <th>PRÓXIMAS CHEGADAS</th>

                    </tr>
                    <tr>  
                        <td>Trem 103 | SP-RJ | 09:45</td>
                        <td>Trem 400 | BH-SP | 10:00</td>
                    </tr>
                    <tr>
                        <td>Trem 208 | RJ-MG | 10:15</td>
                        <td>Trem 225 | RJ-ES | 10:30</td>
                    </tr>
                    <tr>
                        <td>Trem 301 | SP-SC | 10:15</td>
                        <td>Trem 602 | BA-MG | 11:00</td>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>

            </textarea>



            <div class="mb-3 mt-4">
                </textarea>
            </div>
            <h4 class=" text-center text-secondary mb-3">EDITAR ROTAS</h4>
            <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Número da rota:"
                maxlength="80" required>

            <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Número do trem:"
                maxlength="80" required>

            <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Paradas:"
                maxlength="80" required>

            <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Horários:"
                maxlength="80" required>

            <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Descrição:"
                maxlength="80" required>

            <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Cód. Funcionario:"
                maxlength="80" required>
            <button type="submit" class="btn btn-secondary w-300 mt-3">Salvar Alterações</button>
        </div>

        <div class="mb-3 mt-4">
            </textarea>
        </div>
        <h4 class=" text-center text-secondary mb-3">REDIRECIONAMENTO EM TEMPO REAL</h4>
        <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Número do trem:"
            maxlength="80" required>

        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Nova rota:"
            maxlength="80" required>

        <input type="text" id="titulo" name="titulo" class="form-control mt-3" placeholder="Cód. Funcionario:"
            maxlength="80" required>
        <button type="submit" class="btn btn-secondary w-300 mt-3">Salvar Trem</button>

        
    </div>
    <div style="margin: 90px;">
        </textarea>

    </div>
</body>
</html>
