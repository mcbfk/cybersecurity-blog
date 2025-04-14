document.addEventListener('DOMContentLoaded', function() {
    // Configuração do Carousel
    const carouselItems = document.querySelectorAll('.carousel-item');
    const prevBtn = document.querySelector('.carousel-control.prev');
    const nextBtn = document.querySelector('.carousel-control.next');
    const indicators = document.querySelectorAll('.indicator');
    
    let currentIndex = 0;
    const totalItems = carouselItems.length;

    // Função para atualizar o carousel
    function updateCarousel() {
        carouselItems.forEach(item => {
            item.classList.remove('active');
        });
        
        if (indicators && indicators.length > 0) {
            indicators.forEach(indicator => {
                indicator.classList.remove('active');
            });
            indicators[currentIndex].classList.add('active');
        }
        
        carouselItems[currentIndex].classList.add('active');
    }

    // Ir para o próximo slide
    function nextSlide() {
        if (totalItems <= 1) return;
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
    }

    // Ir para o slide anterior
    function prevSlide() {
        if (totalItems <= 1) return;
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        updateCarousel();
    }

    // Ir para um slide específico
    function goToSlide(index) {
        if (index >= 0 && index < totalItems) {
            currentIndex = index;
            updateCarousel();
        }
    }

    // Adicionar event listeners para os botões
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    // Adicionar event listeners para os indicadores
    if (indicators && indicators.length > 0) {
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                goToSlide(index);
            });
        });
    }

    // Rotação automática do carousel (se tiver mais de um slide)
    let intervalId;
    if (totalItems > 1) {
        intervalId = setInterval(nextSlide, 5000);

        // Pausar a rotação quando o mouse está sobre o carousel
        const carouselContainer = document.querySelector('.carousel-container');
        if (carouselContainer) {
            carouselContainer.addEventListener('mouseenter', () => {
                clearInterval(intervalId);
            });

            carouselContainer.addEventListener('mouseleave', () => {
                intervalId = setInterval(nextSlide, 5000);
            });
        }
    }

    // Garantir que não haja botões duplicados
    const loadMoreBtns = document.querySelectorAll('#load-more-btn');
    if (loadMoreBtns.length > 1) {
        // Se houver mais de um botão, remove os extras
        for (let i = 1; i < loadMoreBtns.length; i++) {
            loadMoreBtns[i].parentNode.removeChild(loadMoreBtns[i]);
        }
    }

    // Configuração do Scroll Infinito
    const newsGrid = document.getElementById('news-grid');
    const loadingIndicator = document.getElementById('loading');
    
    let page = 1;
    let isLoading = false;
    let hasMore = true;
    
    // Cache para rastrear títulos já exibidos e evitar duplicatas
    const displayedTitles = new Set();
    
    // Preencher o cache com os títulos já exibidos na página
    document.querySelectorAll('.news-card h3').forEach(title => {
        displayedTitles.add(normalizeTitle(title.textContent));
    });

    // Função para normalizar título para comparação
    function normalizeTitle(title) {
        return title.toLowerCase().trim().replace(/\s+/g, ' ');
    }

    // Adicionar listener para o botão "Carregar mais"
    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            if (!isLoading && hasMore) {
                loadMoreNews();
            }
        });
    }
    
    // Atualizar o estado do botão quando mudar o status de carregamento
    function updateButtonState() {
        if (loadMoreBtn) {
            if (!hasMore) {
                loadMoreBtn.textContent = 'Não há mais notícias';
                loadMoreBtn.disabled = true;
                loadMoreBtn.classList.add('disabled');
                loadMoreBtn.style.display = 'inline-block';
            } else if (isLoading) {
                // Esconde o botão durante o carregamento em vez de mostrar "Carregando..."
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.textContent = 'Carregar mais notícias';
                loadMoreBtn.disabled = false;
                loadMoreBtn.classList.remove('disabled');
                loadMoreBtn.style.display = 'inline-block';
            }
        }
    }

    // Função para carregar mais notícias
    async function loadMoreNews() {
        if (isLoading || !hasMore) return;
        
        isLoading = true;
        if (loadingIndicator) loadingIndicator.style.display = 'block';
        updateButtonState();
        
        try {
            const response = await fetch(`scraper.php?load_more=1&page=${page}`);
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor: ' + response.status);
            }
            
            // Verificar se a resposta é JSON válido
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Resposta inválida do servidor (não é JSON)');
            }
            
            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                console.error('Erro ao analisar JSON:', parseError);
                throw new Error('A resposta do servidor não é um JSON válido');
            }
            
            if (data.error) {
                throw new Error(data.message || 'Erro desconhecido');
            }
            
            if (data.news && data.news.length > 0) {
                const addedCount = appendNews(data.news);
                page++;
                hasMore = data.hasMore;
                
                // Se recebemos notícias, mas nenhuma foi adicionada (todas eram duplicadas)
                // E ainda há mais notícias disponíveis, tenta buscar o próximo lote automaticamente
                if (addedCount === 0 && hasMore) {
                    console.log('Todas as notícias eram duplicadas, carregando mais...');
                    setTimeout(() => {
                        loadMoreNews();
                    }, 500);
                }
            } else {
                hasMore = false;
                console.log(data.message || 'Não há mais notícias para carregar');
            }
        } catch (error) {
            console.error('Erro ao carregar mais notícias:', error);
            // Exibe um alerta mais discreto em vez de um popup
            const errorMsg = document.createElement('div');
            errorMsg.className = 'error-message';
            errorMsg.innerHTML = `<p>Erro ao carregar notícias: ${error.message}</p>`;
            errorMsg.style.color = 'red';
            errorMsg.style.textAlign = 'center';
            errorMsg.style.padding = '10px';
            
            if (newsGrid) {
                newsGrid.parentNode.insertBefore(errorMsg, newsGrid.nextSibling);
                
                // Remove a mensagem após 5 segundos
                setTimeout(() => {
                    if (errorMsg.parentNode) {
                        errorMsg.parentNode.removeChild(errorMsg);
                    }
                }, 5000);
            }
            
            hasMore = false; // Para de tentar carregar em caso de erro
            
            // Tenta novamente após 3 segundos em caso de erro
            setTimeout(() => {
                isLoading = false;
                updateButtonState();
            }, 3000);
            return;
        } finally {
            isLoading = false;
            if (loadingIndicator) loadingIndicator.style.display = 'none';
            updateButtonState();
        }
    }

    // Função para adicionar notícias ao grid
    function appendNews(news) {
        if (!newsGrid || !Array.isArray(news) || news.length === 0) return 0;
        
        let addedCount = 0;
        
        news.forEach(item => {
            if (!item || !item.title) return; // Verifica se o item é válido
            
            // Normaliza o título e verifica se já foi exibido
            const normalizedTitle = normalizeTitle(item.title);
            if (displayedTitles.has(normalizedTitle)) {
                console.log('Notícia duplicada ignorada:', item.title);
                return; // Pula esta notícia se for duplicada
            }
            
            // Adiciona ao cache de títulos exibidos
            displayedTitles.add(normalizedTitle);
            
            const article = document.createElement('article');
            article.className = 'news-card';
            
            // Verifica se a imagem existe antes de usar
            let imageUrl = 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';
            if (item.image) {
                imageUrl = item.image;
            }
            
            article.innerHTML = `
                <div class="news-image">
                    <img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(item.title)}" onerror="this.src='https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';">
                    <span class="badge">${escapeHtml(item.source)}</span>
                </div>
                <div class="news-content">
                    <h3>${escapeHtml(item.title)}</h3>
                    <p>${escapeHtml(item.description)}</p>
                    <a href="${escapeHtml(item.url)}" target="_blank" class="read-more">Leia mais <i class="fas fa-arrow-right"></i></a>
                </div>
            `;
            
            newsGrid.appendChild(article);
            addedCount++;
        });
        
        return addedCount;
    }

    // Função auxiliar para escapar HTML
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Detectar quando o usuário chega próximo ao final da página
    let scrollTimer = null;
    window.addEventListener('scroll', () => {
        // Evita múltiplas chamadas durante o scroll
        if (scrollTimer !== null) {
            clearTimeout(scrollTimer);
        }
        
        scrollTimer = setTimeout(() => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 800 && hasMore && !isLoading) {
                loadMoreNews();
            }
            scrollTimer = null;
        }, 300);
    });
}); 
 