<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

// Verifica se a requisição é do tipo POST e se o parâmetro 'email' foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {

    // Inclui o arquivo de conexão com o banco de dados
    include "conexao.php";

    // Verifica se a conexão com o banco de dados foi estabelecida corretamente
    if ($conexao == false) {
        // Define o código de resposta HTTP 500 (Erro interno do servidor) e encerra o script
        http_response_code(500);
        exit('Erro ao conectar ao banco de dados.');
    }

    // Obtém o novo e-mail fornecido no formulário e o ID do usuário da variável de sessão
    $newEmail = $_POST['email'];
    $userId = $_SESSION['codigo'];

    // Prepara a consulta SQL para atualizar o e-mail do usuário
    $sql = "UPDATE users SET email = ? WHERE codigo = ?";
    $stmt = mysqli_prepare($conexao, $sql);

    // Associa os parâmetros à declaração preparada
    mysqli_stmt_bind_param($stmt, "si", $newEmail, $userId);

    // Executa a declaração preparada
    if (mysqli_stmt_execute($stmt)) {
        // Define o código de resposta HTTP 200 (Sucesso) e encerra o script
        http_response_code(200);
        exit();
    } else {
        // Define o código de resposta HTTP 500 (Erro interno do servidor) e encerra o script
        http_response_code(500);
        exit();
    }

    // Fecha a declaração preparada e a conexão com o banco de dados
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
} else {
    // Define o código de resposta HTTP 400 (Requisição inválida) e encerra o script
    http_response_code(400);
    exit();
}
?>
