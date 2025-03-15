<?php
// inc/news-updater.php

require 'vendor/autoload.php'; // Certifique-se de que o caminho está correto

// Carregar variáveis do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Retorna as últimas notícias de Cyber Security e TI utilizando a NewsAPI.
 *
 * @return string HTML formatado com a notícia mais recente ou mensagem de erro.
 */
function fetchLatestNews() {
    $apiKey = $_ENV['NEWS_API_KEY'];
    $url = "https://newsapi.org/v2/everything?q=cibersegurança&language=pt&apiKey={$apiKey}";
    
    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Executar a requisição
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Decodificar a resposta JSON
    $newsData = json_decode($response, true);
    
    // Verificar se a requisição foi bem-sucedida
    if (isset($newsData['articles'])) {
        $output = '';
        foreach ($newsData['articles'] as $article) {
            $output .= "<h2>{$article['title']}</h2>";
            $output .= "<p>{$article['description']}</p>";
            $output .= "<a href='{$article['url']}'>Leia mais</a><br>";
        }
        return $output;
    } else {
        return "Não foi possível obter notícias.";
    }
}
