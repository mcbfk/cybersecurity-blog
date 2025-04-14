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
            <div class="spinner"></div>
            <p>Carregando mais notícias...</p>
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

    <script src="script.js"></script>
</body>
</html>