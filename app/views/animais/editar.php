<?php
session_start();

// Proteção de acesso: se não estiver logado, bloqueia
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

include_once "../../controllers/AnimalController.php";
include_once "../../models/Animal.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) { 
    header("Location: listar.php"); 
    exit; 
}

$animalM = new Animal($conn);
$mensagemErro = "";

// Processamento do formulário de atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $especie = trim($_POST['especie'] ?? '');
    $raca = trim($_POST['raca'] ?? '');
    $idade = !empty($_POST['idade']) ? intval($_POST['idade']) : null;
    $peso = !empty($_POST['peso']) ? floatval(str_replace(',', '.', $_POST['peso'])) : null;
    $sexo = trim($_POST['sexo'] ?? '');
    $id_tutor = intval($_POST['id_tutor'] ?? 0);

    // Validação estrita: Nome, Raça e Tutor são prioridades para alteração
    if (!empty($nome) && !empty($raca) && $id_tutor > 0) {
        if ($animalM->atualizar($id, $nome, $especie, $raca, $idade, $peso, $sexo, $id_tutor)) {
            header("Location: listar.php?msg=editado");
            exit;
        } else {
            $mensagemErro = "Erro ao atualizar o animal no banco de dados.";
        }
    } else {
        $mensagemErro = "Os campos Nome do Animal, Raça e Tutor são obrigatórios!";
    }
}

// Procura os dados atuais do registro e a lista de tutores
$dadosAnimal = $animalM->buscarPorId($id);
$listaTutores = $animalController->listarTutoresDisponiveis();

include_once "../includes/header.php";
?>

<main class="container py-4" style="max-width: 700px;">
    
    <div class="mb-3">
        <a href="listar.php" class="text-decoration-none text-secondary small fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para a lista
        </a>
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Editar Animal</h2>
        <p class="text-muted small">Atualize as informações do paciente. Campos com <span class="text-danger">*</span> são obrigatórios.</p>
    </div>

    <?php if (!empty($mensagemErro)): ?>
        <div class="alert alert-danger py-2 px-3 mb-4" style="border-radius: 8px; font-size: 14px;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $mensagemErro ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background-color: #ffffff;">
        <form action="editar.php?id=<?= $id ?>" method="POST" autocomplete="off" class="needs-validation" novalidate>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label text-secondary small fw-bold">Nome do Animal <span class="text-danger">*</span></label>
                    <input type="text" name="nome" id="nome" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosAnimal['nome'] ?? '') ?>">
                    <div class="invalid-feedback">O nome do animal é obrigatório.</div>
                </div>
                
                <div class="col-md-6">
                    <label for="id_tutor" class="form-label text-secondary small fw-bold">Tutor / Dono <span class="text-danger">*</span></label>
                    <select name="id_tutor" id="id_tutor" class="form-select" style="border-radius: 8px;" required>
                        <option value="">Selecione um tutor...</option>
                        <?php foreach ($listaTutores as $tutor): ?>
                            <option value="<?= $tutor['id'] ?>" <?= $tutor['id'] == ($dadosAnimal['id_tutor'] ?? 0) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tutor['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Por favor, selecione um tutor responsável.</div>
                </div>

                <div class="col-md-4">
                    <label for="especie" class="form-label text-secondary small fw-bold">Espécie</label>
                    <input type="text" name="especie" id="especie" class="form-control" style="border-radius: 8px;" value="<?= htmlspecialchars($dadosAnimal['especie'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label for="raca" class="form-label text-secondary small fw-bold">Raça <span class="text-danger">*</span></label>
                    <input type="text" name="raca" id="raca" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosAnimal['raca'] ?? '') ?>">
                    <div class="invalid-feedback">A raça é obrigatória.</div>
                </div>

                <div class="col-md-4">
                    <label for="sexo" class="form-label text-secondary small fw-bold">Sexo</label>
                    <select name="sexo" id="sexo" class="form-select" style="border-radius: 8px;">
                        <option value="M" <?= ($dadosAnimal['sexo'] ?? '') == 'M' ? 'selected' : '' ?>>Macho</option>
                        <option value="F" <?= ($dadosAnimal['sexo'] ?? '') == 'F' ? 'selected' : '' ?>>Fêmea</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="idade" class="form-label text-secondary small fw-bold">Idade (Anos)</label>
                    <input type="number" name="idade" id="idade" class="form-control" style="border-radius: 8px;" min="0" value="<?= htmlspecialchars($dadosAnimal['idade'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label for="peso" class="form-label text-secondary small fw-bold">Peso (Kg)</label>
                    <input type="number" name="peso" id="peso" class="form-control" style="border-radius: 8px;" step="0.01" min="0" value="<?= htmlspecialchars($dadosAnimal['peso'] ?? '') ?>">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="listar.php" class="btn btn-light px-4" style="border-radius: 8px;">Cancelar</a>
                <button type="submit" class="btn btn-success px-5 fw-semibold shadow-sm" style="border-radius: 8px; background-color: #2e7d32; border: none;">
                    Salvar Alterações
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