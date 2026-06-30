<?php

// Inclui o arquivo de conexão com o banco de dados.
include("config/conexao.php");

// Faz uma consulta para contar quantos tutores existem na tabela tutores.
$resultado_tutores = $conn->query("SELECT COUNT(*) AS total FROM tutores");

// Pega o resultado da consulta em formato de array.
$tutores = $resultado_tutores->fetch_assoc();

// Faz uma consulta para contar quantos animais existem na tabela animais.
$resultado_animais = $conn->query("SELECT COUNT(*) AS total FROM animais");

// Pega o resultado da consulta em formato de array.
$animais = $resultado_animais->fetch_assoc();

// Faz uma consulta para contar quantas consultas existem na tabela consultas.
$resultado_consultas = $conn->query("SELECT COUNT(*) AS total FROM consultas");

// Pega o resultado da consulta em formato de array.
$consultas = $resultado_consultas->fetch_assoc();

// Conta somente as consultas que possuem a data de hoje.
$resultado_consultas_hoje = $conn->query("
    SELECT COUNT(*) AS total
    FROM consultas
    WHERE data_consulta = CURDATE()
");

// Pega o resultado da consulta.
$consultas_hoje = $resultado_consultas_hoje->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <title>VetCare - Dashboard</title>

    <!-- Importa o Bootstrap para usar os cards, botões e grid responsivo. -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<!-- Barra de navegação superior. -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <!-- Nome do sistema. -->
        <a class="navbar-brand" href="index.php">
            VetCare
        </a>

        <!-- Links para os módulos do sistema. -->
        <div class="navbar-nav">
            <a class="nav-link" href="app/views/tutores/listar.php">
                Tutores
            </a>

            <a class="nav-link" href="app/views/animais/listar.php">
                Animais
            </a>

            <a class="nav-link" href="app/views/consultas/listar.php">
                Consultas
            </a>
        </div>

    </div>
</nav>

<main class="container mt-5">

    <!-- Título e explicação da tela. -->
    <div class="mb-4">
        <h1>Dashboard</h1>
        <p class="text-muted">
            Resumo geral da clínica veterinária.
        </p>
    </div>

    <!-- row organiza os cards em uma linha. -->
    <div class="row g-4">

        <!-- Card de tutores. -->
        <div class="col-md-3">
            <div class="card text-bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Tutores</h5>

                    <!-- Mostra o número retornado pelo COUNT no banco. -->
                    <p class="display-6 mb-0">
                        <?= $tutores['total'] ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card de animais. -->
        <div class="col-md-3">
            <div class="card text-bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Animais</h5>

                    <p class="display-6 mb-0">
                        <?= $animais['total'] ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card de todas as consultas. -->
        <div class="col-md-3">
            <div class="card text-bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Consultas</h5>

                    <p class="display-6 mb-0">
                        <?= $consultas['total'] ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card de consultas do dia. -->
        <div class="col-md-3">
            <div class="card text-bg-danger h-100">
                <div class="card-body">
                    <h5 class="card-title">Consultas hoje</h5>

                    <p class="display-6 mb-0">
                        <?= $consultas_hoje['total'] ?>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Área com atalhos para as ações principais. -->
    <section class="mt-5">

        <h2 class="h4 mb-3">Ações rápidas</h2>

        <a
            href="app/views/tutores/cadastrar.php"
            class="btn btn-primary me-2"
        >
            Cadastrar tutor
        </a>

        <a
            href="app/views/animais/cadastrar.php"
            class="btn btn-success me-2"
        >
            Cadastrar animal
        </a>

        <a
            href="app/views/consultas/cadastrar.php"
            class="btn btn-warning"
        >
            Agendar consulta
        </a>

    </section>

</main>

</body>
</html>