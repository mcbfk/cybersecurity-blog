<?php
// Script para corrigir problemas de codificação UTF-8 nas notícias
header('Content-Type: text/html; charset=utf-8');

// Função para corrigir a codificação de strings
function fixEncoding($text) {
    // Detecta a codificação atual
    $encoding = mb_detect_encoding($text, 'UTF-8, ISO-8859-1', true);
    
    // Se não for UTF-8, converte para UTF-8
    if ($encoding != 'UTF-8') {
        $text = mb_convert_encoding($text, 'UTF-8', $encoding);
    }
    
    // Corrige problemas comuns de codificação
    $replacements = [
        'Ã\u00a3' => 'ã',
        'Ã\u00a1' => 'á',
        'Ã\u00a9' => 'é',
        'Ã\u00ad' => 'í',
        'Ã\u00b3' => 'ó',
        'Ã\u00ba' => 'ú',
        'Ã\u00a7' => 'ç',
        'Ã\u00a2' => 'â',
        'Ã\u00aa' => 'ê',
        'Ã\u00ae' => 'î',
        'Ã\u00b4' => 'ô',
        'Ã\u00bb' => 'û',
        'Ã\u00a0' => 'à',
        'Ã\u00a8' => 'è',
        'Ã\u00ac' => 'ì',
        'Ã\u00b2' => 'ò',
        'Ã\u00b9' => 'ù',
        'Ã\u0081' => 'Á',
        'Ã\u0089' => 'É',
        'Ã\u008d' => 'Í',
        'Ã\u0093' => 'Ó',
        'Ã\u009a' => 'Ú',
        'Ã\u0087' => 'Ç',
        'Ã\u0082' => 'Â',
        'Ã\u008a' => 'Ê',
        'Ã\u008e' => 'Î',
        'Ã\u0094' => 'Ô',
        'Ã\u009b' => 'Û',
        'Ã\u0080' => 'À',
        'Ã\u0088' => 'È',
        'Ã\u008c' => 'Ì',
        'Ã\u0092' => 'Ò',
        'Ã\u0099' => 'Ù',
        'ConteÃºdo em inglÃªs' => 'Conteúdo em inglês',
        'notÃ\u00adcias' => 'notícias',
        'seguranÃ§a' => 'segurança',
        'cibernÃ©tica' => 'cibernética',
        'matÃ©ria' => 'matéria'
    ];
    
    foreach ($replacements as $search => $replace) {
        $text = str_replace($search, $replace, $text);
    }
    
    return $text;
}

// Função para corrigir arquivos PHP
function fixPhpFile($filePath) {
    echo "Corrigindo arquivo: $filePath<br>";
    
    // Lê o conteúdo do arquivo
    $content = file_get_contents($filePath);
    
    if ($content === false) {
        echo "Erro ao ler o arquivo: $filePath<br>";
        return false;
    }
    
    // Corrige a codificação
    $fixedContent = fixEncoding($content);
    
    // Salva o arquivo corrigido
    $result = file_put_contents($filePath, $fixedContent);
    
    if ($result === false) {
        echo "Erro ao salvar o arquivo: $filePath<br>";
        return false;
    }
    
    echo "Arquivo corrigido com sucesso: $filePath<br>";
    return true;
}

// Lista de arquivos PHP para corrigir
$files = [
    __DIR__ . '/scraper.php',
    __DIR__ . '/index.php',
    __DIR__ . '/preload.php',
    __DIR__ . '/cache_updater.php'
];

// Corrige cada arquivo
foreach ($files as $file) {
    if (file_exists($file)) {
        fixPhpFile($file);
    } else {
        echo "Arquivo não encontrado: $file<br>";
    }
}

echo "<h2>Processo de correção de codificação concluído!</h2>";
echo "<p>Todos os arquivos foram verificados e corrigidos para UTF-8.</p>";
echo "<p><a href='index.php'>Voltar para a página principal</a></p>";
