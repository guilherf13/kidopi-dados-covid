// Função para preencher os países no select
async function preencherPaises() {
  const response = await fetch('https://dev.kidopilabs.com.br/exercicio/covid.php?listar_paises=1');
  const paises = await response.json();
  const country1Select = document.getElementById('country1');
  const country2Select = document.getElementById('country2');

  // Preenche as opções do select com o nome do país
  Object.keys(paises).forEach(countryCode => {
    const countryName = paises[countryCode];
    const option1 = document.createElement('option');
    option1.value = countryName; 
    option1.textContent = countryName; 
    country1Select.appendChild(option1);

    const option2 = document.createElement('option');
    option2.value = countryName; 
    option2.textContent = countryName; 
    country2Select.appendChild(option2);
  });
}

// Função para calcular a taxa de morte
function calcularTaxaMorte(mortes, confirmados) {
  if (confirmados === 0) return 0;
  return (mortes / confirmados) * 100;
}

// Função para buscar dados de COVID e calcular a diferença
async function compararTaxas() {
  const country1 = document.getElementById('country1').value;
  const country2 = document.getElementById('country2').value;

  if (country1 === country2) {
    alert('Escolha dois países diferentes!');
    return;
  }

  async function buscarDadosPais(country) {
    try {
      const response = await fetch(`http://localhost:80/api/v1/covid-country?country=${country}`);
   
      if (!response.ok) {
        alert(`Erro ao buscar dados para o país: ${country}`);
        return { mortes: 0, confirmados: 0 };
      }
  
      const data = await response.json();

      if (data.data.status !== "sucess") {
        alert(`Erro ao buscar dados para o país: ${country}`);
        return { mortes: 0, confirmados: 0 };
      }
      // Soma os dados de todos os estados do país
      let mortesTotal = 0;
      let confirmadosTotal = 0;
      const dataArray = data.data.data;
  
      dataArray.forEach(item => {
        mortesTotal += item.Mortos;
        confirmadosTotal += item.Confirmados;
      });
  
      return { mortes: mortesTotal, confirmados: confirmadosTotal };
  
    } catch (error) {
      console.error('Erro ao buscar dados:', error);
      alert('Ocorreu um erro ao buscar os dados!');
      return { mortes: 0, confirmados: 0 };
    }
  }

  // Buscar dados de COVID para o país 1
  const { mortes: mortesPais1, confirmados: confirmadosPais1 } = await buscarDadosPais(country1);
  const taxaMortePais1 = calcularTaxaMorte(mortesPais1, confirmadosPais1);

  // Buscar dados de COVID para o país 2
  const { mortes: mortesPais2, confirmados: confirmadosPais2 } = await buscarDadosPais(country2);
  const taxaMortePais2 = calcularTaxaMorte(mortesPais2, confirmadosPais2);

  // Calcular a diferença das taxas de morte
  let diferencaTaxa = taxaMortePais1 - taxaMortePais2;
  if(diferencaTaxa < 0){
    diferencaTaxa = Math.abs(diferencaTaxa)
  }

  // Exibir o resultado
  document.getElementById('result').innerHTML = `
    <p><strong>Taxa de Mortalidade ${country1}:</strong> ${taxaMortePais1.toFixed(2)}%</p>
    <p><strong>Taxa de Mortalidade ${country2}:</strong> ${taxaMortePais2.toFixed(2)}%</p>
    <p><strong>Diferença:</strong> ${diferencaTaxa.toFixed(2)}%</p>
  `;
}

// Inicializar a lista de países ao carregar a página
window.onload = preencherPaises;
