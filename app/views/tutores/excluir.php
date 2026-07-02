<?php
session_start();

// Proteção de acesso: se não estiver logado, bloqueia
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../login.php");
    exit;
}

// Inclui o Controller unificado
include_once __DIR__ . "/../../controllers/TutorController.php";

// Captura o ID da URL de forma segura
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Dispara a exclusão através do Controller
$tutorController->processarExclusao($id);
?>
