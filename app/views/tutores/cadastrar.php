<?php
session_start();

// Proteção de acesso: se não estiver logado, bloqueia
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

// Inclui o controlador correto de listagem de tutores
include_once "../../controllers/TutorListarController.php";

$mensagemErro = "";

// Processa o envio do formulário para cadastrar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validação estrita no backend antes de mandar para o banco
    if (!empty($nome) && !empty($cpf) && !empty($email)) {
        $resultado = $tutorController->processarCadastro();
        
        if (is_string($resultado)) {
            $mensagemErro = $resultado;
        }
    } else {
        $mensagemErro = "Os campos Nome, CPF e E-mail são obrigatórios para realizar o cadastro!";
    }
}

include_once "../includes/header.php";
?>

<main class="container py-4" style="max-width: 700px;">
    
    <div class="mb-3">
        <a href="listar.php" class="text-decoration-none text-secondary small fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para a lista
        </a>
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Cadastrar Tutor</h2>
        <p class="text-muted small">Insira os dados para registrar um novo tutor. Campos com <span class="text-danger">*</span> são obrigatórios.</p>
    </div>

    <?php if (!empty($mensagemErro)): ?>
        <div class="alert alert-danger py-2 px-3 mb-4" style="border-radius: 8px; font-size: 14px;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $mensagemErro ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background-color: #ffffff;">
        <form action="cadastrar.php" method="POST" autocomplete="off" class="needs-validation" novalidate>
            
            <div class="mb-3">
                <label for="nome" class="form-label text-secondary small fw-bold">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" name="nome" id="nome" class="form-control" style="border-radius: 8px;" required placeholder="Ex: João Silva">
                <div class="invalid-feedback">Por favor, insira o nome completo do tutor.</div>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label text-secondary small fw-bold">CPF <span class="text-danger">*</span></label>
                <input type="text" name="cpf" id="cpf" class="form-control" style="border-radius: 8px;" required placeholder="000.000.000-00">
                <div class="invalid-feedback">O CPF é obrigatório para o cadastro.</div>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label text-secondary small fw-bold">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" style="border-radius: 8px;" placeholder="(00) 00000-0000">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label text-secondary small fw-bold">E-mail <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" style="border-radius: 8px;" required placeholder="exemplo@gmail.com">
                <div class="invalid-feedback">Insira um endereço de e-mail válido.</div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="listar.php" class="btn btn-light px-4" style="border-radius: 8px;">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm" style="border-radius: 8px;">
                    Cadastrar Tutor
                </button>
            </div>

        </form>
    </div>
</main>

<script>
// Impedir envios se houver campos inválidos vazios
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
