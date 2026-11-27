CREATE DATABASE aluguel_quadras;

USE aluguel_quadras;

CREATE TABLE cliente (
    id_cliente INT NOT NULL AUTO_INCREMENT,
    nome_completo VARCHAR(60) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    status_cadastro VARCHAR(10) NOT NULL,
    senha VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id_cliente)
);

CREATE TABLE empresa (
    id_empresa INT NOT NULL AUTO_INCREMENT,
    razao_social VARCHAR(100) NOT NULL,
    nome_fantasia VARCHAR(80) NOT NULL,
    cnpj CHAR(14) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    status_cadastro VARCHAR(10) NOT NULL,
    PRIMARY KEY (id_empresa)
);

CREATE TABLE esporte (
    id_esporte INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(80) NOT NULL UNIQUE,
    descricao VARCHAR(300),
    status VARCHAR(10) NOT NULL,
    PRIMARY KEY (id_esporte)
);

CREATE TABLE quadra (
    id_quadra INT NOT NULL AUTO_INCREMENT,
    id_empresa INT NOT NULL,
    nome VARCHAR(70) NOT NULL,
    descricao VARCHAR(300),
    tipo_piso VARCHAR(30) NOT NULL,
    cobertura BOOLEAN NOT NULL,
    capacidade INT NOT NULL,
    valor_hora DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_quadra),
    CONSTRAINT fk_quadra_empresa
        FOREIGN KEY (id_empresa)
        REFERENCES empresa(id_empresa)
);

CREATE TABLE horario_funcionamento (
    id_horario INT NOT NULL AUTO_INCREMENT,
    id_quadra INT NOT NULL,
    dia_semana VARCHAR(15) NOT NULL,
    hora_abertura TIME NOT NULL,
    hora_encerramento TIME NOT NULL,
    intervalo_reservas INT NOT NULL,
    PRIMARY KEY (id_horario),
    CONSTRAINT fk_horario_quadra
        FOREIGN KEY (id_quadra)
        REFERENCES quadra(id_quadra)
);

CREATE TABLE material_esportivo (
    id_material INT NOT NULL AUTO_INCREMENT,
    id_empresa INT NOT NULL,
    nome VARCHAR(60) NOT NULL,
    descricao VARCHAR(300),
    quantidade_total INT NOT NULL,
    valor_aluguel DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) NOT NULL,
    PRIMARY KEY (id_material),
    CONSTRAINT fk_material_empresa
        FOREIGN KEY (id_empresa)
        REFERENCES empresa(id_empresa)
);

CREATE TABLE reserva (
    id_reserva INT NOT NULL AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_quadra INT NOT NULL,
    data_reserva DATE NOT NULL,
    hora_inicial TIME NOT NULL,
    hora_final TIME NOT NULL,
    data_hora_registro DATETIME NOT NULL,
    status VARCHAR(15) NOT NULL,
    observacao VARCHAR(500),
    valor_total DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_reserva),
    CONSTRAINT fk_reserva_cliente
        FOREIGN KEY (id_cliente)
        REFERENCES cliente(id_cliente),
    CONSTRAINT fk_reserva_quadra
        FOREIGN KEY (id_quadra)
        REFERENCES quadra(id_quadra)
);

CREATE TABLE quadra_esporte (
    id_quadra INT NOT NULL,
    id_esporte INT NOT NULL,
    PRIMARY KEY (id_quadra, id_esporte),
    CONSTRAINT fk_quadra_esporte_quadra
        FOREIGN KEY (id_quadra)
        REFERENCES quadra(id_quadra),
    CONSTRAINT fk_quadra_esporte_esporte
        FOREIGN KEY (id_esporte)
        REFERENCES esporte(id_esporte)
);

CREATE TABLE item_material_reserva (
    id_reserva INT NOT NULL,
    id_material INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_reserva, id_material),
    CONSTRAINT fk_item_reserva
        FOREIGN KEY (id_reserva)
        REFERENCES reserva(id_reserva),
    CONSTRAINT fk_item_material
        FOREIGN KEY (id_material)
        REFERENCES material_esportivo(id_material)
);

SELECT
    id_cliente,
    nome_completo,
    cpf,
    telefone,
    email,
    status_cadastro
FROM cliente
WHERE id_cliente = 1;

INSERT INTO cliente (id_cliente, nome_completo, cpf, telefone, email, status_cadastro)
VALUES (1, 'Benício Buhrer de Lima', '11111111111', '41933333333', 'benicio@gmail.com', 'ativo');

SELECT id_cliente, nome_completo, cpf, telefone, email, status_cadastro
FROM cliente
WHERE id_cliente = 1;

UPDATE cliente
SET telefone = '41900000003'
WHERE id_cliente = 1;

