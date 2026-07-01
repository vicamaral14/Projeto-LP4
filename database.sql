-- ==========================================
-- BANCO DE DADOS
-- ==========================================
CREATE DATABASE IF NOT EXISTS clinica_veterinaria;
USE clinica_veterinaria;

-- ==========================================
-- TABELA DE USUÁRIOS
-- ==========================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- ==========================================
-- TABELA DE TUTORES
-- ==========================================
CREATE TABLE tutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(200)
);

-- ==========================================
-- TABELA DE ANIMAIS
-- ==========================================
CREATE TABLE animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especie VARCHAR(50) NOT NULL,
    raca VARCHAR(50),
    idade INT,
    peso DECIMAL(5,2),
    sexo ENUM('Macho','Fêmea'),
    id_tutor INT NOT NULL,

    CONSTRAINT fk_animal_tutor
        FOREIGN KEY (id_tutor)
        REFERENCES tutores(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================
-- TABELA DE CONSULTAS
-- ==========================================
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_animal INT NOT NULL,
    veterinario VARCHAR(100) NOT NULL,
    data_consulta DATE NOT NULL,
    hora TIME NOT NULL,
    descricao TEXT,
    valor DECIMAL(10,2),

    CONSTRAINT fk_consulta_animal
        FOREIGN KEY (id_animal)
        REFERENCES animais(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ==========================================
-- USUÁRIO PADRÃO
-- senha: 123456
-- ==========================================
INSERT INTO usuarios (nome, email, senha)
VALUES
('Administrador', 'admin@vet.com',
'$2y$10$89JubN9CgC66v7gX2t7wEu4nI.x3D3Aea.B99kU1Z2M6hFhA7d2re');

-- ==========================================
-- TUTORES
-- ==========================================
INSERT INTO tutores (nome, cpf, telefone, email, endereco) VALUES
('João Silva','111.111.111-11','(49)99999-1111','joao@email.com','Rua A, 100'),
('Maria Oliveira','222.222.222-22','(49)99999-2222','maria@email.com','Rua B, 200'),
('Carlos Souza','333.333.333-33','(49)99999-3333','carlos@email.com','Rua C, 300');

-- ==========================================
-- ANIMAIS
-- ==========================================
INSERT INTO animais (nome, especie, raca, idade, peso, sexo, id_tutor) VALUES
('Rex','Cachorro','Labrador',3,25.50,'Macho',1),
('Mimi','Gato','Siamês',2,4.20,'Fêmea',2),
('Thor','Cachorro','Pitbull',5,32.00,'Macho',1),
('Luna','Gato','Persa',1,3.80,'Fêmea',3),
('Mel','Cachorro','Golden Retriever',4,28.60,'Fêmea',2);

-- ==========================================
-- CONSULTAS
-- ==========================================
INSERT INTO consultas (id_animal, veterinario, data_consulta, hora, descricao, valor) VALUES
(1,'Dr. Pedro','2026-07-01','09:00:00','Consulta de rotina',120.00),
(2,'Dra. Ana','2026-07-02','10:30:00','Vacinação',80.00),
(3,'Dr. Lucas','2026-07-03','14:00:00','Exame clínico',150.00),
(4,'Dra. Marina','2026-07-04','15:30:00','Avaliação geral',100.00),
(5,'Dr. Pedro','2026-07-05','11:00:00','Retorno',60.00);
