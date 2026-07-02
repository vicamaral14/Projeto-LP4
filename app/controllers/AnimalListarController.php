<?php

include("../../config/conexao.php");
include("../models/Animal.php");

// Cria um objeto da classe Animal
$model = new Animal($conn);

// Busca os animais
$animais = $model->listar();

// Envia os dados para a View
include("../views/animais/listar.php");