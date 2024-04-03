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

if((!isset($_SESSION['usuario']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['codigo']) == true)){
    // Redireciona para a página de login caso não esteja logado:
    echo "<script>window.location.href='login.php'</script>";
    unset($_SESSION['codigo']);
    unset($_SESSION['usuario']);
    unset($_SESSION['senha']);
}

?>

<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en_us'; ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                      <!--CSS-->
  <link rel="stylesheet" href="ranking.css">
  <link rel="stylesheet" href="font.css">
  <title>Ranking</title>

<!-- script idioma-->
<script>
        function submitLanguageForm() {
            document.getElementById("languageForm").submit(); // Submete o formulário
        }
    </script>

</head>
<body>
            <!--Botão "retornar MENU"-->
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
      <a href="sair.php"target="_self"><?php echo isset($translations['logoutButton']) ? $translations['logoutButton'] : 'Logout' ?></a>
</header>

                      <!--Score-->
<div id="principal">
  <div class="m-5">
    <table class="table text-white table-bg">
      <thead>
        <tr>
          <th width="100" scope="col">Rankig</th>
          <th width="100" scope="col"><?php echo isset($translations['user']) ? $translations['user'] : 'User' ?></th>
          <th width="100" scope="col"><?php echo isset($translations['score']) ? $translations['score'] : 'Score' ?></th>
        </tr>
      </thead>
      <tbody>
<?php
include "conexao.php";
// Verifica se houve erro na conexão:
if($conexao == false) {
    echo "<script>alert('Erro ao conectar-se ao banco de dados!')</script>";
} else {
    // Executa a consulta SQL para obter os dados dos usuários ordenados por pontos:
    $res = mysqli_query($conexao, "SELECT * FROM users ORDER BY pontos DESC");

    $lugar = 1; // Variável para armazenar a posição no ranking:

    while($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>" . $lugar . "</td>";
        echo "<td>" . $row["usuario"] . "</td>";
        echo "<td>" . $row["pontos"] . "</td>";
        echo "</tr>";
        $lugar++; // Incrementa a posição no ranking:
    }
    // Fecha a tabela:
    echo "</tbody></table>";
}
?>
</div>
</div>
</body>
</html>
