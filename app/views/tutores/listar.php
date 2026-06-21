<?php
    include("../../../config/conexao.php");
    $resultado = $conn->query("SELECT * FROM tutores");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tutores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
    <h2>Lista de Tutores</h2>
    <a href="cadastrar.php" class="btn btn-primary mb-3">
    Novo Tutor
    </a>
    <table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Telefone</th>
    </tr>
    <?php while($linha = $resultado->fetch_assoc()) { ?>
<tr>
    <td><?= $linha['id']; ?></td>
    <td><?= $linha['nome']; ?></td>
    <td><?= $linha['cpf']; ?></td>
    <td><?= $linha['telefone']; ?></td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>