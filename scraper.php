<?php
// Enable error reporting for debugging
if (isset($_GET['load_more'])) {
    // For debugging only - remove in production
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
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
 * Remove notícias duplicadas baseado no título e URL
 */
function removeDuplicateNews($news) {
    $uniqueNews = [];
    $usedTitles = [];
    $usedUrls = [];
    $usedDomains = [];
    
    // Para comparação de títulos
    $similarityThreshold = 0.75; // Aumentado de 0.7 para 0.75 para ser mais seletivo
    
    foreach ($news as $item) {
        // Normaliza o título para comparação
        $title = mb_strtolower(trim($item['title']));
        $title = preg_replace('/[\s\-_:;.,!?]+/', ' ', $title); // Remove pontuação e espaços extras
        $title = preg_replace('/\s+/', ' ', $title); // Normaliza múltiplos espaços
        $title = trim($title);
        
        // Ignora títulos muito curtos
        if (mb_strlen($title) < 10) {
            continue;
        }
        
        // Extrai domínio da URL para evitar muitas notícias do mesmo site
        $domain = '';
        if (!empty($item['url'])) {
            $parsed_url = parse_url($item['url']);
            if (isset($parsed_url['host'])) {
                $domain = $parsed_url['host'];
                // Remove www. se presente
                $domain = preg_replace('/^www\./', '', $domain);
            }
        }
        
        // Verifica se URL é exatamente igual a alguma já usada
        if (!empty($item['url']) && in_array($item['url'], $usedUrls)) {
            continue;
        }
        
        // Verifica se URL contém fragmento de paginação (#page=2, etc)
        if (!empty($item['url']) && preg_match('/#(page|pagina|p)=\d+/i', $item['url'])) {
            // Verifica se já temos uma URL similar sem o fragmento
            $baseUrl = preg_replace('/#.*$/', '', $item['url']);
            if (in_array($baseUrl, $usedUrls)) {
                continue;
            }
        }
        
        // Limita número de notícias do mesmo domínio (máximo 3 por domínio)
        if (!empty($domain)) {
            if (isset($usedDomains[$domain]) && $usedDomains[$domain] >= 3) {
                continue;
            }
        }
        
        // Verifica similaridade com títulos existentes
        $isDuplicate = false;
        foreach ($usedTitles as $existingTitle) {
            if (empty($title) || empty($existingTitle)) {
                continue;
            }
            
            // Similar_text dá uma porcentagem de similaridade
            similar_text($title, $existingTitle, $percent);
            
            // Se a similaridade for alta, considera duplicata
            if ($percent > $similarityThreshold * 100) {
                $isDuplicate = true;
                break;
            }
            
            // Verifica se um título está contido no outro (caso de subtítulos)
            if (mb_strlen($title) > 20 && mb_strlen($existingTitle) > 20) {
                if (strpos($title, $existingTitle) !== false || strpos($existingTitle, $title) !== false) {
                    $isDuplicate = true;
                    break;
                }
            }
        }
        
        if (!$isDuplicate) {
            $uniqueNews[] = $item;
            $usedTitles[] = $title;
            
            if (!empty($item['url'])) {
                $usedUrls[] = $item['url'];
                // Também armazena URL sem fragmento
                $usedUrls[] = preg_replace('/#.*$/', '', $item['url']);
            }
            
            // Incrementa contador de domínio
            if (!empty($domain)) {
                if (!isset($usedDomains[$domain])) {
                    $usedDomains[$domain] = 1;
                } else {
                    $usedDomains[$domain]++;
                }
            }
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
 * Função para resolver URLs relativos para absolutos
 */
function resolveRelativeUrlBase($baseUrl, $relativeUrl) {
    // Se o URL já for absoluto, retorna ele mesmo
    if (filter_var($relativeUrl, FILTER_VALIDATE_URL)) {
        return $relativeUrl;
    }
    
    // Se o URL relativo começar com //, é um URL protocolo-relativo
    if (substr($relativeUrl, 0, 2) === '//') {
        // Extrai o protocolo do URL base e o usa
        $parsedBase = parse_url($baseUrl);
        $protocol = isset($parsedBase['scheme']) ? $parsedBase['scheme'] : 'https';
        return $protocol . ':' . $relativeUrl;
    }
    
    // Se o URL relativo começar com /, é relativo à raiz do domínio
    if (substr($relativeUrl, 0, 1) === '/') {
        $parsedBase = parse_url($baseUrl);
        $baseRoot = $parsedBase['scheme'] . '://' . $parsedBase['host'];
        return $baseRoot . $relativeUrl;
    }
    
    // Para outros URLs relativos, resolve em relação ao URL base
    $basePathParts = explode('/', rtrim(dirname($baseUrl), '/'));
    $relativePathParts = explode('/', $relativeUrl);
    
    foreach ($relativePathParts as $part) {
        if ($part === '..') {
            array_pop($basePathParts);
        } elseif ($part !== '.') {
            $basePathParts[] = $part;
        }
    }
    
    return implode('/', $basePathParts);
}

/**
 * Extrai uma URL válida de imagem a partir de elementos HTML
 * Versão melhorada para priorizar imagens reais dos artigos
 */
function extractValidImageUrl($element, $baseUrl) {
    // Fallback para quando o elemento não é encontrado
    if (empty($element)) {
        return '';
    }
    
    // Lista de possíveis atributos que podem conter URLs de imagem
    $imgAttributes = ['src', 'data-src', 'data-lazy-src', 'data-original', 'data-srcset', 'srcset', 
                     'data-original-src', 'data-lazy-loaded', 'data-img-url', 'data-full-src', 
                     'data-large-file', 'data-medium-file', 'loading-src', 'data-hi-res-src'];
    
    // Tenta encontrar tag <img> com classes comuns de imagens principais
    $mainImageClasses = ['featured-image', 'main-image', 'post-image', 'article-image', 'entry-image', 
                        'thumbnail', 'wp-post-image', 'attachment-large', 'hero-image'];
    $imgTags = $element->getElementsByTagName('img');
    
    // Primeiro tenta imagens com classes específicas de imagens principais
    foreach ($imgTags as $img) {
        if ($img->hasAttribute('class')) {
            $class = $img->getAttribute('class');
            foreach ($mainImageClasses as $mainClass) {
                if (strpos($class, $mainClass) !== false) {
                    foreach ($imgAttributes as $attr) {
                        if ($img->hasAttribute($attr)) {
                            $imgUrl = $img->getAttribute($attr);
                            
                            // Se for um conjunto de srcset, pega a maior imagem
                            if ($attr == 'srcset' || $attr == 'data-srcset') {
                                $imgUrl = extractLargestFromSrcset($imgUrl);
                            }
                            
                            // Resolve URL relativa para absoluta
                            $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
                            
                            // Verifica se é uma URL válida e se é uma imagem
                            if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                                return $imgUrl;
                            }
                        }
                    }
                }
            }
        }
    }
    
    // Depois tenta qualquer imagem, priorizando as maiores
    $bestImageUrl = '';
    $largestArea = 0;
    
    foreach ($imgTags as $img) {
        foreach ($imgAttributes as $attr) {
            if ($img->hasAttribute($attr)) {
                $imgUrl = $img->getAttribute($attr);
                
                // Se for um conjunto de srcset, pega a maior imagem
                if ($attr == 'srcset' || $attr == 'data-srcset') {
                    $imgUrl = extractLargestFromSrcset($imgUrl);
                }
                
                // Resolve URL relativa para absoluta
                $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
                
                // Verifica se é uma URL válida e se é uma imagem de tamanho adequado
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    // Tenta obter as dimensões da imagem dos atributos
                    $width = $img->hasAttribute('width') ? intval($img->getAttribute('width')) : 0;
                    $height = $img->hasAttribute('height') ? intval($img->getAttribute('height')) : 0;
                    
                    // Se as dimensões estão disponíveis, calcula a área
                    if ($width > 0 && $height > 0) {
                        $area = $width * $height;
                        if ($area > $largestArea) {
                            $largestArea = $area;
                            $bestImageUrl = $imgUrl;
                        }
                    } 
                    // Se não temos as dimensões, mas ainda não encontramos nenhuma imagem
                    else if (empty($bestImageUrl)) {
                        $bestImageUrl = $imgUrl;
                    }
                }
            }
        }
    }
    
    // Se encontramos uma imagem boa, retorna ela
    if (!empty($bestImageUrl)) {
        return $bestImageUrl;
    }
    
    // Tenta encontrar tag <meta property="og:image">
    $metas = $element->ownerDocument->getElementsByTagName('meta');
    foreach ($metas as $meta) {
        if (($meta->hasAttribute('property') && $meta->getAttribute('property') == 'og:image') || 
            ($meta->hasAttribute('name') && $meta->getAttribute('name') == 'twitter:image')) {
            if ($meta->hasAttribute('content')) {
                $imgUrl = $meta->getAttribute('content');
                $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
                
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    return $imgUrl;
                }
            }
        }
    }
    
    // Tenta encontrar tag <source> (comum em <picture>)
    $sourceTags = $element->getElementsByTagName('source');
    foreach ($sourceTags as $source) {
        foreach ($imgAttributes as $attr) {
            if ($source->hasAttribute($attr)) {
                $imgUrl = $source->getAttribute($attr);
                
                // Se for um conjunto de srcset, pega a maior imagem
                if ($attr == 'srcset' || $attr == 'data-srcset') {
                    $imgUrl = extractLargestFromSrcset($imgUrl);
                }
                
                // Resolve URL relativa para absoluta
                $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
                
                // Verifica se é uma URL válida e se é uma imagem
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    return $imgUrl;
                }
            }
        }
    }
    
    // Tenta encontrar imagens em background CSS
    $divs = $element->getElementsByTagName('div');
    foreach ($divs as $div) {
        if ($div->hasAttribute('style')) {
            $style = $div->getAttribute('style');
            if (preg_match('/background(-image)?\s*:\s*url\([\'"]?([^\'"]*)[\'"]?\)/i', $style, $matches)) {
                $imgUrl = $matches[2];
                
                // Resolve URL relativa para absoluta
                $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
                
                // Verifica se é uma URL válida e se é uma imagem
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    return $imgUrl;
                }
            }
        }
    }
    
    // Tenta encontrar uma tag <a> com uma imagem (caso o artigo seja apenas um link)
    $links = $element->getElementsByTagName('a');
    foreach ($links as $link) {
        if ($link->hasAttribute('href') && preg_match('/\.(jpe?g|png|gif|webp)$/i', $link->getAttribute('href'))) {
            $imgUrl = $link->getAttribute('href');
            
            // Resolve URL relativa para absoluta
            $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
            
            // Verifica se é uma URL válida e se é uma imagem
            if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                return $imgUrl;
            }
        }
    }
    
    // Última tentativa - procura qualquer elemento com background-image
    $allElements = $element->getElementsByTagName('*');
    foreach ($allElements as $el) {
        if ($el->hasAttribute('style')) {
            $style = $el->getAttribute('style');
            if (preg_match('/background(-image)?\s*:\s*url\([\'"]?([^\'"]*)[\'"]?\)/i', $style, $matches)) {
                $imgUrl = $matches[2];
                
                // Resolve URL relativa para absoluta
                $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
                
                // Verifica se é uma URL válida e se é uma imagem
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    return $imgUrl;
                }
            }
        }
    }
    
    // Tenta puxar qualquer imagem do documento inteiro como último recurso
    $docImgTags = $element->ownerDocument->getElementsByTagName('img');
    foreach ($docImgTags as $img) {
        if ($img->hasAttribute('src')) {
            $imgUrl = $img->getAttribute('src');
            $imgUrl = resolveRelativeUrlBase($baseUrl, $imgUrl);
            
            if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                return $imgUrl;
            }
        }
    }
    
    // Nenhuma imagem encontrada
    return '';
}

