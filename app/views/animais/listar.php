<?php

// Inclui a conexão com o banco.
include("../../../config/conexao.php");

// Busca os animais e também o nome do tutor de cada animal.
// INNER JOIN une as tabelas animais e tutores.
$sql = "SELECT animais.*, tutores.nome AS nome_tutor
        FROM animais
        INNER JOIN tutores ON animais.id_tutor = tutores.id
        ORDER BY animais.nome";

// Executa a consulta.
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Animais</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Animais</h2>

        <a href="cadastrar.php" class="btn btn-primary">
            Novo Animal
        </a>
    </div>

    <table class="table table-bordered table-hover">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Peso</th>
                <th>Tutor</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($animal = $resultado->fetch_assoc()) { ?>

            <tr>
                <td><?= $animal['id'] ?></td>
                <td><?= htmlspecialchars($animal['nome']) ?></td>
                <td><?= htmlspecialchars($animal['especie']) ?></td>
                <td><?= htmlspecialchars($animal['raca']) ?></td>
                <td><?= $animal['idade'] ?></td>
                <td><?= $animal['peso'] ?> kg</td>
                <td><?= htmlspecialchars($animal['nome_tutor']) ?></td>

                <td>
                    <a
                        href="editar.php?id=<?= $animal['id'] ?>"
                        class="btn btn-warning btn-sm"
                    >
                        Editar
                    </a>

                    <a
                        href="../../controllers/AnimalController.php?acao=excluir&id=<?= $animal['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Deseja realmente excluir este animal?')"
                    >
                        Excluir
                    </a>
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>

    <a href="../../../index.php" class="btn btn-secondary">
        Voltar ao início
    </a>

</div>

</body>
</html>