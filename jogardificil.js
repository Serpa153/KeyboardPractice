var translations = {
  // Definições de traduções para palavras-chave
  hipopotamo: {
    en_us: "Hippopotamus",
    pt_br: "Hipopótamo",
    emptyInput: { en_us: "", pt_br: "" },
  },
};

var palavraGerada = ""; // armazenar a palavra gerada
var pts = 0; // pontuação
var contador; // contador de tempo
var jogoIniciado = false; // Estado do jogo

document.cookie = "cpts=" + pts; // Define o cookie para armazenar a pontuação

// Função para gerar palavras de acordo com a categoria selecionada
function gerarStrings() {
  var categoria = document.getElementById("categoria").value; // Obtém a categoria selecionada
  var palavras = [];

  // Seleciona palavras com base na categoria escolhida
  switch (categoria) {
    case "programacao":
      palavras = ["Javascript", "html", "css", "php", "python", "java"];
      break;
    case "animais":
      palavras = [
        "Hipopótamo",
        "Albatroz",
        "Avestruz",
        "Andorinha",
        "Cachorro",
        "Antílope",
        "Elefante",
      ];
      break;
    case "objetos":
      palavras = [
        "Abotoadura",
        "Espectrofotometria",
        "Bumerangue",
        "Calçadeira",
        "Detergente",
        "Espartilho",
        "Grampeador",
        "Pipoqueira",
      ];
      break;
  }

  // Escolhe uma palavra aleatória da lista
  palavraGerada = palavras[Math.floor(Math.random() * palavras.length)];

  // Traduz a palavra gerada para o idioma selecionado
  var palavraTraduzida =
    translations[palavraGerada.toLowerCase()]?.[
      document.getElementById("languages").value
    ];

  // Se a tradução não estiver disponível, usa a palavra original em inglês
  palavraGerada = palavraTraduzida ? palavraTraduzida : palavraGerada;

  // Exibe a palavra gerada na tela
  document.getElementById("palavra").innerHTML = palavraGerada;
}

// Função para atribuir pontos e gerenciar o jogo
function pontos() {
  var palavraDigitada = document.getElementById("escreverPalavra").value;

  if (palavraDigitada == "") {
    document.getElementById("vazio").innerHTML = "Digite algo"; // Exibe uma mensagem se nada for digitado
    document.getElementById("incorreta").innerHTML = "";
    return false;
  } else {
    if (palavraDigitada.toLowerCase() == palavraGerada.toLowerCase()) {
      gerarStrings(); // Gera uma nova palavra
      pts += 1; // Incrementa a pontuação
      document.cookie = "cpts=" + pts; // Atualiza o cookie com a nova pontuação
      document.getElementById("pontos").innerHTML = pts; // Exibe a pontuação atualizada na tela
      document.getElementById("vazio").innerHTML = "";
      document.getElementById("incorreta").innerHTML = "";
      document.getElementById("escreverPalavra").value = ""; // Limpa o campo de entrada
      document.getElementById("escreverPalavra").focus(); // Dá foco novamente ao campo de entrada
    } else {
      document.getElementById("incorreta").innerHTML =
        translations.ERROU[document.getElementById("languages").value]; // Exibe uma mensagem de erro
      document.getElementById("vazio").innerHTML = "";
      return false;
    }
    return false;
  }
}

// Função para iniciar o contador regressivo
function iniciarContador() {
  var segundos = 10; // Tempo inicial em segundos
  contador = setInterval(function () {
    document.getElementById("segundos").value = "Tempo: " + segundos + "s"; // Exibe o tempo restante na tela
    segundos--;

    // Encerra o contador quando o tempo acabar
    if (segundos < 0) {
      clearInterval(contador); // Limpa o intervalo
      document.getElementById("segundos").value = "CONTADOR"; // Exibe "CONTADOR" quando o tempo acaba
      tempoEncerrado(); // Executa a função para lidar com o término do tempo
    }
  }, 1000); // Atualiza a cada segundo
}

// Marca o início do jogo
function marcarJogoIniciado() {
  jogoIniciado = true;
}

// Função para lidar com o término do tempo
function tempoEncerrado() {
  if (jogoIniciado) {
    alert(translations.timeUp[document.getElementById("languages").value]); // Exibe uma mensagem de "Tempo esgotado"
    gerarStrings(); // Gera uma nova palavra
    marcarJogoIniciado(); // Marca o jogo como iniciado
  }
}

// Função para escolher uma categoria e gerar uma palavra correspondente
function escolherCategoria() {
  gerarStrings(); // Gera as palavras da categoria selecionada
}

// Confirma a categoria selecionada e executa a função para escolher a categoria
function confirmarCategoria() {
  escolherCategoria(); // Chama a função para escolher a categoria
  document.getElementById("categoriaEscolhida").style.display = "block"; // Exibe a opção de categoria escolhida
}

// Inicia o jogo
function startJogo() {
  escolherCategoria(); // Escolhe uma categoria e gera uma palavra correspondente
  marcarJogoIniciado(); // Marca o jogo como iniciado
  iniciarContador(); // Inicia o contador regressivo
  document.getElementById("escreverPalavra").removeAttribute("disabled"); // Habilita o campo de entrada de texto
}

// Desabilita o campo de entrada de texto inicialmente
document.getElementById("escreverPalavra").setAttribute("disabled", "disabled");
