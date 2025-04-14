<?php
// Inclui o scraper de notícias
include 'scraper.php';

// Obtem as notícias
$allNews = getAllNews();
$featuredNews = array_slice($allNews, 0, 5); // Primeiras 5 notícias para o carousel
$gridNews = array_slice($allNews, 0, 12); // Primeiras 12 notícias para o grid inicial
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
<body>
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
                <div class="theme-toggle">
                    <button id="theme-switch" title="Alternar tema">
                        <i class="fas fa-moon"></i>
                        <i class="fas fa-cannabis"></i>
                    </button>
                </div>
            </div>
        </header>

        <main class="container">
            <!-- Carousel -->
            <section class="carousel-container">
                <div class="carousel">
                    <?php foreach ($featuredNews as $index => $news): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="carousel-image" style="background-image: url('<?= htmlspecialchars($news['image']) ?>'); background-size: cover; background-position: center;"></div>
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

            <!-- Grid de notícias com scroll infinito -->
            <section class="news-grid" id="news-grid">
                <?php foreach ($gridNews as $news): ?>
                <article class="news-card">
                    <div class="news-image">
                        <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';">
                        <span class="badge"><?= htmlspecialchars($news['source']) ?></span>
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
                    
                    <!-- Cannabis leaves em órbita -->
                    <div class="fractal-leaf">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#5cdb5c" d="M50,10 C60,25 80,20 85,30 C90,40 80,50 70,55 C80,60 85,75 80,85 C75,95 60,90 50,85 C40,90 25,95 20,85 C15,75 20,60 30,55 C20,50 10,40 15,30 C20,20 40,25 50,10 Z" />
                        </svg>
                    </div>
                    <div class="fractal-leaf">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#5cdb5c" d="M50,10 C60,25 80,20 85,30 C90,40 80,50 70,55 C80,60 85,75 80,85 C75,95 60,90 50,85 C40,90 25,95 20,85 C15,75 20,60 30,55 C20,50 10,40 15,30 C20,20 40,25 50,10 Z" />
                        </svg>
                    </div>
                    <div class="fractal-leaf">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#5cdb5c" d="M50,10 C60,25 80,20 85,30 C90,40 80,50 70,55 C80,60 85,75 80,85 C75,95 60,90 50,85 C40,90 25,95 20,85 C15,75 20,60 30,55 C20,50 10,40 15,30 C20,20 40,25 50,10 Z" />
                        </svg>
                    </div>
                    <div class="fractal-leaf">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#5cdb5c" d="M50,10 C60,25 80,20 85,30 C90,40 80,50 70,55 C80,60 85,75 80,85 C75,95 60,90 50,85 C40,90 25,95 20,85 C15,75 20,60 30,55 C20,50 10,40 15,30 C20,20 40,25 50,10 Z" />
                        </svg>
                    </div>
                    
                    <!-- Cogumelos em órbita -->
                    <div class="fractal-mushroom">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#8e44ad" d="M50,20 C35,20 20,40 20,60 C20,75 35,85 50,85 C65,85 80,75 80,60 C80,40 65,20 50,20 Z M50,40 C45,60 40,70 30,75 C40,80 60,80 70,75 C60,70 55,60 50,40 Z" />
                        </svg>
                    </div>
                    <div class="fractal-mushroom">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#8e44ad" d="M50,20 C35,20 20,40 20,60 C20,75 35,85 50,85 C65,85 80,75 80,60 C80,40 65,20 50,20 Z M50,40 C45,60 40,70 30,75 C40,80 60,80 70,75 C60,70 55,60 50,40 Z" />
                        </svg>
                    </div>
                    <div class="fractal-mushroom">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#8e44ad" d="M50,20 C35,20 20,40 20,60 C20,75 35,85 50,85 C65,85 80,75 80,60 C80,40 65,20 50,20 Z M50,40 C45,60 40,70 30,75 C40,80 60,80 70,75 C60,70 55,60 50,40 Z" />
                        </svg>
                    </div>
                    <div class="fractal-mushroom">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#8e44ad" d="M50,20 C35,20 20,40 20,60 C20,75 35,85 50,85 C65,85 80,75 80,60 C80,40 65,20 50,20 Z M50,40 C45,60 40,70 30,75 C40,80 60,80 70,75 C60,70 55,60 50,40 Z" />
                        </svg>
                    </div>
                    
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
            
            <div class="load-more-container">
                <button id="load-more-btn" class="btn">Carregar mais notícias</button>
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