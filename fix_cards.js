// Script para remover qualquer texto indesejado que possa aparecer no centro das imagens
document.addEventListener('DOMContentLoaded', function() {
    // Funu00e7u00e3o para limpar os cards de notu00edcias
    function cleanNewsCards() {
        // Seleciona todos os elementos .news-image
        const newsImages = document.querySelectorAll('.news-image');
        
        // Para cada elemento .news-image
        newsImages.forEach(function(newsImage) {
            // Remove qualquer texto ou elemento indesejado
            const childNodes = Array.from(newsImage.childNodes);
            childNodes.forEach(function(node) {
                // Mantu00e9m apenas as imagens, botu00f5es de fonte e badges de idioma
                if (node.nodeName !== 'IMG' && 
                    !node.classList?.contains('source-button') && 
                    !node.classList?.contains('language-badge') &&
                    node.nodeName !== 'SCRIPT') {
                    // Se for um elemento de texto ou outro elemento indesejado, remove
                    if (node.nodeType === Node.TEXT_NODE || node.nodeType === Node.ELEMENT_NODE) {
                        newsImage.removeChild(node);
                    }
                }
            });
            
            // Adiciona um fundo preto su00f3lido
            newsImage.style.backgroundColor = '#1a1a1a';
            
            // Garante que a imagem esteja visu00edvel
            const img = newsImage.querySelector('img');
            if (img) {
                img.style.position = 'relative';
                img.style.zIndex = '1';
                
                // Garante que a imagem seja carregada corretamente
                if (img.complete) {
                    img.style.opacity = '1';
                } else {
                    img.onload = function() {
                        this.style.opacity = '1';
                    };
                    img.onerror = function() {
                        this.onerror = null;
                        this.src = 'https://source.unsplash.com/random/800x600?cybersecurity,hacker&sig=' + Date.now() + Math.random();
                        this.style.opacity = '1';
                    };
                }
            }
            
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
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                cleanNewsCards();
            }
        });
    });
    
    // Observa o grid de notu00edcias para detectar novos cards
    const newsGrid = document.getElementById('news-grid');
    if (newsGrid) {
        observer.observe(newsGrid, { childList: true, subtree: true });
    }
});