/**
 * Extrai a maior imagem de um conjunto srcset
 */
function extractLargestFromSrcset($srcset) {
    $srcsetParts = explode(',', $srcset);
    $largestSize = 0;
    $largestUrl = '';
    
    foreach ($srcsetParts as $part) {
        $part = trim($part);
        if (preg_match('/^(.+)\s+(\d+)w$/i', $part, $matches)) {
            $url = trim($matches[1]);
            $size = intval($matches[2]);
            
            if ($size > $largestSize) {
                $largestSize = $size;
                $largestUrl = $url;
            }
        } else if (empty($largestUrl)) {
            // Se não tem tamanho definido, pega a primeira URL
            $largestUrl = preg_replace('/\s+\d+[wx].*$/', '', $part);
        }
    }
    
    return !empty($largestUrl) ? $largestUrl : $srcset;
}

/**
 * Verifica se é uma imagem pequena ou ícone
 */
function isSmallOrIconImage($url) {
    // Verifica se a URL contém indicações de que é um ícone
    if (preg_match('/icon|logo|avatar|favicon|thumb(\-|\.|_)?(small|tiny|min)|badge|button|banner|social|widget|gravatar|20x20|24x24|32x32|48x48|64x64/i', $url)) {
        return true;
    }
    
    // Verifica se tem dimensão no nome e se é pequena
    if (preg_match('/(\-|\.|_)(\d+x\d+|w\d+|h\d+|size\d+)/i', $url)) {
        if (preg_match('/(\-|\.|_)(\d+)x(\d+)/i', $url, $matches)) {
            $width = intval($matches[2]);
            $height = intval($matches[3]);
            // Imagens menores que 300px são consideradas pequenas
            if ($width < 300 || $height < 300) {
                return true;
            }
        }
    }
    
    return false;
}

