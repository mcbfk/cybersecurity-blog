// assets/js/news-updater.js

document.addEventListener('DOMContentLoaded', function() {
    function updateNews() {
      const newsElement = document.getElementById('news-updater');
      // Aqui você pode implementar uma chamada AJAX para atualizar as notícias em tempo real.
      // No momento, o conteúdo é carregado via PHP no index.php.
    }
  
    updateNews();
    setInterval(updateNews, 120000); // Atualiza a cada 120 segundos, caso seja implementada a atualização via JS
  });
  
  // assets/js/news-updater.js

document.addEventListener('DOMContentLoaded', function() {
  function updateNews() {
      const newsElement = document.getElementById('news-updater');
      
      fetch('inc/news-updater.php') // Chama o PHP que retorna as notícias
          .then(response => response.text())
          .then(data => {
              newsElement.innerHTML = data; // Atualiza o conteúdo da div com as notícias
          })
          .catch(error => {
              console.error('Erro ao buscar notícias:', error);
              newsElement.innerHTML = 'Erro ao carregar notícias.';
          });
  }

  updateNews();
  setInterval(updateNews, 120000); // Atualiza a cada 120 segundos
});
