<?php

$conexao = mysqli_connect(
    'localhost',
    'alessandro',
    'livre',
    'quinta_feira'
);


mysqli_query(
    $conexao,
    "INSERT INTO tb_habilidade VALUES (3, 'MongoDB', 'Bla bla bla')"
);

$resultado = mysqli_query($conexao, 'SELECT * FROM tb_habilidade');

echo count($resultado->fetch_all());