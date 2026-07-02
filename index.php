<?php
session_start();

// Proteção da sessão: se não houver usuário logado, redireciona para o login
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: login.php"); 
    exit; 
}

// Inclui o arquivo de conexão com o banco de dados.
include("config/conexao.php");

// Faz uma consulta para contar quantos tutores existem na tabela tutores.
$resultado_tutores = $conn->query("SELECT COUNT(*) AS total FROM tutores");
$tutores = $resultado_tutores->fetch_assoc();

// Faz uma consulta para contar quantos animais existem na tabela animais.
$resultado_animais = $conn->query("SELECT COUNT(*) AS total FROM animais");
$animais = $resultado_animais->fetch_assoc();

// Faz uma consulta para contar quantas consultas existem na tabela consultas.
$resultado_consultas = $conn->query("SELECT COUNT(*) AS total FROM consultas");
$consultas = $resultado_consultas->fetch_assoc();

// Conta somente as consultas que possuem a data de hoje.
$resultado_consultas_hoje = $conn->query("
    SELECT COUNT(*) AS total
    FROM consultas
    WHERE data_consulta = CURDATE()
");
$consultas_hoje = $resultado_consultas_hoje->fetch_assoc();

// Inclui o cabeçalho padronizado com rotas absolutas
include_once "app/views/includes/header.php";
?>

<main class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Dashboard</h2>
        <p class="text-muted small mb-0">Resumo geral e estatísticas da clínica veterinária VetCare.</p>
    </div>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card text-bg-primary h-100 border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0 fw-semibold">Tutores</h5>
                        <i class="fa-solid fa-users opacity-50 fs-4"></i>
                    </div>
                    <p class="display-5 fw-bold mb-0"><?= $tutores['total'] ?? 0 ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success h-100 border-0 shadow-sm" style="border-radius: 12px; background-color: #2e7d32 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0 fw-semibold">Animais</h5>
                        <i class="fa-solid fa-paw opacity-50 fs-4"></i>
                    </div>
                    <p class="display-5 fw-bold mb-0"><?= $animais['total'] ?? 0 ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning h-100 border-0 shadow-sm text-white" style="border-radius: 12px; background-color: #f57c00 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0 fw-semibold">Consultas</h5>
                        <i class="fa-solid fa-calendar-days opacity-50 fs-4"></i>
                    </div>
                    <p class="display-5 fw-bold mb-0"><?= $consultas['total'] ?? 0 ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-danger h-100 border-0 shadow-sm" style="border-radius: 12px; background-color: #c62828 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0 fw-semibold">Consultas Hoje</h5>
                        <i class="fa-solid fa-clock opacity-50 fs-4"></i>
                    </div>
                    <p class="display-5 fw-bold mb-0"><?= $consultas_hoje['total'] ?? 0 ?></p>
                </div>
            </div>
        </div>

    </div>

    <section class="mt-5 mb-5">
        <h4 class="fw-bold text-dark mb-3">Ações rápidas</h4>
        
        <div class="d-flex flex-wrap gap-2">
            <a href="/Projeto-LP4/app/views/tutores/cadastrar.php" class="btn btn-primary px-4 fw-medium" style="border-radius: 8px;">
                <i class="fa-solid fa-user-plus me-2"></i> Cadastrar tutor
            </a>

            <a href="/Projeto-LP4/app/views/animais/cadastrar.php" class="btn btn-success px-4 fw-medium" style="border-radius: 8px; background-color: #2e7d32; border: none;">
                <i class="fa-solid fa-dog me-2"></i> Cadastrar animal
            </a>

            <a href="/Projeto-LP4/app/views/consultas/cadastrar.php" class="btn btn-warning px-4 fw-medium text-white" style="border-radius: 8px; background-color: #f57c00; border: none;">
                <i class="fa-solid fa-calendar-check me-2"></i> Agendar consulta
            </a>
        </div>
    </section>

</main>

<?php 
// Inclui o rodapé de forma limpa
include_once "app/views/includes/footer.php"; 
?>
