-- cria o banco de dados
CREATE DATABASE IF NOT EXISTS expresso_real;

-- usa o banco de dados criado
USE expresso_real;

-- cria tabela "usuario" para armazenar os conteúdos recebidos pelo form (Nome de usuário, email e senha)
-- cria também um Id, data de cadastro e daa de atualização automáticas dentro do banco, 
-- disponível como chave primária para melhor organização e identificação do usuário para os adms.
CREATE TABLE
    IF NOT EXISTS usuario (
        IdUsuario INT PRIMARY KEY AUTO_INCREMENT,
        NomeUsuario VARCHAR(60) NOT NULL UNIQUE,
        EmailUsuario VARCHAR(60) NOT NULL UNIQUE,
        DataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        DataAtualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        SenhaHash char(60) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS sensor (
        IdSensor INT PRIMARY KEY AUTO_INCREMENT,
        NomeSensor VARCHAR(60) NOT NULL,
        TipoSensor VARCHAR(60) NOT NULL,
        DataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        StatusSensor VARCHAR(20) NOT NULL
    );

CREATE TABLE IF NOT EXISTS trens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  trem INT NOT NULL,
  descricao VARCHAR(100),
  cod_funcionario VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS inspecoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mes VARCHAR(30),
  data DATE,
  descricao VARCHAR(100),
  status VARCHAR(20),
  cod_funcionario VARCHAR(20)
);

USE expresso_real;

-- Cria a tabela de trens em manutenção
USE expresso_real;

CREATE TABLE trens_manutencao (
  trem INT PRIMARY KEY,
  descricao VARCHAR(100) NOT NULL,
  cod_funcionario VARCHAR(10) NOT NULL
);

CREATE TABLE calendario_inspecoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mes VARCHAR(20) NOT NULL,
  data DATE NOT NULL,
  cod_funcionario VARCHAR(10) NOT NULL,
  status VARCHAR(20) NOT NULL
);


