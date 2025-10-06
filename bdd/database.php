<?php
// endereço onde ta o MySQL (estamos rodando no localhost porque nao temos servidor)
$host = "localhost";

// quem ta usando o SQL, configurado la no xampp
$usuario = "root";

// senha do usuario do MySQL, também tem como configurar, mas a padrão é nenhuma
$senha = "root";

// nome do nosso banco de dados
$banco = "expresso_real";

// porta usada
$porta = "3307";

// cria conexão com o banco usando o MySQLi
$conn = new mysqli($host, $usuario, $senha, $banco, $porta);

// verifica se tem erro na conexão
if ($conn->connect_error) {
    // Se der erro, o código para aqui e mostra a mensagem
    die("Falha na conexão: " . $conn->connect_error);
}
?>