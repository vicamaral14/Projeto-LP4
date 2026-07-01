CREATE TABLE tutores(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco VARCHAR(200)
);

CREATE TABLE animais(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    especie VARCHAR(50),
    raca VARCHAR(50),
    idade INT,
    peso DECIMAL(5,2),
    sexo VARCHAR(10),
    id_tutor INT,
    FOREIGN KEY(id_tutor) REFERENCES tutores(id)
);

CREATE TABLE consultas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_animal INT,
    veterinario VARCHAR(100),
    data_consulta DATE,
    hora TIME,
    descricao TEXT,
    valor DECIMAL(10,2),
    FOREIGN KEY(id_animal) REFERENCES animais(id)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Inserindo o administrador com a senha "123456" criptografada de forma segura
INSERT INTO usuarios (nome, email, senha) VALUES 
('Administrador', 'admin@vet.com', '$2y$10$89JubN9CgC66v7gX2t7wEu4nI.x3D3Aea.B99kU1Z2M6hFhA7d2re');