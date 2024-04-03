<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();

// Verifica se a requisição é do tipo POST e se o campo 'password' foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include "conexao.php";

    // Verifica se houve erro na conexão com o banco de dados
    if ($conexao == false) {
        // Define o código de resposta HTTP 500 e encerra o script
        http_response_code(500);
        exit('Erro ao conectar ao banco de dados.');
    }

    // Obtém a nova senha enviada através do formulário
    $newPassword = $_POST['password'];
    // Obtém o ID do usuário da sessão
    $userId = $_SESSION['codigo'];

    // Prepara a consulta SQL para atualizar a senha do usuário
    $sql = "UPDATE users SET senha = ? WHERE codigo = ?";
    // Prepara a declaração SQL e vincula os parâmetros
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $newPassword, $userId);

    // Executa a declaração preparada
    if (mysqli_stmt_execute($stmt)) {
        // Define o código de resposta HTTP 200 e encerra o script
        http_response_code(200);
        exit();
    } else {
        // Define o código de resposta HTTP 500 e encerra o script
        http_response_code(500);
        exit();
    }

    // Fecha a declaração preparada e a conexão com o banco de dados
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
} else {
    // Se a requisição não for do tipo POST ou se o campo 'password' não foi enviado, define o código de resposta HTTP 400 e encerra o script
    http_response_code(400);
    exit();
}
?>
