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

// Cache global para URLs de imagens fallback - evitar gerar muitas imagens Ãºnicas
$GLOBALS['image_fallback_cache'] = [];

/**
 * Scraper de notÃ­cias de cybersecurity
 */

/**
 * Obtem todas as notÃ­cias dos sites de seguranÃ§a
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
            'name' => 'Bloomberg LÃ­nea',
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
            'name' => 'Minuto da SeguranÃ§a',
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
            'name' => 'CanalTech SeguranÃ§a',
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
            'name' => 'ConvergÃªncia Digital',
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
        
        // Adiciona a fonte a cada notÃ­cia para melhor rastreabilidade
        foreach ($news as &$item) {
            // Garante que o tÃ­tulo Ã© Ãºnico adicionando a fonte
            if (!isset($item['original_title'])) {
                $item['original_title'] = $item['title'];
            }
            
            // Identifica se Ã© site internacional (inglÃªs) baseado no domÃ­nio
            $isEnglish = !preg_match('/(\.br|\.com\.br)/i', $site['url']);
            $item['language'] = $isEnglish ? 'en' : 'pt';
            
            // Se o tÃ­tulo for muito curto ou genÃ©rico, adiciona o nome da fonte para diferenciar
            if (strlen($item['title']) < 25) {
                $item['title'] = $item['title'] . ' - ' . $item['source'];
            }
            
            // Para sites em inglÃªs, adicionar indicaÃ§Ã£o no tÃ­tulo se nÃ£o estiver em portuguÃªs
            if ($isEnglish) {
                $item['title'] = '[EN] ' . $item['title'];
            }
        }
        
        $allNews = array_merge($allNews, $news);
    }

    // Remove notÃ­cias duplicadas
    $allNews = removeDuplicateNews($allNews);

    // Embaralha as notÃ­cias para ter uma mistura de fontes
    shuffle($allNews);

    // Filtrar notÃ­cias para remover aquelas sem imagens vÃ¡lidas
    $allNews = array_filter($allNews, function($item) {
        // Remove notÃ­cias com URLs de imagem invÃ¡lidas
        if (!isset($item['image']) || empty($item['image'])) {
            return false;
        }
        
        $image = $item['image'];
        
        // Lista de padrÃµes para imagens invÃ¡lidas
        $invalidPatterns = [
            '@', 'unsplash.com', 'placeholder', 'default', 
            'logo-', 'logo.', 'missing-', '-ico.', 'icon.',
            'favicon', 'no-image', 'newsletter', 'banner',
            'author', 'profile', 'avatar', 'anonymous',
            'thumb-', '-thumb', 'button', '.svg', 'pixel.gif',
            'spacer', '1x1', 'blank', 'transparent'
        ];
        
        // Verificar por padrÃµes invÃ¡lidos
        foreach ($invalidPatterns as $pattern) {
            if (stripos($image, $pattern) !== false) {
                return false;
            }
        }
        
        // Verificar se a URL contÃ©m extensÃ£o de imagem
        $validExtensions = ['.jpg', '.jpeg', '.png', '.webp', '.gif'];
        $hasValidExtension = false;
        
        foreach ($validExtensions as $ext) {
            if (stripos($image, $ext) !== false) {
                $hasValidExtension = true;
                break;
            }
        }
        
        // Se nÃ£o tem extensÃ£o vÃ¡lida, verifica se a URL termina com algum parÃ¢metro de imagem
        if (!$hasValidExtension && !preg_match('/(image|foto|picture|img)/i', $image)) {
            return false;
        }
        
        // Verificar se a URL Ã© absoluta (deve comeÃ§ar com http ou https)
        if (!preg_match('/^https?:\/\//i', $image)) {
            return false;
        }
        
        return true;
    });
    
    // Reindexar o array
    $allNews = array_values($allNews);

    return $allNews;
}

/**
 * Remove notÃ­cias duplicadas baseado no tÃ­tulo e URL
 */
