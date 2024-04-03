<?php
// Inicia a sessão
session_start();

include 'i18n.php'; // Inclua o arquivo de tradução

// Define o idioma padrão como "en_us" se não estiver definido
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts(); // Obtém as traduções

// Verifica se os campos "usuario" e "senha" foram enviados via POST:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['languages'])) {
        $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
        header("Location: ".$_SERVER['PHP_SELF']); // Redireciona para atualizar a página com o novo idioma
        exit();
    }
}
    
if (!isset($_SESSION['usuario']) || !isset($_SESSION['senha']) || !isset($_SESSION['codigo'])) {
    echo "<script>window.location.href='login.php'</script>";
    exit; // Termina a execução do script para evitar execução adicional desnecessária
}

include "conexao.php";

if ($conexao == false) {
    echo "<script>alert('Erro ao conectar ao banco de dados!')</script>";
    echo "<script>window.location.href='painel.php'</script>";
    exit;
}

$logado = $_SESSION['codigo'];

// Consulta SQL para recuperar os dados do usuário logado
$sql = "SELECT * FROM users WHERE codigo = $logado";
$result = mysqli_query($conexao, $sql);

if (!$result || mysqli_num_rows($result) != 1) {
    echo "<script>alert('Erro ao recuperar dados do usuário!')</script>";
    echo "<script>window.location.href='painel.php'</script>";
    exit;
}

$row = mysqli_fetch_assoc($result);
$u = htmlspecialchars($row["usuario"]);
$e = htmlspecialchars($row["email"]);
$s = htmlspecialchars($row["senha"]);

?>


<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="infoconta.css">
    <link rel="stylesheet" href="font.css">
    <title>Minha conta</title>

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

    <a href="painel.php">Menu</a>
    <a href="sair.php" target="_self"><?php echo isset($translations['logoutButton']) ? $translations['logoutButton'] : 'Logout' ?></a>
</header>

<div id="caixa">
    <div id="caixaInterior">
        <h2><?php echo isset($translations['myAccount']) ? $translations['myAccount'] : 'My account'?></h2>

        <div id="linha1">

            <label for="nomeUsuario"><?php echo isset($translations['userName']) ? $translations['userName'] : 'User name'?></label>
            <span id="nomeUsuario"><?php echo isset($u) ? $u : ''; ?></span>

            <input type="text" id="editNomeUsuario" style="display: none;" value="<?php echo isset($u) ? $u : ''; ?>">


            <button onclick="editUsername()" class="usuario"><?php echo isset($translations['editButtom']) ? $translations['editButtom'] : 'Edit'?></button>

            <input type="submit" name="saveUsername" value="<?php echo isset($translations['saveButtom']) ? $translations['saveButtom'] : 'Save'; ?>">
        </div>


 <div id="linha2">

            <label for="editEmail"><?php echo isset($translations['myEmail']) ? $translations['myEmail'] : 'My E-mail:'?></label>
            <span id="email"><?php echo isset($e) ? $e : ''; ?></span> 

            <input type="text" id="editEmail" style="display: none;" value="<?php echo isset($e) ? $e : ''; ?>"> 

            <button onclick="editEmail()" class="email"><?php echo isset($translations['editButtom']) ? $translations['editButtom'] : 'Edit'?></button>

            <input type="submit" name="saveEmail" value="<?php echo isset($translations['saveButtom']) ? $translations['saveButtom'] : 'Save'; ?>">
</div>
        

  <div id="linha3">

            <label for="editPassword"><?php echo isset($translations['myPassword']) ? $translations['myPassword'] : 'My Password:'?></label>
            <span id="senha"><?php echo isset($s) ? $s : ''; ?></span> 

            <input type="text" id="editPassword" style="display: none;" value="<?php echo isset($s) ? $s : ''; ?>"> 

            <button onclick="editPassword()"><?php echo isset($translations['editButtom']) ? $translations['editButtom'] : 'Edit'?></button>
            
            <input type="submit" name="savePassword" value="<?php echo isset($translations['saveButtom']) ? $translations['saveButtom'] : 'Save'; ?>">
        </div>

        <div id="linha4">

            <button onclick="deleteAccount()"><?php echo isset($translations['deleteAccountButtom']) ? $translations['deleteAccountButtom'] : 'Delete my account'?></button>
        </div>
    </div>
</div>

<!--JS-->
<script src="infoconta.js"></script>
</body>
</html>
