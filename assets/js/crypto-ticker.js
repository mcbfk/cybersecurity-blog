// assets/js/crypto-ticker.js

document.addEventListener('DOMContentLoaded', function() {
    function updateCryptoTicker() {
      const tickerElement = document.getElementById('crypto-ticker');
      // Dados fixos para simulação. Em produção, utilize AJAX/fetch para obter dados reais.
      const cryptoData = "BTC: $45,000 | ETH: $3,000 | LTC: $180";
      tickerElement.innerHTML = cryptoData;
    }
  
    updateCryptoTicker();
    setInterval(updateCryptoTicker, 60000); // Atualiza a cada 60 segundos
  });
  