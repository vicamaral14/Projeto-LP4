<?php
// Inicia a sessão para verificar se o usuário está logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o usuário já estiver logado, redireciona direto para o painel principal unificado (index das views)
if (isset($_SESSION['usuario_id']) || isset($_SESSION['logado'])) {
    header("Location: app/views/index.php");
    exit;
} else {
    // Caso contrário, manda para a tela de login
    header("Location: login.php");
    exit;
}
?>