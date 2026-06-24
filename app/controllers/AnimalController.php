<?php

// Inclui a conexão com o banco de dados.
// Este arquivo está em app/controllers, então volta duas pastas até a raiz.
include("../../config/conexao.php");

// Recebe a ação pela URL ou pelo formulário.
// Se não receber nada, usa uma string vazia.
$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

// Ação para cadastrar um animal.
if ($acao == "cadastrar") {

    // Recebe os dados preenchidos no formulário.
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $peso = $_POST['peso'];
    $sexo = $_POST['sexo'];
    $id_tutor = $_POST['id_tutor'];

    // Cria o comando SQL para inserir o animal.
    // Os ? serão substituídos pelos valores recebidos.
    $sql = "INSERT INTO animais
            (nome, especie, raca, idade, peso, sexo, id_tutor)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepara o comando SQL.
    $comando = $conn->prepare($sql);

    // Liga os valores aos ? da consulta.
    // s = texto (string)
    // i = número inteiro
    // d = número decimal
    $comando->bind_param(
        "sssid si",
        $nome,
        $especie,
        $raca,
        $idade,
        $peso,
        $sexo,
        $id_tutor
    );

    // Executa o INSERT.
    $comando->execute();

    // Retorna para a página de listagem.
    header("Location: ../views/animais/listar.php");
    exit;
}

// Ação para atualizar um animal.
if ($acao == "atualizar") {

    // Recebe os dados do formulário de edição.
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $peso = $_POST['peso'];
    $sexo = $_POST['sexo'];
    $id_tutor = $_POST['id_tutor'];

    // Atualiza os dados do animal escolhido pelo ID.
    $sql = "UPDATE animais
            SET nome = ?, especie = ?, raca = ?, idade = ?,
                peso = ?, sexo = ?, id_tutor = ?
            WHERE id = ?";

    // Prepara a consulta.
    $comando = $conn->prepare($sql);

    // Liga os valores aos ?.
    $comando->bind_param(
        "sssidsii",
        $nome,
        $especie,
        $raca,
        $idade,
        $peso,
        $sexo,
        $id_tutor,
        $id
    );

    // Executa o UPDATE.
    $comando->execute();

    // Retorna para a lista.
    header("Location: ../views/animais/listar.php");
    exit;
}

// Ação para excluir um animal.
if ($acao == "excluir") {

    // Recebe o ID do animal pela URL.
    $id = $_GET['id'];

    // Cria o SQL de exclusão.
    $sql = "DELETE FROM animais WHERE id = ?";

    // Prepara o SQL.
    $comando = $conn->prepare($sql);

    // Associa o ID ao ?.
    $comando->bind_param("i", $id);

    // Executa a exclusão.
    $comando->execute();

    // Retorna para a lista.
    header("Location: ../views/animais/listar.php");
    exit;
}

// Se a ação for inválida, retorna para a lista.
header("Location: ../views/animais/listar.php");
exit;