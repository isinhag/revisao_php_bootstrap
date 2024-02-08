<?php

// Incluir a conexao com o banco de dados
include_once "conexao.php";

// Receber os dados do formulário via método POST
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);


