let pais = 'Brazil'; // Inicialize com um valor padrão para evitar undefined.
let chartInstance = null; // Variável para armazenar a instância do gráfico
let lastAccessDate = '';
let lastAccessCountry = '';

function atualizarValor() {
  // Captura o valor selecionado e atualiza a variável global
  const selectElement = document.getElementById('opcoes');
  pais = selectElement.value;

  // Chama a função para buscar dados com o valor selecionado
  fetchData(pais);
  fetchAcessData();
}

// Função para buscar os dados da API de Covid
async function fetchData(pais) {
  try {
    const url = 'http://localhost:80/api/v1/covid-data?country=' + pais;
    const response = await fetch(url);
    const data = await response.json();
    const estados = data.data.data;
    
    // Preparando os dados para o gráfico
    const labels = estados.map(item => item.ProvinciaEstado || 'Desconhecido');
    const confirmados = estados.map(item => item.Confirmados || 0);
    const mortos = estados.map(item => item.Mortos || 0);

    // Exibindo o gráfico
    renderChart(labels, confirmados, mortos, pais);
  } catch (error) {
    console.error('Erro ao buscar dados da API:', error);
    document.getElementById('loading').innerText = 'Erro ao carregar os dados.';
  }
}

function renderChart(labels, confirmados, mortos, pais) {
  const ctx = document.getElementById('covidChart').getContext('2d');

  // Se já existe um gráfico, destrua-o antes de criar um novo
  if (chartInstance) {
    chartInstance.destroy();
  }

  // Escala para aumentar a visibilidade dos mortos
  const mortosEscalados = mortos.map(valor => valor * 20); // Aumentar ainda mais os valores de mortos para melhor visualização

  // Criação de um novo gráfico
  chartInstance = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Confirmados',
          data: confirmados,
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
        },
        {
          label: 'Mortos',
          data: mortosEscalados,
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          callbacks: {
            label: function (context) {
              // Ajustar o rótulo para exibir os valores reais (sem escala)
              if (context.dataset.label === 'Mortos') {
                const realValue = context.raw / 20; // Valor original sem escala
                return `${context.dataset.label}: ${new Intl.NumberFormat('pt-BR').format(realValue)}`;
              }
              return `${context.dataset.label}: ${new Intl.NumberFormat('pt-BR').format(context.raw)}`;
            }
          }
        },
        title: {
          display: true,
          text: 'Covid-19 Dados por Estado - ' + pais
        },
        legend: {
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function (value) {
              return new Intl.NumberFormat('pt-BR').format(value);
            }
          },
          title: {
            display: true,
            text: 'Números (Escala aplicada apenas aos mortos)'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Estados'
          }
        }
      }
    }
  });

  // Remover a mensagem de "Carregando"
  document.getElementById('loading').style.display = 'none';
}

// Função para buscar os dados de acesso
async function fetchAcessData() {
  try {
    const url = 'http://localhost:80/api/v1/acess-data';
    const response = await fetch(url);
    const data = await response.json();

    const lastAccess = data.data.data;
    lastAccessDate = lastAccess.date;
    lastAccessCountry = lastAccess.country;

    // Exibir no rodapé
    updateFooter();
  } catch (error) {
    console.error('Erro ao buscar dados de acesso:', error);
  }
}

function updateFooter() {
  const footerElement = document.getElementById('lastAccess');
  footerElement.innerHTML = `
    Último acesso: ${lastAccessDate} <br>
    Último País acessado: ${lastAccessCountry}
  `;
}

// Carregar os dados com o valor inicial ao carregar a página
fetchData(pais);
fetchAcessData(); // Carregar também os dados de acesso
