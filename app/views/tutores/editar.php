<?php

// Inclui a conexão com o banco.
// Como este arquivo está dentro de app/views/tutores,
// precisamos voltar três pastas para chegar até config.
include("../../../config/conexao.php");

// Recebe o ID enviado pela URL.
// Exemplo: editar.php?id=3
$id = $_GET['id'];

// Cria uma consulta para buscar somente o tutor escolhido.
$sql = "SELECT * FROM tutores WHERE id = ?";

// Prepara a consulta.
$comando = $conn->prepare($sql);

// Associa o ID ao ?.
// "i" significa inteiro.
$comando->bind_param("i", $id);

// Executa a consulta.
$comando->execute();

// Obtém o resultado da consulta.
$resultado = $comando->get_result();

// Busca os dados do tutor em formato de array.
$tutor = $resultado->fetch_assoc();

// Se não encontrar o tutor, volta para a lista.
if (!$tutor) {
    header("Location: listar.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tutor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Editar Tutor</h2>

    <!-- Envia os dados atualizados para o controller. -->
    <form action="../../controllers/TutorController.php?acao=atualizar" method="POST">

        <!-- Campo escondido: envia o ID do tutor que será atualizado. -->
        <input type="hidden" name="id" value="<?= $tutor['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Nome</label>

            <!-- value mostra o valor que já estava salvo no banco. -->
            <input
                type="text"
                name="nome"
                class="form-control"
                value="<?= htmlspecialchars($tutor['nome']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">CPF</label>

            <input
                type="text"
                name="cpf"
                class="form-control"
                value="<?= htmlspecialchars($tutor['cpf']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone</label>

            <input
                type="text"
                name="telefone"
                class="form-control"
                value="<?= htmlspecialchars($tutor['telefone']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">E-mail</label>

            <input
                type="email"
                name="email"
                class="form-control"
                value="<?= htmlspecialchars($tutor['email']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Endereço</label>

            <input
                type="text"
                name="endereco"
                class="form-control"
                value="<?= htmlspecialchars($tutor['endereco']) ?>"
            >
        </div>

        <button type="submit" class="btn btn-success">
            Salvar alterações
        </button>

        <a href="listar.php" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

</body>
</html>