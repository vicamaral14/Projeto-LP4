<?php

class Animal
{
    private $conn;

    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }

    public function listar()
    {
        $sql = "SELECT animais.*, tutores.nome AS nome_tutor
                FROM animais
                INNER JOIN tutores
                ON animais.id_tutor = tutores.id
                ORDER BY animais.nome";

        return $this->conn->query($sql);
    }
}