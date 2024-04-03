<?php
session_start();
include 'i18n.php'; // Inclua o arquivo de tradução

// Define o idioma padrão como "en_us" se não estiver definido
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts(); // Obtém as traduções

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['languages'])) {
        $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
        header("Location: ".$_SERVER['PHP_SELF']); // Redireciona para atualizar a página com o novo idioma
        exit();
    }
}

// Verificação da Sessão:
if (!isset($_SESSION['conta-criada']) || empty($_SESSION['conta-criada'])) {
    // Redireciona para a página de registro se a variável de sessão 'conta-criada' não estiver definida
    header("Location: registrar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="contaefetuada.css">
    <link rel="stylesheet" href="font.css">
    <title><?php echo isset($translations['accountCreatedTitle']) ? $translations['accountCreatedTitle'] : 'Conta criada'; ?></title>
  
    <!-- script idioma -->
    <script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
        }
    </script>
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

    <div id="principal">
        <h1><?php echo isset($translations['accountCreatedSuccess']) ? $translations['accountCreatedSuccess'] : 'YOUR ACCOUNT HAS BEEN CREATED SUCCESSFULLY!!'; ?></h1>
        <div id="secundaria">
            <span><?php echo isset($translations['weCanStart']) ? $translations['weCanStart'] : 'Now we can start the game!'; ?></span>
        </div>
        <br>
        <a href="login.php">
            <input type="button" id="irlogin" value="<?php echo isset($translations['loginButton']) ? $translations['loginButton'] : 'Login'; ?>">
        </a>
    </div>
</body>
</html>