function removeDuplicateNews($news) {
    $uniqueNews = [];
    $usedTitles = [];
    $usedUrls = [];
    $usedDomains = [];
    
    // Para comparaÃ§Ã£o de tÃ­tulos - aumentando o threshold para ser mais restritivo
    $similarityThreshold = 0.85; // Aumentado para 85% para ser mais rigoroso
    
    foreach ($news as $item) {
        // Ignorar itens sem tÃ­tulo, URL ou imagem
        if (empty($item['title']) || empty($item['url']) || empty($item['image'])) {
            continue;
        }
        
        // Normaliza o tÃ­tulo para comparaÃ§Ã£o
        $title = mb_strtolower(trim($item['title']));
        $title = preg_replace('/[\s\-_:;.,!?]+/', ' ', $title); // Remove pontuaÃ§Ã£o e espaÃ§os extras
        $title = preg_replace('/\s+/', ' ', $title); // Normaliza mÃºltiplos espaÃ§os
        $title = trim($title);
        
        // Ignora tÃ­tulos muito curtos ou genÃ©ricos
        if (mb_strlen($title) < 10) {
            continue;
        }
        
        // Extrai domÃ­nio da URL para evitar muitas notÃ­cias do mesmo site
        $domain = '';
        if (!empty($item['url'])) {
            $parsed_url = parse_url($item['url']);
            if (isset($parsed_url['host'])) {
                $domain = $parsed_url['host'];
                // Remove www. se presente
                $domain = preg_replace('/^www\./', '', $domain);
            }
        }
        
        // Verifica se URL Ã© exatamente igual a alguma jÃ¡ usada
        if (!empty($item['url']) && in_array($item['url'], $usedUrls)) {
            continue;
        }
        
        // Verifica se URL contÃ©m fragmento de paginaÃ§Ã£o (#page=2, etc)
        if (!empty($item['url']) && preg_match('/#(page|pagina|p)=\d+/i', $item['url'])) {
            // Verifica se jÃ¡ temos uma URL similar sem o fragmento
            $baseUrl = preg_replace('/#.*$/', '', $item['url']);
            if (in_array($baseUrl, $usedUrls)) {
                continue;
            }
        }
        
        // Limita nÃºmero de notÃ­cias do mesmo domÃ­nio (mÃ¡ximo 2 por domÃ­nio)
        if (!empty($domain)) {
            if (isset($usedDomains[$domain]) && $usedDomains[$domain] >= 2) {
                continue;
            }
        }
        
        // Verifica similaridade com tÃ­tulos existentes
        $isDuplicate = false;
        foreach ($usedTitles as $existingTitle) {
            if (empty($title) || empty($existingTitle)) {
                continue;
            }
            
            // Procura por "Tags" no inÃ­cio - ex: [EN], [NotÃ­cia], etc
            $cleanTitle = preg_replace('/^\[[^\]]+\]\s*/', '', $title);
            $cleanExistingTitle = preg_replace('/^\[[^\]]+\]\s*/', '', $existingTitle);
            
            // Se os tÃ­tulos "limpos" forem exatamente iguais (ignorando tags)
            if ($cleanTitle === $cleanExistingTitle) {
                $isDuplicate = true;
                break;
            }
            
            // Similar_text dÃ¡ uma porcentagem de similaridade
            similar_text($title, $existingTitle, $percent);
            
            // Se a similaridade for alta, considera duplicata
            if ($percent > $similarityThreshold * 100) {
                $isDuplicate = true;
                break;
            }
            
            // Verifica se um tÃ­tulo estÃ¡ contido no outro (caso de subtÃ­tulos)
            if (mb_strlen($title) > 20 && mb_strlen($existingTitle) > 20) {
                if (strpos($title, $existingTitle) !== false || strpos($existingTitle, $title) !== false) {
                    $isDuplicate = true;
                    break;
                }
            }
            
            // Verifica palavras-chave especÃ­ficas de duplicaÃ§Ã£o
            $titleWords = explode(' ', $title);
            $existingWords = explode(' ', $existingTitle);
            
            // Se ambos os tÃ­tulos tÃªm mais de 4 palavras e compartilham pelo menos 70% das palavras
            if (count($titleWords) > 4 && count($existingWords) > 4) {
                $commonWords = array_intersect($titleWords, $existingWords);
                $commonPercent = count($commonWords) / min(count($titleWords), count($existingWords));
                
                if ($commonPercent > 0.7) {
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
                // TambÃ©m armazena URL sem fragmento
                $usedUrls[] = preg_replace('/#.*$/', '', $item['url']);
            }
            
            // Incrementa contador de domÃ­nio
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
 * FunÃ§Ã£o para resolver URLs relativos para absolutos
 */
function resolveRelativeUrlBase($baseUrl, $relativeUrl) {
    // Se o URL jÃ¡ for absoluto, retorna ele mesmo
    if (filter_var($relativeUrl, FILTER_VALIDATE_URL)) {
        return $relativeUrl;
    }
    
    // Se o URL relativo comeÃ§ar com //, Ã© um URL protocolo-relativo
    if (substr($relativeUrl, 0, 2) === '//') {
        // Extrai o protocolo do URL base e o usa
        $parsedBase = parse_url($baseUrl);
        $protocol = isset($parsedBase['scheme']) ? $parsedBase['scheme'] : 'https';
        return $protocol . ':' . $relativeUrl;
    }
    
    // Se o URL relativo comeÃ§ar com /, Ã© relativo Ã  raiz do domÃ­nio
    if (substr($relativeUrl, 0, 1) === '/') {
        $parsedBase = parse_url($baseUrl);
        $baseRoot = $parsedBase['scheme'] . '://' . $parsedBase['host'];
        return $baseRoot . $relativeUrl;
    }
    
    // Para outros URLs relativos, resolve em relaÃ§Ã£o ao URL base
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
 * Extrai uma URL vÃ¡lida de imagem a partir de elementos HTML
 * VersÃ£o melhorada para priorizar imagens reais dos artigos
 */
function extractValidImageUrl($element, $baseUrl) {
    // Fallback para quando o elemento nÃ£o Ã© encontrado
    if (empty($element)) {
        // Retornar string vazia em vez de URL para fallback
        return '';
    }
    
    // Lista de possÃ­veis atributos que podem conter URLs de imagem
    $imgAttributes = ['src', 'data-src', 'data-lazy-src', 'data-original', 'data-srcset', 'srcset', 
                     'data-original-src', 'data-lazy-loaded', 'data-img-url', 'data-full-src', 
                     'data-large-file', 'data-medium-file', 'loading-src', 'data-hi-res-src'];
    
    // Tenta encontrar tag <img> com classes comuns de imagens principais
    $mainImageClasses = ['featured-image', 'main-image', 'post-image', 'article-image', 'entry-image', 
                        'thumbnail', 'wp-post-image', 'attachment-large', 'hero-image'];
    $imgTags = $element->getElementsByTagName('img');
    
    // Primeiro tenta imagens com classes especÃ­ficas de imagens principais
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
                            
                            // Verifica se Ã© uma URL vÃ¡lida e se Ã© uma imagem
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
                
                // Verifica se Ã© uma URL vÃ¡lida e se Ã© uma imagem de tamanho adequado
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    // Tenta obter as dimensÃµes da imagem dos atributos
                    $width = $img->hasAttribute('width') ? intval($img->getAttribute('width')) : 0;
                    $height = $img->hasAttribute('height') ? intval($img->getAttribute('height')) : 0;
                    
                    // Se as dimensÃµes estÃ£o disponÃ­veis, calcula a Ã¡rea
                    if ($width > 0 && $height > 0) {
                        $area = $width * $height;
                        if ($area > $largestArea) {
                            $largestArea = $area;
                            $bestImageUrl = $imgUrl;
                        }
                    } 
                    // Se nÃ£o temos as dimensÃµes, mas ainda nÃ£o encontramos nenhuma imagem
                    else if (empty($bestImageUrl)) {
                        $bestImageUrl = $imgUrl;
                    }
                }
            }
        }
    }
    
    // Se encontramos uma imagem boa, retorna ela
    if (!empty($bestImageUrl)) {
        // Verificar se a URL retornada contÃ©m caracteres invÃ¡lidos ou Ã© do Unsplash
        if (strpos($bestImageUrl, '@') !== false || strpos($bestImageUrl, 'unsplash.com') !== false) {
            return '';
        }
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
                
                // Verifica se Ã© uma URL vÃ¡lida e se Ã© uma imagem
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
                
                // Verifica se Ã© uma URL vÃ¡lida e se Ã© uma imagem
                if (isValidImageUrl($imgUrl) && !isSmallOrIconImage($imgUrl)) {
                    return $imgUrl;
                }
            }
        }
    }
    
    // Se nenhuma imagem foi encontrada, retorna string vazia
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
            // Se nÃ£o tem tamanho definido, pega a primeira URL
            $largestUrl = preg_replace('/\s+\d+[wx].*$/', '', $part);
        }
    }
    
    return !empty($largestUrl) ? $largestUrl : $srcset;
}

