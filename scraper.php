<?php
// Suprimir erros se for uma requisição AJAX
if (isset($_GET['load_more'])) {
    error_reporting(0);
    ini_set('display_errors', 0);
}

/**
 * Scraper de notícias de cybersecurity
 */

/**
 * Obtem todas as notícias dos sites de segurança
 */
function getAllNews() {
    $sites = [
        [
            'name' => 'TecMundo',
            'url' => 'https://www.tecmundo.com.br/seguranca',
            'article_selector' => 'article',
            'title_selector' => 'h3, h2',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Canaltech',
            'url' => 'https://canaltech.com.br/seguranca/',
            'article_selector' => 'article',
            'title_selector' => 'h3, h2',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Tecnoblog',
            'url' => 'https://tecnoblog.net/categoria/seguranca/',
            'article_selector' => 'article',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'CNN Brasil',
            'url' => 'https://www.cnnbrasil.com.br/tudo-sobre/ciberseguranca/',
            'article_selector' => 'article',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Forbes Brasil',
            'url' => 'https://forbes.com.br/tag/ciberseguranca/',
            'article_selector' => 'article, .item',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'InfoMoney',
            'url' => 'https://www.infomoney.com.br/tema/ciberseguranca/',
            'article_selector' => 'article',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Bloomberg Línea',
            'url' => 'https://www.bloomberglinea.com.br/tag/ciberataques/',
            'article_selector' => 'article',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'CISO Advisor',
            'url' => 'https://ciso.com.br/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'BoletimSec',
            'url' => 'https://boletimsec.com.br/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3, .title',
            'image_selector' => 'img',
            'description_selector' => 'p, .excerpt',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Minuto da Segurança',
            'url' => 'https://minutodaseguranca.blog.br/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Gizmodo Brasil',
            'url' => 'https://gizmodo.uol.com.br/categoria/seguranca/',
            'article_selector' => 'article',
            'title_selector' => 'h3, h2',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'TechTudo',
            'url' => 'https://www.techtudo.com.br/tudo-sobre/seguranca-digital/',
            'article_selector' => 'article, .feed-post-body',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'CertiSign Blog',
            'url' => 'https://blog.certisign.com.br/category/seguranca-da-informacao/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3, .entry-title',
            'image_selector' => 'img',
            'description_selector' => 'p, .entry-summary',
            'link_selector' => 'a'
        ],
        [
            'name' => 'TI Inside',
            'url' => 'https://tiinside.com.br/categoria/seguranca/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'CanalTech Segurança',
            'url' => 'https://canaltech.com.br/seguranca/',
            'article_selector' => 'article, .ct-article',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'ComputerWorld Brasil',
            'url' => 'https://computerworld.com.br/categoria/seguranca/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Portal Defesa',
            'url' => 'https://www.defesa.tv.br/category/ciberseguranca/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Convergência Digital',
            'url' => 'https://www.convergenciadigital.com.br/Seguranca',
            'article_selector' => 'article, .view-content',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        // Sites internacionais
        [
            'name' => 'The Hacker News',
            'url' => 'https://thehackernews.com/',
            'article_selector' => 'article, .body-post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p, .home-desc',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Bleeping Computer',
            'url' => 'https://www.bleepingcomputer.com/',
            'article_selector' => 'article, .cat_bpost',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Krebs on Security',
            'url' => 'https://krebsonsecurity.com/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3, .entry-title',
            'image_selector' => 'img',
            'description_selector' => 'p, .entry-content',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Dark Reading',
            'url' => 'https://www.darkreading.com/',
            'article_selector' => 'article, .river-well',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'SecurityWeek',
            'url' => 'https://www.securityweek.com/',
            'article_selector' => 'article, .post',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ],
        [
            'name' => 'Threatpost',
            'url' => 'https://threatpost.com/',
            'article_selector' => 'article, .c-card',
            'title_selector' => 'h2, h3',
            'image_selector' => 'img',
            'description_selector' => 'p',
            'link_selector' => 'a'
        ]
    ];

    $allNews = [];

    foreach ($sites as $site) {
        $news = scrapeWebsite($site);
        
        // Adiciona a fonte a cada notícia para melhor rastreabilidade
        foreach ($news as &$item) {
            // Garante que o título é único adicionando a fonte
            if (!isset($item['original_title'])) {
                $item['original_title'] = $item['title'];
            }
            
            // Identifica se é site internacional (inglês) baseado no domínio
            $isEnglish = !preg_match('/(\.br|\.com\.br)/i', $site['url']);
            $item['language'] = $isEnglish ? 'en' : 'pt';
            
            // Se o título for muito curto ou genérico, adiciona o nome da fonte para diferenciar
            if (strlen($item['title']) < 25) {
                $item['title'] = $item['title'] . ' - ' . $item['source'];
            }
            
            // Para sites em inglês, adicionar indicação no título se não estiver em português
            if ($isEnglish) {
                $item['title'] = '[EN] ' . $item['title'];
            }
        }
        
        $allNews = array_merge($allNews, $news);
    }

    // Se não conseguiu notícias, cria algumas de exemplo
    if (count($allNews) == 0) {
        $allNews = getSampleNews();
    }
    
    // Remove notícias duplicadas
    $allNews = removeDuplicateNews($allNews);

    // Embaralha as notícias para ter uma mistura de fontes
    shuffle($allNews);

    return $allNews;
}

/**
 * Remove notícias duplicadas baseadas no título
 */
function removeDuplicateNews($news) {
    $uniqueNews = [];
    $titles = [];
    
    foreach ($news as $item) {
        // Normaliza o título para comparação (remove espaços extras, converte para minúsculas)
        $normalizedTitle = strtolower(trim(preg_replace('/\s+/', ' ', $item['title'])));
        
        // Se o título for muito curto, adiciona sempre para evitar falsos positivos
        if (strlen($normalizedTitle) < 15) {
            $uniqueNews[] = $item;
            $titles[] = $normalizedTitle;
            continue;
        }
        
        // Verifica se já existe notícia com título similar
        $isDuplicate = false;
        foreach ($titles as $existingTitle) {
            // Compara se os títulos são similares (mais de 65% de similaridade)
            $similarity = similar_text($normalizedTitle, $existingTitle) / max(strlen($normalizedTitle), strlen($existingTitle));
            if ($similarity > 0.65) {
                $isDuplicate = true;
                break;
            }
        }
        
        // Se não for duplicada, adiciona à lista de notícias únicas
        if (!$isDuplicate) {
            $uniqueNews[] = $item;
            $titles[] = $normalizedTitle;
        }
    }
    
    return $uniqueNews;
}

/**
 * Notícias de exemplo para caso o scraping falhe
 */
function getSampleNews() {
    return [
        [
            'title' => 'Nova vulnerabilidade descoberta em sistemas Windows',
            'image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Pesquisadores descobriram uma falha crítica que afeta milhões de dispositivos Windows em todo o mundo.',
            'url' => 'https://www.tecmundo.com.br/seguranca',
            'source' => 'TecMundo'
        ],
        [
            'title' => 'Ataque de ransomware paralisa empresa de grande porte',
            'image' => 'https://images.unsplash.com/photo-1566837945700-30057527ade0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Uma das maiores empresas do setor teve seus sistemas comprometidos por um sofisticado ataque de ransomware.',
            'url' => 'https://canaltech.com.br/seguranca/',
            'source' => 'Canaltech'
        ],
        [
            'title' => 'Dicas para proteger suas senhas online',
            'image' => 'https://images.unsplash.com/photo-1528901166007-3784c7dd3653?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Especialistas compartilham as melhores práticas para manter suas credenciais seguras no ambiente digital.',
            'url' => 'https://gizmodo.uol.com.br/categoria/seguranca/',
            'source' => 'Gizmodo Brasil'
        ],
        [
            'title' => 'Nova técnica de phishing atinge usuários bancários',
            'image' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Criminosos estão usando métodos avançados para enganar clientes de bancos e roubar dados financeiros.',
            'url' => 'https://www.tecmundo.com.br/seguranca',
            'source' => 'TecMundo'
        ],
        [
            'title' => 'Governo anuncia nova estratégia nacional de cibersegurança',
            'image' => 'https://images.unsplash.com/photo-1551808525-51a94da548ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Plano inclui investimentos bilionários para proteger infraestruturas críticas de ataques cibernéticos.',
            'url' => 'https://canaltech.com.br/seguranca/',
            'source' => 'Canaltech'
        ],
        [
            'title' => 'Como configurar autenticação de dois fatores',
            'image' => 'https://images.unsplash.com/photo-1569012871812-f38ee64cd54c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Guia passo a passo para ativar esta importante camada de segurança em suas contas mais importantes.',
            'url' => 'https://gizmodo.uol.com.br/categoria/seguranca/',
            'source' => 'Gizmodo Brasil'
        ],
        [
            'title' => 'Vazamento de dados expõe informações de milhões de usuários',
            'image' => 'https://images.unsplash.com/photo-1614064642553-f86c30fe08fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Empresa de e-commerce sofre violação massiva que compromete dados pessoais e financeiros.',
            'url' => 'https://www.tecmundo.com.br/seguranca',
            'source' => 'TecMundo'
        ],
        [
            'title' => 'Inteligência Artificial está revolucionando a cibersegurança',
            'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Novas soluções baseadas em IA detectam ameaças com mais eficiência e antecipam movimentos de hackers.',
            'url' => 'https://canaltech.com.br/seguranca/',
            'source' => 'Canaltech'
        ],
        [
            'title' => 'NFTs são o novo alvo de hackers: saiba como se proteger',
            'image' => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Colecionadores de tokens não fungíveis estão sendo vítimas de golpes sofisticados. Especialistas recomendam cautela.',
            'url' => 'https://tecnoblog.net/categoria/seguranca/',
            'source' => 'Tecnoblog'
        ],
        [
            'title' => 'Estudo revela aumento de 300% em ataques de dia zero',
            'image' => 'https://images.unsplash.com/photo-1504639725590-34d0984388bd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Vulnerabilidades desconhecidas estão sendo exploradas em ritmo alarmante, com empresas lutando para se proteger.',
            'url' => 'https://www.cnnbrasil.com.br/tudo-sobre/ciberseguranca/',
            'source' => 'CNN Brasil'
        ],
        [
            'title' => 'Empresas brasileiras investem recorde em segurança cibernética',
            'image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Companhias aumentam orçamentos de TI após série de ataques de alto perfil no país. LGPD acelera conscientização.',
            'url' => 'https://forbes.com.br/tag/ciberseguranca/',
            'source' => 'Forbes Brasil'
        ],
        [
            'title' => 'Mercado financeiro é o setor mais visado por cibercriminosos',
            'image' => 'https://images.unsplash.com/photo-1607962837359-5e7e89f86776?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Bancos e corretoras enfrentam ondas de ataques coordenados. Hackers buscam dados financeiros e credenciais para fraudes.',
            'url' => 'https://www.infomoney.com.br/tema/ciberseguranca/',
            'source' => 'InfoMoney'
        ],
        [
            'title' => 'Hackers russos atacam infraestrutura crítica de países europeus',
            'image' => 'https://images.unsplash.com/photo-1614064548237-096d7a4af960?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Grupo APT29, ligado a serviços de inteligência, tem como alvo sistemas energéticos e de distribuição de água.',
            'url' => 'https://www.bloomberglinea.com.br/tag/ciberataques/',
            'source' => 'Bloomberg Línea'
        ],
        [
            'title' => 'CISOs relatam burnout em meio a crescentes ameaças cibernéticas',
            'image' => 'https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Executivos de segurança enfrentam pressão intensa, longas jornadas e esforço constante para manter empresas seguras.',
            'url' => 'https://ciso.com.br/',
            'source' => 'CISO Advisor'
        ],
        [
            'title' => 'Novo padrão global para segurança em IoT é anunciado',
            'image' => 'https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Certificação promete reduzir vulnerabilidades em dispositivos conectados, agora alvos frequentes de ciberataques.',
            'url' => 'https://boletimsec.com.br/',
            'source' => 'BoletimSec'
        ],
        [
            'title' => '5 medidas essenciais para proteger pequenas empresas de ransomware',
            'image' => 'https://images.unsplash.com/photo-1535191042502-e6a9a3d407e7?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
            'description' => 'Especialistas recomendam backups regulares, atualizações de sistema e treinamento de funcionários para mitigar riscos.',
            'url' => 'https://minutodaseguranca.blog.br/',
            'source' => 'Minuto da Segurança'
        ]
    ];
}

/**
 * Faz o scraping de um site específico
 */
function scrapeWebsite($site) {
    $news = [];
    $html = getWebsiteContent($site['url']);
    
    if (!$html) {
        return $news;
    }

    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($dom);

    try {
        // Tenta diferentes estratégias para encontrar artigos
        try {
            // Usa apenas seletores simples e seguros
            if ($site['article_selector'] == 'article') {
                $articles = $xpath->query("//article");
            } else if (strpos($site['article_selector'], 'div') !== false) {
                $articles = $xpath->query("//div");
            } else {
                // Fallback para article ou div com classe de artigo
                $articles = $xpath->query("//article | //div[contains(@class, 'article')]");
            }
        } catch (Exception $e) {
            // Se o seletor for inválido, tenta algo mais genérico
            $articles = null;
        }
        
        if (!$articles || $articles->length == 0) {
            // Se não encontrou com o seletor específico, tenta algo mais genérico
            $articles = $xpath->query("//div[contains(@class, 'article') or contains(@class, 'post') or contains(@class, 'card') or contains(@class, 'news')]");
        }
        
        if (!$articles || $articles->length == 0) {
            return $news;
        }
        
        for ($i = 0; $i < min($articles->length, 5); $i++) {
            $article = $articles->item($i);
            
            // Busca título (tenta vários seletores)
            $title = null;
            foreach (explode(', ', $site['title_selector']) as $selector) {
                try {
                    // Usa apenas seletores simples e seguros
                    if ($selector == 'h2') {
                        $titles = $xpath->query(".//h2", $article);
                    } else if ($selector == 'h3') {
                        $titles = $xpath->query(".//h3", $article);
                    } else if ($selector == 'title') {
                        $titles = $xpath->query(".//title", $article);
                    } else {
                        // Para seletores complexos, usa h2 como fallback
                        $titles = $xpath->query(".//h2", $article);
                    }
                    
                    if ($titles && $titles->length > 0) {
                        $title = $titles->item(0);
                        break;
                    }
                } catch (Exception $e) {
                    // Se o seletor for inválido, continua para o próximo
                    continue;
                }
            }
            
            // Busca link principal do artigo
            $link = null;
            try {
                $linkElements = $xpath->query(".//a[contains(@class, 'title') or contains(@class, 'link')]", $article);
            } catch (Exception $e) {
                $linkElements = null;
            }
            if (!$linkElements || $linkElements->length == 0) {
                try {
                    $linkElements = $xpath->query(".//h2/a | .//h3/a", $article);
                } catch (Exception $e) {
                    $linkElements = null; 
                }
            }
            if (!$linkElements || $linkElements->length == 0) {
                try {
                    // Usa apenas seletores simples e seguros
                    if ($site['link_selector'] == 'a') {
                        $linkElements = $xpath->query(".//a", $article);
                    } else {
                        // Para qualquer outro seletor, usa 'a' como fallback
                        $linkElements = $xpath->query(".//a", $article);
                    }
                } catch (Exception $e) {
                    // Se falhar, tenta qualquer link
                    $linkElements = $xpath->query(".//a", $article);
                }
            }
            if ($linkElements && $linkElements->length > 0) {
                $link = $linkElements->item(0);
            }
            
            if (!$title || !$link) {
                continue;
            }
            
            $titleText = $title->textContent;
            $linkUrl = $link->getAttribute('href');
            
            // Verifica se a URL é relativa e adiciona o domínio
            if ($linkUrl && strpos($linkUrl, 'http') !== 0) {
                $parsedUrl = parse_url($site['url']);
                $domain = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                $linkUrl = $domain . ($linkUrl[0] == '/' ? '' : '/') . $linkUrl;
            }
            
            // Busca melhor imagem do artigo
            $imageUrl = '';
            
            // Tenta encontrar imagem destacada ou principal
            try {
                // Usa apenas seletores simples e seguros
                $imageElements = null;
                
                try {
                    if ($site['image_selector'] == 'img') {
                        $imageElements = $xpath->query(".//img", $article);
                    } else {
                        // Para seletores complexos, usa img como fallback
                        $imageElements = $xpath->query(".//img", $article);
                    }
                } catch (Exception $e) {
                    $imageElements = null;
                }
                
                if (!$imageElements || $imageElements->length == 0) {
                    // Tenta seletores específicos um por um para evitar erro de expressão
                    $imageElements = $xpath->query(".//img[@class='featured']", $article);
                }
                
                if (!$imageElements || $imageElements->length == 0) {
                    $imageElements = $xpath->query(".//img[@class='thumb']", $article);
                }
                
                if (!$imageElements || $imageElements->length == 0) {
                    $imageElements = $xpath->query(".//img[@class='post-image']", $article);
                }
                
                if (!$imageElements || $imageElements->length == 0) {
                    // Tenta simplesmente qualquer imagem no artigo
                    $imageElements = $xpath->query(".//img", $article);
                }
                
                // Se encontrou alguma imagem
                if ($imageElements && $imageElements->length > 0) {
                    $image = $imageElements->item(0);
                    // Verifica atributos possíveis para a URL da imagem
                    $imageUrl = $image->getAttribute('data-src');
                    if (empty($imageUrl)) {
                        $imageUrl = $image->getAttribute('data-lazy-src');
                    }
                    if (empty($imageUrl)) {
                        $imageUrl = $image->getAttribute('src');
                    }
                }
            } catch (Exception $e) {
                // Se falhar a busca por imagem, continua com imagem vazia
            }
            
            // Se ainda não encontrou, busca na página toda
            if (empty($imageUrl) && !empty($linkUrl)) {
                try {
                    // Tenta buscar link completo da notícia para pegar a imagem
                    $articleHtml = getWebsiteContent($linkUrl);
                    if ($articleHtml) {
                        $articleDom = new DOMDocument();
                        @$articleDom->loadHTML(mb_convert_encoding($articleHtml, 'HTML-ENTITIES', 'UTF-8'));
                        $articleXpath = new DOMXPath($articleDom);
                        
                        // Tenta buscar meta tags Open Graph para imagem
                        $metaImages = $articleXpath->query("//meta[@property='og:image']");
                        if ($metaImages && $metaImages->length > 0) {
                            $imageUrl = $metaImages->item(0)->getAttribute('content');
                        }
                        
                        // Se não encontrou, busca imagens grandes na página de forma mais segura
                        if (empty($imageUrl)) {
                            // Busca imagens de forma mais simples, um seletor por vez
                            $largeImages = $articleXpath->query("//img");
                            if ($largeImages && $largeImages->length > 0) {
                                // Pega a primeira imagem grande que encontrar
                                for ($j = 0; $j < min($largeImages->length, 5); $j++) {
                                    $imgWidth = $largeImages->item($j)->getAttribute('width');
                                    // Se a imagem tem largura definida e é maior que 300px, usa ela
                                    if (!empty($imgWidth) && intval($imgWidth) > 300) {
                                        $imageUrl = $largeImages->item($j)->getAttribute('src');
                                        if (empty($imageUrl)) {
                                            $imageUrl = $largeImages->item($j)->getAttribute('data-src');
                                        }
                                        if (!empty($imageUrl)) {
                                            break;
                                        }
                                    }
                                }
                                
                                // Se ainda não encontrou, usa a primeira imagem
                                if (empty($imageUrl)) {
                                    $imageUrl = $largeImages->item(0)->getAttribute('src');
                                    if (empty($imageUrl)) {
                                        $imageUrl = $largeImages->item(0)->getAttribute('data-src');
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    // Se falhar, continua com imagem vazia
                }
            }
            
            // Verifica se a URL da imagem é relativa e adiciona o domínio
            if ($imageUrl && strpos($imageUrl, 'http') !== 0) {
                $parsedUrl = parse_url($site['url']);
                $domain = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                $imageUrl = $domain . ($imageUrl[0] == '/' ? '' : '/') . $imageUrl;
            }
            
            // Se não encontrou imagem, coloca uma imagem padrão
            if (!$imageUrl) {
                $imageUrl = 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';
            }
            
            // Busca descrição
            $descriptionText = "";
            
            // Usa o título como base para a descrição
            if (!empty($titleText)) {
                // Se o título for curto, usa ele como está
                if (strlen($titleText) < 100) {
                    $descriptionText = "Saiba mais sobre: " . $titleText;
                } else {
                    // Se for longo, corta para evitar duplicação
                    $descriptionText = "Leia a matéria completa sobre " . substr($titleText, 0, 70) . "...";
                }
            } else {
                $descriptionText = "Confira esta notícia sobre segurança cibernética no site original.";
            }
            
            // Limpa o texto removendo espaços extras
            $titleText = trim(preg_replace('/\s+/', ' ', $titleText));
            
            // Limita a descrição a 150 caracteres
            if (strlen($descriptionText) > 150) {
                $descriptionText = substr($descriptionText, 0, 147) . '...';
            }
            
            // Verifica se é site internacional (em inglês) baseado no domínio
            $isEnglish = !preg_match('/(\.br|\.com\.br)/i', $site['url']);
            
            // Para sites em inglês, adiciona indicador no início da descrição
            if ($isEnglish) {
                $descriptionText = "[Conteúdo em inglês] " . $descriptionText;
            }
            
            $news[] = [
                'title' => $titleText,
                'image' => $imageUrl,
                'description' => $descriptionText,
                'url' => $linkUrl,
                'source' => $site['name'],
                'language' => $isEnglish ? 'en' : 'pt'
            ];
        }
    } catch (Exception $e) {
        // Em caso de erro, retorna array vazio
        return [];
    }

    return $news;
}

/**
 * Obtém o conteúdo HTML de um site usando cURL
 * Inclui sistema de cache para não sobrecarregar os sites
 */
function getWebsiteContent($url) {
    // Verifica se existe cache e se não está expirado (2 horas)
    $cacheFile = 'cache/' . md5($url) . '.html';
    $cacheTime = 7200; // 2 horas
    
    // Cria diretório de cache se não existir
    if (!file_exists('cache')) {
        mkdir('cache', 0777, true);
    }
    
    // Verifica se o cache existe e está válido
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
        return file_get_contents($cacheFile);
    }
    
    // Caso contrário, faz a requisição
    $ch = curl_init();
    
    // Configura o cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_ENCODING, ''); // Aceita codificação gzip
    
    // Adiciona um delay aleatório para não sobrecarregar os sites
    usleep(rand(500000, 1500000)); // 0.5 a 1.5 segundos
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        // Salva o resultado no cache
        file_put_contents($cacheFile, $html);
        return $html;
    }
    
    return false;
}

/**
 * Função para carregar mais notícias (usado pelo AJAX para scroll infinito)
 */
if (isset($_GET['load_more'])) {
    // Set headers for JSON response
    header('Content-Type: application/json');
    
    // Get current page and items per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = isset($_GET['items']) ? (int)$_GET['items'] : 12;
    
    // Obter filtro de idioma
    $languageFilter = isset($_GET['lang']) ? $_GET['lang'] : 'all';
    
    // Get all news
    $allNews = getAllNews();
    
    // Filtrar notícias por idioma se necessário
    if ($languageFilter !== 'all') {
        $filteredNews = [];
        foreach ($allNews as $item) {
            if (isset($item['language']) && $item['language'] === $languageFilter) {
                $filteredNews[] = $item;
            }
        }
        $allNews = $filteredNews;
    }
    
    // Calculate offset based on page
    $offset = ($page - 1) * $itemsPerPage;
    
    // Get news slice for current page
    $newsSlice = array_slice($allNews, $offset, $itemsPerPage);
    
    // Check if there are more news available
    $hasMore = (count($allNews) > ($offset + $itemsPerPage));
    
    // Return JSON response
    echo json_encode([
        'news' => $newsSlice,
        'hasMore' => $hasMore,
        'total' => count($allNews),
        'page' => $page,
        'filter' => $languageFilter,
        'message' => count($newsSlice) > 0 ? 'Notícias carregadas com sucesso' : 'Não há mais notícias para carregar'
    ]);
    
    exit;
}