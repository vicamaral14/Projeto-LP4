<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../login.php");
    exit;
}

// Inclui o Controller unificado de Animais
include_once "../../controllers/AnimalController.php";
$listaAnimais = $animalController->listarAnimais();

// Inclui o cabeçalho padrão
include_once "../includes/header.php";
?>

<main class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Pacientes & Animais</h2>
            <p class="text-muted small mb-0">Controle de pets, idade e peso integrados aos tutores do VetCare</p>
        </div>
        <a href="cadastrar.php" class="btn btn-success px-4 fw-semibold shadow-sm" style="background-color: #1b4d3e; border: none;">
            <i class="fa-solid fa-dog me-2"></i> Novo Animal
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-5" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark" style="background-color: #1b4d3e;">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Nome do Pet</th>
                        <th>Espécie</th>
                        <th>Raça</th>
                        <th>Sexo</th>
                        <th>Idade</th>
                        <th>Peso</th>
                        <th>Tutor / Dono</th>
                        <th class="text-end pe-4" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listaAnimais)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open display-6 mb-3 d-block text-secondary"></i>
                                Nenhum animal registrado no banco de dados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listaAnimais as $animal): ?>
                            <tr>
                                <td class="fw-bold text-secondary ps-4">#<?= $animal['id'] ?></td>
                                <td class="fw-semibold text-dark">
                                    <i class="fa-solid fa-paw text-success me-1" style="font-size: 12px;"></i> 
                                    <?= htmlspecialchars($animal['nome']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 13px;">
                                        <?= htmlspecialchars($animal['especie']) ?>
                                    </span>
                                </td>
                                <td class="text-muted"><?= htmlspecialchars($animal['raca'] ?: 'Não informada') ?></td>
                                <td>
                                    <span class="text-muted small">
                                        <?= $animal['sexo'] == 'Macho' ? '<i class="fa-solid fa-mars text-primary me-1"></i> Macho' : ($animal['sexo'] == 'Fêmea' ? '<i class="fa-solid fa-venus text-danger me-1"></i> Fêmea' : '---') ?>
                                    </span>
                                </td>
                                <td class="text-muted fw-medium"><?= $animal['idade'] !== null ? $animal['idade'] . ' anos' : '---' ?></td>
                                <td class="text-muted fw-medium"><?= $animal['peso'] !== null ? number_format($animal['peso'], 1, ',', '.') . ' kg' : '---' ?></td>
                                <td class="fw-medium text-secondary">
                                    <i class="fa-solid fa-user text-muted me-1" style="font-size: 12px;"></i>
                                    <?= htmlspecialchars($animal['tutor_nome'] ?? 'Não vinculado') ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="editar.php?id=<?= $animal['id'] ?>" class="btn btn-outline-primary" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="excluir.php?id=<?= $animal['id'] ?>" class="btn btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja remover este animal?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php 
include_once "../includes/footer.php"; 
?>