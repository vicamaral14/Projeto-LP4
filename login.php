<?php
session_start();
include_once "config/conexao.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!empty($email) && !empty($senha)) {
        
        // Se for o admin padrão, entra direto para testarmos o painel
        if ($email === 'admin@vet.com' && $senha === '123456') {
            $_SESSION['usuario_id'] = 1;
            $_SESSION['usuario_nome'] = 'Administrador';
            
            header("Location: app/views/tutores/listar.php");
            exit;
        }

        // Caso contrário, tenta validar pelo banco de dados
        if (isset($conn)) {
            $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $usuario = $resultado->fetch_assoc();
                if ($senha === $usuario['senha'] || password_verify($senha, $usuario['senha'])) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    header("Location: app/views/tutores/listar.php");
                    exit;
                }
            }
        }
        
        $erro = "E-mail ou senha incorretos!";
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VetCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-lg" style="width: 100%; max-width: 400px; border-radius: 12px;">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h2 class="text-success fw-bold"><i class="fa-solid fa-paw"></i> VetCare</h2>
            <p class="text-muted">Acesse o painel administrativo</p>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger p-2 text-center" style="font-size: 14px;"><?= $erro ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Seu e-mail" value="" autocomplete="off">
            </div>
            
            <div class="mb-4">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required placeholder="Sua senha" value="" autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #1b4d3e; border: none;">
                Entrar no Sistema
            </button>
        </form>
    </div>
</div>

</body>
</html>
