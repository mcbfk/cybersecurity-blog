<?php
// Incluir o script de pré-carregamento no início
include 'preload.php';

// Inclui o scraper de notícias
include 'scraper.php';

// Obtem as notícias
$allNews = getAllNews();

// Filtra as notícias para remover URLs inválidas
$validNews = [];
$badPatterns = [
    'contato', 'contact', 'reportar-erro', 'report-error', 'error', 'erro',
    'login', 'cadastro', 'register', 'password', 'senha', 'account', 'conta',
    'admin', 'wp-admin', 'wp-login', 'painel', 'dashboard', 'perfil', 'profile',
    'form', 'formulario', 'captcha', 'privacidade', 'privacy', 'terms', 'termos',
    'politica', 'policy', 'cookies', 'lgpd', 'gdpr', 'subscribe', 'newsletter'
];

foreach ($allNews as $news) {
    $isValid = true;
    
    // Verifica se a URL é válida
    if (empty($news['url'])) {
        $isValid = false;
    }
    
    // Verifica padrões indesejados na URL
    foreach ($badPatterns as $pattern) {
        if (stripos($news['url'], $pattern) !== false) {
            $isValid = false;
            break;
        }
    }
    
    // Verifica parâmetros específicos que indicam páginas internas
    if (preg_match('/(\?pst=|\?post=|\?page=|\?p=)/i', $news['url'])) {
        $isValid = false;
    }
    
    // Verifica se a imagem é válida ou se precisa de uma imagem padrão
    if (empty($news['image']) || 
        preg_match('/(logo|icon|avatar|favicon|thumb|banner|button|header|footer)/i', $news['image'])) {
        // Gera uma imagem aleatória do Unsplash para segurança cibernética
        $uniqueId = time() . rand(1000, 9999);
        $news['image'] = "https://source.unsplash.com/random/800x600?cybersecurity,hacker&sig={$uniqueId}";
    }
    
    if ($isValid) {
        $validNews[] = $news;
    }
}

// Seleciona as notícias para o carousel e grid a partir das notícias válidas
$featuredNews = array_slice($validNews, 0, 5); // Primeiras 5 notícias para o carousel

// Cria um conjunto de IDs das notícias já usadas no carousel
$usedTitles = [];
foreach ($featuredNews as $news) {
    $usedTitles[] = $news['title'];
}

// Filtra as notícias para o grid, removendo as que já estão no carousel
$gridNews = [];
$gridCount = 0;
foreach ($validNews as $news) {
    if (!in_array($news['title'], $usedTitles) && $gridCount < 24) {
        $gridNews[] = $news;
        $gridCount++;
    }
}

