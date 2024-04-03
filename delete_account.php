<?php
// Inicia a sessão
session_start();

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inclui o arquivo de conexão com o banco de dados
    include "conexao.php";

    // Verifica se a conexão foi estabelecida
    if ($conexao == false) {
        http_response_code(500); // Define o código de resposta HTTP para 500 (Erro interno do servidor)
        exit('Erro ao conectar ao banco de dados.'); // Encerra o script com uma mensagem de erro
    }

    // Obtém o ID do usuário da sessão
    $userId = $_SESSION['codigo'];

    // Prepara a consulta SQL para excluir o usuário
    $sql = "DELETE FROM users WHERE codigo = ?";
    $stmt = mysqli_prepare($conexao, $sql); // Prepara a consulta
    mysqli_stmt_bind_param($stmt, "i", $userId); // Associa o parâmetro à consulta

    // Executa a consulta preparada
    if (mysqli_stmt_execute($stmt)) {
        http_response_code(200); // Define o código de resposta HTTP para 200 (OK)
        exit('Conta excluída com sucesso.'); // Encerra o script com uma mensagem de sucesso
    } else {
        http_response_code(500); // Define o código de resposta HTTP para 500 (Erro interno do servidor)
        exit('Erro ao excluir a conta.'); // Encerra o script com uma mensagem de erro
    }

    mysqli_stmt_close($stmt); // Fecha a consulta preparada
    mysqli_close($conexao); // Fecha a conexão com o banco de dados
} else {
    http_response_code(400); // Define o código de resposta HTTP para 400 (Requisição inválida)
    exit('Requisição inválida.'); // Encerra o script com uma mensagem de erro
}
?>
