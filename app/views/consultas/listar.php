<?php
session_start();

// 1. Proteção de acesso (se aplicável ao seu sistema)
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

// 2. CORREÇÃO DO ERRO FATAL: Inclui o controlador antes de chamá-lo
include_once "../../controllers/ConsultaController.php";

// 3. Busca a lista de consultas através do controlador carregado
$consultas = $consultaController->listarConsultas();

// Variáveis para o cálculo do Sumário Dinâmico
$totalConsultas = count($consultas);
$faturamentoTotal = 0.0;

// 4. Inclui o cabeçalho do layout
include_once "../includes/header.php";
?>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Agenda de Consultas</h2>
            <p class="text-muted small">Gerencie os horários, atendimentos clínicos e fluxo financeiro do VetCare</p>
        </div>
        <a href="cadastrar.php" class="btn btn-warning fw-semibold px-4 shadow-sm" style="border-radius: 8px; background-color: #ffb300; border: none;">
            <i class="fa-solid fa-calendar-plus me-2"></i> Agendar Consulta
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="60" class="text-center">ID</th>
                        <th>Paciente / Pet</th>
                        <th>Tutor / Dono</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Descrição / Motivo</th>
                        <th class="text-end" width="130">Valor</th>
                        <th width="100" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($consultas)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Nenhuma consulta agendada até o momento.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($consultas as $con): ?>
                            <?php 
                                // Soma acumulada do faturamento total
                                $faturamentoTotal += floatval($con['valor'] ?? 0); 
                            ?>
                            <tr>
                                <td class="text-center text-secondary small fw-bold">#<?= $con['id'] ?></td>
                                <td class="fw-bold text-dark">
                                    <span class="text-warning me-1">🐾</span> <?= htmlspecialchars($con['animal_nome']) ?>
                                </td>
                                <td class="text-secondary"><?= htmlspecialchars($con['tutor_nome'] ?? 'Não informado') ?></td>
                                <td class="fw-semibold text-dark"><?= date('d/m/Y', strtotime($con['data_consulta'])) ?></td>
                                <td class="fw-bold text-dark"><?= !empty($con['hora']) ? substr($con['hora'], 0, 5) : '---' ?></td>
                                <td>
                                    <span class="badge bg-light text-secondary border px-2 py-1.5 font-monospace small" style="max-width: 250px; display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?= htmlspecialchars($con['descricao'] ?? 'Sem observações.') ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    R$ <?= number_format($con['valor'] ?? 0, 2, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="editar.php?id=<?= $con['id'] ?>" class="btn btn-outline-primary btn-sm" style="border-radius: 6px;" title="Editar">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <a href="excluir.php?id=<?= $con['id'] ?>" class="btn btn-outline-danger btn-sm" style="border-radius: 6px;" title="Excluir" onclick="return confirm('Tem certeza que deseja desmarcar esta consulta?');">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                
                <tfoot class="table-light border-top-2">
                    <tr>
                        <td colspan="5" class="text-start fw-semibold text-secondary py-3 ps-3">
                            <i class="fa-solid fa-calculator me-2"></i> Total de Atendimentos: <span class="badge bg-secondary text-white ms-1"><?= $totalConsultas ?></span>
                        </td>
                        <td class="text-end fw-bold text-dark py-3">Faturamento Total:</td>
                        <td class="text-end fw-black text-success py-3 fs-5" style="letter-spacing: -0.5px;">
                            <strong>R$ <?= number_format($faturamentoTotal, 2, ',', '.') ?></strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</main>

<?php include_once "../includes/footer.php"; ?>