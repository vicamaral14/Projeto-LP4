<?php
session_start();

// Proteção de acesso: se não estiver logado, bloqueia
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

include_once "../../controllers/ConsultaController.php";
include_once "../../models/Consulta.php";

// Garante que o arquivo de conexão global foi incluído
include_once "../../../config/conexao.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) { 
    header("Location: listar.php"); 
    exit; 
}

$consultaM = new Consulta($conn);
$mensagemErro = "";

// Processamento do formulário de atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_animal = intval($_POST['id_animal'] ?? 0);
    $veterinario = trim($_POST['veterinario'] ?? '');
    $data_consulta = trim($_POST['data_consulta'] ?? '');
    $hora_consulta = trim($_POST['hora_consulta'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    
    // Converte a vírgula em ponto para não quebrar valores decimais
    $preco_cru = trim($_POST['preco'] ?? '');
    $preco = !empty($preco_cru) ? floatval(str_replace(',', '.', $preco_cru)) : 0.0;

    // TRAVA COMPLETA NO BACKEND: Não deixa passar se os campos prioritários estiverem vazios ou zerados
    if ($id_animal > 0 && !empty($veterinario) && !empty($data_consulta) && !empty($hora_consulta) && $preco > 0) {
        
        if ($consultaM->atualizar($id, $id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco)) {
            header("Location: listar.php?msg=editado");
            exit;
        } else {
            $mensagemErro = "Erro ao atualizar a consulta no banco de dados. Verifique os campos.";
        }
        
    } else {
        $mensagemErro = "Atenção: Médico, Data, Horário e um Valor maior que zero são estritamente obrigatórios!";
    }
}

// Busca os dados atuais do registro para preencher o formulário
$dadosConsulta = $consultaM->buscarPorId($id);
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
        <h2 class="fw-bold text-dark mb-1">Editar Consulta</h2>
        <p class="text-muted small">Altere os dados do agendamento. Campos com <span class="text-danger">*</span> são obrigatórios prioritários.</p>
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
                    <label for="id_animal" class="form-label text-secondary small fw-bold">Paciente / Animal <span class="text-danger">*</span></label>
                    <select name="id_animal" id="id_animal" class="form-select" style="border-radius: 8px;" required>
                        <?php foreach ($listaAnimais as $animal): ?>
                            <option value="<?= $animal['id'] ?>" <?= $animal['id'] == ($dadosConsulta['id_animal'] ?? 0) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($animal['nome']) ?> (<?= htmlspecialchars($animal['tutor_nome']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Selecione o paciente.</div>
                </div>

                <div class="col-md-6">
                    <label for="veterinario" class="form-label text-secondary small fw-bold">Médico Veterinário (Doutor) <span class="text-danger">*</span></label>
                    <input type="text" name="veterinario" id="veterinario" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosConsulta['veterinario'] ?? '') ?>">
                    <div class="invalid-feedback">O nome do doutor é obrigatório.</div>
                </div>

                <div class="col-md-4">
                    <label for="data_consulta" class="form-label text-secondary small fw-bold">Data <span class="text-danger">*</span></label>
                    <input type="date" name="data_consulta" id="data_consulta" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($dadosConsulta['data_consulta'] ?? '') ?>">
                    <div class="invalid-feedback">Informe a data.</div>
                </div>

                <div class="col-md-4">
                    <label for="hora_consulta" class="form-label text-secondary small fw-bold">Horário <span class="text-danger">*</span></label>
                    <?php 
                        $horaExibir = "";
                        if (!empty($dadosConsulta['hora_consulta']) && $dadosConsulta['hora_consulta'] != "00:00:00") {
                            $horaExibir = substr($dadosConsulta['hora_consulta'], 0, 5);
                        }
                    ?>
                    <input type="time" name="hora_consulta" id="hora_consulta" class="form-control" style="border-radius: 8px;" required value="<?= htmlspecialchars($horaExibir) ?>">
                    <div class="invalid-feedback">O horário da consulta é obrigatório.</div>
                </div>

                <div class="col-md-4">
                    <label for="preco" class="form-label text-secondary small fw-bold">Valor (R$) <span class="text-danger">*</span></label>
                    <input type="number" name="preco" id="preco" class="form-control" style="border-radius: 8px;" step="0.01" min="0.01" required value="<?= htmlspecialchars(!empty($dadosConsulta['preco']) ? $dadosConsulta['preco'] : '') ?>" placeholder="0.00">
                    <div class="invalid-feedback">Insira um valor maior que zero.</div>
                </div>

                <div class="col-12">
                    <label for="descricao" class="form-label text-secondary small fw-bold">Descrição / Sintomas</label>
                    <textarea name="descricao" id="descricao" class="form-control" style="border-radius: 8px;" rows="3"><?= htmlspecialchars($dadosConsulta['descricao'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="listar.php" class="btn btn-light px-4" style="border-radius: 8px;">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5 fw-semibold shadow-sm" style="border-radius: 8px;">
                    Salvar Alterações
                </button>
            </div>

        </form>
    </div>
</main>

<script>
// JavaScript nativo do Bootstrap para interceptar o clique e travar na hora se houver campos em branco
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