<?php
session_start();

// limpa todas as variáveis da sessão
$_SESSION = [];

// destrói a sessão
session_destroy();

// redireciona para login
header("Location: login.php");
exit;
