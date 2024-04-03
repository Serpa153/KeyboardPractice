<?php
// Verifica se os campos "usuario", "senha" e "email" foram enviados via POST:
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuario"]) && isset($_POST["senha"]) && isset($_POST["email"])) {
    // Recebe dados do formulário do usuário:
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $email = $_POST["email"];

    $temUsuario = false;
    $temEmail = false;

    // Conexão ao banco de dados:
    $conexao = mysqli_connect("localhost", "root", "root", "banco_bd");

    // Verificação da conexão:
    if ($conexao == false) {
        echo "<h3>Erro ao conectar o banco de dados ...</h3>";
    } else {
        echo "<h3>Conexão efetuada com sucesso!</h3>";

        // Consulta ao banco de dados para verificar se há existência de usuários ou e-mails:
        $res = mysqli_query($conexao, "SELECT * FROM users ORDER BY codigo");

        while ($row = mysqli_fetch_assoc($res)) {
            if ($row["usuario"] == $usuario) {
                $temUsuario = true;
            }
            if ($row["email"] == $email) {
                $temEmail = true;
            }
        }

        // Exibição de mensagens de erro, se necessário:
        if ($temUsuario || $temEmail) {
            echo "<script>document.getElementById('faltouInformacoes').innerHTML = 'Nome de usuário e/ou email já cadastrado(s)!';</script>";
        } else {
            // Inserção de novo usuário no banco de dados:
            $query = "INSERT INTO users (usuario, senha, email) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conexao, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $usuario, $senha, $email);
                mysqli_stmt_execute($stmt);

                echo "Usuário: <b>" . $usuario . "</b>";
                echo "<br>Senha: <b>" . $senha . "</b>";
                echo "<br>E-mail: <b>" . $email . "</b>";
            } else {
                echo "<script>alert('Erro ao preparar a declaração SQL para inserção.')</script>";
            }
        }

        mysqli_close($conexao);
    }
} else {
    echo "<h3>Erro: Dados do formulário não foram recebidos corretamente.</h3>";
}
?>
