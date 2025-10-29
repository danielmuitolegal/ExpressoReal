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

CREATE TABLE
    IF NOT EXISTS trens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        trem INT NOT NULL,
        descricao VARCHAR(100),
        cod_funcionario VARCHAR(20)
    );

CREATE TABLE
    IF NOT EXISTS inspecoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        mes VARCHAR(30),
        data DATE,
        descricao VARCHAR(100),
        status VARCHAR(20),
        cod_funcionario VARCHAR(20)
    );

CREATE TABLE
    IF NOT EXISTS trens_manutencao (
        trem INT PRIMARY KEY,
        descricao VARCHAR(100) NOT NULL,
        cod_funcionario VARCHAR(10) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS manutencao (
        IdManutencao INT PRIMARY KEY AUTO_INCREMENT,
        NumTrem INT NOT NULL,
        Descricao VARCHAR(200),
        StatusManutencao VARCHAR(20) NOT NULL,
        CodFunc INT NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS notificacoes (
        idNotificacoes INT AUTO_INCREMENT PRIMARY KEY,
        tipo_acao VARCHAR(50) NOT NULL, -- Ex: 'alerta_criado', 'manutencao_finalizada', 'inspecao_atualizada'
        mensagem_curta VARCHAR(255) NOT NULL, -- O texto que aparece no feed.
        id_referencia INT, -- O ID da linha na tabela original (alertas, manutencoes, etc.)
        data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        lida BOOLEAN DEFAULT FALSE
    );

CREATE TABLE
    IF NOT EXISTS estacoes (
        id int (11) NOT NULL,
        `nome` varchar(100) NOT NULL,
        `latitude` decimal(10, 8) NOT NULL,
        `longitude` decimal(11, 8) NOT NULL,
        `endereco` text DEFAULT NULL,
        `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
    );

CREATE TABLE `rotas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `distancia_km` decimal(8,2) DEFAULT NULL,
  `tempo_estimado_min` int(11) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
);

CREATE TABLE `rota_estacoes` (
  `id` int(11) NOT NULL,
  `id_rota` int(11) NOT NULL,
  `id_estacao` int(11) NOT NULL,
  `ordem` int(11) NOT NULL
);

INSERT INTO
    `estacoes` (
        `id`,
        `nome`,
        `latitude`,
        `longitude`,
        `endereco`,
        `data_criacao`
    )
VALUES
    (
        1,
        'Estação 1',
        -26.30400000,
        -48.84600000,
        'Joinville',
        '2025-10-27 11:11:09'
    ),
    (
        2,
        'Estação 2',
        -3.73045100,
        -38.52179900,
        'Fortaleza',
        '2025-10-27 11:13:07'
    ),
    (
        3,
        'Estação 1.1',
        -25.42770000,
        -49.27310000,
        'Curitiba',
        '2025-10-27 14:58:37'
    ),
    (
        4,
        'Estação 1.2',
        -23.59140000,
        -48.05310000,
        'Itapetininga',
        '2025-10-27 14:59:50'
    ),
    (
        5,
        'Estação 1.3',
        -19.92270000,
        -43.94510000,
        'Belo Horizonte',
        '2025-10-27 15:00:29'
    ),
    (
        6,
        'Estação 1.4',
        -18.85000000,
        -41.94000000,
        'Governador Valadares',
        '2025-10-27 15:01:26'
    ),
    (
        7,
        'Estação 1.5',
        -9.39000000,
        -40.50000000,
        'Petrolina',
        '2025-10-27 15:02:21'
    ),
    (
        8,
        'Estação 1.6',
        -7.21300000,
        -39.31500000,
        'Juazeiro do Norte',
        '2025-10-27 15:03:02'
    ),
    (
        9,
        'Estação 1.7',
        -7.23000000,
        -35.88000000,
        'Campina Grande',
        '2025-10-27 15:04:08'
    ),
    (
        10,
        'Estação 1.8',
        -5.96166700,
        -35.20888900,
        'Natal',
        '2025-10-27 15:05:12'
    ),
    (
        11,
        'Estação 1.9',
        -5.18412850,
        -37.34778050,
        'Mossoró',
        '2025-10-27 15:05:57'
    );

INSERT INTO `rotas` (`id`, `nome`, `distancia_km`, `tempo_estimado_min`, `data_criacao`) VALUES
(1, 'Rota Sul-Norte', 3511.25, 3511, '2025-10-27 15:36:21');
    
INSERT INTO `rota_estacoes` (`id`, `id_rota`, `id_estacao`, `ordem`) VALUES
(1, 1, 1, 0),
(2, 1, 3, 1),
(3, 1, 4, 2),
(4, 1, 5, 3),
(5, 1, 6, 4),
(6, 1, 7, 5),
(7, 1, 8, 6),
(8, 1, 9, 7),
(9, 1, 10, 8),
(10, 1, 11, 9),
(11, 1, 2, 10);