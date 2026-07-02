<?php

class Tutor
{
    private $conn;

    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }

    // 1. Listar todos
    public function listar()
    {
        $sql = "SELECT id, nome, cpf, telefone, email FROM tutores ORDER BY nome";
        $resultado = $this->conn->query($sql);

        $tutores = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $tutores[] = $linha;
            }
        }
        return $tutores;
    }

    // 2. Cadastrar novo
    public function cadastrar($nome, $cpf, $telefone, $email)
    {
        $stmt = $this->conn->prepare("INSERT INTO tutores (nome, cpf, telefone, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $cpf, $telefone, $email);
        return $stmt->execute();
    }

    // 3. Buscar específico para editar
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT id, nome, cpf, telefone, email FROM tutores WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Atualizar dados existentes
    public function atualizar($id, $nome, $cpf, $telefone, $email) {
        $stmt = $this->conn->prepare("UPDATE tutores SET nome = ?, cpf = ?, telefone = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $cpf, $telefone, $email, $id);
        return $stmt->execute();
    }
    // 5. Excluir tutor do banco de dados
    public function excluir($id) {
    $stmt = $this->conn->prepare("DELETE FROM tutores WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
}
