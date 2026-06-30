<?php
include_once __DIR__ . "/../../config/conexao.php";
include_once __DIR__ . "/../models/Consulta.php";

class ConsultaController {
    private $conn;
    private $consultaModel;

    public function __construct($db) {
        $this->conn = $db;
        $this->consultaModel = new Consulta($db);
    }

    // Listar todas as consultas agendadas
    public function listarConsultas() {
        return $this->consultaModel->listar();
    }

    // Carregar os animais disponíveis para as caixas de seleção (Select)
    public function listarAnimaisDisponiveis() {
        $sql = "SELECT a.id, a.nome, t.nome as tutor_nome 
                FROM animais a 
                LEFT JOIN tutores t ON a.id_tutor = t.id 
                ORDER BY a.nome";
        $resultado = $this->conn->query($sql);
        
        $animais = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $animais[] = $linha;
            }
        }
        return $animais;
    }

    // Processar o agendamento de uma nova consulta
    public function processarCadastro($id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco) {
        if ($id_animal > 0 && !empty($veterinario) && !empty($data_consulta) && !empty($hora_consulta) && $preco > 0) {
            return $this->consultaModel->cadastrar($id_animal, $veterinario, $data_consulta, $hora_consulta, $descricao, $preco);
        }
        return false;
    }

    // Processar a exclusão de uma consulta
    public function processarExclusao($id) {
        if ($id > 0) {
            if ($this->consultaModel->excluir($id)) {
                header("Location: listar.php?msg=excluido");
                exit;
            }
        }
        header("Location: listar.php?msg=erro");
        exit;
    }
}

// Instanciação global para uso nas views de consultas
$consultaController = new ConsultaController($conn);
?>