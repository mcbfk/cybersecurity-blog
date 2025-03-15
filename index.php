<?php

require 'vendor/autoload.php'; // Certifique-se de que o caminho está correto

// Carregar variáveis do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Obter a chave da API a partir das variáveis de ambiente
$apiKey = $_ENV['NEWS_API_KEY'];

// Endpoint da News API para buscar notícias de cibersegurança
$url = "https://newsapi.org/v2/everything?q=cibersegurança&language=pt&apiKey={$apiKey}";

// Inicializar cURL
$ch = curl_init();

// Configurar opções do cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executar a requisição
$response = curl_exec($ch);

// Fechar a conexão cURL
curl_close($ch);

// Decodificar a resposta JSON
$newsData = json_decode($response, true);

// Verificar se a requisição foi bem-sucedida
if (isset($newsData['articles'])) {
    foreach ($newsData['articles'] as $article) {
        echo "<h2>{$article['title']}</h2>";
        echo "<p>{$article['description']}</p>";
        echo "<a href='{$article['url']}'>Leia mais</a><br>";
    }
} else {
    echo "Não foi possível obter notícias.";
}
