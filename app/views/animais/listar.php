<?php

include("../../../config/conexao.php");
include("../../models/Animal.php");

// cria objeto da classe Animal
$animal = new Animal($conn);

// busca os animais
$animais = $animal->listar();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Animais</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Lista de Animais</h2>

    <a href="cadastrar.php" class="btn btn-primary mb-3">
        Novo Animal
    </a>

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Idade</th>
                <th>Peso</th>
                <th>Sexo</th>
                <th>Tutor</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

<?php if (!empty($animais)) { ?>
<?php foreach ($animais as $a) { ?>
                <tr>
                    <td><?= $a['id'] ?></td>
                    <td><?= $a['nome'] ?></td>
                    <td><?= $a['especie'] ?></td>
                    <td><?= $a['raca'] ?></td>
                    <td><?= $a['idade'] ?></td>
                    <td><?= $a['peso'] ?></td>
                    <td><?= $a['sexo'] ?></td>
<?= $a['tutor_nome'] ?? 'Sem tutor' ?>
                    <td>
                        <a href="editar.php?id=<?= $a['id'] ?>" class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <a href="../../controllers/AnimalController.php?acao=excluir&id=<?= $a['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Deseja realmente excluir?')">
                            Excluir
                        </a>
                    </td>
                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="9" class="text-center">
                    Nenhum animal cadastrado
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>