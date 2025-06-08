<?php
// Cabeçalho limpo sem referências a cache
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberNews - As Melhores Notícias de Segurança</title>
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="rss.php">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="fix-image-loading.css">
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
                </div>
                <button class="carousel-control prev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-control next"><i class="fas fa-chevron-right"></i></button>
                <div class="carousel-indicators">
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
                <article class="news-card">
                    <div class="news-image">
                        <div style="background: #f0f0f0; height: 200px;"></div>
                    </div>
                    <div class="news-content">
                        <h3>Título da Notícia</h3>
                        <p>Descrição da notícia aparecerá aqui</p>
                        <a href="#" class="read-more">Leia mais <i class="fas fa-arrow-right"></i></a>
                    </div>
                </article>
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

            <div class="loading-container">
                <div class="loading-spinner"></div>
                <p>Carregando mais notícias...</p>
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
    <script src="fix-image-loading.js"></script>
</body>
</html>