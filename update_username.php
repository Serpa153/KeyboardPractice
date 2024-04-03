<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

// Verifica se a requisição é do tipo POST e se o campo 'username' está definido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include "conexao.php";

    // Verifica se houve erro na conexão com o banco de dados
    if ($conexao == false) {
        // Define o código de resposta HTTP como 500 (Erro interno do servidor) e encerra o script
        http_response_code(500);
        exit('Erro ao conectar ao banco de dados.');
    }

    // Obtém o novo nome de usuário enviado pelo formulário
    $newUsername = $_POST['username'];
    // Obtém o ID do usuário a partir das variáveis de sessão
    $userId = $_SESSION['codigo'];

    // Prepara a consulta SQL para atualizar o nome de usuário na tabela 'users'
    $sql = "UPDATE users SET usuario = ? WHERE codigo = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    // Liga os parâmetros da consulta SQL com as variáveis PHP
    mysqli_stmt_bind_param($stmt, "si", $newUsername, $userId);

    // Executa a consulta SQL preparada
    if (mysqli_stmt_execute($stmt)) {
        // Define o código de resposta HTTP como 200 (OK) e encerra o script
        http_response_code(200);
        exit();
    } else {
        // Define o código de resposta HTTP como 500 (Erro interno do servidor) e encerra o script
        http_response_code(500);
        exit();
    }

    // Fecha o statement e a conexão com o banco de dados
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
} else {
    // Se a requisição não for do tipo POST ou o campo 'username' não estiver definido, define o código de resposta HTTP como 400 (Requisição inválida) e encerra o script
    http_response_code(400);
    exit();
}
?>
