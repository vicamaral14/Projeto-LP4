<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Tutor</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <h2>Cadastrar Tutor</h2>
        <form action="../../controllers/TutorController.php" method="POST">
            <div class="mb-3">
             <label>Nome</label>
              <input type="text" name="cpf" class="form-control">
            </div>
        <div class="mb-3">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>Endereço</label>
            <input type="text" name="endereço" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">
    Salvar
</button>
        </button>
        </form>
    </div>
</body>
</html>