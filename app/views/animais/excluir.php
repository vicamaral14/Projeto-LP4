<?php
session_start();

// Proteção de acesso: se não estiver logado, bloqueia
if (!isset($_SESSION['usuario_id'])) { 
    header("Location: /Projeto-LP4/login.php"); 
    exit; 
}

// Inclui o controlador de Animais
include_once "../../controllers/AnimalController.php";

// Captura o ID de forma segura
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Dispara o processo lógico de exclusão
$animalController->processarExclusao($id);
?>
