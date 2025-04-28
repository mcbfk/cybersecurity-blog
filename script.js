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
            leaf.innerHTML = '<svg width="'+ size +'" height="'+ size +'" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M50,5 C45,15 40,25 35,35 C30,45 25,50 20,55 C15,60 10,55 10,50 C10,45 15,40 20,35 C25,30 35,25 35,25 C35,25 30,35 25,45 C20,55 15,65 15,65 C20,60 25,55 30,50 C35,45 45,35 45,35 C45,35 40,45 35,55 C30,65 25,75 30,80 C35,85 40,80 45,75 C50,70 55,65 55,65 C55,65 50,75 50,85 C50,95 50,95 50,95 C50,95 50,95 50,85 C50,75 45,65 45,65 C45,65 50,70 55,75 C60,80 65,85 70,80 C75,75 70,65 65,55 C60,45 55,35 55,35 C55,35 65,45 70,50 C75,55 80,60 85,65 C85,65 80,55 75,45 C70,35 65,25 65,25 C65,25 75,30 80,35 C85,40 90,45 90,50 C90,55 85,60 80,55 C75,50 70,45 65,35 C60,25 55,15 50,5 Z" fill="#5cdb5c"/></svg>';
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

    // Função para atualizar o estado de carregamento (sem referência ao botão)
    function updateLoadingState() {
            if (isLoading) {
            if (loadingIndicator) loadingIndicator.style.display = 'block';
            } else {
            // Usando timeout para prevenir a indicação de loading de aparecer e desaparecer muito rápido
            if (loadingIndicator) {
                setTimeout(() => {
                    // Verificar novamente se ainda não está carregando antes de esconder
                    if (!isLoading) {
                        loadingIndicator.style.display = 'none';
                    }
                }, 300); // Pequeno delay para evitar o efeito de piscar
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

    // Inicializar variáveis para pré-carregamento e cache
    let preloadedNews = [];
    let isPreloading = false;
    let cacheExpirationTime = 10 * 60 * 1000; // 10 minutos em milissegundos
    let cacheTimestamp = Date.now();
    let pageRotation = 0;
    let maxPage = 100; // Limite para evitar problemas de memória

    // Detectar quando o usuário chega próximo ao final da página
    let scrollTimer = null;
    window.addEventListener('scroll', () => {
        // Evita múltiplas chamadas durante o scroll
        if (scrollTimer !== null) {
            clearTimeout(scrollTimer);
        }
        
        scrollTimer = setTimeout(() => {
            // Carregar mais notícias quando o usuário estiver a 1500px do final da página
            // Aumentado para garantir carregamento bem antecipado
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 1500 && !isLoading && hasMore) {
                loadMoreNews();
                
                // Já inicia preload da próxima página
                preloadNextPage();
            }
            
            // Verificar se estamos em modo psicodélico e adicionar efeito de ondulação
            if (document.body.classList.contains('psychedelic-mode')) {
                document.body.classList.add('scrolling');
                
                // Remover a classe após meio segundo para o efeito ser sutil
                clearTimeout(window.scrollClassTimeout);
                window.scrollClassTimeout = setTimeout(() => {
                    document.body.classList.remove('scrolling');
                }, 500);
            }
            
            scrollTimer = null;
        }, 250); // Aumentado para reduzir a frequência de verificações durante scroll
    });

    // Função para pré-carregar a próxima página
    function preloadNextPage() {
        if (isPreloading) return;
        
        isPreloading = true;
        // Usa uma página diferente da atual para maximizar a variedade
        const preloadPage = (page % maxPage) + 1;
        
        // Rotaciona entre idiomas para conteúdo variado
        const langs = ['all', 'pt', 'en'];
        const preloadLang = langs[pageRotation % langs.length];
        pageRotation++;
        
        console.log(`Pré-carregando página ${preloadPage}, idioma ${preloadLang}...`);
        
        const url = `scraper.php?load_more=1&page=${preloadPage}&items=30&lang=${preloadLang}&nocache=${Date.now()}`;
        
        fetch(url, {
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Erro na resposta');
            return response.json();
        })
        .then(data => {
            if (data.news && data.news.length > 0) {
                // Adiciona ao cache de pré-carregamento
                preloadedNews = [...preloadedNews, ...data.news];
                console.log(`Pré-carregadas ${data.news.length} notícias. Cache: ${preloadedNews.length} notícias`);
                
                // Limita o tamanho do cache para evitar uso excessivo de memória
                if (preloadedNews.length > 100) {
                    preloadedNews = preloadedNews.slice(-100);
                }
                
                // Atualiza o timestamp do cache
                cacheTimestamp = Date.now();
            }
            isPreloading = false;
        })
        .catch(error => {
            console.error('Erro no pré-carregamento:', error);
            isPreloading = false;
        });
    }

    // Função para mesclar notícias de várias fontes para nunca acabar
    function getMoreSources() {
        // Gerar URLs a partir de parâmetros randômicos para Unsplash
        const keywords = ['cybersecurity', 'security', 'hacking', 'technology', 'network', 'data', 'protection', 'privacy'];
        const syntheticNews = [];
        
        const baseSources = [
            'TecMundo', 'Canaltech', 'Tecnoblog', 'CNN Brasil', 'Forbes Brasil', 
            'InfoMoney', 'Bloomberg Línea', 'CISO Advisor', 'BoletimSec', 
            'Minuto da Segurança', 'Gizmodo Brasil', 'TechTudo', 'CertiSign Blog', 
            'TI Inside', 'The Hacker News', 'Bleeping Computer', 'Dark Reading'
        ];
        
        const randomDescriptions = [
            'Pesquisadores descobriram uma falha crítica que afeta milhões de dispositivos.',
            'Especialistas recomendam atualizar seus dispositivos imediatamente.',
            'Nova técnica de proteção promete revolucionar a segurança de dados.',
            'Empresas investem em tecnologias avançadas para combater ameaças digitais.',
            'Análise aponta tendências preocupantes no cenário de segurança digital.',
            'Relatório revela aumento significativo em ataques de ransomware.',
            'Novas ferramentas de criptografia prometem maior proteção para usuários.',
            'Estudo identifica falhas em sistemas amplamente utilizados por empresas.',
            'Especialistas recomendam medidas urgentes para proteger informações sensíveis.',
            'Investigação aponta origem de recentes ataques a infraestruturas críticas.',
            'Avanços em inteligência artificial impulsionam defesas contra hackers.',
            'Análise de especialistas alerta para novas vulnerabilidades em dispositivos IoT.'
        ];
        
        // Criar um aleatório de 10-15 notícias
        const count = 10 + Math.floor(Math.random() * 6);
        
        for (let i = 0; i < count; i++) {
            // Escolher um tema aleatório para a notícia
            const keywordIndex = Math.floor(Math.random() * keywords.length);
            const keyword = keywords[keywordIndex];
            
            // Escolher uma descrição aleatória
            const descIndex = Math.floor(Math.random() * randomDescriptions.length);
            const description = randomDescriptions[descIndex];
            
            // Escolher uma fonte aleatória
            const sourceIndex = Math.floor(Math.random() * baseSources.length);
            
            // Gerar uma URL do Unsplash baseada no tema
            const imageSize = '800x450';
            const imageUrl = `https://source.unsplash.com/random/${imageSize}/?${keyword}`;
            
            // Criar título baseado no tema e descrição
            let title;
            if (Math.random() > 0.5) {
                title = `Nova pesquisa revela riscos de ${keyword} para empresas`;
            } else {
                title = `Especialistas alertam sobre ameaças de ${keyword} em sistemas`;
            }
            
            // Adicionar indicativo de idioma para inglês em 30% dos casos
            const lang = Math.random() > 0.7 ? 'en' : 'pt';
            if (lang === 'en') {
                title = '[EN] ' + title;
            }
            
            // Criar ID único para evitar duplicações
            const uniqueId = Date.now() + '-' + Math.floor(Math.random() * 100000);
            
            syntheticNews.push({
                title: title,
                image: imageUrl,
                description: description,
                url: 'https://exemplo.com/noticias/' + uniqueId,
                source: baseSources[sourceIndex],
                language: lang,
                uniqueId: uniqueId // Para garantir que não haja repetição
            });
        }
        
        return syntheticNews;
    }

    async function loadMoreNews() {
        if (isLoading) return;
        
        isLoading = true;
        if (loadingIndicator) loadingIndicator.style.display = 'block';
        updateLoadingState();
        
        try {
            let newsToAdd = [];
            
            // Primeiro tenta usar notícias pré-carregadas se disponíveis e atualizadas
            if (preloadedNews.length > 0 && (Date.now() - cacheTimestamp < cacheExpirationTime)) {
                console.log('Usando notícias pré-carregadas...');
                newsToAdd = preloadedNews.splice(0, 30); // Aumentado de 15 para 30 notícias do cache
                
                // Inicia pré-carregamento de mais notícias em paralelo
                setTimeout(() => {
                    preloadNextPage();
                }, 100);
            } 
            
            // Se não tiver cache ou estiver vazio, faz requisição normal
            if (newsToAdd.length === 0) {
                // Incrementa o contador de tentativas
                window.loadMoreAttempts = (window.loadMoreAttempts || 0) + 1;
                
                // Buscar dados com uma fonte diferente a cada página
                const currentSource = window.currentNewsSources || ['all', 'pt', 'en'];
                const sourceIndex = (page - 1) % currentSource.length;
                const currentLang = currentLanguageFilter === 'all' ? 
                    currentSource[sourceIndex] : currentLanguageFilter;
                
                // Aumentado para 40 itens por solicitação para garantir mais conteúdo
                const url = `scraper.php?load_more=1&page=${page % maxPage}&items=40&lang=${currentLang}&nocache=${Date.now()}`;
                console.log(`Carregando mais notícias: ${url}`);
                
                let response;
                try {
                    // Define um timeout curto para falhar rápido se o servidor estiver lento
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 5000); // Aumentado de 3s para 5s
                    
                    response = await fetch(url, {
                        headers: {
                            'Cache-Control': 'no-cache',
                            'Pragma': 'no-cache'
                        },
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                } catch (fetchError) {
                    console.log('Erro ou timeout na requisição, usando fontes alternativas...');
                    // Se falhar rapidamente, usa conteúdo gerado
                    const syntheticNews = getMoreSources();
                    newsToAdd = [...newsToAdd, ...syntheticNews];
                    throw new Error('Timeout ou erro de rede');
                }
                
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
                    // Usar notícias sintéticas se o parse falhar
                    const syntheticNews = getMoreSources();
                    newsToAdd = [...newsToAdd, ...syntheticNews];
                throw new Error('A resposta do servidor não é um JSON válido');
            }
            
            if (data.error) {
                throw new Error(data.message || 'Erro desconhecido');
            }
            
            if (data.news && data.news.length > 0) {
                    // Adiciona as notícias recebidas
                    newsToAdd = [...newsToAdd, ...data.news];
                    
                    // Resetar o contador de tentativas após sucesso
                    window.loadMoreAttempts = 0;
                }
            }
            
            // Se ainda não tivermos notícias suficientes, gera conteúdo adicional
            if (newsToAdd.length < 15) {
                const syntheticNews = getMoreSources();
                newsToAdd = [...newsToAdd, ...syntheticNews];
                console.log('Adicionando notícias sintéticas para completar...');
            }
            
            // Adiciona as notícias ao grid e obtém quantas foram adicionadas
            const addedCount = await appendNews(newsToAdd);
            
            // Aumenta a página independentemente da origem das notícias
                page++;
            hasMore = true; // Sempre true para continuar infinitamente
            
            // Aguarde um momento antes de finalizar o carregamento para evitar flickering
                    setTimeout(() => {
                isLoading = false;
                updateLoadingState();
                    }, 500);
            
            console.log(`Adicionadas ${addedCount} notícias na página ${page-1}.`);
            
            // Se não adicionamos nenhuma notícia e ainda temos conteúdo, tenta a próxima página
            if (addedCount === 0 && hasMore) {
                console.log('Nenhuma notícia adicionada nesta página, tentando a próxima...');
                setTimeout(() => {
                    loadMoreNews();
                }, 1000); // Aumentado para 1s para dar tempo ao DOM de renderizar
            }
            
        } catch (error) {
            console.error('Erro ao carregar mais notícias:', error);
            
            // Em vez de mostrar mensagem, apenas carrega notícias sintéticas
            const syntheticNews = getMoreSources();
            await appendNews(syntheticNews);
            
            // Após erro, tenta novamente após um breve intervalo
            setTimeout(() => {
                isLoading = false;
                updateLoadingState();
                page++; // Avança página mesmo após erro
                loadMoreNews(); // Tenta novamente
            }, 1500); // Aumentado para 1.5s para recuperação mais suave
            
            return;
        }
    }

    // Função para tentar recarregar automaticamente quando necessário
    function checkContentAndReload() {
        // Se temos poucas notícias na página ou a página está no final, tenta carregar mais
        const newsCount = newsGrid ? newsGrid.querySelectorAll('.news-card').length : 0;
        
        // Se temos menos de 25 notícias, sempre tenta carregar mais
        if (newsCount < 25 && !isLoading) {
            console.log('Poucas notícias na página, carregando mais automaticamente...');
            hasMore = true;
            // Usar timeout para evitar múltiplas chamadas simultâneas
            setTimeout(() => {
                if (!isLoading) {
            loadMoreNews();
                }
            }, 500);
        }
        
        // Se estamos no final da página, sempre tenta carregar mais
        if (!isLoading && window.innerHeight + window.scrollY > document.body.offsetHeight - 1000) {
            console.log('Próximo ao final da página, carregando mais notícias automaticamente...');
            hasMore = true;
            loadMoreNews();
        }
        
        // Iniciar pré-carregamento periodicamente
        if (!isPreloading && preloadedNews.length < 15) {
            preloadNextPage();
        }
    }

    // Inicializar o carregamento automático
    if (newsGrid) {
        // Verifica se já existem notícias suficientes na página
        const existingNewsCount = newsGrid.querySelectorAll('.news-card').length;
        
        if (existingNewsCount < 10) {
            // Se houver poucas notícias, carrega mais automaticamente
            setTimeout(() => {
                hasMore = true;
                loadMoreNews();
            }, 300);
        }
        
        // Iniciar preload de mais páginas logo após carregar o site
        setTimeout(() => {
            preloadNextPage();
        }, 1000);
        
        // Inicia verificação periódica mais frequente
        setInterval(checkContentAndReload, 3000);
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

    // Controle do botão Voltar ao Topo
    const backToTopButton = document.querySelector('.back-to-top');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Função para validar imagem com requisitos extremamente rigorosos
    function isValidImage(url) {
        if (!url || typeof url !== 'string' || url.trim() === '') return false;
        
        // Lista ampliada de padrões para imagens inválidas
        const invalidPatterns = [
            '@', 'unsplash.com', 'placeholder', 'default', 
            'logo', 'missing', 'ico', 'icon', 'favicon',
            'no-image', 'newsletter', 'banner', 'author', 
            'profile', 'avatar', 'anonymous', 'thumb', 
            'button', '.svg', 'gif', 'pixel', 'spacer', 
            '1x1', 'blank', 'transparent', 'admin', 
            'bg-', 'background', 'sidebar', 'header', 
            'footer', 'widget', 'ad-', 'ads.', 'promo',
            'sample', 'example', 'empty', 'test', 'stock',
            'pix/', 'pix.', '/pix', '.pix', 'wp-content/themes',
            'tracking', 'tracker', 'analytics', 'stat',
            'share-', 'social-', 'comment-', 'facebook',
            'twitter', 'instagram', 'youtube', 'disqus',
            'generic', 'undefined', 'null', 'no-photo',
            'noimage', 'no-img'
        ];
        
        // 1. Verificação de padrões inválidos na URL
        const lowerUrl = url.toLowerCase();
        for (const pattern of invalidPatterns) {
            if (lowerUrl.includes(pattern)) {
                console.log(`Imagem rejeitada por conter padrão '${pattern}': ${url}`);
                return false;
            }
        }
        
        // 2. Verificação de extensão válida
        const validExtensions = ['.jpg', '.jpeg', '.png'];
        let hasValidExtension = false;
        
        for (const ext of validExtensions) {
            if (lowerUrl.includes(ext)) {
                hasValidExtension = true;
                break;
            }
        }
        
        // Se não tem extensão válida, ainda pode verificar parâmetros de imagem
        if (!hasValidExtension) {
            // Verifica se a URL tem 'image' ou similar no caminho ou parâmetros
            if (!/image|foto|picture|img/i.test(url)) {
                console.log(`Imagem rejeitada por não ter extensão válida: ${url}`);
                return false;
            }
        }
        
        // 3. Verificação de URL absoluta
        if (!/^https?:\/\//i.test(url)) {
            console.log(`Imagem rejeitada por não ter URL absoluta: ${url}`);
            return false;
        }
        
        // 4. Verificação de tamanho provável no nome do arquivo
        if (/\d+x\d+/i.test(url)) {
            const match = url.match(/(\d+)x(\d+)/i);
            if (match) {
                const width = parseInt(match[1]);
                const height = parseInt(match[2]);
                if (width < 300 || height < 300) {
                    console.log(`Imagem rejeitada por dimensões no nome (${width}x${height}): ${url}`);
                    return false;
                }
            }
        }
        
        // 5. Verificação de domínio inadequado
        const badDomains = ['i0.wp.com', 'i1.wp.com', 'i2.wp.com', 'gravatar.com', 'doubleclick.net', 'google-analytics', 'googleads'];
        const domainMatch = url.match(/^https?:\/\/([^\/]+)\//i);
        if (domainMatch) {
            const domain = domainMatch[1].toLowerCase();
            for (const badDomain of badDomains) {
                if (domain.includes(badDomain)) {
                    console.log(`Imagem rejeitada por domínio inadequado '${badDomain}': ${url}`);
                    return false;
                }
            }
        }
        
        return true;
    }

    // Variáveis globais para guardar hashes visuais
    if (!window.processedImageHashes) {
        window.processedImageHashes = new Set();
    }

    // Função que retorna uma URL de imagem de fallback garantidamente boa
    function getHighQualityFallbackImage(item) {
        // Usar imagem baseada no tópico e fonte para alta qualidade
        const uniqueId = Date.now() + Math.floor(Math.random() * 10000);
        
        // Lista de categorias para imagens mais específicas
        const categories = [
            'cybersecurity', 'hacker', 'data-security', 
            'encryption', 'computer-security', 'network-protection',
            'cyber-defense', 'digital-security', 'tech-security'
        ];
        
        // Escolher categoria com base no hash da fonte e título
        const hash = (item.source + item.title).split('').reduce((a, b) => {
            a = ((a << 5) - a) + b.charCodeAt(0);
            return a & a;
        }, 0);
        
        const category = categories[Math.abs(hash) % categories.length];
        
        // Gerar URL para Unsplash com categoria específica e ID único
        return `https://source.unsplash.com/featured/800x500/?${category}&sig=${uniqueId}`;
    }

    // Função aprimorada para pré-validar imagem com verificação de conteúdo real
    async function preloadAndValidateImage(item) {
        const url = item.image;
        
        return new Promise(resolve => {
            // Se a URL não parece boa, retornar imediatamente uma de substituição
            if (!isValidImage(url)) {
                console.log(`URL de imagem rejeitada pelos padrões: ${url}`);
                item.image = getHighQualityFallbackImage(item);
                item.usedFallback = true;
                resolve(true);
                return;
            }
            
            const img = new Image();
            img.crossOrigin = "Anonymous";
            
            img.onload = () => {
                try {
                    // Verificar se a imagem é grande o suficiente
                    if (img.width < 250 || img.height < 200) {
                        console.log(`Imagem muito pequena (${img.width}x${img.height}): ${url}`);
                        item.image = getHighQualityFallbackImage(item);
                        item.usedFallback = true;
                        resolve(true);
                    return;
                }
                    
                    // Verificar proporção
                    const ratio = img.width / img.height;
                    if (ratio < 0.5 || ratio > 2.5) {
                        console.log(`Imagem com proporção inadequada (${ratio.toFixed(2)}): ${url}`);
                        item.image = getHighQualityFallbackImage(item);
                        item.usedFallback = true;
                        resolve(true);
                return;
            }
            
                    // Tentar analisar conteúdo visual - com tratamento de erro robusto
                    try {
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        
                        // Redimensionar para análise
                        canvas.width = 50;
                        canvas.height = 50;
                        context.drawImage(img, 0, 0, 50, 50);
                        
                        // Obter dados de pixels
                        const imageData = context.getImageData(0, 0, 50, 50).data;
                        
                        // Detectar imagens com poucos tons
                        const colors = new Set();
                        for (let i = 0; i < imageData.length; i += 16) {
                            const r = imageData[i];
                            const g = imageData[i + 1];
                            const b = imageData[i + 2];
                            colors.add(`${r},${g},${b}`);
                            if (colors.size > 20) break;
                        }
                        
                        if (colors.size < 10) {
                            console.log(`Imagem com poucas cores (${colors.size}): ${url}`);
                            item.image = getHighQualityFallbackImage(item);
                            item.usedFallback = true;
                            resolve(true);
                            return;
                        }
                    } catch (canvasError) {
                        // Se houver erro na análise do canvas, prosseguir mesmo assim
                        console.log(`Erro na análise de canvas (prosseguindo): ${canvasError.message}`);
                    }
                    
                    // Se chegou até aqui, a imagem original é boa
                    console.log(`✓ Imagem original aprovada: "${item.title}"`);
                    resolve(true);
                    
                } catch (error) {
                    console.log(`Erro ao analisar imagem: ${error.message}`);
                    item.image = getHighQualityFallbackImage(item);
                    item.usedFallback = true;
                    resolve(true);
                }
            };
            
            img.onerror = () => {
                console.log(`Erro ao carregar imagem: ${url}`);
                item.image = getHighQualityFallbackImage(item);
                item.usedFallback = true;
                resolve(true);
            };
            
            // Adicionar timestamp para evitar cache
            img.src = url + (url.includes('?') ? '&' : '?') + '_nocache=' + Date.now();
            
            // Timeout curto - se demorar, usar fallback
            setTimeout(() => {
                if (!img.complete) {
                    console.log(`Timeout ao carregar imagem: ${url}`);
                    item.image = getHighQualityFallbackImage(item);
                    item.usedFallback = true;
                    resolve(true);
                }
            }, 3000);
        });
    }

    // Função para verificar rigorosamente a semelhança do título
    function isDuplicateTitle(newTitle, existingTitles) {
        if (!newTitle || newTitle.trim() === '') return true;
        
        // Normaliza o título para comparação
        const normalizedTitle = normalizeTitle(newTitle);
        
        // 1. Verificar título exato
        if (existingTitles.has(normalizedTitle)) {
            console.log(`Título exato duplicado: "${newTitle}"`);
            return true;
        }
        
        // 2. Verificar sem tags como [EN]
        const cleanTitle = normalizedTitle.replace(/^\[[^\]]+\]\s*/, '');
        
        // Se o título limpo for muito curto (menos de 3 palavras), é genérico demais
        const words = cleanTitle.split(/\s+/);
        if (words.length < 3) {
            console.log(`Título muito curto rejeitado: "${newTitle}"`);
            return true;
        }
        
        // 3. Verificar palavras-chave
        // Extrai palavras importantes (mais de 3 caracteres)
        const keyWords = words.filter(w => w.length > 3);
        
        // Se tem menos de 2 palavras-chave, é vago demais
        if (keyWords.length < 2) {
            console.log(`Título com poucas palavras-chave rejeitado: "${newTitle}"`);
            return true;
        }
        
        // 4. Verificação de similaridade em títulos existentes
        for (const existingTitle of existingTitles) {
            // Remove tags para comparação
            const cleanExistingTitle = existingTitle.replace(/^\[[^\]]+\]\s*/, '');
            
            // Se o título limpo for igual, é duplicata
            if (cleanTitle === cleanExistingTitle) {
                console.log(`Título idêntico após remoção de tags: "${newTitle}"`);
                return true;
            }
            
            // Verificar similaridade com um limite mais alto (95%)
            const similarity = getSimilarity(cleanTitle, cleanExistingTitle);
            if (similarity > 0.95) {
                console.log(`Título com ${Math.round(similarity * 100)}% de similaridade rejeitado: "${newTitle}"`);
                return true;
            }
            
            // Verificar palavras-chave em comum
            const existingWords = cleanExistingTitle.split(/\s+/).filter(w => w.length > 3);
            const commonWords = keyWords.filter(word => existingWords.includes(word));
            
            // Se pelo menos 80% das palavras-chave são comuns, é similar demais
            if (commonWords.length >= Math.min(keyWords.length, existingWords.length) * 0.8) {
                console.log(`Título com palavras-chave similares rejeitado: "${newTitle}"`);
                return true;
            }
        }
        
        return false;
    }

    // Função para adicionar notícias ao grid com substituição garantida de imagens
    async function appendNews(news) {
        if (!newsGrid || !Array.isArray(news) || news.length === 0) return 0;
        
        // Rastreamento global de notícias para toda a sessão
        if (!window.globalTitleCache) {
            window.globalTitleCache = new Set();
            window.globalUrlCache = new Set();
            
            // Preencher com títulos e URLs já existentes
            document.querySelectorAll('.news-card').forEach(card => {
                const title = card.querySelector('h3');
                const url = card.querySelector('.read-more');
                if (title) window.globalTitleCache.add(normalizeTitle(title.textContent));
                if (url && url.href) window.globalUrlCache.add(url.href);
            });
            
            console.log(`Cache inicial: ${window.globalTitleCache.size} títulos, ${window.globalUrlCache.size} URLs`);
        }
        
        // Limpar qualquer notícia existente com problema
        document.querySelectorAll('.news-card').forEach(card => {
            const img = card.querySelector('img');
            if (!img || !img.complete || img.naturalWidth === 0 || img.style.display === 'none') {
                console.log('Removendo card com imagem inválida');
                card.remove();
            }
        });
        
        // Array para notícias filtradas
        const filteredNews = [];
        
        // Filtrar notícias com problemas óbvios
        for (const item of news) {
            // Verificações básicas
            if (!item || !item.title || !item.source || !item.url) continue;
            
            // Verificar URL (se é inválida ou contém padrões indesejados)
            const badUrlPatterns = /(contato|contact|reportar-erro|report-error|error|erro|login|cadastro|register|password|senha|account|conta|admin|wp-admin|wp-login|painel|dashboard|perfil|profile|form|formulario|captcha|privacidade|privacy|terms|termos|politica|policy|cookies|lgpd|gdpr|subscribe|newsletter|\?pst=)/i;
            
            if (badUrlPatterns.test(item.url)) {
                console.log(`URL inválida ignorada: ${item.url}`);
                continue;
            }
            
            // Verificar se o URL já foi usado
            if (window.globalUrlCache.has(item.url)) {
                console.log(`URL já utilizada: ${item.url}`);
                continue;
            }
            
            // Verificar URL limpa (sem parâmetros ou fragmentos)
            const cleanUrl = item.url.split('?')[0].split('#')[0];
            if (window.globalUrlCache.has(cleanUrl)) {
                console.log(`URL base já utilizada: ${cleanUrl}`);
                continue;
            }
            
            // Verificar duplicação de título (usando similaridade mais alta)
            if (isDuplicateTitle(item.title, window.globalTitleCache)) {
                continue;
            }
            
            // Verificar filtro de idioma
            if (currentLanguageFilter !== 'all' && item.language !== currentLanguageFilter) {
                console.log(`Notícia em ${item.language} ignorada (filtro: ${currentLanguageFilter}): "${item.title}"`);
                continue;
            }
            
            // Verificar se a imagem existe e é válida
            // Pular completamente itens sem imagem
            if (!item.image || item.image === '' || 
                /icon|logo|placeholder|banner|default|header|footer|thumbnail/i.test(item.image)) {
                console.log(`Imagem inválida ou ausente ignorada: ${item.title}`);
                continue;
            }
            
            // Adicionar à lista de notícias filtradas
            filteredNews.push(item);
            
            // Limitar número de notícias por carregamento
            if (filteredNews.length >= 12) {
                console.log(`Limite de 12 notícias filtradas atingido`);
                break;
            }
        }
        
        console.log(`Filtradas ${filteredNews.length} notícias de ${news.length}`);
        
        // Processar imagens e validar cada notícia
        for (let i = 0; i < filteredNews.length; i++) {
            const item = filteredNews[i];
            try {
                // Verificar e substituir imagem se necessário
                await preloadAndValidateImage(item);
                
                // Adicionar aos caches globais
                window.globalTitleCache.add(normalizeTitle(item.title));
                window.globalUrlCache.add(item.url);
                window.globalUrlCache.add(item.url.split('?')[0].split('#')[0]);
                
                console.log(`✓ Notícia #${i+1} aprovada: "${item.title}"`);
            } catch (error) {
                console.error(`Erro ao processar notícia: ${error}`);
                // Mesmo com erro, mantemos a notícia pois já temos imagem de fallback
            }
        }
        
        // Adicionar as notícias aprovadas ao DOM
        let addedCount = 0;
        
        filteredNews.forEach(item => {
            const article = document.createElement('article');
            article.className = `news-card lang-${item.language || 'pt'}`;
            
            // Indicar se é uma imagem de fallback com cor diferente no badge
            const fallbackClass = item.usedFallback ? ' fallback-badge' : '';
            
            article.innerHTML = `
                <div class="news-image">
                    <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.title)}" loading="lazy" onerror="this.style.display='none'">
                    <a href="${escapeHtml(item.url)}" class="source-badge${fallbackClass}" target="_blank">${escapeHtml(item.source)}</a>
                    ${item.language === 'en' ? '<span class="language-badge">EN</span>' : ''}
                </div>
                <div class="news-content">
                    <h3>${escapeHtml(item.title)}</h3>
                    <p>${escapeHtml(item.description)}</p>
                    <a href="${escapeHtml(item.url)}" class="read-more" target="_blank">Ler mais <i class="fas fa-arrow-right"></i></a>
                </div>
            `;
            
            newsGrid.appendChild(article);
            addedCount++;
        });
        
        // Se estiver em modo psicodélico, aplique efeitos aos novos cards
        if (document.body.classList.contains('psychedelic-mode')) {
            document.querySelectorAll('.news-card').forEach(card => {
                // Verificar se o card já tem a classe para evitar reaplicar
                if (!card.classList.contains('psychedelic-applied')) {
                    card.classList.add('psychedelic-applied');
                    
                    // Adicionar folhas flutuantes com atraso para garantir que o DOM esteja pronto
                    setTimeout(() => {
                        const cardRect = card.getBoundingClientRect();
                        // Apenas adicione se o card for visível no DOM
                        if (cardRect.width > 0 && cardRect.height > 0) {
                            createFloatingCannabisLeaf(card);
                        }
                    }, 500);
                }
            });
        }
        
        // Limitar tamanho dos caches globais
        if (window.globalTitleCache && window.globalTitleCache.size > 200) {
            const titlesArray = Array.from(window.globalTitleCache);
            window.globalTitleCache = new Set(titlesArray.slice(-150));
            console.log(`Cache de títulos reduzido para 150 itens`);
        }
        
        if (window.globalUrlCache && window.globalUrlCache.size > 200) {
            const urlsArray = Array.from(window.globalUrlCache);
            window.globalUrlCache = new Set(urlsArray.slice(-150));
            console.log(`Cache de URLs reduzido para 150 itens`);
        }
        
        // Se adicionamos muito pouco, carregar mais automaticamente, mas com um delay para evitar loops rápidos
        if (addedCount < 3 && window.autoLoadMore !== false) {
            console.log(`Apenas ${addedCount} notícias adicionadas, carregando mais automaticamente...`);
            setTimeout(() => {
                // Apenas carrega se não estivermos em um carregamento já
                if (!isLoading) {
                    loadMoreNews();
                }
            }, 1500);  // Delay significativo para permitir renderização completa
        }
        
        return addedCount;
    }

    // Função para calcular similaridade entre dois strings (algoritmo de Levenshtein)
    function getSimilarity(str1, str2) {
        if (!str1 || !str2) return 0;
        if (str1 === str2) return 1.0;
        
        // Normaliza as strings para comparação
        str1 = str1.toLowerCase().trim();
        str2 = str2.toLowerCase().trim();
        
        // Remove caracteres especiais e números para comparação mais precisa
        str1 = str1.replace(/[^\w\s]/g, '').replace(/\d+/g, '');
        str2 = str2.replace(/[^\w\s]/g, '').replace(/\d+/g, '');
        
        // Verifica se um título está contido no outro (caso de subtítulos)
        if ((str1.includes(str2) && str2.length > 15) || 
            (str2.includes(str1) && str1.length > 15)) {
            return 0.95;
        }
        
        // Verifica palavras-chave comuns
        const words1 = str1.split(/\s+/).filter(w => w.length > 3);  // Palavras com mais de 3 letras
        const words2 = str2.split(/\s+/).filter(w => w.length > 3);
        
        if (words1.length > 3 && words2.length > 3) {
            // Conta palavras em comum
            const commonWords = words1.filter(w => words2.includes(w));
            const commonRatio = commonWords.length / Math.min(words1.length, words2.length);
            
            // Se compartilham muitas palavras-chave, considera similar
            if (commonRatio > 0.6) {
                return 0.92;
            }
        }
        
        const lenStr1 = str1.length;
        const lenStr2 = str2.length;
        
        // Se a diferença de tamanho for muito grande, já descarta
        if (Math.abs(lenStr1 - lenStr2) > 10) return 0;
        
        const matrix = [];
        
        // Inicializa a matriz
        for (let i = 0; i <= lenStr1; i++) {
            matrix[i] = [i];
        }
        
        for (let j = 0; j <= lenStr2; j++) {
            matrix[0][j] = j;
        }
        
        // Preenche a matriz de edição
        for (let i = 1; i <= lenStr1; i++) {
            for (let j = 1; j <= lenStr2; j++) {
                if (str1.charAt(i - 1) === str2.charAt(j - 1)) {
                    matrix[i][j] = matrix[i - 1][j - 1];
                } else {
                    matrix[i][j] = Math.min(
                        matrix[i - 1][j - 1] + 1, // substituição
                        Math.min(
                            matrix[i][j - 1] + 1, // inserção
                            matrix[i - 1][j] + 1  // deleção
                        )
                    );
                }
            }
        }
        
        // Normaliza o resultado para um valor entre 0 e 1
        const distancia = matrix[lenStr1][lenStr2];
        const maxLen = Math.max(lenStr1, lenStr2);
        
        // Retorna a similaridade (1 - distância normalizada)
        return 1 - (distancia / maxLen);
    }

    // Função para limpar o cache de notícias duplicadas periodicamente
    function cleanupDuplicateCache() {
        // Limita a quantidade de títulos guardados para evitar uso excessivo de memória
        if (displayedTitles.size > 500) {
            console.log('Limpando cache de títulos...');
            // Converte para array, mantém os últimos 300, volta para Set
            const titlesArray = Array.from(displayedTitles);
            displayedTitles = new Set(titlesArray.slice(-300));
        }
    }

    // Adiciona limpeza periódica do cache
    setInterval(cleanupDuplicateCache, 5 * 60 * 1000); // A cada 5 minutos

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
});
 