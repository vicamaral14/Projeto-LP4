<?php 
$host = "localhost"; 
$usuario = "root"; 
$senha = ""; 
$banco = "clinica_veterinaria"; 

// Cria a conexão padrão do sistema
$conn = new mysqli($host, $usuario, $senha, $banco);

// Garante compatibilidade caso outros arquivos usem o nome $conexao
$conexao = $conn;

// Verifica se houve erro na tentativa de conexão
if ($conn->connect_error) { 
    die("Erro na conexão: " . $conn->connect_error);
}

// Configura o banco para aceitar acentuação corretamente (Ex: Ç, Á, é)
$conn->set_charset("utf8mb4");
?>