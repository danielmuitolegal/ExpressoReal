<?php
session_start();

if (!isset($_SESSION['nome'])) {
  header("Location: ../login/login.php");
  exit();
}

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: ../login/login.php");
    exit();
}

$nome = $_SESSION['usuario_nome'];

// Conexão com o banco
include '../dashboard/dropdown.php';
include_once('../../bdd/database.php');

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Carrega dados (Read)
$sql_trens = "SELECT trem, descricao, cod_funcionario, statusTrensManut FROM trens_manutencao ORDER BY trem ASC";
$result_trens = $conn->query($sql_trens);

$sql_inspecoes = "SELECT idInspecao, mes, data, descricao, cod_funcionario, status FROM inspecoes ORDER BY data DESC";
$result_inspecoes = $conn->query($sql_inspecoes);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Painel de Manutenção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5f5f5; }
    .container { max-width: 1200px; }
    .caixa {
      background-color: #e0e0e0;
      padding: 15px;
      border-radius: 6px;
      margin-bottom: 25px;
      box-shadow: 0px 1px 4px rgba(0,0,0,0.08);
    }
    .titulo-secao {
      background-color: #555;
      color: white;
      padding: 8px;
      text-align: center;
      font-weight: bold;
      border-radius: 4px;
      margin-bottom: 15px;
    }
    table { width: 100%; text-align: center; }
    th, td { padding: 10px; vertical-align: middle; }
    .status-pendente { color: #b22222; font-weight: bold; }
    .status-realizada { color: #228B22; font-weight: bold; }
    .btn-acao { margin: 0 3px; }
    .form-label { font-weight: bold; }
    .btn-salvar { width: 120px; }
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="../dashboard/dashboard.php">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30" class="me-2">
        Expresso Real
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2"><a class="nav-link" href="../itinerarios/itinerarios.php">Trens/Rotas</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="#">Manutenção</a></li>
        </ul>

        <form class="d-flex me-3 my-2" role="search">
          <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
          <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </form>

        <ul class="nav nav-pills me-3">
          <li class="nav-item">
            <a class="nav-link bg-primary text-white" href="#">
              <img src="https://www.svgrepo.com/show/431413/alert.svg" alt="alerta" width="22">
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center">
          <span class="navbar-text me-3">Olá, <?php echo htmlspecialchars($nome); ?>!</span>
          <a href="../login/logout.php" class="btn btn-outline-dark btn-sm">Sair</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mt-4">

    <!-- TRENS EM MANUTENÇÃO -->
    <div class="caixa">
      <div class="titulo-secao">TRENS EM MANUTENÇÃO</div>

      <table class="table table-striped table-sm">
        <thead class="table-dark">
          <tr>
            <th>Trem</th>
            <th>Descrição</th>
            <th>Cód. Funcionário</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result_trens && $result_trens->num_rows > 0): ?>
            <?php while ($row = $result_trens->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['trem']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <td><?php echo htmlspecialchars($row['cod_funcionario']); ?></td>
                <td><?php echo htmlspecialchars($row['statusTrensManut']); ?></td>
                <td>
                  <a href="crud_manutencao.php?acao=editar&id=<?php echo urlencode($row['trem']); ?>" class="btn btn-sm btn-primary btn-acao">Alterar</a>
                  <a href="crud_manutencao.php?acao=excluir&id=<?php echo urlencode($row['trem']); ?>" class="btn btn-sm btn-danger btn-acao"
                     onclick="return confirm('Deseja realmente excluir este registro?');">Excluir</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5">Nenhum trem em manutenção encontrado.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- INSPEÇÕES -->
    <div class="caixa">
      <div class="titulo-secao">CALENDÁRIO DE INSPEÇÕES</div>

      <table class="table table-striped table-sm">
        <thead class="table-dark">
          <tr>
            <th>Mês</th>
            <th>Data</th>
            <th>Descrição</th>
            <th>Cód. Funcionário</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result_inspecoes && $result_inspecoes->num_rows > 0): ?>
            <?php while ($row = $result_inspecoes->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['mes']); ?></td>
                <td><?php echo htmlspecialchars($row['data']); ?></td>
                <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                <td><?php echo htmlspecialchars($row['cod_funcionario']); ?></td>
                <td>
                  <?php if ($row['status'] === 'Pendente'): ?>
                    <span class="status-pendente">Pendente</span>
                  <?php else: ?>
                    <span class="status-realizada">Realizada</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="crud_inspecao.php?acao=editar&id=<?php echo urlencode($row['idInspecao']); ?>" class="btn btn-sm btn-primary btn-acao">Alterar</a>
                  <a href="crud_inspecao.php?acao=excluir&id=<?php echo urlencode($row['idInspecao']); ?>" class="btn btn-sm btn-danger btn-acao"
                     onclick="return confirm('Deseja realmente excluir esta inspeção?');">Excluir</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6">Nenhuma inspeção registrada.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- FORMULÁRIO: ADICIONAR INSPEÇÃO -->
    <div class="caixa">
      <div class="titulo-secao">ADICIONAR NOVA INSPEÇÃO</div>

      <form action="crud_inspecao.php" method="POST" class="mt-3">
        <input type="hidden" name="acao" value="inserir">
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Mês*</label>
            <input type="text" name="mes" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Data*</label>
            <input type="date" name="data" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Cód. Funcionário*</label>
            <input type="text" name="cod_funcionario" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Descrição</label>
          <input type="text" name="descricao" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Status*</label>
          <select name="status" class="form-select" required>
            <option value="Pendente">Pendente</option>
            <option value="Realizada">Realizada</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-salvar">Salvar</button>
        <button type="reset" class="btn btn-secondary">Cancelar</button>
      </form>
    </div>

    <!-- FORMULÁRIO: ADICIONAR MANUTENÇÃO -->
    <div class="caixa">
      <div class="titulo-secao">ADICIONAR MANUTENÇÃO</div>

      <form action="crud_manutencao.php" method="POST" class="mt-3">
        <input type="hidden" name="acao" value="inserir">
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Trem (número)*</label>
            <input type="number" name="trem" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Descrição*</label>
            <input type="text" name="descricao" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Cód. Funcionário*</label>
            <input type="text" name="cod_funcionario" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Status*</label>
          <select name="statusTrensManut" class="form-select" required>
            <option value="Pendente">Pendente</option>
            <option value="Realizada">Realizada</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-salvar">Salvar</button>
        <button type="reset" class="btn btn-secondary">Cancelar</button>
      </form>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// fecha conexão
$conn->close();
?>
