<?php

// Inclui a conexão.
// O arquivo está em app/views/animais, então volta três pastas.
include("../../../config/conexao.php");

// Busca os tutores para preencher o select.
$tutores = $conn->query("SELECT id, nome FROM tutores ORDER BY nome");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Animal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Cadastrar Animal</h2>

    <form action="../../controllers/AnimalController.php?acao=cadastrar" method="POST">

        <div class="mb-3">
            <label class="form-label">Nome do animal</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Espécie</label>
            <input type="text" name="especie" class="form-control" placeholder="Ex.: Cachorro, Gato, Cavalo" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Raça</label>
            <input type="text" name="raca" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Idade</label>
            <input type="number" name="idade" class="form-control" min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Peso (kg)</label>
            <input type="number" name="peso" class="form-control" min="0" step="0.01">
        </div>

        <div class="mb-3">
            <label class="form-label">Sexo</label>

            <select name="sexo" class="form-select" required>
                <option value="">Selecione</option>
                <option value="Macho">Macho</option>
                <option value="Fêmea">Fêmea</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tutor responsável</label>

            <select name="id_tutor" class="form-select" required>
                <option value="">Selecione um tutor</option>

                <?php while ($tutor = $tutores->fetch_assoc()) { ?>
                    <option value="<?= $tutor['id'] ?>">
                        <?= htmlspecialchars($tutor['nome']) ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <button type="submit" class="btn btn-success">
            Salvar animal
        </button>

        <a href="listar.php" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

</body>
</html>