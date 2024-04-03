var translations = {
  // Palavras com traduções definidas
  gato: {
    en_us: "Cat",
    pt_br: "Gato",
    emptyInput: { en_us: "", pt_br: "" },
  },
  cachorro: {
    en_us: "Dog",
    pt_br: "Cachorro",
    emptyInput: { en_us: "", pt_br: "" },
  },
  elefante: {
    en_us: "Elephant",
    pt_br: "Elefante",
    emptyInput: { en_us: "", pt_br: "" },
  },
  leão: {
    en_us: "Lion",
    pt_br: "Leão",
    emptyInput: { en_us: "", pt_br: "" },
  },
  tigre: {
    en_us: "Tiger",
    pt_br: "Tigre",
    emptyInput: { en_us: "", pt_br: "" },
  },
  girafa: {
    en_us: "Giraffe",
    pt_br: "Girafa",
    emptyInput: { en_us: "", pt_br: "" },
  },
  computador: {
    en_us: "Computer",
    pt_br: "Computador",
    emptyInput: { en_us: "", pt_br: "" },
  },
  carro: {
    en_us: "Car",
    pt_br: "Carro",
    emptyInput: { en_us: "", pt_br: "" },
  },
  cadeira: {
    en_us: "Chair",
    pt_br: "Cadeira",
    emptyInput: { en_us: "", pt_br: "" },
  },
  mesa: {
    en_us: "Table",
    pt_br: "Mesa",
    emptyInput: { en_us: "", pt_br: "" },
  },
  celular: {
    en_us: "Cell Phone",
    pt_br: "Celular",
    emptyInput: { en_us: "", pt_br: "" },
  },
  livro: {
    en_us: "Book",
    pt_br: "Livro",
    emptyInput: { en_us: "", pt_br: "" },
  },
  grande: {
    en_us: "Big",
    pt_br: "Grande",
    emptyInput: { en_us: "", pt_br: "" },
  },
  pequeno: {
    en_us: "Small",
    pt_br: "Pequeno",
    emptyInput: { en_us: "", pt_br: "" },
  },
  bonito: {
    en_us: "Beautiful",
    pt_br: "Bonito",
    emptyInput: { en_us: "", pt_br: "" },
  },
  feio: {
    en_us: "Ugly",
    pt_br: "Feio",
    emptyInput: { en_us: "", pt_br: "" },
  },
  rápido: {
    en_us: "Fast",
    pt_br: "Rápido",
    emptyInput: { en_us: "", pt_br: "" },
  },
  lento: {
    en_us: "Slow",
    pt_br: "Lento",
    emptyInput: { en_us: "", pt_br: "" },
  },
  ERROU: {
    en_us: "Wrong... try again!",
    pt_br: "ERROU... tente outra vez!",
    emptyInput: { en_us: "", pt_br: "" },
  },
};

var palavraGerada = "";
var pts = 0;
document.cookie = "cpts=" + pts;

document.getElementById("escreverPalavra").onpaste = false;

// Gerar strings aleatórias:
function gerarStrings() {
  // Lista de palavras aleatórias
  var palavras = [];

  // Seleciona a lista de palavras com base na categoria selecionada
  var categoria = document.getElementById("categoria").value;
  switch (categoria) {
    case "programacao":
      palavras = ["javascript", "html", "css", "php", "python", "java"];
      break;
    case "animais":
      palavras = ["gato", "cachorro", "elefante", "leão", "tigre", "girafa"];
      break;
    case "objetos":
      palavras = ["computador", "carro", "cadeira", "mesa", "celular", "livro"];
      break;
    case "adjetivos":
      palavras = ["grande", "pequeno", "bonito", "feio", "rápido", "lento"];
      break;
  }

  // Escolher uma palavra aleatória da lista
  var palavraOriginal = palavras[Math.floor(Math.random() * palavras.length)];

  // Traduzir a palavra gerada para o idioma selecionado
  palavraGerada =
    translations[palavraOriginal]?.[document.getElementById("languages").value];

  if (!palavraGerada) {
    // Se a tradução não estiver disponível, usa a palavra original
    palavraGerada = palavraOriginal;
  }

  document.getElementById("palavra").innerHTML = palavraGerada;
}

// Função para calcular pontos:
function pontos() {
  var palavraDigitada = document.getElementById("escreverPalavra").value;

  // Verifica se a entrada está vazia:
  if (palavraDigitada == "") {
    var idiomaSelecionado = document.getElementById("languages").value;
    var traducaoVazia =
      translations[palavraGerada]?.emptyInput?.[idiomaSelecionado];

    if (traducaoVazia) {
      document.getElementById("vazio").innerHTML = traducaoVazia;
    } else {
      // Se a tradução vazia não estiver definida, exibe uma mensagem padrão
      document.getElementById("vazio").innerHTML =
        translations.emptyInput[idiomaSelecionado];
    }
    document.getElementById("incorreta").innerHTML = "";
    return false;
  } else {
    // Verifica se a palavra digitada é igual à palavra gerada:
    if (palavraDigitada == document.getElementById("palavra").innerHTML) {
      gerarStrings();
      pts += 1; // Número ganho a cada escrita correta:

      document.cookie = "cpts=" + pts;
      // Atualiza a exibição dos pontos e limpa a entrada:
      document.getElementById("pontos").innerHTML = pts;
      document.getElementById("vazio").innerHTML = "";
      document.getElementById("incorreta").innerHTML = "";
      document.getElementById("escreverPalavra").value = "";
      document.getElementById("escreverPalavra").focus();
    } else {
      document.getElementById("incorreta").innerHTML =
        translations.ERROU[document.getElementById("languages").value];
      document.getElementById("vazio").innerHTML = "";
      return false;
    }
    return false;
  }
}

// Adicionando a funcionalidade de escolha de categorias
function confirmarCategoria() {
  // Chama a função para gerar as palavras
  gerarStrings();

  // Esconde o elemento que exibe a categoria escolhida
  document.getElementById("categoriaEscolhida").style.display = "none";
}

// Adicionando evento para limpar a mensagem de erro ao clicar novamente no campo de entrada
document
  .getElementById("escreverPalavra")
  .addEventListener("click", function () {
    document.getElementById("incorreta").innerHTML = "";
  });
