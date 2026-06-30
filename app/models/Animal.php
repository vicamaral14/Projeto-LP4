<?php

class Animal {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    // 1. Listar todos os animais trazendo o nome do tutor associado
    public function listar() {
        $sql = "SELECT a.id, a.nome, a.especie, a.raca, a.idade, a.peso, a.sexo, a.id_tutor, t.nome as tutor_nome 
                FROM animais a 
                LEFT JOIN tutores t ON a.id_tutor = t.id 
                ORDER BY a.nome";
        $resultado = $this->conn->query($sql);

        $animais = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $animais[] = $linha;
            }
        }
        return $animais;
    }

    // 2. Cadastrar novo animal
    public function cadastrar($nome, $especie, $raca, $idade, $peso, $sexo, $id_tutor) {
        $stmt = $this->conn->prepare("INSERT INTO animais (nome, especie, raca, idade, peso, sexo, id_tutor) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssidsi", $nome, $especie, $raca, $idade, $peso, $sexo, $id_tutor);
        return $stmt->execute();
    }

    // 3. Buscar um animal por ID para preencher o formulário de edição
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT id, nome, especie, raca, idade, peso, sexo, id_tutor FROM animais WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Atualizar dados do animal cadastrado
    public function atualizar($id, $nome, $especie, $raca, $idade, $peso, $sexo, $id_tutor) {
        $stmt = $this->conn->prepare("UPDATE animais SET nome = ?, especie = ?, raca = ?, idade = ?, peso = ?, sexo = ?, id_tutor = ? WHERE id = ?");
        $stmt->bind_param("sssidsii", $nome, $especie, $raca, $idade, $peso, $sexo, $id_tutor, $id);
        return $stmt->execute();
    }

    // 5. Excluir animal do banco de dados
    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM animais WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>