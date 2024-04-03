<?php
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

    include "conexao.php";
    // Desativa a exibição de mensagens de erro:
    error_reporting(0);

    // Verifica se as variáveis de sessão estão definidas, se não, redireciona para a página de login:
    if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['codigo']) == true)){
        echo "<script>window.location.href='login.php'</script>";
        unset($_SESSION['codigo']);
        unset($_SESSION['usuario']);
        unset($_SESSION['senha']);
    }
    // Obtém o código do usuário logado da sessão:
    $logado = $_SESSION['codigo'];
}
?>    

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS-->
    <link rel="stylesheet" href="treinojogar.css">
    <link rel="stylesheet" href="font.css">
    <title>Treino</title>

    <!-- script idioma-->
    <script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
             // Chamada para gerar as palavras após a seleção do idioma
             gerarStrings();
        }
    </script>

</head>
<!--Botão "retornar ao Menu"-->
<header>
    <nav>
        <form id="languageForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="languages"><?php echo isset($translations['chooseALanguage']) ? $translations['chooseALanguage'] : ''; ?></label>
            <select onchange="submitLanguageForm()" name="languages" id="languages">
                <option value="en_us" <?php if ($_SESSION['lang'] == 'en_us') echo 'selected'; ?>>English</option>
                <option value="pt_br" <?php if ($_SESSION['lang'] == 'pt_br') echo 'selected'; ?>>Português</option>
            </select>

            <!-- Menu suspenso para escolher a categoria de tema de palavras -->
            <select name="categoria" id="categoria">
                <option value="programacao"><?php echo isset($translations['programming']) ? $translations['programming'] : 'Programming'?></option>

                <option value="animais"><?php echo isset($translations['animals']) ? $translations['animals'] : 'Animals'?></option>

                <option value="objetos"><?php echo isset($translations['objects']) ? $translations['objects'] : 'Objects'?></option>

                <option value="adjetivos"><?php echo isset($translations['adjectives']) ? $translations['adjectives'] : 'Adjectives'?></option>
            </select>
            <br>

            <!-- Botão para confirmar a escolha da categoria -->
            <button type="button" onclick="confirmarCategoria()">OK</button>
        </form>

        <!-- Mostrar opção de categoria escolhida -->
        <div id="categoriaEscolhida" style="display: none;"></div>
    </nav>

    <a href="painel.php" class="voltar">Menu</a>
    <a href="sair.php" target="_self"><?php echo isset($translations['logoutButton']) ? $translations['logoutButton'] : 'Logout'?></a>
</header>

<!--Pequena Instrução-->
<aside>
    <p><?php echo isset($translations['instruction']) ? $translations['instruction'] : 'After rewriting the letters above, press the ENTER key to start again.'?></p>
</aside>

<body onload="gerarStrings()" oncopy="return false;" oncut="return false;" onpaste="return false;" oncontextmenu="return false;">
    <form id="jogar" name="jogar" method="post" action="treinojogar.php">
        <div id="principal">
            <div id="itens-palavra">
                <div id="palavra"></div>
                <br>
                <div id="entradaDeDados">
                    <input type="text" id="escreverPalavra" placeholder="<?php echo isset($translations['writeWord']) ? $translations['writeWord'] : 'Rewrite the words above'?>" onkeyup="if(event.keyCode === 13) verificarPalavra()">
                    <br>
                    <div id="incorreta"></div>
                    <div id="vazio"></div>
                    <div id="pontosPai"></div>
                    <br>
                </div>
            </div>
        </div>
    </form>
    <!--JS-->
    <script src="treinojogar.js"></script>
</body>
</html>
