<?php
include_once __DIR__ . "/../../config/conexao.php";
include_once __DIR__ . "/../models/Animal.php";
include_once __DIR__ . "/../models/Tutor.php"; 

class AnimalController {
    private $animalModel;
    private $tutorModel;

    public function __construct($db) {
        $this->animalModel = new Animal($db);
        $this->tutorModel = new Tutor($db);
    }

    // Listar todos os animais
    public function listarAnimais() {
        return $this->animalModel->listar();
    }

    // Buscar tutores para a caixinha de seleção (Select) do formulário
    public function listarTutoresDisponiveis() {
        return $this->tutorModel->listar();
    }

    // Processar Cadastro com os campos reais do Banco
    public function processarCadastro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = trim($_POST['nome'] ?? '');
            $especie = trim($_POST['especie'] ?? '');
            $raca = trim($_POST['raca'] ?? '');
            $idade = isset($_POST['idade']) && $_POST['idade'] !== '' ? intval($_POST['idade']) : null;
            $peso = isset($_POST['peso']) && $_POST['peso'] !== '' ? floatval(str_replace(',', '.', $_POST['peso'])) : null;
            $sexo = trim($_POST['sexo'] ?? '');
            $id_tutor = intval($_POST['id_tutor'] ?? 0);

            // Validação dos campos obrigatórios
            if (!empty($nome) && !empty($especie) && $id_tutor > 0) {
                if ($this->animalModel->cadastrar($nome, $especie, $raca, $idade, $peso, $sexo, $id_tutor)) {
                    header("Location: listar.php?msg=sucesso");
                    exit;
                } else {
                    return "Erro ao salvar o animal no banco de dados.";
                }
            } else {
                return "Nome, Espécie e Tutor são obrigatórios.";
            }
        }
        return null;
    }

    // Processar Exclusão
    public function processarExclusao($id) {
        if ($id > 0) {
            if ($this->animalModel->excluir($id)) {
                header("Location: listar.php?msg=excluido");
                exit;
            }
        }
        header("Location: listar.php?msg=erro");
        exit;
    }
}

// Instancia global
$animalController = new AnimalController($conn);
?>