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
        StatusSensor VARCHAR(20) DEFAULT 
    );