<?php
// Idiomas
session_start(); // Inicia a sessão

include 'i18n.php';

// Define o idioma padrão como "en_us" se não estiver definido
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts();

// Verifica se os campos "usuario" e "senha" foram enviados via POST:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['languages'])) {
        $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
        header("Location: ".$_SERVER['PHP_SELF']); // Redireciona para atualizar a página com o novo idioma
        exit();
    }

    if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
        // Obtém os valores dos campos:
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        include "conexao.php";
        // Verifica se houve erro na conexão com o banco de dados:
        if ($conexao == false) {
            echo "<script>alert('Erro ao conectar ao banco de dados!')</script>";
        } else {
            // Constrói a consulta SQL para verificar as credenciais do usuário:
            $sql = "SELECT * FROM users WHERE usuario = ? AND senha = ?";
            // Prepara a declaração SQL:
            $stmt = $conexao->prepare($sql);
            if ($stmt) {
                // Associa os parâmetros:
                $stmt->bind_param("ss", $usuario, $senha);
                // Executa a consulta:
                $stmt->execute();
                // Obtém o resultado da consulta:
                $result = $stmt->get_result();

                if ($result->num_rows < 1) {
                    echo "<script>alert('Usuário e/ou senha incorreto(s)!');</script>";
                    // Remove as variáveis de sessão se estiverem definidas:
                    if (isset($_SESSION["usuario"]) && isset($_SESSION["senha"]) && isset($_SESSION["codigo"])) {
                        unset($_SESSION['codigo']);
                        unset($_SESSION['usuario']);
                        unset($_SESSION['senha']);
                    }
                } else {
                    $row = $result->fetch_assoc();
                    // Define as variáveis de sessão:
                    $_SESSION['codigo'] = $row['codigo'];
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['senha'] = $senha;

                    // Redireciona para a página 'painel.php':
                    echo "<script>window.location.href='painel.php'</script>";
                }
            } else {
                echo "<script>alert('Erro ao preparar a declaração SQL para verificação de credenciais.')</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="font.css">
    
    <title>Login</title>

    <!-- script idioma-->
    <script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
            // Chamada para gerar as palavras após a seleção do idioma
            gerarStrings();
        }
    </script>

</head>
<body>
    <!--Botão "retornar ao Menu"-->
<header>
    <nav>
        <form id="languageForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="languages"><?php echo isset($translations['chooseALanguage']) ? $translations['chooseALanguage'] : ''; ?></label>
            <select onchange="submitLanguageForm()" name="languages" id="languages">
                <option value="en_us" <?php if ($_SESSION['lang'] == 'en_us') echo 'selected'; ?>>English</option>
                <option value="pt_br" <?php if ($_SESSION['lang'] == 'pt_br') echo 'selected'; ?>>Português</option>
            </select>
        </form>
    </nav>
</header>                      


<section>
    <form id="formulario" name="formulario" method="post" action="login.php" onsubmit="return valida()">
       
        <div id="principal">
            <h1><?php echo isset($translations['loginTitle']) ? $translations['loginTitle'] : 'LogIn'; ?></h1>

            <div class="icon_usuario">
                <ion-icon name="person"></ion-icon>
                <input type="text" placeholder="<?php echo isset($translations['usernamePlaceholder']) ? $translations['usernamePlaceholder'] : 'Username'; ?>" id="usuario" name="usuario">
            </div>

            <div class="icon_senha">
                <ion-icon class="senha_icon" name="key"></ion-icon>
                <input type="password" placeholder="<?php echo isset($translations['passwordPlaceholder']) ? $translations['passwordPlaceholder'] : 'Password'; ?>" id="senha" name="senha">
            </div>

            <div class="login">
                <input type="submit" id="entrar" name="entrar" value="Login">
            </div>

            <!--Redirecionamento Registro-->
            <div class="criar_conta">
                <a href="registrar.php"><?php echo isset($translations['createAccount']) ? $translations['createAccount'] : 'Create an Account'; ?></a>
            </div>
        </div>
    </form>
</section>

<div id="faltouInformacoes"></div>

<!--JS-->
<script src="login.js"></script>

<!--ionicons-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
