<?php
include_once __DIR__ . "/../../config/conexao.php";
include_once __DIR__ . "/../models/Tutor.php";

class TutorController {
    private $tutorModel;

    public function __construct($db) {
        $this->tutorModel = new Tutor($db);
    }

    public function listarTutores() {
        return $this->tutorModel->listar();
    }

    public function processarCadastro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = trim($_POST['nome'] ?? '');
            $cpf = trim($_POST['cpf'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!empty($nome) && !empty($cpf) && !empty($email)) {
                if ($this->tutorModel->cadastrar($nome, $cpf, $telefone, $email)) {
                    header("Location: listar.php?msg=sucesso");
                    exit;
                } else {
                    return "Erro ao cadastrar o tutor no banco de dados.";
                }
            } else {
                return "Nome, CPF e E-mail são obrigatórios.";
            }
        }
        return null;
    }

    public function processarEdicao($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = trim($_POST['nome'] ?? '');
            $cpf = trim($_POST['cpf'] ?? '');
            $telefone = trim($_POST['telefone'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!empty($nome) && !empty($cpf) && !empty($email)) {
                if ($this->tutorModel->atualizar($id, $nome, $cpf, $telefone, $email)) {
                    header("Location: listar.php?msg=editado");
                    exit;
                } else {
                    return "Erro ao atualizar o tutor no banco de dados.";
                }
            } else {
                return "Nome, CPF e E-mail são obrigatórios.";
            }
        }
        return $this->tutorModel->buscarPorId($id);
    }

    public function processarExclusao($id) {
        if ($id > 0) {
            if ($this->tutorModel->excluir($id)) {
                header("Location: listar.php?msg=excluido");
                exit;
            }
        }
        header("Location: listar.php?msg=erro");
        exit;
    }
}

// Instancia global usada pelas views de tutores
$tutorController = new TutorController($conn);
?>