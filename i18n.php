<?php
// Define o idioma padrão como "en_us" se não estiver definido
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en_us';
}

// Carrega as traduções do arquivo correspondente ao idioma atual da sessão
$filePath = sprintf('translations/%s.json', $_SESSION['lang']);
$fileContent = file_get_contents($filePath);
$translations = json_decode($fileContent, true);

function getTranslatedTexts()
{
    global $translations;
    return $translations;
}
?>
