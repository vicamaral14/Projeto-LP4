<?php

include("../../../config/conexao.php");

// Recebe o ID do animal pela URL.
$id = $_GET['id'];

// Busca os dados do animal que será editado.
$sql = "SELECT * FROM animais WHERE id = ?";

$comando = $conn->prepare($sql);
$comando->bind_param("i", $id);
$comando->execute();

$resultado = $comando->get_result();
$animal = $resultado->fetch_assoc();

// Se o animal não existir, volta para a lista.
if (!$animal) {
    header("Location: listar.php");
    exit;
}

// Busca todos os tutores para preencher o select.
$tutores = $conn->query("SELECT id, nome FROM tutores ORDER BY nome");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Animal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Editar Animal</h2>

    <form action="../../controllers/AnimalController.php?acao=atualizar" method="POST">

        <input type="hidden" name="id" value="<?= $animal['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Nome do animal</label>
            <input
                type="text"
                name="nome"
                class="form-control"
                value="<?= htmlspecialchars($animal['nome']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Espécie</label>
            <input
                type="text"
                name="especie"
                class="form-control"
                value="<?= htmlspecialchars($animal['especie']) ?>"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Raça</label>
            <input
                type="text"
                name="raca"
                class="form-control"
                value="<?= htmlspecialchars($animal['raca']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Idade</label>
            <input
                type="number"
                name="idade"
                class="form-control"
                min="0"
                value="<?= $animal['idade'] ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Peso (kg)</label>
            <input
                type="number"
                name="peso"
                class="form-control"
                min="0"
                step="0.01"
                value="<?= $animal['peso'] ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Sexo</label>

            <select name="sexo" class="form-select" required>
                <option value="Macho" <?= $animal['sexo'] == 'Macho' ? 'selected' : '' ?>>
                    Macho
                </option>

                <option value="Fêmea" <?= $animal['sexo'] == 'Fêmea' ? 'selected' : '' ?>>
                    Fêmea
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tutor responsável</label>

            <select name="id_tutor" class="form-select" required>

                <?php while ($tutor = $tutores->fetch_assoc()) { ?>

                    <option
                        value="<?= $tutor['id'] ?>"
                        <?= $tutor['id'] == $animal['id_tutor'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($tutor['nome']) ?>
                    </option>

                <?php } ?>

            </select>
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