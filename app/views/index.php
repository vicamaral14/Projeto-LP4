<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Inclui a conexão com o banco de dados
include_once "../../config/conexao.php";

// Busca os totais para exibir nos blocos/cards da Dashboard
$resAnimais = $conn->query("SELECT COUNT(*) as total FROM animais");
$totalAnimais = $resAnimais ? $resAnimais->fetch_assoc()['total'] : 0;

$resTutores = $conn->query("SELECT COUNT(*) as total FROM tutores");
$totalTutores = $resTutores ? $resTutores->fetch_assoc()['total'] : 0;

$resConsultas = $conn->query("SELECT COUNT(*) as total, SUM(valor) as faturamento FROM consultas");
$dadosConsultas = $resConsultas ? $resConsultas->fetch_assoc() : ['total' => 0, 'faturamento' => 0];
$totalConsultas = $dadosConsultas['total'] ?? 0;
$faturamentoTotal = $dadosConsultas['faturamento'] ?? 0;

// Inclui o menu do topo (header.php)
include_once "includes/header.php";
?>

<main class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Painel Geral - VetCare</h2>
        <p class="text-muted small mb-0">Bem-vindo de volta! Aqui está o resumo da sua clínica hoje.</p>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white text-dark p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success me-3">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="text-muted small mb-1">Tutores</h5>
                        <h3 class="fw-bold mb-0"><?= $totalTutores ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white text-dark p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary me-3">
                        <i class="fa-solid fa-dog fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="text-muted small mb-1">Animais</h5>
                        <h3 class="fw-bold mb-0"><?= $totalAnimais ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-white text-dark p-3" style="border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning me-3">
                        <i class="fa-solid fa-calendar-check fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="text-muted small mb-1">Consultas</h5>
                        <h3 class="fw-bold mb-0"><?= $totalConsultas ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-white p-3" style="border-radius: 12px; background-color: #1b4d3e;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center me-3" style="width: 54px; height: 54px; min-width: 54px;">
                        <i class="fa-solid fa-dollar-sign fa-xl"></i>
                    </div>
                    <div>
                        <h5 class="text-white-50 small mb-1">Faturamento Total</h5>
                        <h3 class="fw-bold mb-0">R$ <?= number_format($faturamentoTotal, 2, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
        <h5 class="fw-bold mb-3">Acesso Rápido ao Sistema</h5>
        <div class="d-flex gap-3 flex-wrap">
            <a href="tutores/listar.php" class="btn btn-outline-dark px-4 py-2 fw-semibold"><i class="fa-solid fa-users me-2"></i>Ver Tutores</a>
            <a href="animais/listar.php" class="btn btn-outline-dark px-4 py-2 fw-semibold"><i class="fa-solid fa-dog me-2"></i>Ver Animais</a>
            <a href="consultas/listar.php" class="btn btn-outline-dark px-4 py-2 fw-semibold"><i class="fa-solid fa-calendar-days me-2"></i>Gerenciar Consultas</a>
        </div>
    </div>
</main>

<?php 
include_once "includes/footer.php"; 
?>