/**
 * Verifica se Ã© uma imagem pequena, Ã­cone, logo ou imagem inadequada
 */
function isSmallOrIconImage($url) {
    // Verifica se a URL contÃ©m indicaÃ§Ãµes de que Ã© um Ã­cone ou logo
    if (preg_match('/icon|logo|avatar|favicon|thumb(\-|\.|_)?(small|tiny|min)|badge|button|banner|social|widget|gravatar|footer|header|nav|menu|sprite/i', $url)) {
        return true;
    }
    
    // Verifica se contÃ©m palavras que indicam imagens de interface ou nÃ£o relacionadas a notÃ­cias
    if (preg_match('/template|theme|layout|interface|ui\-|ui\_|placeholder|empty|blank|default|promotion|ad\-|ad\_/i', $url)) {
        return true;
    }
    
    // Verifica dimensÃµes especÃ­ficas de Ã­cones comuns
    if (preg_match('/16x16|24x24|32x32|48x48|64x64|72x72|96x96|128x128/i', $url)) {
        return true;
    }
    
    // Verifica se tem dimensÃ£o no nome e se Ã© pequena
    if (preg_match('/(\-|\.|_)(\d+x\d+|w\d+|h\d+|size\d+)/i', $url)) {
        if (preg_match('/(\-|\.|_)(\d+)x(\d+)/i', $url, $matches)) {
            $width = intval($matches[2]);
            $height = intval($matches[3]);
            // Imagens menores que 400px (aumentado de 300px) sÃ£o consideradas pequenas
            if ($width < 400 || $height < 400) {
                return true;
            }
        }
    }
    
    // Verifica se Ã© um SVG (frequentemente usado para Ã­cones e logos)
    if (preg_match('/\.svg(\?.*)?$/i', $url)) {
        return true;
    }
    
    return false;
}

