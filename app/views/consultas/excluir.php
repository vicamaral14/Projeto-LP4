<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include_once "../../controllers/ConsultaController.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$consultaController->processarExclusao($id);
?>