// Se não tivermos notícias suficientes no grid, adiciona mais do array original
if (count($gridNews) < 24) {
    $remaining = 24 - count($gridNews);
    for ($i = 5; $i < count($validNews) && count($gridNews) < 24; $i++) {
        if (!in_array($validNews[$i]['title'], $usedTitles)) {
            $gridNews[] = $validNews[$i];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNews - As Melhores Notícias de Segurança</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body class="psychedelic-mode">
    <!-- Botão Voltar ao Topo -->
    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Menu Lateral Alucinado -->
    <div class="psychedelic-menu-container">
        <div class="menu-toggle">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <nav class="side-menu">
            <div class="menu-background">
                <div class="liquid-shape"></div>
                <div class="fractal-pattern"></div>
                <div class="glow-particles"></div>
            </div>
            
            <div class="menu-content">
                <div class="menu-header">
                    <div class="menu-logo">
                        <i class="fas fa-shield-alt"></i>
                        <h2>CyberNews</h2>
                    </div>
                </div>
                
                <ul class="menu-items">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-home"></i>
                            <span>Início</span>
                            <div class="link-fx"></div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-newspaper"></i>
                            <span>Notícias</span>
                            <div class="link-fx"></div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-lock"></i>
                            <span>Segurança</span>
                            <div class="link-fx"></div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-bug"></i>
                            <span>Vulnerabilidades</span>
                            <div class="link-fx"></div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-virus"></i>
                            <span>Malware</span>
                            <div class="link-fx"></div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="fas fa-user-secret"></i>
                            <span>Privacidade</span>
                            <div class="link-fx"></div>
                        </a>
                    </li>
                </ul>
                
                <div class="menu-footer">
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-github"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Preloader - fully covers screen until loaded -->
    <div id="preloader">
        <div class="circuit-lines"></div>
        <div class="binary-text"></div>
        <div class="scan-line"></div>
        <div class="preloader-content">
            <div class="holo-container">
                <div class="rotating-ring"></div>
                <div class="rotating-ring"></div>
                <div class="rotating-ring"></div>
                <div class="tech-circle"></div>
                <div class="hex-spinner">
                    <div class="hex"></div>
                    <div class="hex"></div>
                    <div class="hex"></div>
                    <div class="hex"></div>
                    <div class="hex"></div>
                    <div class="hex"></div>
                </div>
                <div class="loading-bubbles">
                    <div class="bubble psychedelic"></div>
                    <div class="bubble psychedelic"></div>
                    <div class="bubble psychedelic"></div>
                    <div class="bubble psychedelic"></div>
                    <div class="bubble psychedelic"></div>
                    <div class="bubble psychedelic"></div>
                </div>
            </div>
            <div class="loading-text">CARREGANDO CYBERNEWS</div>
            <div class="progress-bars">
                <div class="progress-bar"></div>
                <div class="progress-bar"></div>
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>

    <div id="main-content">
        <header>
            <div class="container">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                    <h1>CyberNews</h1>
                </div>
                <p class="tagline">Notícias de segurança cibernética em um só lugar</p>
            </div>
        </header>

        <main class="container">
            <!-- Carousel -->
            <section class="carousel-container">
                <div class="carousel">
                    <?php foreach ($featuredNews as $index => $news): ?>
                    <?php 
                        // Gera um ID único para a imagem de fallback
                        $uniqueId = time() . rand(1000, 9999);
                        
                        // Garante que a imagem seja válida
                        $imageUrl = $news['image'];
                        if (empty($imageUrl) || preg_match('/(logo|icon|avatar|favicon|thumb|banner|button|header|footer)/i', $imageUrl)) {
                            $imageUrl = "https://source.unsplash.com/random/1200x600?cybersecurity,hacker&sig={$uniqueId}";
                        }
                    ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="carousel-image" style="background-image: url('<?= htmlspecialchars($imageUrl) ?>'); background-size: cover; background-position: center;" 
                            data-fallback="https://source.unsplash.com/random/1200x600?cybersecurity,hacker&sig=<?= $uniqueId ?>">
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var img = new Image();
                                    img.onerror = function() {
                                        var carouselImage = document.querySelector('.carousel-item:nth-child(<?= $index + 1 ?>) .carousel-image');
                                        if (carouselImage) {
                                            carouselImage.style.backgroundImage = 'url(' + carouselImage.getAttribute('data-fallback') + ')';
                                        }
                                    };
                                    img.src = '<?= htmlspecialchars($imageUrl) ?>';
                                });
                            </script>
                        </div>
                        <div class="carousel-content">
                            <span class="badge"><?= htmlspecialchars($news['source']) ?></span>
                            <h2><?= htmlspecialchars($news['title']) ?></h2>
                            <p><?= htmlspecialchars($news['description']) ?></p>
                            <a href="<?= htmlspecialchars($news['url']) ?>" target="_blank" class="btn">Leia mais <i class="fas fa-external-link-alt"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
                <div class="carousel-indicators">
                    <?php for ($i = 0; $i < count($featuredNews); $i++): ?>
                    <span class="indicator <?= $i === 0 ? 'active' : '' ?>" data-index="<?= $i ?>"></span>
                    <?php endfor; ?>
                </div>
            </section>

            <div class="section-header">
                <h2 class="section-title">Últimas Notícias</h2>
                <div class="section-line"></div>
            </div>

            <!-- Filtros de idioma -->
            <section class="filter-container">
                <div class="language-filter">
                    <span>Filtrar por idioma:</span>
                    <button class="filter-btn active" data-filter="all">Todos</button>
                    <button class="filter-btn" data-filter="pt">Português</button>
                    <button class="filter-btn" data-filter="en">Inglês</button>
                </div>
            </section>

            <!-- Grid de notícias com scroll infinito -->
            <section class="news-grid" id="news-grid">
                <?php foreach ($gridNews as $news): ?>
                <?php 
                    // Verifica se a imagem parece ser inadequada (logo, ícone, etc)
                    $imageUrl = $news['image'];
                    $uniqueId = time() . rand(1000, 9999);
                    
                    // Verifica por padrões comuns em URLs de logos e ícones
                    if (empty($imageUrl) || 
                        preg_match('/(logo|icon|avatar|favicon|footer|header|banner|button|thumb|widget|placeholder)/i', $imageUrl) ||
                        preg_match('/(\-|\.|_)(16|24|32|48|64|72|96|128)x\1/i', $imageUrl) ||
                        preg_match('/\.(svg|ico|gif)(\?.*)?$/i', $imageUrl)) {
                        
                        // Termos para imagens de segurança cibernética
                        $terms = ['cybersecurity', 'hacker', 'security', 'computer-security', 'encryption', 'technology'];
                        $term1 = $terms[array_rand($terms)];
                        $term2 = $terms[array_rand($terms)];
                        
                        $imageUrl = "https://source.unsplash.com/random/800x600?{$term1},{$term2}&sig={$uniqueId}";
                    }
                ?>
                <article class="news-card">
                    <div class="news-image">
                        <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($news['title']) ?>" 
                             loading="lazy"
                             onerror="this.onerror=null; this.src='https://source.unsplash.com/random/800x600?cybersecurity,hacker&sig=<?= $uniqueId ?>';">
                        <span class="badge"><?= htmlspecialchars($news['source']) ?></span>
                        <?php if (isset($news['language']) && $news['language'] === 'en'): ?>
                        <span class="language-badge">EN</span>
                        <?php endif; ?>
                    </div>
                    <div class="news-content">
                        <h3><?= htmlspecialchars($news['title']) ?></h3>
                        <p><?= htmlspecialchars($news['description']) ?></p>
                        <a href="<?= htmlspecialchars($news['url']) ?>" target="_blank" class="read-more">Leia mais <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
                <?php endforeach; ?>
            </section>

            <div id="loading" class="loading-indicator" style="display: none;">
                <div class="loading-fractals">
                    <div class="fractal-core"></div>
                    <div class="fractal-pattern">
                        <div class="fractal-ring"></div>
                        <div class="fractal-ring"></div>
                        <div class="fractal-ring"></div>
                    </div>
                    <div class="fractal-shape hexagon"></div>
                    <div class="fractal-shape triangle"></div>
                    
                    <!-- Dupla hélice de DNA -->
                    <div class="dna-strand">
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                        <div class="dna-point"></div>
                    </div>
                    
                    <!-- Partículas de energia -->
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                    <div class="energy-particle"></div>
                </div>
                <div class="loading-text">Carregando mais notícias...</div>
            </div>
        </main>

        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-logo">
                        <i class="fas fa-shield-alt"></i>
                        <h2>CyberNews</h2>
                    </div>
                    <p>Seu portal de notícias sobre cibersegurança. Agregando conteúdo dos melhores sites especializados.</p>
                </div>
                <div class="copyright">
                    <p>&copy; <?= date('Y') ?> CyberNews - Todas as notícias são de propriedade de seus respectivos sites.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>