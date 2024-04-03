<?php
session_start();
include 'i18n.php'; // Inclua o arquivo de tradução

// Define o idioma padrão como "en_us" se não estiver definido
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts(); // Obtém as traduções

// Verifica se a seleção de idioma foi feita
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['languages'])) {
    $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
    // Redireciona para atualizar a página com o novo idioma, preservando a seleção de idioma
    header("Location: ".$_SERVER['PHP_SELF']."?lang=".$_SESSION['lang']); 
    exit();
}

// Verifica se as variáveis de sessão 'usuario', 'senha' e 'codigo' estão definidas:
if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha']) || !isset($_SESSION['codigo'])) {
    // Redireciona para a página de login se as condições acima forem verdadeiras:
    echo "<script>window.location.href='login.php'</script>";
}

$logado = $_SESSION['codigo'];
?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <!--CSS-->
    <link rel="stylesheet" href="painel.css">
    <link rel="stylesheet" href="font.css">
    <!-- script idioma-->
    <script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
        }
    </script>
</head>
<body>

<!--Idiomas-->
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

<!-- Menu Sanduíche -->
<header>
    <div id="menuToggle">
        <input type="checkbox" />
        <div class="menu-icon"></div>
        <!-- Links do menu -->
        <nav id="menu" class="nav-links">
            <ul>
                <li><a href="ranking.php" target="_self"><?php echo isset($translations['rankingLink']) ? $translations['rankingLink'] : 'Ranking' ?></a></li>
                <li><a href="pontos.php" target="_self"><?php echo isset($translations['score']) ? $translations['score'] : 'Score' ?></a></li>
                <li><a href="infoconta.php"><?php echo isset($translations['accountInfoLink']) ? $translations['accountInfoLink'] : 'Account Info' ?></a></li>
                <li><a href="treinopainel.php" target="_self"><?php echo isset($translations['trainingModeLink']) ? $translations['trainingModeLink'] : 'Training Mode' ?></a></li>
                <li><a href="jogarfacil.php" target="_self"><?php echo isset($translations['easyLevelLink']) ? $translations['easyLevelLink'] : 'Easy Level'?></a></li>
                <li><a href="jogardificil.php" target="_self"><?php echo isset($translations['hardLevelLink']) ? $translations['hardLevelLink'] : 'Hard Level' ?></a></li>
                <li><a href="sair.php" class="sair" target="_self"><?php echo isset($translations['logoutButton']) ? $translations['logoutButton'] : 'Logout' ?></a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Manual -->
<article>
    <div class="column_1">
        <h2><strong><?php echo isset($translations['postureForTyping']) ? $translations['postureForTyping'] : 'Sitting posture for typing' ?></strong></h2>
        <p>
            &deg; <?php echo isset($translations['postureStep1']) ? $translations['postureStep1'] : 'Sit up straight and remember to keep your back straight.' ?><br>
            &deg; <?php echo isset($translations['postureStep2']) ? $translations['postureStep2'] : 'Keep your elbows bent at the correct angle.' ?><br>
            &deg; <?php echo isset($translations['postureStep3']) ? $translations['postureStep3'] : 'Face the screen with your head tilted slightly forward.' ?><br>
            &deg; <?php echo isset($translations['postureStep4']) ? $translations['postureStep4'] : 'Keep a distance of 45 to 70 cm between your eyes and the screen.' ?><br>
            &deg; <?php echo isset($translations['postureStep5']) ? $translations['postureStep5'] : 'Expose your shoulder, arm and wrist muscles to as little strain as possible.' ?><br>
            &deg; <?php echo isset($translations['postureStep6']) ? $translations['postureStep6'] : 'Wrists can touch the table top in front of the keyboard.' ?><br>
        </p>
    </div>
    <div class="column_2">
        <h2><strong><?php echo isset($translations['initialLinePosition']) ? $translations['initialLinePosition'] : 'Home row position' ?></strong></h2>
        <p>
            &deg; <?php echo isset($translations['initialLineStep1']) ? $translations['initialLineStep1'] : 'Curl your fingers slightly and place them on the ASDF and JKLC keys, which are located on the center row of the letter keys.' ?><br>
            &deg; <?php echo isset($translations['initialLineStep2']) ? $translations['initialLineStep2'] : 'This line is called the HOME LINE because you always start from these keys and always return to them.' ?><br>
            &deg; <?php echo isset($translations['initialLineStep3']) ? $translations['initialLineStep3'] : 'The F and J keys under your index fingers should have a raised line to help you find them without looking' ?><br>
        </p>
        <br>
        <h2><strong><?php echo isset($translations['keyboardLayout']) ? $translations['keyboardLayout'] : 'Keyboard layout' ?></strong></h2>
        <p>
            &deg; <?php echo isset($translations['keyboardStep1']) ? $translations['keyboardStep1'] : 'Always return to the starting position of the fingers, ASDF and JKLC.' ?><br>
            &deg; <?php echo isset($translations['keyboardStep2']) ? $translations['keyboardStep2'] : 'Establish and maintain a rhythm while typing.' ?><br>
            &deg; <?php echo isset($translations['keyboardStep3']) ? $translations['keyboardStep3'] : 'Key presses must occur at equal intervals.' ?><br>
            &deg; <?php echo isset($translations['keyboardStep4']) ? $translations['keyboardStep4'] : 'As you type, imagine the location of the symbol on the keyboard.' ?><br>
            &deg; <?php echo isset($translations['keyboardStep5']) ? $translations['keyboardStep5'] : 'The SHIFT key is always pressed by the little finger opposite the one pressing the other key.' ?><br>
            &deg; <?php echo isset($translations['keyboardStep6']) ? $translations['keyboardStep6'] : 'Use your most convenient thumb to press the space bar.' ?><br>
            &deg; <?php echo isset($translations['keyboardStep7']) ? $translations['keyboardStep7'] : 'For maximum results, choose a typing course for your desired keyboard layout and language.' ?><br> 
            &deg; <?php echo isset($translations['keyboardStep8']) ? $translations['keyboardStep8'] : 'For maximum results, choose a typing course for your desired keyboard layout and language.' ?><br>
        </p>
        <h2><strong><?php echo isset($translations['fingerMovement']) ? $translations['fingerMovement'] : 'Finger movement' ?></strong></h2>
        <p>
            &deg; <?php echo isset($translations['fingerStep1']) ? $translations['fingerStep1'] : 'Dont look at the keys when typing. Just slide your fingers to find the start line marking.' ?><br>
            &deg; <?php echo isset($translations['fingerStep2']) ? $translations['fingerStep2'] : 'Limit the movement of your hand and fingers to only that needed to press a specific key.' ?><br>
            &deg; <?php echo isset($translations['fingerStep3']) ? $translations['fingerStep3'] : 'Keep your hands and fingers close to the starting position. This improves typing speed and reduces stress on your hands.' ?><br>
            &deg; <?php echo isset($translations['fingerStep4']) ? $translations['fingerStep4'] : 'Pay attention to the ring and pinky fingers, as they are considerably underdeveloped.' ?><br>
        </p>
    </div>
</article>

<!-- Botão "Para mais detalhes" -->
<footer class="link">
    <a href="https://www.ratatype.com.br/learn/" target="_blank"><button class="url"><?php echo isset($translations['moreDetailsButton']) ? $translations['moreDetailsButton'] : 'For more details' ?></button></a>
</footer>

<script src="painel.js"></script>
</body>
</html>
