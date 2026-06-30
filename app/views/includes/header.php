<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetCare - Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background-color: #1b4d3e;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/Projeto-LP4/index.php">
            <i class="fa-solid fa-paw me-2"></i>VetCare
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/Projeto-LP4/index.php">
                        <i class="fa-solid fa-house me-1 small"></i> Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Projeto-LP4/app/views/tutores/listar.php">
                        <i class="fa-solid fa-users me-1 small"></i> Tutores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Projeto-LP4/app/views/animais/listar.php">
                        <i class="fa-solid fa-dog me-1 small"></i> Animais
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Projeto-LP4/app/views/consultas/listar.php">
                        <i class="fa-solid fa-calendar-days me-1 small"></i> Consultas
                    </a>
                </li>
            </ul>
            <span class="navbar-text text-white d-flex align-items-center">
                Olá, <?= $_SESSION['usuario_nome'] ?? 'Administrador'; ?>! 
                <a href="/Projeto-LP4/login.php" class="btn btn-sm btn-danger ms-3">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Sair
                </a>
            </span>
        </div>
    </div>
</nav>