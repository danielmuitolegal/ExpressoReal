<?php
session_start();

if (!isset($_SESSION['usuario_nome'])) {
  header("Location: ../login/login.php");
  exit();
}

$nome = $_SESSION['usuario_nome'];

// Conexão com o banco (ajuste conforme seu ambiente)

include_once('../../bdd/database.php');
// Verifica conexão
if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}

// Consulta trens em manutenção
$sql_trens = "SELECT trem, descricao, cod_funcionario FROM trens_manutencao";
$result_trens = $conn->query($sql_trens);

// Consulta calendário de inspeções
$sql_inspecoes = "SELECT mes, data, cod_funcionario, status FROM calendario_inspecoes";
$result_inspecoes = $conn->query($sql_inspecoes);
?>

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

    table {
      width: 100%;
      text-align: center;
    }

    th,
    td {
      padding: 8px;
      border-bottom: 1px solid #ccc;
    }

    .titulo-secao {
      background-color: #555;
      color: white;
      padding: 5px;
      text-align: center;
      font-weight: bold;
    }

    .subtitulo {
      background-color: #444;
      color: white;
      padding: 3px;
      font-weight: bold;
      border-radius: 4px;
    }

    .caixa {
      background-color: #e0e0e0;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 20px;
    }


    .form-label {
      font-weight: bold;
    }

    .btn-custom {
      width: 120px;
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy" class="me-2">
      Expresso Real
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Links principais -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item mx-2"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="#">Trens/Rotas</a></li>
        <li class="nav-item mx-2"><a class="nav-link" href="#">Manutenção</a></li>
      </ul>

      <!-- Campo de pesquisa -->
      <form class="d-flex me-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
      </form>

      <!-- Ícone de alerta -->
      <ul class="nav nav-pills me-3">
        <li class="nav-item">
          <a class="nav-link bg-primary text-white" href="#">
            <img src="https://www.svgrepo.com/show/431413/alert.svg" alt="alerta" width="22">
          </a>
        </li>
      </ul>

      <!-- Saudação + Sair -->
      <div class="d-flex align-items-center">
        <span class="navbar-text me-3">Olá, <?php echo $nome; ?>!</span>
        <a href="../logout.php" class="btn btn-outline-dark btn-sm">Sair</a>
      </div>
    </div>
  </div>
</nav>

  <div class="container mt-4">
    <!-- TRENS EM MANUTENÇÃO -->
    <div class="caixa">
      <div class="titulo-secao">TRENS EM MANUTENÇÃO</div>
      <table class="table table-sm table-striped mt-2">
        <thead class="table-dark">
          <tr>
            <th>Trem</th>
            <th>Descrição</th>
            <th>Cód. Funcionário</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result_trens->num_rows > 0) {
            while ($row = $result_trens->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['trem']}</td>
                      <td>{$row['descricao']}</td>
                      <td>{$row['cod_funcionario']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='3'>Nenhum trem em manutenção.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- CALENDÁRIO DE INSPEÇÕES -->
    <div class="caixa">
      <div class="titulo-secao" style="border-bottom: 3px ;">CALENDÁRIO DE INSPEÇÕES</div>
      <table class="table table-sm table-striped mt-2">
        <thead class="table-dark">
          <tr>
            <th>Mês</th>
            <th>Data</th>
            <th>Cód. Funcionário</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result_inspecoes->num_rows > 0) {
            while ($row = $result_inspecoes->fetch_assoc()) {
              $statusIcon = $row['status'] == 'Pendente' ? "<span class='status-pendente'> Pendente</span>" : "<span class='status-realizada'> Realizada</span>";
              echo "<tr>
                      <td>{$row['mes']}</td>
                      <td>{$row['data']}</td>
                      <td>{$row['cod_funcionario']}</td>
                      <td>$statusIcon</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4'>Nenhuma inspeção registrada.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- FORMULÁRIO -->
    <div class="caixa">
      <div class="titulo-secao">ATUALIZAR INSPEÇÕES</div>
      <form class="mt-3">
        <div class="row mb-2">
          <div class="col-md-6">
            <label class="form-label">Mês*</label>
            <input type="text" class="form-control" placeholder="Ex: Maio">
          </div>
          <div class="col-md-6">
            <label class="form-label">Data*</label>
            <input type="date" class="form-control">
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Descrição</label>
          <input type="text" class="form-control" placeholder="Ex: Troca de freios">
        </div>

        <div class="mb-2">
          <label class="form-label">Status*</label>
          <select class="form-select">
            <option>Pendente</option>
            <option>Realizada</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Cód. Funcionário*</label>
          <input type="number" class="form-control" placeholder="Ex: 000123">
        </div>

        <button type="button" class="btn btn-secondary btn-outline-dark">Salvar</button>
        <button type="reset" class="btn btn-secondary">Cancelar</button>
      </form>
    </div>
  </div>
</body>

</html>

<?php
$conn->close();
?>