SELECT id_cliente, nome_completo, cpf, telefone, email, status_cadastro
FROM cliente
WHERE id_cliente = 1;

DELETE FROM cliente
WHERE id_cliente = 1;

SELECT id_cliente, nome_completo, cpf, telefone, email, status_cadastro
FROM cliente
WHERE id_cliente = 1;

SELECT id_cliente, nome_completo, cpf, telefone, email, status_cadastro
FROM cliente
WHERE id_cliente BETWEEN 2 AND 8;

INSERT INTO cliente (id_cliente, nome_completo, cpf, telefone, email, status_cadastro)
VALUES 
(2, 'Paulo Teste', '22222222222', '41990000002', 'paulo@gmail.com', 'ativo'),
(3, 'Berger Teste', '33333333333', '41990000003', 'berger@gmail.com', 'ativo'),
(4, 'Guilherme Teste', '44444444444', '41990000004', 'guilherme@gmail.com', 'ativo'),
(5, 'Eduardo Teste', '55555555555', '41990000005', 'eduardo@gmail.com', 'ativo'),
(6, 'Inacio Teste', '66666666666', '41990000006', 'inacio@gmail.com', 'ativo'),
(7, 'Fernando Teste', '77777777777', '41990000007', 'fernando@gmail.com', 'ativo'),
(8, 'Abimael Teste', '88888888888', '41990000008', 'abimael@gmail.com', 'ativo');

SELECT id_cliente, nome_completo, cpf, telefone, email, status_cadastro FROM cliente
WHERE status_cadastro = 'ativo';

SELECT id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro
FROM empresa
WHERE id_empresa = 1;

INSERT INTO empresa (id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro)
VALUES (1, 'Arena Demonstracao Ltda', 'Arena Demonstracao', '90000001000129', '4133330001',
		'arena.demo@example.com', 'Rua Teste, 100, Centro, Curitiba, 80000000', 'ativa');

SELECT id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro
FROM empresa
WHERE id_empresa = 1;

UPDATE empresa
SET telefone = '41990002222'
WHERE id_empresa = 1;

SELECT id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro
FROM empresa
WHERE id_empresa = 1;

DELETE FROM empresa
WHERE id_empresa = 1;

SELECT id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro
FROM empresa
WHERE id_empresa = 1;

SELECT id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro
FROM empresa
WHERE id_empresa BETWEEN 2 AND 8;

INSERT INTO empresa (id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro)
VALUES
(2, 'Empresa Teste 2 Ltda', 'Arena Teste 2', '80000002000120', '4130000002', 'empresa2@example.com', 'Rua Teste, 2, Centro, Curitiba, 80000000', 'ativa'),
(3, 'Empresa Teste 3 Ltda', 'Arena Teste 3', '80000003000130', '4130000003', 'empresa3@example.com', 'Rua Teste, 3, Centro, Curitiba, 80000000', 'ativa'),
(4, 'Empresa Teste 4 Ltda', 'Arena Teste 4', '80000004000140', '4130000004', 'empresa4@example.com', 'Rua Teste, 4, Centro, Curitiba, 80000000', 'ativa'),
(5, 'Empresa Teste 5 Ltda', 'Arena Teste 5', '80000005000150', '4130000005', 'empresa5@example.com', 'Rua Teste, 5, Centro, Curitiba, 80000000', 'ativa'),
(6, 'Empresa Teste 6 Ltda', 'Arena Teste 6', '80000006000160', '4130000006', 'empresa6@example.com', 'Rua Teste, 6, Centro, Curitiba, 80000000', 'ativa'),
(7, 'Empresa Teste 7 Ltda', 'Arena Teste 7', '80000007000170', '4130000007', 'empresa7@example.com', 'Rua Teste, 7, Centro, Curitiba, 80000000', 'ativa'),
(8, 'Empresa Teste 8 Ltda', 'Arena Teste 8', '80000008000180', '4130000008', 'empresa8@example.com', 'Rua Teste, 8, Centro, Curitiba, 80000000', 'ativa');

SELECT id_empresa, razao_social, nome_fantasia, cnpj, telefone, email, endereco, status_cadastro
FROM empresa
WHERE status_cadastro = 'ativa';


SELECT id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status
FROM quadra
WHERE id_quadra = 1;

INSERT INTO quadra (id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status)
VALUES (1, 2, 'Quadra Volei', 'Quadra para demonstracao', 'Madeira', 1, 20, 90.00, 'ativa');

SELECT id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status
FROM quadra
WHERE id_quadra = 1;

UPDATE quadra
SET valor_hora = 110.00
WHERE id_quadra = 1;

SELECT id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status
FROM quadra
WHERE id_quadra = 1;

