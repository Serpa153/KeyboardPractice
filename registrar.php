<?php
session_start(); // Inicia a sessão

include 'i18n.php'; // Inclui o arquivo de internacionalização

// Define o idioma padrão como "en_us" se não estiver definido
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts(); // Obtém as traduções das palavras

// Verifica se os campos "usuario", "senha" e "email" foram enviados via POST:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['languages'])) {
        $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
        header("Location: ".$_SERVER['PHP_SELF']); // Redireciona para atualizar a página com o novo idioma
        exit();
    }

    if (isset($_POST["usuario"]) && isset($_POST["senha"]) && isset($_POST["email"])) {
        // Obtém os valores dos campos:
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];
        $email = $_POST["email"];

        // Conexão ao banco de dados:
        $conexao = mysqli_connect("localhost", "root", "root", "banco_bd");

        // Verificação da conexão:
        if ($conexao === false) {
            echo "<script>alert('Erro ao conectar-se ao banco de dados!')</script>";
        } else {
            // Prepara a declaração SQL para a inserção de um novo usuário:
            $query = "INSERT INTO users (usuario, senha, email, pontos) VALUES (?, ?, ?, 0)";
            $stmt = mysqli_prepare($conexao, $query);

            // Verifica se a declaração SQL foi preparada com sucesso:
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sss", $usuario, $senha, $email);
                mysqli_stmt_execute($stmt);

                // Verifica se a inserção foi bem-sucedida:
                if(mysqli_stmt_affected_rows($stmt) > 0) {
                    // Redireciona para a página 'contaefetuada.php' após um breve atraso:
                    echo "<script>setTimeout(function(){ window.location.href='contaefetuada.php'; }, 1000);</script>";
                } else {
                    // Exibe um alerta em caso de erro na inserção:
                    echo "<script>alert('Erro ao criar conta. Por favor, tente novamente.')</script>";
                }

                mysqli_stmt_close($stmt);
            } else {
                // Exibe um alerta em caso de erro na preparação da declaração SQL:
                echo "<script>alert('Erro ao preparar a declaração SQL para inserção.')</script>";
            }

            mysqli_close($conexao);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="registrar.css">
    <title>Registro</title>

    <!-- script idioma-->
    <script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
            // Chamada para gerar as palavras após a seleção do idioma
            gerarStrings();
        }
    </script>

    <style>
        #faltouInformacoes {
            font-size: 15px;
            color: red;
        }
    </style>
</head>
<body>

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
    <form id="formulario" name="formulario" method="post" action="registrar.php" onsubmit="return valida()">
        <div id="principal">
            
            <h1><?php echo isset($translations['registerTitle']) ? $translations['registerTitle'] : 'Register' ?></h1>
            <br>

            <input type="text" placeholder="<?php echo isset($translations['usernamePlaceholder']) ? $translations['usernamePlaceholder'] : 'Username'; ?>" id="usuario" name="usuario" autocomplete="username">
            <br>

            <input type="password" placeholder="<?php echo isset($translations['passwordPlaceholder']) ? $translations['passwordPlaceholder'] : 'Password'; ?>" id="senha" name="senha" autocomplete="current-password">
            <br>

            <input type="text" placeholder="<?php echo isset($translations['emailPlaceholder']) ? $translations['emailPlaceholder'] : 'E-mail'; ?>" id="email" name="email" autocomplete="email">
            <br>

            <div id="faltouInformacoes"></div>
            <br>

            <input type="submit" id="criar-conta" name="criar-conta" value="<?php echo isset($translations['createButton']) ? $translations['createButton'] : 'Create'; ?>">
            <br>

            <a href="login.php" id="jaTenhoConta"><?php echo isset($translations['alreadyHaveAccount']) ? $translations['alreadyHaveAccount'] : 'Have a account already' ?></a>
        </div>
    </form>
</section>
<!--JS-->
<script src="registrar.js"></script>
</body>
</html>
