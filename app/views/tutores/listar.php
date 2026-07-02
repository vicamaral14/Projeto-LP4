<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include_once "../../controllers/TutorController.php";
$listaTutores = $tutorController->listarTutores();

include_once "../includes/header.php";
?>

<main class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Clientes & Tutores</h2>
            <p class="text-muted small mb-0">Gestão de tutores integrados na plataforma VetCare</p>
        </div>
        <a href="cadastrar.php" class="btn btn-success px-4 fw-semibold shadow-sm">
            <i class="fa-solid fa-user-plus me-2"></i> Novo Tutor
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-5">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Nome Completo</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th class="text-end pe-4" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listaTutores)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-regular fa-folder-open display-6 mb-3 d-block text-secondary"></i>
                                Nenhum tutor registrado na base de dados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listaTutores as $tutor): ?>
                            <tr>
                                <td class="fw-bold text-secondary ps-4">#<?= $tutor['id'] ?></td>
                                <td class="fw-semibold text-dark"><?= htmlspecialchars($tutor['nome']) ?></td>
                                <td><?= htmlspecialchars($tutor['cpf']) ?></td>
                                <td><?= htmlspecialchars($tutor['telefone']) ?></td>
                                <td><?= htmlspecialchars($tutor['email']) ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="editar.php?id=<?= $tutor['id'] ?>" class="btn btn-outline-primary" title="Editar">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="excluir.php?id=<?= $tutor['id'] ?>" class="btn btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja remover este registro?');">
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

<?php include_once "../includes/footer.php"; ?>
