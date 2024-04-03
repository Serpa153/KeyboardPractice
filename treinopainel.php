<?php
session_start(); // Inicia a sessão

include 'i18n.php'; // Inclui o arquivo de internacionalização

// Define o idioma padrão como "en_us" se não estiver definido na sessão
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts(); // Obtém as traduções dos textos

// Verifica se os campos "usuario" e "senha" foram enviados via POST:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o formulário de seleção de idioma foi submetido
    if (isset($_POST['languages'])) {
        $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
        header("Location: ".$_SERVER['PHP_SELF']); // Redireciona para atualizar a página com o novo idioma
        exit();
    }

    include "conexao.php"; // Inclui o arquivo de conexão com o banco de dados
    // Desativa a exibição de mensagens de erro:
    error_reporting(0);
}

// Verifica se o usuário está logado, se não estiver, redireciona para a página de login
if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['codigo']) == true)){
    echo "<script>window.location.href='login.php'</script>"; // Redireciona para a página de login
    unset($_SESSION['codigo']);
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
}
$logado = $_SESSION['codigo']; // Obtém o código do usuário logado
?>


<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="treinopainel.css">
    <link rel="stylesheet" href="font.css">
    <title>Menu treino</title>

    <!-- script para mudar o idioma -->
    <script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); //Submete o formulário de seleção de idioma
        }
    </script>

</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <nav>
            <!-- Formulário para seleção de idioma -->
            <form id="languageForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="languages"><?php echo isset($translations['chooseALanguage']) ? $translations['chooseALanguage'] : ''; ?></label>
                <select onchange="submitLanguageForm()" name="languages" id="languages">
                    <!-- Opções de idioma -->
                    <option value="en_us" <?php if ($_SESSION['lang'] == 'en_us') echo 'selected'; ?>>English</option>
                    <option value="pt_br" <?php if ($_SESSION['lang'] == 'pt_br') echo 'selected'; ?>>Português</option>
                </select>
            </form>
        </nav>

                 <!-- Botões "Retornar ao Menu" e "Sair" -->
        <a href="painel.php" class="voltar">Menu</a>
        <a href="sair.php" target="_self"><?php echo isset($translations['logoutButton']) ? $translations['logoutButton'] : 'Logout'?></a>
    </header>

                       <!-- Pequena instrução -->
    <aside>
        <h2><?php echo isset($translations['trainMod']) ? $translations['trainMod'] : 'Training Mode:'?></h2>
        <p><?php echo isset($translations['manual']) ? $translations['manual'] : 'Practice, without time limits and without worrying about points before starting the real game!'?></p>
    </aside>

                    <!-- Botão "Iniciar Jogo" -->
    <div id="areajogar">
        <a href="treinojogar.php" class="jogar">START</a>
    </div> 
</body>
</html>
