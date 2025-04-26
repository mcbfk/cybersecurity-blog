<?php
/**
 * Script para atualizar o cache de notícias em segundo plano
 * Execute esse script via cron a cada hora para manter o cache fresco
 * 
 * Exemplo de configuração de cron:
 * 0 * * * * php /var/www/html/cybersecurity-blog/cache_updater.php > /dev/null 2>&1
 */

// Define tempo limite mais longo para permitir scraping completo
set_time_limit(300); // 5 minutos

// Função para limpar cache antigo (mais de 24 horas)
function cleanOldCache() {
    $cachePath = 'cache/';
    if (!is_dir($cachePath)) return;
    
    $now = time();
    $files = scandir($cachePath);
    
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        
        $filePath = $cachePath . $file;
        if (is_file($filePath)) {
            // Se o arquivo tem mais de 24 horas, deleta
            if ($now - filemtime($filePath) > 86400) {
                unlink($filePath);
                echo "Removido arquivo de cache antigo: $file\n";
            }
        }
    }
}

// Função para pré-carregar o cache de notícias
function precacheNews() {
    echo "Iniciando processo de pré-cache de notícias...\n";
    
    // Pré-cache para todas as combinações comuns
    $langs = ['all', 'pt', 'en'];
    $pages = [1, 2];
    
    foreach ($langs as $lang) {
        foreach ($pages as $page) {
            echo "Atualizando cache para idioma '$lang', página $page...\n";
            
            // Gera URL para requisição
            $url = "http://localhost/scraper.php?load_more=1&page=$page&items=16&lang=$lang&force_update=1";
            
            // Faz a requisição
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_USERAGENT, 'CacheBot/1.0');
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            curl_close($ch);
            
            if ($httpCode >= 200 && $httpCode < 300) {
                echo "Cache atualizado com sucesso!\n";
            } else {
                echo "Erro ao atualizar cache. HTTP Code: $httpCode\n";
            }
            
            // Pausa entre requisições para evitar sobrecarga
            sleep(5);
        }
    }
    
    echo "Processo de pré-cache concluído!\n";
}

// Limpar cache antigo primeiro
cleanOldCache();

// Remover flag de atualização necessária, se existir
if (file_exists('cache/update_needed.flag')) {
    unlink('cache/update_needed.flag');
    echo "Flag de atualização removida\n";
}

// Atualizar cache
precacheNews();

echo "Atualização de cache concluída em: " . date('Y-m-d H:i:s') . "\n"; 