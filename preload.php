<?php
/**
 * Script para pré-carregar notícias quando o usuário visita o site
 * Este script deve ser incluído no topo do index.php
 */

// Verifica se o cache já está sendo atualizado por outro processo
if (file_exists('cache/updating.lock')) {
    $lockTime = filemtime('cache/updating.lock');
    // Se o lock tiver mais de 10 minutos, considera que o processo travou e remove
    if (time() - $lockTime > 600) {
        unlink('cache/updating.lock');
    } else {
        // Outra atualização está em andamento, não faz nada
        return;
    }
}

// Se o cache precisa ser atualizado e não há atualizações em andamento
if (file_exists('cache/update_needed.flag') && !file_exists('cache/updating.lock')) {
    // Verifica o momento da última atualização
    $lastUpdate = 0;
    if (file_exists('cache/last_update.txt')) {
        $lastUpdate = (int)file_get_contents('cache/last_update.txt');
    }
    
    // Se a última atualização foi há mais de 30 minutos, inicia uma nova
    if (time() - $lastUpdate > 1800) {
        // Cria um arquivo de lock para evitar atualizações simultâneas
        file_put_contents('cache/updating.lock', time());
        
        // Inicia a atualização em segundo plano
        $cmd = "php " . __DIR__ . "/cache_updater.php > /dev/null 2>&1 &";
        
        if (function_exists('exec')) {
            // Tenta usar exec para rodar em background
            @exec($cmd);
        } else if (function_exists('shell_exec')) {
            // Alternativa usando shell_exec
            @shell_exec($cmd);
        } else if (function_exists('popen')) {
            // Terceira opção usando popen
            $handle = @popen($cmd, 'r');
            if ($handle) {
                pclose($handle);
            }
        }
        
        // Registra o momento da última atualização
        file_put_contents('cache/last_update.txt', time());
        
        // Remove o lock - a atualização vai acontecer em segundo plano
        if (file_exists('cache/updating.lock')) {
            unlink('cache/updating.lock');
        }
    }
}

/**
 * Função para verificar e criar cache para as primeiras páginas
 * Isso garante que o usuário tenha uma experiência mais rápida
 */
function ensureInitialCache() {
    // Verifica e cria diretório de cache se não existir
    if (!is_dir('cache')) {
        mkdir('cache', 0777, true);
    }
    
    // Verificar se os caches iniciais existem
    $initialCaches = [
        'cache/news_cache_all_1.json',
        'cache/news_cache_pt_1.json',
        'cache/news_cache_en_1.json'
    ];
    
    $needsInitialCache = false;
    foreach ($initialCaches as $cache) {
        if (!file_exists($cache)) {
            $needsInitialCache = true;
            break;
        }
    }
    
    // Se algum cache inicial não existe, cria o arquivo de flag para atualização
    if ($needsInitialCache) {
        file_put_contents('cache/update_needed.flag', '1');
    }
}

// Verifica e cria caches iniciais se necessário
ensureInitialCache(); 