/**
 * Verifica se uma URL é uma imagem válida
 */
function isValidImageUrl($url) {
    // Remove whitespace e verifica se é vazia
    $url = trim($url);
    if (empty($url)) {
        return false;
    }
    
    // Verifica se a URL tem extensão de imagem comum
    if (preg_match('/\.(jpe?g|png|gif|webp|svg|avif)(\?.*)?$/i', $url)) {
        return true;
    }
    
    // Verifica se não é um ícone ou outra imagem pequena
    if (preg_match('/icon|logo|avatar|favicon|thumb(\-|\.|_)?(small|tiny|min)/i', $url)) {
        return false;
    }
    
    // Verifica tamanho dos arquivos se tiver dimensão no nome do arquivo (comum em CDNs)
    if (preg_match('/(\-|\.|_)(\d+x\d+|w\d+|h\d+|size\d+)/i', $url)) {
        if (preg_match('/(\-|\.|_)(\d+x\d+)/i', $url, $matches)) {
            $dimensions = explode('x', strtolower($matches[2]));
            if (count($dimensions) == 2) {
                // Se a imagem for muito pequena (menos de 300px em qualquer dimensão), provavelmente não é uma imagem principal
                if (intval($dimensions[0]) < 300 || intval($dimensions[1]) < 300) {
                    return false;
                }
            }
        }
    }
    
    // Aceita URLs de CDNs de imagens conhecidas
    $knownImageCDNs = [
        'img.', 'image.', 'images.', 'media.', 'cdn.', 'assets.',
        'wp-content/uploads', 'uploads', 'photos', 'pictures'
    ];
    
    foreach ($knownImageCDNs as $cdn) {
        if (stripos($url, $cdn) !== false) {
            return true;
        }
    }
    
    // Se chegou até aqui, tenta verificar através do Content-Type
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        
        if ($response !== false) {
            $contentType = '';
            
            // Extrai Content-Type do header
            if (preg_match('/Content-Type: (image\/[^\s;]+)/i', $response, $matches)) {
                $contentType = $matches[1];
            }
            
            curl_close($ch);
            
            if (!empty($contentType) && strpos($contentType, 'image/') === 0) {
                return true;
            }
        } else {
            curl_close($ch);
        }
    }
    
    return false;
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

    // Use libxml_use_internal_errors to suppress warnings during HTML parsing
    libxml_use_internal_errors(true);

    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($dom);
    
    // Clear libxml errors
    libxml_clear_errors();

    try {
        // Tenta diferentes estratégias para encontrar artigos
        $articles = null;
        
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
                $linkUrl = resolveRelativeUrlBase($site['url'], $linkUrl);
            }
            
            // Obtém a imagem, primeiro tentando no artigo e depois no conteúdo da página linkada
            $imageUrl = '';
            
            // 1. Primeiro tenta extrair do elemento do artigo na lista
            if (!empty($site['image_selector'])) {
                try {
                    $imageNode = $xpath->query($site['image_selector'], $article)->item(0);
                    if ($imageNode) {
                        $imageUrl = extractValidImageUrl($imageNode, $site['url']);
                    }
                } catch (Exception $e) {
                    // Se falhar, tenta encontrar qualquer imagem
                    $imageUrl = '';
                }
            }
            
            // 2. Se não encontrou imagem, procura em padrões comuns dentro do artigo
            if (empty($imageUrl)) {
                // Tenta encontrar imagens dentro do artigo
                $imgTags = $xpath->query('.//img', $article);
                if ($imgTags->length > 0) {
                    foreach ($imgTags as $img) {
                        $potentialUrl = extractValidImageUrl($img, $site['url']);
                        if (!empty($potentialUrl) && 
                            strpos($potentialUrl, 'data:image') !== 0 && 
                            !isSmallOrIconImage($potentialUrl)) {
                            $imageUrl = $potentialUrl;
                            break;
                        }
                    }
                }
                
                // Tenta encontrar elementos de imagem de fundo
                    if (empty($imageUrl)) {
                    $divsWithBg = $xpath->query('.//*[@style[contains(., "background")]]', $article);
                    if ($divsWithBg->length > 0) {
                        foreach ($divsWithBg as $div) {
                            $potentialUrl = extractValidImageUrl($div, $site['url']);
                            if (!empty($potentialUrl) && strpos($potentialUrl, 'data:image') !== 0) {
                                $imageUrl = $potentialUrl;
                                break;
                            }
                        }
                    }
                }
            }
            
            // 3. Se ainda não encontramos uma imagem e temos o URL do artigo, tenta buscar diretamente no artigo
            if (empty($imageUrl) && !empty($linkUrl)) {
                // Tentativa de carregar o artigo completo para encontrar a imagem
                    $articleHtml = getWebsiteContent($linkUrl);
                    if ($articleHtml) {
                        $articleDom = new DOMDocument();
                        @$articleDom->loadHTML(mb_convert_encoding($articleHtml, 'HTML-ENTITIES', 'UTF-8'));
                    
                    // Prioriza meta tags de OpenGraph
                    $metas = $articleDom->getElementsByTagName('meta');
                    foreach ($metas as $meta) {
                        if (($meta->hasAttribute('property') && $meta->getAttribute('property') == 'og:image') || 
                            ($meta->hasAttribute('name') && $meta->getAttribute('name') == 'twitter:image')) {
                            if ($meta->hasAttribute('content')) {
                                $imgUrl = $meta->getAttribute('content');
                                $imgUrl = resolveRelativeUrlBase($linkUrl, $imgUrl);
                                
                                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                                    $imageUrl = $imgUrl;
                                            break;
                                }
                                        }
                                    }
                                }
                                
                    // Se ainda não encontrou, procura a maior imagem no artigo
                                if (empty($imageUrl)) {
                        $articleImg = extractValidImageUrl($articleDom, $linkUrl);
                        if (!empty($articleImg)) {
                            $imageUrl = $articleImg;
                        }
                    }
                }
            }
            
            // Se mesmo após todas as tentativas não encontramos uma imagem válida,
            // deixamos vazio em vez de usar uma imagem padrão
            
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
    // Verifica se existe cache e se não está expirado (estendido para 6 horas)
    $cacheFile = 'cache/' . md5($url) . '.html';
    $cacheTime = 21600; // 6 horas (aumentado de 2 para 6 horas)
    
    // Cria diretório de cache se não existir
    if (!file_exists('cache')) {
        mkdir('cache', 0777, true);
    }
    
    // Verifica se o cache existe e está válido
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
        return file_get_contents($cacheFile);
    }
    
    // Para requisições AJAX, priorize a velocidade e use cache mesmo se expirado
    if (isset($_GET['load_more']) && file_exists($cacheFile)) {
        // Atualiza a data do arquivo para estender sua vida útil
        touch($cacheFile);
        // Agenda uma atualização assíncrona para depois
        touch('cache/update_needed.flag');
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Reduzido de 10 para 5 segundos
    curl_setopt($ch, CURLOPT_ENCODING, ''); // Aceita codificação gzip
    
    // Adiciona um delay reduzido para não sobrecarregar os sites
    usleep(rand(100000, 300000)); // 0.1 a 0.3 segundos (reduzido de 0.5-1.5s)
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300 && !empty($html)) {
        // Salva o resultado no cache
        file_put_contents($cacheFile, $html);
        return $html;
    } else if (file_exists($cacheFile)) {
        // Se a requisição falhou mas existe cache, usa o cache mesmo que expirado
        return file_get_contents($cacheFile);
    }
    
    return false;
}

