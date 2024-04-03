<?php
    session_start(); // Inicia a sessão

    // Remove as variáveis de sessão relacionadas ao usuário:
    unset($_SESSION["usuario"]);
    unset($_SESSION["senha"]);
    unset($_SESSION["codigo"]);

    // Redireciona o usuário para a página de login após deslogar:
    echo "<script>window.location.href='login.php'</script>";
?>
