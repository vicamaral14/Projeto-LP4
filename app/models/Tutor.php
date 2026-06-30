<?php

class Tutor
{

    private $conn;

    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }

    public function listar()
    {

        $sql = "SELECT * FROM tutores ORDER BY nome";

        return $this->conn->query($sql);

    }

}