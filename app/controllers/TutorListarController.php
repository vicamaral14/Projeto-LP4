<?php

include("../../config/conexao.php");

include("../models/Tutor.php");

$model = new Tutor($conn);

$tutores = $model->listar();

include("../views/tutores/listar.php");