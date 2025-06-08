// Script para remover qualquer texto indesejado que possa aparecer no centro das imagens
document.addEventListener('DOMContentLoaded', function() {
    // Funu00e7u00e3o para limpar os cards de notu00edcias
    function cleanNewsCards() {
        // Seleciona todos os elementos .news-image
        const newsImages = document.querySelectorAll('.news-image');
        
        // Para cada elemento .news-image
        newsImages.forEach(function(newsImage) {
            // Define o fundo como preto su00f3lido
            newsImage.style.backgroundColor = '#1a1a1a';
            newsImage.style.backgroundImage = 'none';
            
            // Garante que a imagem esteja visu00edvel
            const img = newsImage.querySelector('img');
            if (img) {
                img.style.position = 'relative';
                img.style.zIndex = '1';
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                
                // Remove o atributo alt para evitar que o texto aparu00e7a durante o carregamento
                img.setAttribute('alt', '');
            }
            
            // Remove qualquer texto ou elemento indesejado
            Array.from(newsImage.childNodes).forEach(function(node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    newsImage.removeChild(node);
                }
            });
            
            // Garante que os badges estejam visu00edveis
            const badges = newsImage.querySelectorAll('.source-button, .language-badge');
            badges.forEach(function(badge) {
                badge.style.zIndex = '2';
            });
        });
    }
    
    // Executa a limpeza imediatamente
    cleanNewsCards();
    
    // Executa a limpeza novamente apu00f3s um curto intervalo para garantir que funcione
    setTimeout(cleanNewsCards, 500);
    setTimeout(cleanNewsCards, 1500);
    
    // Observa mudanu00e7as no DOM para limpar novos cards que possam ser adicionados
    const observer = new MutationObserver(function(mutations) {
        cleanNewsCards();
    });
    
    // Observa o grid de notu00edcias para detectar novos cards
    const newsGrid = document.getElementById('news-grid');
    if (newsGrid) {
        observer.observe(newsGrid, { childList: true, subtree: true });
    }
});