/**
 * Verifica se uma URL Ã© uma imagem vÃ¡lida
 */
function isValidImageUrl($url) {
    // Remove whitespace e verifica se Ã© vazia
    $url = trim($url);
    if (empty($url)) {
        return false;
    }
    
    // Verifica se a URL contÃ©m @ (sÃ­mbolo que indica URL mal formada)
    if (strpos($url, '@') !== false) {
        return false;
    }
    
    // Verifica se a URL contÃ©m referÃªncia ao Unsplash (que nÃ£o estÃ¡ carregando)
    if (strpos($url, 'unsplash.com') !== false) {
        return false;
    }
    
    // Lista de extensÃµes indesejadas que normalmente nÃ£o sÃ£o imagens de artigos
    $badExtensions = ['ico', 'svg', 'gif', 'webp'];
    foreach ($badExtensions as $ext) {
        if (preg_match('/\.' . $ext . '(\?.*)?$/i', $url)) {
            return false;
        }
    }
    
    // Verifica se a URL tem extensÃ£o de imagem comum
    if (preg_match('/\.(jpe?g|png)(\?.*)?$/i', $url)) {
        // VerificaÃ§Ãµes adicionais para evitar imagens indesejadas
        if (isSmallOrIconImage($url)) {
            return false;
        }
        return true;
    }
    
    // Rejeita URLs que parecem ser Ã­cones ou imagens de interface
    if (preg_match('/icon|logo|avatar|favicon|thumb(\-|\.|_)?(small|tiny|min)|badge|button|banner|social|widget|gravatar|empty|blank|default|nav|header|footer/i', $url)) {
        return false;
    }
    
    // Verifica tamanho dos arquivos se tiver dimensÃ£o no nome do arquivo (comum em CDNs)
    if (preg_match('/(\-|\.|_)(\d+x\d+|w\d+|h\d+|size\d+)/i', $url)) {
        if (preg_match('/(\-|\.|_)(\d+x\d+)/i', $url, $matches)) {
            $dimensions = explode('x', strtolower($matches[2]));
            if (count($dimensions) == 2) {
                // Se a imagem for muito pequena (menos de 400px em qualquer dimensÃ£o), provavelmente nÃ£o Ã© uma imagem principal
                if (intval($dimensions[0]) < 400 || intval($dimensions[1]) < 400) {
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
    
    $isFromCDN = false;
    foreach ($knownImageCDNs as $cdn) {
        if (stripos($url, $cdn) !== false) {
            $isFromCDN = true;
            break;
        }
    }
    
    // Se nÃ£o Ã© de um CDN conhecido, verifica atravÃ©s do Content-Type
    if (!$isFromCDN && function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Reduzido de 5 para 3 segundos
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        
        if ($response !== false) {
            $contentType = '';
            
            // Extrai Content-Type do header
            if (preg_match('/Content-Type: (image\/[^\s;]+)/i', $response, $matches)) {
                $contentType = $matches[1];
                
                // Especificamente queremos apenas imagens JPEG ou PNG
                if (strpos($contentType, 'image/jpeg') === 0 || strpos($contentType, 'image/png') === 0) {
                    curl_close($ch);
                    return true;
                }
            }
            
            curl_close($ch);
            return false;
        } else {
            curl_close($ch);
            return false;
        }
    }
    
    // Se Ã© de um CDN conhecido mas nÃ£o passou nas verificaÃ§Ãµes anteriores, retorna true
    return $isFromCDN;
}

/**
 * Verifica se uma URL Ã© uma pÃ¡gina de notÃ­cia vÃ¡lida
 */
function isValidArticleUrl($url) {
    // Verificar se a URL Ã© vazia
    if (empty($url)) {
        return false;
    }
    
    // Lista de padrÃµes que indicam pÃ¡ginas que nÃ£o sÃ£o notÃ­cias
    $badPatterns = [
        'contato', 'contact', 'reportar-erro', 'report-error', 'error', 'erro',
        'login', 'cadastro', 'register', 'password', 'senha', 'account', 'conta',
        'admin', 'wp-admin', 'wp-login', 'painel', 'dashboard', 'perfil', 'profile',
        'form', 'formulario', 'captcha', 'privacidade', 'privacy', 'terms', 'termos',
        'politica', 'policy', 'cookies', 'lgpd', 'gdpr', 'subscribe', 'newsletter',
        'assinatura', 'inscreva', 'ajuda', 'help', 'faq', 'suporte', 'support'
    ];
    
    // Verifica se a URL contÃ©m algum dos padrÃµes indesejados
    foreach ($badPatterns as $pattern) {
        if (stripos($url, $pattern) !== false) {
            return false;
        }
    }
    
    // Verifica se parece ser uma URL de pÃ¡gina interna ou administrativa
    if (preg_match('/(\/wp-|\/admin|\/login|\/conta|\/form|\?pst=|\?post=|\?page=|\?p=)/i', $url)) {
        return false;
    }
    
    return true;
}

/**
 * Faz o scraping de um site especÃ­fico
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
        // Tenta diferentes estratÃ©gias para encontrar artigos
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
            // Se o seletor for invÃ¡lido, tenta algo mais genÃ©rico
            $articles = null;
        }
        
        if (!$articles || $articles->length == 0) {
            // Se nÃ£o encontrou com o seletor especÃ­fico, tenta algo mais genÃ©rico
            $articles = $xpath->query("//div[contains(@class, 'article') or contains(@class, 'post') or contains(@class, 'card') or contains(@class, 'news')]");
        }
        
        if (!$articles || $articles->length == 0) {
            return $news;
        }
        
        for ($i = 0; $i < min($articles->length, 5); $i++) {
            $article = $articles->item($i);
            
            // Busca tÃ­tulo (tenta vÃ¡rios seletores)
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
                    // Se o seletor for invÃ¡lido, continua para o prÃ³ximo
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
            
            // Verifica se a URL Ã© relativa e adiciona o domÃ­nio
            if ($linkUrl && strpos($linkUrl, 'http') !== 0) {
                $linkUrl = resolveRelativeUrlBase($site['url'], $linkUrl);
            }
            
            // Verifica se a URL Ã© vÃ¡lida para uma notÃ­cia
            if (!isValidArticleUrl($linkUrl)) {
                continue;
            }
            
            // ObtÃ©m a imagem, primeiro tentando no artigo e depois no conteÃºdo da pÃ¡gina linkada
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
            
            // 2. Se nÃ£o encontrou imagem, procura em padrÃµes comuns dentro do artigo
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
            
            // 3. Se ainda nÃ£o encontramos uma imagem e temos o URL do artigo, tenta buscar diretamente no artigo
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
                                
                    // Se ainda nÃ£o encontrou, procura a maior imagem no artigo
                                if (empty($imageUrl)) {
                        $articleImg = extractValidImageUrl($articleDom, $linkUrl);
                        if (!empty($articleImg)) {
                            $imageUrl = $articleImg;
                        }
                    }
                }
            }
            
            // Se mesmo apÃ³s todas as tentativas nÃ£o encontramos uma imagem vÃ¡lida,
            // geramos uma imagem dinÃ¢mica do sistema
            if (empty($imageUrl) || strpos($imageUrl, '@') !== false || strpos($imageUrl, 'unsplash.com') !== false) {
                // Pular esta notÃ­cia ao invÃ©s de usar fallback
                continue;
            }
            
            // Busca descriÃ§Ã£o
            $descriptionText = "";
            
            // Usa o tÃ­tulo como base para a descriÃ§Ã£o
            if (!empty($titleText)) {
                // Se o tÃ­tulo for curto, usa ele como estÃ¡
                if (strlen($titleText) < 100) {
                    $descriptionText = "Saiba mais sobre: " . $titleText;
                } else {
                    // Se for longo, corta para evitar duplicaÃ§Ã£o
                    $descriptionText = "Leia a matÃ©ria completa sobre " . substr($titleText, 0, 70) . "...";
                }
            } else {
                $descriptionText = "Confira esta notÃ­cia sobre seguranÃ§a cibernÃ©tica no site original.";
            }
            
            // Limpa o texto removendo espaÃ§os extras
            $titleText = trim(preg_replace('/\s+/', ' ', $titleText));
            
            // Limita a descriÃ§Ã£o a 150 caracteres
            if (strlen($descriptionText) > 150) {
                $descriptionText = substr($descriptionText, 0, 147) . '...';
            }
            
            // Verifica se Ã© site internacional (em inglÃªs) baseado no domÃ­nio
            $isEnglish = !preg_match('/(\.br|\.com\.br)/i', $site['url']);
            
            // Para sites em inglÃªs, adiciona indicador no inÃ­cio da descriÃ§Ã£o
            if ($isEnglish) {
                $descriptionText = "[ConteÃºdo em inglÃªs] " . $descriptionText;
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
 * ObtÃ©m o conteÃºdo HTML de um site usando cURL
 * Inclui sistema de cache para nÃ£o sobrecarregar os sites
 */
function getWebsiteContent($url) {
    // Verifica se existe cache e se nÃ£o estÃ¡ expirado (estendido para 6 horas)
    $cacheFile = 'cache/' . md5($url) . '.html';
    $cacheTime = 21600; // 6 horas (aumentado de 2 para 6 horas)
    
    // Cria diretÃ³rio de cache se nÃ£o existir
    if (!file_exists('cache')) {
        mkdir('cache', 0777, true);
    }
    
    // Verifica se o cache existe e estÃ¡ vÃ¡lido
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
        return file_get_contents($cacheFile);
    }
    
    // Para requisiÃ§Ãµes AJAX, priorize a velocidade e use cache mesmo se expirado
    if (isset($_GET['load_more']) && file_exists($cacheFile)) {
        // Atualiza a data do arquivo para estender sua vida Ãºtil
        touch($cacheFile);
        // Agenda uma atualizaÃ§Ã£o assÃ­ncrona para depois
        touch('cache/update_needed.flag');
        return file_get_contents($cacheFile);
    }
    
    // Caso contrÃ¡rio, faz a requisiÃ§Ã£o
    $ch = curl_init();
    
    // Configura o cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Reduzido de 10 para 5 segundos
    curl_setopt($ch, CURLOPT_ENCODING, ''); // Aceita codificaÃ§Ã£o gzip
    
    // Adiciona um delay reduzido para nÃ£o sobrecarregar os sites
    usleep(rand(100000, 300000)); // 0.1 a 0.3 segundos (reduzido de 0.5-1.5s)
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    if ($httpCode >= 200 && $httpCode < 300 && !empty($html)) {
        // Salva o resultado no cache
        file_put_contents($cacheFile, $html);
        return $html;
    } else if (file_exists($cacheFile)) {
        // Se a requisiÃ§Ã£o falhou mas existe cache, usa o cache mesmo que expirado
        return file_get_contents($cacheFile);
    }
    
    return false;
}

// Handling AJAX requests for more news
if (isset($_GET['load_more'])) {
    // Get requested page and items per page (default to 30 items)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $itemsPerPage = isset($_GET['items']) ? (int)$_GET['items'] : 30;
    
    // Apply limits to avoid excessive processing
    $itemsPerPage = min(max($itemsPerPage, 10), 50); // Between 10 and 50 items
    
    // Get news
    $allNewsFromScrapers = getAllNews();
    
    // Filter by language if requested
    $requestedLang = isset($_GET['lang']) ? strtolower($_GET['lang']) : 'all';
    if ($requestedLang != 'all') {
        $allNewsFromScrapers = array_filter($allNewsFromScrapers, function($item) use ($requestedLang) {
            return isset($item['language']) && strtolower($item['language']) == $requestedLang;
        });
        // Re-index array
        $allNewsFromScrapers = array_values($allNewsFromScrapers);
    }
    
    // Get subset based on pagination
    $totalItems = count($allNewsFromScrapers);
    $maxPages = ceil($totalItems / $itemsPerPage);
    
    // Ensure page doesn't exceed the maximum, and handle empty pages
    if ($maxPages == 0) $maxPages = 1;
    $page = min(max($page, 1), $maxPages);
    
    // Calculate subset of news to return
    $startIndex = ($page - 1) * $itemsPerPage;
    $endIndex = min($startIndex + $itemsPerPage, $totalItems);
    
    // If we're at the last page, circle back to the beginning with some randomness
    if ($startIndex >= $totalItems) {
        // Shuffle news when we've gone through all of them
        shuffle($allNewsFromScrapers);
        $startIndex = 0;
        $endIndex = min($itemsPerPage, $totalItems);
    }
    
    // Get slice of news
    $newsSlice = array_slice($allNewsFromScrapers, $startIndex, $endIndex - $startIndex);
    
    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode([
        'page' => $page,
        'maxPages' => $maxPages,
        'totalItems' => $totalItems,
        'itemsPerPage' => $itemsPerPage,
        'news' => $newsSlice
    ]);
    exit;
}
