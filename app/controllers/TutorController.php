<?php
// Garante o caminho correto para a conexão e para o Model
include_once __DIR__ . "/../../config/conexao.php";
include_once __DIR__ . "/../models/Tutor.php";

class TutorController {
    private $model;

    public function __construct($db) {
        // Inicializa o Model passando a conexão estável
        $this->model = new Tutor($db);
    }

    // 1. Listar
    public function listarTutores() {
        return $this->model->listar();
    }

    // 2. Cadastrar
    public function processarCadastro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = trim($_POST['nome'] ?? '');
            $cpf = trim($_POST['cpf'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!empty($nome) && !empty($cpf) && !empty($telefone) && !empty($email)) {
                $sucesso = $this->model->cadastrar($nome, $cpf, $telefone, $email);
                if ($sucesso) {
                    header("Location: listar.php?msg=sucesso");
                    exit;
                } else {
                    return "Erro ao salvar no banco de dados.";
                }
            } else {
                return "Por favor, preencha todos os campos obrigatórios.";
            }
        }
        return null;
    }

    // 3. Carregar dados para Edição
    public function carregarTutor($id) {
        return $this->model->buscarPorId($id);
    }

    // 4. Salvar Edição
    public function processarEdicao() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $nome = trim($_POST['nome'] ?? '');
            $cpf = trim($_POST['cpf'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!empty($nome) && !empty($cpf) && !empty($telefone) && !empty($email)) {
                if ($this->model->atualizar($id, $nome, $cpf, $telefone, $email)) {
                    header("Location: listar.php?msg=editado");
                    exit;
                } else {
                    return "Erro ao atualizar os dados.";
                }
            } else {
                return "Todos os campos são obrigatórios.";
            }
        }
        return null;
    }

    // 5. Excluir (O seu método integrado)
    public function processarExclusao($id) {
        if ($id > 0) {
            if ($this->model->excluir($id)) {
                header("Location: listar.php?msg=excluido");
                exit;
            }
        }
        header("Location: listar.php?msg=erro");
        exit;
    }
}

// Instancia o controller passando a conexão global $conn
$tutorController = new TutorController($conn);
?>