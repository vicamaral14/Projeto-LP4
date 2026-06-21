<?php

include("../../config/conexao.php");

// Recebe os dados enviados pelo formulário

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];

// Monta o comando SQL

$sql = "INSERT INTO tutores
(nome, cpf, telefone, email, endereco)
VALUES
('$nome', '$cpf', '$telefone', '$email', '$endereco')";

// Executa o comando

$conn->query($sql);

// Redireciona para a listagem

header("Location: ../views/tutores/listar.php");

?>