<?php
session_start();
session_unset(); // limpa variáveis da sessão
session_destroy(); // encerra a sessão
header("Location: ../login/login.php"); // caminho para sua tela de login
exit();
?>