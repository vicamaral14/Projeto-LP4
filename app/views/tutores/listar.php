<?php

// Inclui a conexão com o banco.
include("../../../config/conexao.php");

// Busca todos os tutores cadastrados.
$resultado = $conn->query("SELECT * FROM tutores ORDER BY nome");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tutores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Lista de Tutores</h2>

        <a href="cadastrar.php" class="btn btn-primary">
            Novo Tutor
        </a>
    </div>

    <table class="table table-bordered table-hover">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($linha = $resultado->fetch_assoc()) { ?>

            <tr>
                <td><?= $linha['id'] ?></td>

                <td><?= htmlspecialchars($linha['nome']) ?></td>

                <td><?= htmlspecialchars($linha['cpf']) ?></td>

                <td><?= htmlspecialchars($linha['telefone']) ?></td>

                <td><?= htmlspecialchars($linha['email']) ?></td>

                <td>
                    <!-- Abre a página de edição e envia o ID pela URL. -->
                    <a
                        href="editar.php?id=<?= $linha['id'] ?>"
                        class="btn btn-warning btn-sm"
                    >
                        Editar
                    </a>

                    <!-- Chama o controller para excluir o tutor. -->
                    <a
                        href="../../controllers/TutorController.php?acao=excluir&id=<?= $linha['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Deseja realmente excluir este tutor?')"
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