<?php
session_start();

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

// Carrega trens e inspeções
$sql_trens = "SELECT trem, descricao, cod_funcionario, statusTrensManut FROM trens_manutencao ORDER BY trem ASC";
$result_trens = $conn->query($sql_trens);

$sql_inspecoes = "SELECT idInspecao, mes, data, descricao, cod_funcionario, status FROM inspecoes ORDER BY data DESC";
$result_inspecoes = $conn->query($sql_inspecoes);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Manutenção - Expresso Real</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5f5f5; }
    .container { max-width: 1200px; }
    .caixa { background:#e9ecef; padding:16px; border-radius:8px; margin-bottom:20px; }
    .titulo-secao { background:#555; color:#fff; padding:8px; text-align:center; border-radius:6px; margin-bottom:12px; font-weight:600; }
    table { width:100%; }
    th, td { vertical-align: middle !important; text-align:center; }
    .status-pendente { color:#b22222; font-weight:700; }
    .status-realizada { color:#228B22; font-weight:700; }
    .btn-acao { margin:0 4px; }
    #mensagemGlobal { margin-bottom:12px; }
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="../dashboard/dashboard.php">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30" class="me-2"> Expresso Real
      </a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item mx-2"><a class="nav-link" href="../itinerarios/itinerarios.php">Trens/Rotas</a></li>
          <li class="nav-item mx-2"><a class="nav-link active" href="../manutenção/manutencao.php">Manutenção</a></li>
        </ul>
        <span class="navbar-text me-3">Olá, <?= htmlspecialchars($nome) ?></span>
        <a class="btn btn-outline-dark btn-sm" href="../login/logout.php">Sair</a>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div id="mensagemGlobal"></div>

    <!-- TRENS EM MANUTENÇÃO -->
    <div class="caixa">
      <div class="titulo-secao">TRENS EM MANUTENÇÃO</div>

      <table id="tabelaTrens" class="table table-striped table-sm">
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
            <?php while ($r = $result_trens->fetch_assoc()): ?>
              <tr data-trem="<?= htmlspecialchars($r['trem']) ?>">
                <td><?= htmlspecialchars($r['trem']) ?></td>
                <td><?= htmlspecialchars($r['descricao']) ?></td>
                <td><?= htmlspecialchars($r['cod_funcionario']) ?></td>
                <td><?= htmlspecialchars($r['statusTrensManut']) ?></td>
                <td>
                  <button class="btn btn-sm btn-primary btn-acao btn-editar-manut" data-trem="<?= htmlspecialchars($r['trem']) ?>">Alterar</button>
                  <button class="btn btn-sm btn-danger btn-acao btn-excluir-manut" data-trem="<?= htmlspecialchars($r['trem']) ?>">Excluir</button>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5">Nenhum trem em manutenção encontrado.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- FORMULÁRIO: ADICIONAR MANUTENÇÃO (AJAX) -->
    <div class="caixa">
      <div class="titulo-secao">ADICIONAR MANUTENÇÃO</div>
      <form id="formManutencao" class="row g-3">
        <input type="hidden" name="acao" value="inserir">
        <div class="col-md-3">
          <label class="form-label">Trem (número)*</label>
          <input type="number" name="trem" class="form-control" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Descrição*</label>
          <input type="text" name="descricao" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Cód. Funcionário*</label>
          <input type="text" name="cod_funcionario" class="form-control" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Status*</label>
          <select name="statusTrensManut" class="form-select" required>
            <option value="Pendente">Pendente</option>
            <option value="Realizada">Realizada</option>
          </select>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form>
    </div>

    <!-- INSPEÇÕES (apenas listagem aqui) -->
    <div class="caixa">
      <div class="titulo-secao">CALENDÁRIO DE INSPEÇÕES</div>
      <table id="tabelaInspecoes" class="table table-striped table-sm">
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
            <?php while ($r = $result_inspecoes->fetch_assoc()): ?>
              <tr data-id="<?= htmlspecialchars($r['idInspecao']) ?>">
                <td><?= htmlspecialchars($r['mes']) ?></td>
                <td><?= htmlspecialchars($r['data']) ?></td>
                <td><?= htmlspecialchars($r['descricao']) ?></td>
                <td><?= htmlspecialchars($r['cod_funcionario']) ?></td>
                <td>
                  <?php if ($r['status'] === 'Pendente'): ?>
                    <span class="status-pendente">Pendente</span>
                  <?php else: ?>
                    <span class="status-realizada">Realizada</span>
                  <?php endif; ?>
                </td>
                <td>
                  <button class="btn btn-sm btn-primary btn-acao btn-editar-inspec" data-id="<?= htmlspecialchars($r['idInspecao']) ?>">Alterar</button>
                  <button class="btn btn-sm btn-danger btn-acao btn-excluir-inspec" data-id="<?= htmlspecialchars($r['idInspecao']) ?>">Excluir</button>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6">Nenhuma inspeção registrada.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- FORMULÁRIO: ADICIONAR INSPEÇÃO (submete para crud_inspecao.php — se quiser AJAX, eu adiciono também) -->
    <div class="caixa">
      <div class="titulo-secao">ADICIONAR NOVA INSPEÇÃO</div>
      <form id="formInspecao" action="crud_inspecao.php" method="POST" class="row g-3">
        <input type="hidden" name="acao" value="inserir">
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

        <div class="col-md-8">
          <label class="form-label">Descrição</label>
          <input type="text" name="descricao" class="form-control">
        </div>
        <div class="col-md-4">
          <label class="form-label">Status*</label>
          <select name="status" class="form-select" required>
            <option value="Pendente">Pendente</option>
            <option value="Realizada">Realizada</option>
          </select>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <button type="reset" class="btn btn-secondary">Cancelar</button>
        </div>
      </form>
    </div>

  </div>

<script>
/**
 * Util: mostra mensagem global de forma simples (bootstrap alert)
 * type: 'success' | 'danger' | 'warning'
 */
function showGlobalMessage(text, type = 'success', timeout = 4000) {
  const container = document.getElementById('mensagemGlobal');
  container.innerHTML = `<div class="alert alert-${type}">${text}</div>`;
  if (timeout > 0) {
    setTimeout(() => { container.innerHTML = ''; }, timeout);
  }
}

/* ----------------- AJAX: adicionar manutenção ----------------- */
document.getElementById('formManutencao').addEventListener('submit', async function(e){
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  try {
    const resp = await fetch('crud_manutencao.php', {
      method: 'POST',
      body: formData
    });
    const data = await resp.json();

    if (data.success) {
      showGlobalMessage(data.mensagem, 'success');

      // adiciona linha na tabela sem recarregar
      const tbody = document.querySelector('#tabelaTrens tbody');
      const tr = document.createElement('tr');
      tr.setAttribute('data-trem', data.row.trem);
      tr.innerHTML = `
        <td>${data.row.trem}</td>
        <td>${data.row.descricao}</td>
        <td>${data.row.cod_funcionario}</td>
        <td>${data.row.statusTrensManut}</td>
        <td>
          <button class="btn btn-sm btn-primary btn-acao btn-editar-manut" data-trem="${data.row.trem}">Alterar</button>
          <button class="btn btn-sm btn-danger btn-acao btn-excluir-manut" data-trem="${data.row.trem}">Excluir</button>
        </td>
      `;
      tbody.prepend(tr);
      form.reset();
    } else {
      showGlobalMessage(data.mensagem, 'danger');
    }
  } catch (err) {
    showGlobalMessage('Erro na requisição: ' + err.message, 'danger');
  }
});

/* ----------------- AJAX: excluir manutenção (POST com acao=excluir) ----------------- */
async function excluirManutencao(trem) {
  if (!confirm('Confirma exclusão da manutenção do trem ' + trem + '?')) return;

  try {
    const body = new URLSearchParams();
    body.append('acao', 'excluir');
    body.append('trem', String(trem));

    const resp = await fetch('crud_manutencao.php', {
      method: 'POST',
      body: body
    });

    const data = await resp.json();

    if (data.success) {
      showGlobalMessage(data.mensagem, 'success');
      // remove linha da tabela
      const row = document.querySelector(`#tabelaTrens tbody tr[data-trem="${trem}"]`);
      if (row) row.remove();
    } else {
      showGlobalMessage(data.mensagem, 'danger');
    }
  } catch (err) {
    showGlobalMessage('Erro na requisição: ' + err.message, 'danger');
  }
}

/* ----------------- delegação de eventos para botões dinamicamente adicionados ----------------- */
document.addEventListener('click', function(e){
  // excluir manutenção
  if (e.target && e.target.classList.contains('btn-excluir-manut')) {
    const trem = e.target.getAttribute('data-trem');
    excluirManutencao(trem);
  }

  // editar manutenção: abre página de edição (GET) - essa rota exibe o formulário preenchido
  if (e.target && e.target.classList.contains('btn-editar-manut')) {
    const trem = e.target.getAttribute('data-trem');
    // abre o editor (crud_manutencao.php?acao=editar&id=...)
    window.location.href = 'crud_manutencao.php?acao=editar&id=' + encodeURIComponent(trem);
  }

  // excluir inspeção (se quiser que exclua via AJAX usando crud_inspecao.php)
  if (e.target && e.target.classList.contains('btn-excluir-inspec')) {
    const id = e.target.getAttribute('data-id');
    if (!confirm('Confirma exclusão da inspeção?')) return;
    // request via POST to crud_inspecao.php
    (async () => {
      try {
        const body = new URLSearchParams();
        body.append('acao', 'excluir');
        body.append('id', String(id));
        const r = await fetch('crud_inspecao.php', { method: 'POST', body });
        const j = await r.json();
        if (j.success) {
          showGlobalMessage(j.mensagem, 'success');
          const row = document.querySelector(`#tabelaInspecoes tbody tr[data-id="${id}"]`);
          if (row) row.remove();
        } else {
          showGlobalMessage(j.mensagem, 'danger');
        }
      } catch (err) {
        showGlobalMessage('Erro na requisição: ' + err.message, 'danger');
      }
    })();
  }

  // editar inspeção: abre editor (crud_inspecao.php?acao=editar&id=...)
  if (e.target && e.target.classList.contains('btn-editar-inspec')) {
    const id = e.target.getAttribute('data-id');
    window.location.href = 'crud_inspecao.php?acao=editar&id=' + encodeURIComponent(id);
  }
});
</script>

</body>
</html>

<?php
$conn->close();
?>
