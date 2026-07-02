<?php
session_start();

// Proteção de acesso: se não estiver logado, bloqueia
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

// Inclui o controlador correto de listagem de tutores
include_once "../../controllers/TutorListarController.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) { 
    header("Location: listar.php"); 
    exit; 
}

$mensagemErro = "";

// Processa o envio ou busca as informações atuais do tutor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validação estrita no backend: impede salvar campos cruciais vazios
    if (!empty($nome) && !empty($cpf) && !empty($email)) {
        // Instancia o model e executa a atualização usando o controlador
        $resultado = $tutorController->processarEdicao($id);
        
        // Se o processamento do controller redirecionar, o código abaixo não roda. 
        // Caso retorne uma string de erro, nós capturamos aqui:
        if (is_string($resultado)) {
            $mensagemErro = $resultado;
        }
    } else {
        $mensagemErro = "Os campos Nome, CPF e E-mail são obrigatórios e prioritários!";
    }
}

// Busca os dados atuais do tutor para preencher o formulário
$dadosTutor = $tutorController->listarTutores(); // Apenas para inicializar a conexão se necessário
// Altere as linhas de inclusão do banco e do model (por volta da linha 45) para:
include_once "../../../config/conexao.php";
include_once "../../models/Tutor.php";
$tutorModel = new Tutor($conn);
$dadosTutor = $tutorModel->buscarPorId($id);

include_once "../includes/header.php";
?>

<main class="container py-4" style="max-width: 700px;">
    
    <div class="mb-3">
        <a href="listar.php" class="text-decoration-none text-secondary small fw-semibold">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para a lista
        </a>
    </div>

    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Editar Tutor</h2>
        <p class="text-muted small">Altere os dados do cadastro do tutor selecionado. Campos com <span class="text-danger">*</span> são obrigatórios.</p>
    </div>

    <?php if (!empty($mensagemErro)): ?>
        <div class="alert alert-danger py-2 px-3 mb-4" style="border-radius: 8px; font-size: 14px;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= $mensagemErro ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 12px; background-color: #ffffff;">
        <form action="editar.php?id=<?= $id ?>" method="POST" autocomplete="off" class="needs-validation" novalidate>
            
            <div class="mb-3">
                <label for="nome" class="form-label text-secondary small fw-bold">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" name="nome" id="nome" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosTutor['nome'] ?? '') ?>">
                <div class="invalid-feedback">Por favor, insira o nome completo do tutor.</div>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label text-secondary small fw-bold">CPF <span class="text-danger">*</span></label>
                <input type="text" name="cpf" id="cpf" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosTutor['cpf'] ?? '') ?>">
                <div class="invalid-feedback">O CPF é obrigatório para o cadastro.</div>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label text-secondary small fw-bold">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" style="border-radius: 8px;" value="<?= htmlspecialchars($dadosTutor['telefone'] ?? '') ?>">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label text-secondary small fw-bold">E-mail <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosTutor['email'] ?? '') ?>">
                <div class="invalid-feedback">Insira um endereço de e-mail válido.</div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="listar.php" class="btn btn-light px-4" style="border-radius: 8px;">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm" style="border-radius: 8px;">
                    Salvar Alterações
                </button>
            </div>

        </form>
    </div>
</main>

<script>
// JavaScript nativo do Bootstrap para impedir envios de formulários inválidos instantaneamente
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
