<?php 
    $host ="localhost"; 
    //endereço do servidor do BD
    $usuario = "root"; 
    // Nome do usuario que será utilizado para acessar O MySQL
    $senha = ""; 
    // No XAMPP, por padrão, a senha costuma ser vazia.
    $banco = "clinica_veterinaria"; 
    // Nome do banco de dados que será utilizado pelo sistema.

    $conn =new mysqli($host, $usuario, $senha, $banco);
    // Cria uma nova conexão com o banco de dados.
    // mysqli é uma classe do PHP usada para trabalhar com MySQL.
    if ($conn->connect_error) { // Verifica se ocorreu algum erro ao tentar conectar.
        die ("Erro na conexão: " . $conn->connect_error);
        // Encerra a execução do programa e exibe a mensagem de erro.
        // O operador "." concatena textos.
        // $conn->connect_error contém a descrição do erro ocorrido.

    }
?>