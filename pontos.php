<?php
session_start();
include 'i18n.php'; // Inclui o arquivo de tradução

// Define o idioma padrão como "en_us" se não estiver definido na sessão
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

$translations = getTranslatedTexts(); // Obtém as traduções

// Verifica se a seleção de idioma foi feita via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['languages'])) {
    $_SESSION['lang'] = $_POST['languages']; // Define a linguagem selecionada na sessão
    // Redireciona para atualizar a página com o novo idioma, preservando a seleção de idioma
    header("Location: ".$_SERVER['PHP_SELF']."?lang=".$_SESSION['lang']); 
    exit();
}

// Verifica se o usuário está logado, caso contrário, redireciona para a página de login
if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['codigo']) == true)){
    echo "<script>window.location.href='login.php'</script>"; // Redireciona para a página de login
    unset($_SESSION['codigo']);
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
}

$logado = $_SESSION['codigo']; // Obtém o código do usuário logado

include "conexao.php"; // Inclui o arquivo de conexão com o banco de dados

if($conexao == false)
   echo "<script>alert('Erro ao conectar-se ao banco de dados!')</script>"; // Exibe alerta em caso de erro de conexão
else {
   $res = mysqli_query($conexao, "select * from users order by codigo"); // Executa a consulta SQL para obter os usuários

   while($row = mysqli_fetch_assoc($res)) {
       if ($row["codigo"] == $logado){
           $pt = $row["pontos"]; // Obtém os pontos do usuário logado
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
  <link rel="stylesheet" href="pontos.css"> 
  <link rel="stylesheet" href="font.css">
  <title>Pontos</title>

<!-- script idioma-->
<script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
        }
    </script>

</head>
<body>

                      <!--Opção de Idiomas-->
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
                     <!--Botão Menu, Sair-->
        <a href="painel.php">Menu</a>
        <a href="sair.php"target="_self"><?php echo isset($translations['logoutButton']) ? $translations['logoutButton'] : 'Logout'; ?></a> <!-- Exibe o botão de logout com a tradução correspondente -->
    </header>
                    <!--Pontos-->
    <div id="principal">
      <h1><?php echo isset($translations['totalScore']) ? $translations['totalScore'] : 'Total Score'; ?></h1> <!-- Exibe o título "Total Pontos" com a tradução correspondente -->
      <div id="meus_pontos" name="meus_pontos"><?php echo $pt;?></div> <!-- Exibe os pontos do usuário logado -->
      </div>
    </div>
</body>
</html>
