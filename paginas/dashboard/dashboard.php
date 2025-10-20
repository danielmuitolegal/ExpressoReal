<?php
session_start();

if (!isset($_SESSION['usuario_nome'])) {
  header("Location: ../login/login.php");
  exit();
}

$nome = $_SESSION['usuario_nome'];
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
  <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="../../imagens/logo.png" alt="logo" width="38" height="30" loading="lazy">
      </a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-3"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item mx-3"><a class="nav-link active" href="#">Trens/Rotas</a></li>
          <li class="nav-item mx-3"><a class="nav-link active" href="#">Manutenção</a></li>
        </ul>

        <ul class="nav nav-pills">
          <li class="nav-item mx-3">
            <a class="nav-link active bg-primary" href="#">
              <img src="https://www.svgrepo.com/show/431413/alert.svg" alt="alerta" width="24">
            </a>
          </li>
        </ul>

        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>


  <div class="container text-center mt-4">
    <h1 class="text-center mt-3">Bem-vindo, <?php echo $nome . "!" ?></h1>
  </div>
  <div class="container-fluid mx-4 d-flex bg-light">
    <div class="my-2">
      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d28613.025616801246!2d-48.830873600000004!3d-26.3061504!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-BR!2sbr!4v1760107365028!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="false" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div>
      <div class="mt-2 mx-3 rounded" style="background-color: lightgray;">
        <table>
          <thead>
            <tr>
              <td class="bg-secondary rounded-top">
                <h2 class="text-light mt-1 mx-2">ATUALMENTE A EXPRESSO REAL TEM:</h2>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border">
                <p>Cidades atendidas: </p>
              </td>
            </tr>
            <tr>
              <td class="border">
                <p>Linhas ferroviárias: </p>
              </td>
            </tr>
            <tr>
              <td class="border">
                <p>Trens físicos: </p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>