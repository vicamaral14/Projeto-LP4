<?php
session_start();

// Proteção de acesso
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

include_once "../../controllers/ConsultaController.php";

$mensagemErro = "";

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_animal = intval($_POST['id_animal'] ?? 0);
    $veterinario = trim($_POST['veterinario'] ?? '');
    $data_consulta = trim($_POST['data_consulta'] ?? '');
    $hora_consulta = trim($_POST['hora_consulta'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = !empty($_POST['preco']) ? floatval(str_replace(',', '.', $_POST['preco'])) : 0.0;

    // Validação estrita: Doutor, Data, Horário e Valor tornam-se obrigatórios
    if ($id_animal > 0 && !empty($veterinario) && !empty($data_consulta) && !empty($hora_consulta) && $preco > 0) {
        if ($consultaController->processarCadastro($id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco)) {
            header("Location: listar.php?msg=sucesso");
            exit;
        } else {
            $mensagemErro = "Erro ao agendar a consulta no banco de dados.";
        }
    } else {
        $mensagemErro = "Os campos Animal, Doutor, Data, Horário e Valor são obrigatórios!";
    }
}

// Carrega a lista de animais para o <select>
$listaAnimais = $consultaController->listarAnimaisDisponiveis();

include_once "../includes/header.php";
?>

<main class="container py-4" style="max-width: 700px;">
    
    <div class="mb-3">
        <a href="listar.php" class="text-decoration-none text-secondary small fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para a lista
        </a>
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Agendar Consulta</h2>
        <p class="text-muted small">Insira as informações para abrir um novo agendamento. Campos com <span class="text-danger">*</span> são obrigatórios.</p>
    </div>

    <?php if (!empty($mensagemErro)): ?>
        <div class="alert alert-danger py-2 px-3 mb-4" style="border-radius: 8px; font-size: 14px;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $mensagemErro ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background-color: #ffffff;">
        <form action="cadastrar.php" method="POST" autocomplete="off" class="needs-validation" novalidate>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="id_animal" class="form-label text-secondary small fw-bold">Paciente / Animal <span class="text-danger">*</span></label>
                    <select name="id_animal" id="id_animal" class="form-select" style="border-radius: 8px;" required>
                        <option value="">Selecione o paciente...</option>
                        <?php foreach ($listaAnimais as $animal): ?>
                            <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['nome']) ?> (<?= htmlspecialchars($animal['tutor_nome']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Selecione o animal da consulta.</div>
                </div>

                <div class="col-md-6">
                    <label for="veterinario" class="form-label text-secondary small fw-bold">Médico Veterinário (Doutor) <span class="text-danger">*</span></label>
                    <input type="text" name="veterinario" id="veterinario" class="form-control" style="border-radius: 8px;" required placeholder="Ex: Dr. Carlos Medeiros">
                    <div class="invalid-feedback">O nome do médico veterinário é obrigatório.</div>
                </div>

                <div class="col-md-4">
                    <label for="data_consulta" class="form-label text-secondary small fw-bold">Data <span class="text-danger">*</span></label>
                    <input type="date" name="data_consulta" id="data_consulta" class="form-control" style="border-radius: 8px;" required>
                    <div class="invalid-feedback">Informe a data do agendamento.</div>
                </div>

                <div class="col-md-4">
                    <label for="hora_consulta" class="form-label text-secondary small fw-bold">Horário <span class="text-danger">*</span></label>
                    <input type="time" name="hora_consulta" id="hora_consulta" class="form-control" style="border-radius: 8px;" required>
                    <div class="invalid-feedback">Informe o horário do atendimento.</div>
                </div>

                <div class="col-md-4">
                    <label for="preco" class="form-label text-secondary small fw-bold">Valor (R$) <span class="text-danger">*</span></label>
                    <input type="number" name="preco" id="preco" class="form-control" style="border-radius: 8px;" step="0.01" min="0.01" required placeholder="0.00">
                    <div class="invalid-feedback">Informe um valor válido maior que zero.</div>
                </div>

                <div class="col-12">
                    <label for="descricao" class="form-label text-secondary small fw-bold">Descrição / Sintomas</label>
                    <textarea name="descricao" id="descricao" class="form-control" style="border-radius: 8px;" rows="3" placeholder="Descreva brevemente o motivo da consulta..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="listar.php" class="btn btn-light px-4" style="border-radius: 8px;">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm" style="border-radius: 8px;">
                    Agendar Consulta
                </button>
            </div>

        </form>
    </div>
</main>

<script>
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

<?php include_once "../includes/footer.php"; ?>