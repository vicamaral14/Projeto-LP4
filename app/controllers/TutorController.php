<?php

// Inclui o arquivo que cria a conexão com o banco de dados.
include("../../config/conexao.php");

// Recebe a ação enviada pela URL ou pelo formulário.
// Exemplo: cadastrar, atualizar ou excluir.
$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

// Se a ação for cadastrar um tutor...
if ($acao == "cadastrar") {

    // Recebe os dados enviados pelo formulário.
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];

    // Prepara o comando SQL com ? para evitar SQL Injection.
    $sql = "INSERT INTO tutores (nome, cpf, telefone, email, endereco)
            VALUES (?, ?, ?, ?, ?)";

    // Prepara a consulta para receber os valores.
    $comando = $conn->prepare($sql);

    // Associa os valores aos ? da consulta.
    // Os cinco "s" significam que os cinco valores são textos (strings).
    $comando->bind_param("sssss", $nome, $cpf, $telefone, $email, $endereco);

    // Executa o INSERT.
    $comando->execute();

    // Volta para a página de listagem.
    header("Location: ../views/tutores/listar.php");
    exit;
}

// Se a ação for atualizar um tutor...
if ($acao == "atualizar") {

    // Recebe o ID do tutor e os novos dados do formulário.
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];

    // Atualiza o tutor que possui o ID informado.
    $sql = "UPDATE tutores
            SET nome = ?, cpf = ?, telefone = ?, email = ?, endereco = ?
            WHERE id = ?";

    // Prepara a consulta.
    $comando = $conn->prepare($sql);

    // "sssssi": cinco textos e um inteiro (o id).
    $comando->bind_param("sssssi", $nome, $cpf, $telefone, $email, $endereco, $id);

    // Executa o UPDATE.
    $comando->execute();

    // Retorna para a listagem.
    header("Location: ../views/tutores/listar.php");
    exit;
}

// Se a ação for excluir um tutor...
if ($acao == "excluir") {

    // Recebe o ID pela URL.
    $id = $_GET['id'];

    // Cria o comando para excluir o tutor pelo ID.
    $sql = "DELETE FROM tutores WHERE id = ?";

    // Prepara a consulta.
    $comando = $conn->prepare($sql);

    // "i" significa que o ID é um número inteiro.
    $comando->bind_param("i", $id);

    // Executa o DELETE.
    $comando->execute();

    // Retorna para a listagem.
    header("Location: ../views/tutores/listar.php");
    exit;
}

// Caso nenhuma ação válida seja recebida, volta para a listagem.
header("Location: ../views/tutores/listar.php");
exit;