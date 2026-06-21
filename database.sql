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