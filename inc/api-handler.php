<?php
// inc/api-handler.php

if (isset($_GET['api']) && $_GET['api'] === 'data') {
    header('Content-Type: application/json');
    $data = [
        'crypto' => [
            'BTC' => '$45,000',
            'ETH' => '$3,000'
        ],
        'news' => 'Novidades de Cyber Security serão exibidas aqui.'
    ];
    echo json_encode($data);
    exit;
}
