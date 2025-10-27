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

CREATE TABLE trens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  trem INT NOT NULL,
  descricao VARCHAR(100),
  cod_funcionario VARCHAR(20)
);

CREATE TABLE inspecoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mes VARCHAR(30),
  data DATE,
  descricao VARCHAR(100),
  status VARCHAR(20),
  cod_funcionario VARCHAR(20)
);

-- Alguns dados iniciais:
INSERT INTO trens (trem, descricao, cod_funcionario)
VALUES 
(192, 'Revisão Elétrica', '000687'),
(218, 'Troca de Freios', '000763'),
(401, 'Inspeção Geral', '000926'),
(502, 'Manutenção de Motor', '000453'),
(217, 'Substituição de Rodas', '000210');

CREATE TABLE
    IF NOT EXISTS manutencao (
        IdManutencao INT PRIMARY KEY AUTO_INCREMENT,
        NumTrem INT NOT NULL,
        Descricao VARCHAR(200),
        StatusManutencao VARCHAR(20) NOT NULL,
        CodFunc INT NOT NULL
    )

CREATE TABLE notificacoes (
    idNotificacoes INT AUTO_INCREMENT PRIMARY KEY,
    tipo_acao VARCHAR(50) NOT NULL, -- Ex: 'alerta_criado', 'manutencao_finalizada', 'inspecao_atualizada'
    mensagem_curta VARCHAR(255) NOT NULL, -- O texto que aparece no feed.
    id_referencia INT, -- O ID da linha na tabela original (alertas, manutencoes, etc.)
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    lida BOOLEAN DEFAULT FALSE
);