DELETE FROM quadra
WHERE id_quadra = 1;

SELECT id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status
FROM quadra
WHERE id_quadra = 1;

SELECT id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status
FROM quadra
WHERE id_quadra BETWEEN 2 AND 8;

INSERT INTO quadra (id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status)
VALUES
(2, 2, 'Quadra 2', 'Quadra de futsal', 'cimento', 1, 12, 100.00, 'ativa'),
(3, 3, 'Quadra 3', 'Quadra de basquete', 'madeira', 1, 12, 120.00, 'ativa'),
(4, 4, 'Quadra 4', 'Quadra de futevolei', 'madeira', 1, 14, 90.00, 'ativa'),
(5, 5, 'Quadra 5', 'Quadra de tenis', 'cimento', 0, 4, 80.00, 'ativa'),
(6, 6, 'Quadra 6', 'Quadra de beach tennis', 'areia', 0, 4, 100.00, 'ativa'),
(7, 7, 'Quadra 7', 'Quadra de handebol', 'cimento', 1, 16, 110.00, 'ativa'),
(8, 8, 'Quadra 8', 'Quadra de badminton', 'madeira', 1, 4, 70.00, 'ativa');

SELECT id_quadra, id_empresa, nome, descricao, tipo_piso, cobertura, capacidade, valor_hora, status
FROM quadra
WHERE status = 'ativa';

SELECT id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status
FROM material_esportivo
WHERE id_material = 1;

INSERT INTO material_esportivo (id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status)
VALUES (1, 2, 'Bola Demonstracao', 'Material para demonstracao', 10, 15.00, 'disponivel');

SELECT id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status
FROM material_esportivo
WHERE id_material = 1;

UPDATE material_esportivo
SET quantidade_total = 12
WHERE id_material = 1;

SELECT id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status
FROM material_esportivo
WHERE id_material = 1;

DELETE FROM material_esportivo
WHERE id_material = 1;

SELECT id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status
FROM material_esportivo
WHERE id_material = 1;

SELECT id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status
FROM material_esportivo
WHERE id_material BETWEEN 2 AND 8;

INSERT INTO material_esportivo (id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status)
VALUES
(2, 2, 'Bola de futsal', 'Bola para futsal', 10, 10.00, 'disponivel'),
(3, 3, 'Bola de basquete', 'Bola para basquete', 8, 12.00, 'disponivel'),
(4, 4, 'Bola de volei', 'Bola para volei', 12, 10.00, 'disponivel'),
(5, 5, 'Raquete de tenis', 'Raquete para tenis', 6, 20.00, 'disponivel'),
(6, 6, 'Raquete de beach tennis', 'Raquete para beach tennis', 8, 15.00, 'disponivel'),
(7, 7, 'Bola de handebol', 'Bola para handebol', 10, 10.00, 'disponivel'),
(8, 8, 'Raquete de badminton', 'Raquete para badminton', 6, 12.00, 'disponivel');

SELECT id_material, id_empresa, nome, descricao, quantidade_total, valor_aluguel, status
FROM material_esportivo
WHERE status = 'disponivel';

SELECT id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas
FROM horario_funcionamento
WHERE id_horario = 1;

INSERT INTO horario_funcionamento (id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas)
VALUES (1, 2, 'terca-feira', '08:00:00', '22:00:00', 60);

SELECT id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas
FROM horario_funcionamento
WHERE id_horario = 1;

UPDATE horario_funcionamento
SET hora_abertura = '09:00:00'
WHERE id_horario = 1;

SELECT id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas
FROM horario_funcionamento
WHERE id_horario = 1;

DELETE FROM horario_funcionamento
WHERE id_horario = 1;

SELECT id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas
FROM horario_funcionamento
WHERE id_horario = 1;

SELECT id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas
FROM horario_funcionamento
WHERE id_horario BETWEEN 2 AND 8;

INSERT INTO horario_funcionamento (id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas)
VALUES
(2, 2, 'segunda-feira', '08:00:00', '22:00:00', 60),
(3, 3, 'segunda-feira', '09:00:00', '22:00:00', 60),
(4, 4, 'segunda-feira', '08:00:00', '21:00:00', 60),
(5, 5, 'segunda-feira', '07:00:00', '20:00:00', 60),
(6, 6, 'segunda-feira', '08:00:00', '23:00:00', 60),
(7, 7, 'segunda-feira', '09:00:00', '21:00:00', 60),
(8, 8, 'segunda-feira', '08:00:00', '20:00:00', 60);

SELECT id_horario, id_quadra, dia_semana, hora_abertura, hora_encerramento, intervalo_reservas
FROM horario_funcionamento
WHERE dia_semana = 'segunda-feira';