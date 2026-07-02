<?php

class Consulta {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    // 1. Listar todas as consultas trazendo os dados do animal e tutor
    public function listar() {
        $sql = "SELECT c.id, c.id_animal, c.veterinario, c.data_consulta, c.hora, c.descricao, c.valor,
                       a.nome as animal_nome, t.nome as tutor_nome 
                FROM consultas c
                INNER JOIN animais a ON c.id_animal = a.id
                LEFT JOIN tutores t ON a.id_tutor = t.id
                ORDER BY c.data_consulta DESC, c.hora DESC";
        $resultado = $this->conn->query($sql);

        $consultas = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $consultas[] = $linha;
            }
        }
        return $consultas;
    }

    // 2. Cadastrar uma nova consulta
    public function cadastrar($id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco) {
        $stmt = $this->conn->prepare("INSERT INTO consultas (id_animal, veterinario, data_consulta, hora, descricao, valor) VALUES (?, ?, ?, ?, ?, ?)");
        // i = id_animal, s = veterinario, s = data_consulta, s = hora, s = descricao, d = valor
        $stmt->bind_param("issssd", $id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco);
        return $stmt->execute();
    }

    // 3. Buscar uma consulta por ID para preencher a tela de edição
    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT id, id_animal, veterinario, data_consulta, hora as hora_consulta, descricao, valor as preco FROM consultas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // 4. Atualizar os dados da consulta (ORDEM TOTALMENTE CORRIGIDA)
    public function atualizar($id, $id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco) {
        // Ordem na Query SQL: 1º id_animal, 2º veterinario, 3º data_consulta, 4º hora, 5º descricao, 6º valor, 7º id (no WHERE)
        $stmt = $this->conn->prepare("UPDATE consultas SET id_animal = ?, veterinario = ?, data_consulta = ?, hora = ?, descricao = ?, valor = ? WHERE id = ?");
        
        // A ordem no bind_param PRECISA seguir rigorosamente a sequência dos pontos de interrogação (?) acima:
        // ? (id_animal -> i)
        // ? (veterinario -> s)
        // ? (data_consulta -> s)
        // ? (hora_consulta -> s)
        // ? (descricao -> s)
        // ? (preco -> d)
        // ? (id -> i)
        $stmt->bind_param("issssdi", $id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco, $id);
        
        return $stmt->execute();
    }

    // 5. Excluir uma consulta
    public function excluir($id) {
        $stmt = $this->conn->prepare("DELETE FROM consultas WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