// Adicionar API endpoint para carregar mais notícias
if (isset($_GET['load_more'])) {
    // Definir tempos limite de execução mais generosos para scraping inicial
    set_time_limit(60); // 60 segundos para executar
    
    // Usar cache de notícias para carregamento mais rápido
    $cacheFile = 'cache/news_cache_' . $_GET['lang'] . '_' . $_GET['page'] . '.json';
    $cacheTime = 3600; // 1 hora
    
    // Verifica se o cache existe e está válido
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
        // Retorna diretamente do cache
    header('Content-Type: application/json');
        header('X-Cache: HIT');
        echo file_get_contents($cacheFile);
        exit;
    }
    
    // Determinar página e número de itens
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $itemsPerPage = isset($_GET['items']) ? intval($_GET['items']) : 16;
    $lang = isset($_GET['lang']) ? $_GET['lang'] : 'all';
    
    // Validar parâmetros
    if ($page < 1) $page = 1;
    if ($itemsPerPage < 1 || $itemsPerPage > 50) $itemsPerPage = 16;
    
    // Obter todas as notícias (talvez precisemos limitar isso no futuro para performance)
    $allNewsFromScrapers = getAllNews();
    
    // Filtrar por idioma se necessário
    $filteredNews = $allNewsFromScrapers;
    if ($lang !== 'all') {
        $filteredNews = array_filter($allNewsFromScrapers, function($news) use ($lang) {
            return isset($news['language']) && $news['language'] === $lang;
        });
        
        // Reordenar os índices
        $filteredNews = array_values($filteredNews);
    }
    
    // Calcular índices para paginação
    $totalItems = count($filteredNews);
    $offset = ($page - 1) * $itemsPerPage;
    
    // Verificar se ainda há mais itens após esta página
    $hasMore = ($offset + $itemsPerPage) < $totalItems;
    
    // Obter os itens para esta página
    $newsItems = array_slice($filteredNews, $offset, $itemsPerPage);
    
    // Garantir que os índices comecem em 0
    $newsItems = array_values($newsItems);
    
    // Preparar resposta
    $response = [
        'news' => $newsItems,
        'hasMore' => $hasMore,
        'currentPage' => $page,
        'totalPages' => ceil($totalItems / $itemsPerPage),
        'totalItems' => $totalItems,
        'itemsPerPage' => $itemsPerPage,
        'remaining' => max(0, $totalItems - ($offset + $itemsPerPage)),
        'lang' => $lang,
        'cached' => false,
        'timestamp' => time()
    ];
    
    // Salvar em cache para futuras requisições
    file_put_contents($cacheFile, json_encode($response));
    
    // Retornar como JSON
    header('Content-Type: application/json');
    header('X-Cache: MISS');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    echo json_encode($response);
    exit;
}