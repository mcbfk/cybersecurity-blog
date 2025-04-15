document.addEventListener('DOMContentLoaded', function() {
    // Preloader handling - deve ser o primeiro para evitar conflitos
    const preloader = document.getElementById('preloader');
    const mainContent = document.getElementById('main-content');
    
    // Garantir que o conteúdo principal esteja inicialmente oculto
    if (mainContent) {
        mainContent.style.opacity = '0';
        mainContent.style.visibility = 'hidden';
    }
    
    // Criar efeito de texto binário no preloader
    if (document.querySelector('.binary-text')) {
        generateBinaryText();
    }
    
    // Animação das bolhas psicodélicas no preloader
    animatePsychedelicBubbles();
    
    // Função para mostrar a página quando tudo estiver carregado
    function showPage() {
        // Força o preloader a mostrar por pelo menos 2 segundos
        setTimeout(() => {
            // Adiciona a classe loaded ao body para acionar transições
            document.body.classList.add('loaded');
            
            // Tornar o conteúdo principal visível após a transição
            setTimeout(() => {
                if (mainContent) {
                    mainContent.style.opacity = '1';
                    mainContent.style.visibility = 'visible';
                }
                
                // Remover completamente o preloader depois da transição
                if (preloader) {
                    preloader.style.display = 'none';
                }
            }, 800);
        }, 2000);
    }
    
    // Se todos os recursos já estiverem carregados
    if (document.readyState === 'complete') {
        showPage();
    } else {
        // Espera tudo carregar e então mostra a página
        window.addEventListener('load', showPage);
    }
    
    // Theme switching functionality
    const themeSwitch = document.getElementById('theme-switch');
    
    if (themeSwitch) {
        const moonIcon = themeSwitch.querySelector('.fa-moon');
        const cannabisIcon = themeSwitch.querySelector('.fa-cannabis');
        const sunIcon = document.createElement('i');
        sunIcon.className = 'fas fa-sun';
        themeSwitch.appendChild(sunIcon);
        
        let currentTheme = localStorage.getItem('theme') || 'psychedelic';
        
        // Aplicar tema salvo ao carregar a página
        applyTheme(currentTheme);
        
        // Alternar tema ao clicar no botão
        themeSwitch.addEventListener('click', function() {
            switch(currentTheme) {
                case 'psychedelic':
                    currentTheme = 'dark';
                    break;
                case 'dark':
                    currentTheme = 'light';
                    break;
                default:
                    currentTheme = 'psychedelic';
            }
            
            applyTheme(currentTheme);
            localStorage.setItem('theme', currentTheme);
        });
        
        // Aplicar o tema selecionado
        function applyTheme(theme) {
            // Remover classes de tema existentes
            document.body.classList.remove('dark-mode', 'psychedelic-mode');
            
            // Remover elementos psicodélicos existentes
            document.querySelectorAll('.cannabis-leaf').forEach(el => el.remove());
            
            // Esconder todos os ícones primeiro
            moonIcon.style.display = 'none';
            cannabisIcon.style.display = 'none';
            sunIcon.style.display = 'none';
            
            // Aplicar tema selecionado e mostrar ícone apropriado
            switch(theme) {
                case 'dark':
                    document.body.classList.add('dark-mode');
                    moonIcon.style.display = 'flex';
                    break;
                case 'psychedelic':
                    document.body.classList.add('psychedelic-mode');
                    cannabisIcon.style.display = 'flex';
                    createPsychedelicElements();
                    setupPsychedelicEffects();
                    
                    // Aplicar efeitos psicodélicos aos botões de filtro
                    setupPsychedelicFilterButtons();
                    break;
                case 'light':
                    sunIcon.style.display = 'flex';
                    break;
            }
        }
    }
    
    // Função para criar elementos psicodélicos
    function createPsychedelicElements() {
        // Criar um número maior de folhas de cannabis
        for (let i = 0; i < 25; i++) {
            createFloatingCannabisLeaf();
        }
        
        // Configurar intervalo para criar novas folhas periodicamente
        let psychedelicInterval = setInterval(() => {
            // Só continua se estiver no modo psicodélico
            if (!document.body.classList.contains('psychedelic-mode')) {
                clearInterval(psychedelicInterval);
                return;
            }
            
            // Adicionar mais folhas de cannabis com frequência
            createFloatingCannabisLeaf();
            
        }, 2000); // Criar mais frequentemente (a cada 2 segundos)
    }
    
    // Configurar efeitos para o modo psicodélico
    function setupPsychedelicEffects() {
        // Adicionar atributo data-text a todos os títulos para o efeito glitch
        document.querySelectorAll('.news-content h3').forEach(heading => {
            heading.setAttribute('data-text', heading.textContent);
        });
        
        // Adicionar efeito de distorção ao rolar
        let scrollTimer;
        window.addEventListener('scroll', () => {
            if (document.body.classList.contains('psychedelic-mode')) {
                document.body.classList.add('scrolling');
                
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(() => {
                    document.body.classList.remove('scrolling');
                }, 100);
            }
        });
        
        // Adicionar efeitos de cor psicodélica no hover
        document.querySelectorAll('.news-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                if (!document.body.classList.contains('psychedelic-mode')) return;
                
                const randomHue = Math.floor(Math.random() * 30) - 15;
                card.style.filter = `hue-rotate(${randomHue}deg)`;
                
                // Chance de criar uma folha ao passar o mouse
                setTimeout(() => {
                    if (Math.random() > 0.6 && document.body.classList.contains('psychedelic-mode')) {
                        createFloatingCannabisLeaf();
                    }
                }, 300);
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.filter = '';
            });
        });
    }
    
    // Funções de utilidade para criar elementos no preloader e modo psicodélico
    
    // Função para gerar texto binário aleatório
    function generateBinaryText() {
        const binaryText = document.querySelector('.binary-text');
        if (!binaryText) return;
        
        let binaryString = '';
        for (let i = 0; i < 500; i++) {
            binaryString += Math.floor(Math.random() * 2);
            if (i % 8 === 7) binaryString += ' ';
            if (i % 64 === 63) binaryString += '\n';
        }
        
        binaryText.setAttribute('data-text', binaryString);
        
        // Atualizar periodicamente
        setInterval(() => {
            if (!document.body.classList.contains('loaded')) {
                let newBinary = '';
                for (let i = 0; i < 500; i++) {
                    newBinary += Math.floor(Math.random() * 2);
                    if (i % 8 === 7) newBinary += ' ';
                    if (i % 64 === 63) newBinary += '\n';
                }
                binaryText.setAttribute('data-text', newBinary);
            }
        }, 2000);
    }
    
    // Animar as bolhas psicodélicas no preloader
    function animatePsychedelicBubbles() {
        const psychedelicBubbles = document.querySelectorAll('.bubble.psychedelic');
        if (!psychedelicBubbles.length) return;
        
        // Aplicar cores aleatórias às bolhas para efeito mais alucinógeno
        psychedelicBubbles.forEach(bubble => {
            setInterval(() => {
                if (!document.body.classList.contains('loaded')) {
                    const hue = Math.floor(Math.random() * 360);
                    const saturation = 80 + Math.floor(Math.random() * 20);
                    const lightness = 50 + Math.floor(Math.random() * 30);
                    
                    bubble.style.boxShadow = `0 0 ${20 + Math.random() * 40}px hsl(${hue}, ${saturation}%, ${lightness}%), 
                                          0 0 ${40 + Math.random() * 60}px hsl(${(hue + 60) % 360}, ${saturation}%, ${lightness}%),
                                          inset 0 0 ${15 + Math.random() * 15}px rgba(255, 255, 255, 0.8)`;
                }
            }, 1000 + Math.random() * 1000);
        });
    }
    
    // Criar um elemento de folha de cannabis flutuante
    function createFloatingCannabisLeaf() {
        if (!document.body.classList.contains('psychedelic-mode')) return;
        
        const leaf = document.createElement('div');
        leaf.className = 'cannabis-leaf';
        
        // Tamanho mais variado para as folhas
        const size = 20 + Math.random() * 60;
        
        // Mais estilos diferentes de folha de cannabis para mais variedade
        const leafStyle = Math.floor(Math.random() * 3);
        
        if (leafStyle === 0) {
            // Estilo original
            leaf.innerHTML = '<svg width="'+ size +'" height="'+ size +'" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M50 10C40 30 20 40 10 50C20 60 40 70 50 90C60 70 80 60 90 50C80 40 60 30 50 10Z" fill="#5cdb5c"/><path d="M50 10L50 90" stroke="#5cdb5c" stroke-width="3"/><path d="M30 40L70 60M30 60L70 40" stroke="#5cdb5c" stroke-width="2"/></svg>';
        } else if (leafStyle === 1) {
            // Estilo alternativo - folha mais detalhada
            leaf.innerHTML = '<svg width="'+ size +'" height="'+ size +'" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M50 10C45 20 40 25 35 30C30 35 20 40 15 42C10 45 5 47 5 50C5 53 10 55 15 58C20 60 30 65 35 70C40 75 45 80 50 90C55 80 60 75 65 70C70 65 80 60 85 58C90 55 95 53 95 50C95 47 90 45 85 42C80 40 70 35 65 30C60 25 55 20 50 10Z" fill="#5cdb5c"/><path d="M50 10L50 90" stroke="#5cdb5c" stroke-width="2"/><path d="M25 40L75 60M25 60L75 40" stroke="#5cdb5c" stroke-width="1.5"/><path d="M15 50L85 50" stroke="#5cdb5c" stroke-width="1.5"/><path d="M30 30C40 40 60 40 70 30" stroke="#5cdb5c" stroke-width="1.5"/><path d="M30 70C40 60 60 60 70 70" stroke="#5cdb5c" stroke-width="1.5"/></svg>';
        } else {
            // Terceiro estilo - folha mais simples e elegante
            leaf.innerHTML = '<svg width="'+ size +'" height="'+ size +'" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M50 5C45 15 40 25 35 35C30 45 25 50 20 55C15 60 10 55 10 50C10 45 15 40 20 35C25 30 35 25 35 25C35 25 30 35 25 45C20 55 15 65 15 65C20 60 25 55 30 50C35 45 45 35 45 35C45 35 40 45 35 55C30 65 25 75 30 80C35 85 40 80 45 75C50 70 55 65 55 65C55 65 50 75 50 85C50 95 50 95 50 95C50 95 50 95 50 85C50 75 45 65 45 65C45 65 50 70 55 75C60 80 65 85 70 80C75 75 70 65 65 55C60 45 55 35 55 35C55 35 65 45 70 50C75 55 80 60 85 65C85 65 80 55 75 45C70 35 65 25 65 25C65 25 75 30 80 35C85 40 90 45 90 50C90 55 85 60 80 55C75 50 70 45 65 35C60 25 55 15 50 5Z" fill="#5cdb5c"/></svg>';
        }
        
        // Posicionamento mais variado na tela
        // Algumas folhas vêm da esquerda, direita, cima ou baixo
        const randomPos = Math.floor(Math.random() * 4);
        switch (randomPos) {
            case 0: // Da esquerda
                leaf.style.top = Math.random() * 100 + 'vh';
                leaf.style.left = -size + 'px';
                break;
            case 1: // Da direita
                leaf.style.top = Math.random() * 100 + 'vh';
                leaf.style.left = 'calc(100vw + ' + size + 'px)';
                leaf.style.transform = 'scaleX(-1)'; // Espelhar horizontalmente
                break;
            case 2: // De cima
                leaf.style.top = -size + 'px';
                leaf.style.left = Math.random() * 100 + 'vw';
                leaf.style.transform = 'rotate(90deg)'; // Girar 90 graus
                break;
            case 3: // De baixo - novas folhas subindo
                leaf.style.bottom = -size + 'px';
                leaf.style.left = Math.random() * 100 + 'vw';
                leaf.style.transform = 'rotate(-90deg)'; // Girar -90 graus
                leaf.classList.add('rising');
                break;
        }
        
        // Mais variação nas animações, algumas mais lentas para movimento mais suave
        leaf.style.animationDelay = Math.random() * 8 + 's';
        leaf.style.animationDuration = 20 + Math.random() * 30 + 's'; // Durações mais longas para movimento mais suave
        
        document.body.appendChild(leaf);
        
        // Remover após o término da animação
        setTimeout(() => {
            if (leaf.parentNode) {
                leaf.parentNode.removeChild(leaf);
            }
        }, 50000); // Tempo maior para acomodar animações mais longas
    }
    
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

    // Variáveis para filtragem de idioma
    let currentLanguageFilter = 'all';
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    // Configura os ouvintes de eventos para os botões de filtro de idioma
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Remove classe 'active' de todos os botões
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Adiciona classe 'active' ao botão clicado
                this.classList.add('active');
                
                // Adiciona efeito de clique psicodélico se estiver no modo alucinógeno
                if (document.body.classList.contains('psychedelic-mode')) {
                    createClickEffect(e, this);
                }
                
                // Atualiza o filtro atual
                currentLanguageFilter = this.getAttribute('data-filter');
                
                // Limpa o grid e recarrega as notícias
                if (newsGrid) {
                    newsGrid.innerHTML = '';
                    displayedTitles.clear();
                    page = 1;
                    hasMore = true;
                    loadMoreNews();
                }
            });
            
            // Adicionar efeito de rastreamento de mouse para o modo psicodélico
            button.addEventListener('mousemove', function(e) {
                // Obtem a posição relativa do mouse dentro do botão
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Atualiza as variáveis CSS customizadas
                this.style.setProperty('--x', x);
                this.style.setProperty('--y', y);
            });
        });
    }

    // Função para criar efeito visual no clique dos botões no modo alucinógeno
    function createClickEffect(e, button) {
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        // Criar elemento de efeito
        const effect = document.createElement('div');
        effect.className = 'psychedelic-click-effect';
        effect.style.left = x + 'px';
        effect.style.top = y + 'px';
        
        // Adicionar o efeito ao botão
        button.appendChild(effect);
        
        // Criar folhas de cannabis que voam para fora
        for (let i = 0; i < 5; i++) {
            const leaf = document.createElement('div');
            leaf.className = 'cannabis-leaf click-leaf';
            
            // Ângulo aleatório para a trajetória
            const angle = Math.random() * Math.PI * 2;
            const distance = 30 + Math.random() * 60;
            const size = 10 + Math.random() * 15;
            
            // Configurar estilo
            leaf.style.width = size + 'px';
            leaf.style.height = size + 'px';
            leaf.style.left = x + 'px';
            leaf.style.top = y + 'px';
            leaf.style.setProperty('--angle', angle + 'rad');
            leaf.style.setProperty('--distance', distance + 'px');
            
            document.body.appendChild(leaf);
            
            // Remover a folha após a animação
            setTimeout(() => {
                if (leaf.parentNode) {
                    leaf.parentNode.removeChild(leaf);
                }
            }, 1000);
        }
        
        // Remover o efeito após a animação
        setTimeout(() => {
            if (effect.parentNode) {
                effect.parentNode.removeChild(effect);
            }
        }, 700);
    }

    // Atualiza a função loadMoreNews para incluir o filtro de idioma
    async function loadMoreNews() {
        if (isLoading || !hasMore) return;
        
        isLoading = true;
        if (loadingIndicator) loadingIndicator.style.display = 'block';
        updateButtonState();
        
        try {
            // Inclui o parâmetro de filtro de idioma na URL
            const response = await fetch(`scraper.php?load_more=1&page=${page}&items=16&lang=${currentLanguageFilter}`);
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
            
            // Verifica se a notícia atende ao filtro de idioma atual
            if (currentLanguageFilter !== 'all' && item.language !== currentLanguageFilter) {
                console.log(`Notícia em ${item.language} ignorada devido ao filtro atual: ${currentLanguageFilter}`);
                return; // Pula esta notícia se não atender ao filtro
            }
            
            // Adiciona ao cache de títulos exibidos
            displayedTitles.add(normalizedTitle);
            
            const article = document.createElement('article');
            article.className = `news-card lang-${item.language || 'pt'}`;
            
            // Verifica se a imagem existe antes de usar
            let imageUrl = 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';
            if (item.image) {
                imageUrl = item.image;
            }
            
            article.innerHTML = `
                <div class="news-image">
                    <img src="${escapeHtml(imageUrl)}" alt="${escapeHtml(item.title)}" onerror="this.src='https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80';">
                    <span class="badge">${escapeHtml(item.source)}</span>
                    ${item.language === 'en' ? '<span class="language-badge">EN</span>' : ''}
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

    // Inicializar o carregamento automático se houver um botão de carregar mais
    if (loadMoreBtn && newsGrid) {
        // Verifica se já existem notícias suficientes na página
        const existingNewsCount = newsGrid.querySelectorAll('.news-card').length;
        if (existingNewsCount < 6 && hasMore && !isLoading) {
            // Se houver menos de 6 notícias, carrega mais automaticamente
            setTimeout(() => {
                loadMoreNews();
            }, 1000);
        }
        
        // Garante que o botão exibe o estado correto
        updateButtonState();
    }

    // Função para criar elementos do preloader canábico
    function createCannabisPreloaderElements() {
        const preloader = document.getElementById('preloader');
        
        // Adicionar folhas de cannabis ao preloader
        for (let i = 0; i < 10; i++) {
            const leaf = document.createElement('div');
            leaf.className = 'cannabis-leaf preloader-leaf';
            
            // Determinar tamanho aleatório
            const size = Math.random() * 40 + 20;
            leaf.style.width = `${size}px`;
            leaf.style.height = `${size}px`;
            
            // Posição aleatória
            leaf.style.top = `${Math.random() * 100}%`;
            leaf.style.left = `${Math.random() * 100}%`;
            
            // Rotação aleatória
            leaf.style.transform = `rotate(${Math.random() * 360}deg)`;
            
            // Atraso de animação aleatório
            leaf.style.animationDelay = `${Math.random() * 5}s`;
            
            // Determinar qual estilo de folha usar
            const leafStyle = Math.floor(Math.random() * 3);
            
            // Criar SVG para a folha
            leaf.innerHTML = `<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path fill="#5cdb5c" d="${getLeafPath(leafStyle)}" />
            </svg>`;
            
            preloader.appendChild(leaf);
        }
        
        // Adicionar texto temático mais elaborado
        const cannabisTextContainer = document.createElement('div');
        cannabisTextContainer.className = 'cannabis-text-container';
        
        // Texto principal "420" com efeito de brilho e pulsação
        const cannabisText = document.createElement('div');
        cannabisText.className = 'cannabis-text';
        cannabisText.innerHTML = `
            <div class="digit-container">
                <span class="digit" data-digit="4">4</span>
                <div class="digit-shadow" data-digit="4">4</div>
                <div class="digit-glow" data-digit="4">4</div>
            </div>
            <div class="digit-container">
                <span class="digit" data-digit="2">2</span>
                <div class="digit-shadow" data-digit="2">2</div>
                <div class="digit-glow" data-digit="2">2</div>
            </div>
            <div class="digit-container">
                <span class="digit" data-digit="0">0</span>
                <div class="digit-shadow" data-digit="0">0</div>
                <div class="digit-glow" data-digit="0">0</div>
            </div>
            <div class="fractal-overlay"></div>
            <div class="glow-effect"></div>
        `;
        
        // Adicionar animação de rotação e efeito de ilusão
        setTimeout(() => {
            const digitContainers = cannabisText.querySelectorAll('.digit-container');
            digitContainers.forEach((container, index) => {
                // Adicionar classe para iniciar a animação
                container.classList.add('animate');
                
                // Atraso escalonado para cada dígito
                setTimeout(() => {
                    container.classList.add('pulse');
                }, index * 200);
                
                // Criar efeito de eco para cada dígito
                for (let i = 0; i < 3; i++) {
                    const echo = document.createElement('div');
                    echo.className = 'digit-echo';
                    echo.textContent = container.querySelector('.digit').getAttribute('data-digit');
                    echo.style.animationDelay = `${0.2 + i * 0.3}s`;
                    container.appendChild(echo);
                }
            });
            
            // Adicionar efeito fractal animado
            const fractalOverlay = cannabisText.querySelector('.fractal-overlay');
            fractalOverlay.innerHTML = `
                <div class="fractal-ring"></div>
                <div class="fractal-ring" style="animation-delay: 0.2s"></div>
                <div class="fractal-ring" style="animation-delay: 0.4s"></div>
                <div class="fractal-shape"></div>
            `;
        }, 500);
        
        // Adicionar slogan abaixo do 420
        const cannabisSlogan = document.createElement('div');
        cannabisSlogan.className = 'cannabis-slogan';
        cannabisSlogan.textContent = 'Expandindo sua mente digital';
        
        // Adicionar ícones decorativos
        const iconsRow = document.createElement('div');
        iconsRow.className = 'cannabis-icons';
        iconsRow.innerHTML = `
            <i class="fas fa-cannabis"></i>
            <i class="fas fa-brain"></i>
            <i class="fas fa-eye"></i>
            <i class="fas fa-cannabis"></i>
        `;
        
        // Colocar tudo junto
        cannabisTextContainer.appendChild(cannabisText);
        cannabisTextContainer.appendChild(cannabisSlogan);
        cannabisTextContainer.appendChild(iconsRow);
        preloader.appendChild(cannabisTextContainer);
        
        // Adicionar efeito de ondas coloridas ao fundo
        const wavesEffect = document.createElement('div');
        wavesEffect.className = 'psychedelic-waves';
        preloader.appendChild(wavesEffect);
    }

    // Função para obter caminhos SVG de folhas de cannabis
    function getLeafPath(style) {
        // Diferentes estilos de folhas de cannabis em SVG path
        const paths = [
            // Folha de cannabis estilo 1
            "M50,10 C60,25 80,20 85,30 C90,40 80,50 70,55 C80,60 85,75 80,85 C75,95 60,90 50,85 C40,90 25,95 20,85 C15,75 20,60 30,55 C20,50 10,40 15,30 C20,20 40,25 50,10 Z",
            
            // Folha de cannabis estilo 2
            "M50,5 C65,20 75,15 85,30 C95,45 85,60 70,65 C80,75 80,90 65,95 C50,100 45,85 50,75 C55,85 50,100 35,95 C20,90 20,75 30,65 C15,60 5,45 15,30 C25,15 35,20 50,5 Z",
            
            // Folha de cannabis estilo 3
            "M50,5 C60,30 80,25 90,40 C100,55 85,65 70,70 C85,80 85,95 70,98 C55,100 50,85 50,75 C50,85 45,100 30,98 C15,95 15,80 30,70 C15,65 0,55 10,40 C20,25 40,30 50,5 Z"
        ];
        
        return paths[style];
    }

    // Configurar o preloader canábico se estivermos no tema cannabis
    const savedTheme = localStorage.getItem('theme') || 'psychedelic';
    if (savedTheme === 'psychedelic') {
        createCannabisPreloaderElements();
    }

    // Menu lateral alucinado
    function setupPsychedelicMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const body = document.body;
        const mainContent = document.getElementById('main-content');
        
        // Adicionar partículas brilhantes ao menu
        createGlowParticles();
        
        // Manipular clique no botão do menu
        menuToggle.addEventListener('click', function() {
            body.classList.toggle('menu-active');
            
            // Adicionar efeito distorcido ao conteúdo principal quando o menu está aberto
            if (body.classList.contains('menu-active')) {
                if (body.classList.contains('psychedelic-mode')) {
                    // Efeito extra para o modo psicodélico
                    applyPsychedelicMenuEffect();
                }
            }
        });
        
        // Fechar menu ao clicar fora dele
        mainContent.addEventListener('click', function() {
            if (body.classList.contains('menu-active')) {
                body.classList.remove('menu-active');
            }
        });
        
        // Adicionar classe 'active' ao item de menu atual baseado na seção da página
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems[0].classList.add('active'); // Definir 'Início' como ativo por padrão
        
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Remover classe 'active' de todos os itens
                menuItems.forEach(i => i.classList.remove('active'));
                // Adicionar classe 'active' ao item clicado
                this.classList.add('active');
                
                // Se estiver em modo móvel, fechar o menu após clicar
                if (window.innerWidth <= 768) {
                    body.classList.remove('menu-active');
                }
                
                // Adicionar efeito visual quando um item do menu é clicado
                const link = this.querySelector('.menu-link');
                addClickRippleEffect(link, e);
            });
        });
    }
    
    // Função para criar partículas brilhantes dinamicamente
    function createGlowParticles() {
        const glowParticlesContainer = document.querySelector('.glow-particles');
        const particleCount = 10;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'menu-particle';
            
            // Posição aleatória
            particle.style.top = `${Math.random() * 100}%`;
            particle.style.left = `${Math.random() * 100}%`;
            
            // Tamanho aleatório
            const size = Math.random() * 15 + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            // Cor aleatória - duas tonalidades de verde
            const isLightGreen = Math.random() > 0.5;
            const color = isLightGreen ? 
                `rgba(92, 219, 92, ${Math.random() * 0.5 + 0.3})` : 
                `rgba(46, 204, 113, ${Math.random() * 0.5 + 0.3})`;
            
            particle.style.background = `radial-gradient(circle at center, ${color}, transparent 70%)`;
            particle.style.filter = `blur(${Math.random() * 3 + 1}px)`;
            
            // Animação com delay aleatório
            particle.style.animation = `float-particle ${Math.random() * 5 + 5}s ease-in-out infinite`;
            particle.style.animationDelay = `${Math.random() * 5}s`;
            
            // Adicionar ao container
            glowParticlesContainer.appendChild(particle);
        }
    }
    
    // Efeito de ondulação ao clicar em itens do menu
    function addClickRippleEffect(element, event) {
        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        
        ripple.style.width = ripple.style.height = `${size}px`;
        ripple.style.left = `${event.clientX - rect.left - size/2}px`;
        ripple.style.top = `${event.clientY - rect.top - size/2}px`;
        
        element.appendChild(ripple);
        
        // Remover após a animação terminar
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    // Aplicar efeito extra quando o menu está aberto em modo psicodélico
    function applyPsychedelicMenuEffect() {
        // Criar folhas de cannabis que flutuam ao redor do menu quando aberto
        const menuBackground = document.querySelector('.menu-background');
        
        for (let i = 0; i < 3; i++) {
            const leaf = document.createElement('div');
            leaf.className = 'menu-cannabis-leaf';
            
            // Tamanho aleatório
            const size = Math.random() * 30 + 15;
            leaf.style.width = `${size}px`;
            leaf.style.height = `${size}px`;
            
            // Posição aleatória
            leaf.style.top = `${Math.random() * 80 + 10}%`;
            leaf.style.left = `${Math.random() * 80 + 10}%`;
            
            // Rotação aleatória
            leaf.style.transform = `rotate(${Math.random() * 360}deg)`;
            
            // Atraso de animação aleatório
            leaf.style.animationDelay = `${Math.random() * 2}s`;
            
            // Adicionar SVG da folha de cannabis
            leaf.innerHTML = `
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#5cdb5c" d="M50,10 C60,25 80,20 85,30 C90,40 80,50 70,55 C80,60 85,75 80,85 C75,95 60,90 50,85 C40,90 25,95 20,85 C15,75 20,60 30,55 C20,50 10,40 15,30 C20,20 40,25 50,10 Z" />
                </svg>
            `;
            
            menuBackground.appendChild(leaf);
            
            // Remover folha após um tempo
            setTimeout(() => {
                leaf.remove();
            }, 5000);
        }
    }
    
    // Inicializar o menu
    setupPsychedelicMenu();

    // Função para aplicar efeitos psicodélicos aos botões de filtro
    function setupPsychedelicFilterButtons() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        filterButtons.forEach(button => {
            // Limpar quaisquer efeitos anteriores
            button.style.transform = '';
            
            // Adicionar efeitos aleatórios periódicos
            const intervalId = setInterval(() => {
                if (!document.body.classList.contains('psychedelic-mode')) {
                    clearInterval(intervalId);
                    return;
                }
                
                const randomRotate = (Math.random() * 2 - 1);
                const randomScale = 1 + (Math.random() * 0.05);
                
                button.style.transform = `scale(${randomScale}) rotate(${randomRotate}deg)`;
                
                setTimeout(() => {
                    if (document.body.classList.contains('psychedelic-mode')) {
                        button.style.transform = '';
                    }
                }, 200);
            }, 3000 + Math.random() * 2000);
        });
    }
});
 