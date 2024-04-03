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

var palavraGerada =
  ""; /*Variável para armazenar a palavra gerada aleatoriamente*/
var numeroGerado = 0; /* Variável para armazenar o número gerado*/

/*Impedir a função de colar no campo de texto*/
document.getElementById("escreverPalavra").onpaste = false;

/*Função para gerar palavras aleatórias com base na categoria selecionada*/
function gerarStrings() {
  var categoria = document.getElementById("categoria").value;
  var palavras = [];

  /*Seleciona a lista de palavras com base na categoria selecionada*/
  switch (categoria) {
    case "programacao":
      palavras = ["Javascript", "Html", "Css", "Php", "Python", "Java"];
      break;
    case "animais":
      palavras = ["Gato", "Cachorro", "Elefante", "Leão", "Tigre", "Girafa"];
      break;
    case "objetos":
      palavras = ["Computador", "Carro", "Cadeira", "Mesa", "Celular", "Livro"];
      break;
    case "adjetivos":
      palavras = ["Grande", "Pequeno", "Bonito", "Feio", "Rápido", "Lento"];
      break;
  }

  /*Seleciona uma palavra aleatória da lista de palavras*/
  palavraGerada = palavras[Math.floor(Math.random() * palavras.length)];
  var language = document.getElementById("languages").value;

  /*Exibe a palavra gerada na tela, com tradução se disponível*/
  document.getElementById("palavra").innerHTML =
    translations[palavraGerada]?.[language] || palavraGerada;
}

/*Função para confirmar a categoria escolhida e gerar as palavras correspondentes*/
function confirmarCategoria() {
  gerarStrings(); /* Chama a função para gerar as palavras com base na categoria selecionada*/
  document.getElementById("categoriaEscolhida").style.display =
    "none"; /*Oculta o elemento que exibe a categoria escolhida*/
}

/*Função para verificar se a palavra digitada corresponde à palavra gerada*/
function verificarPalavra() {
  var palavraDigitada = document.getElementById("escreverPalavra").value;

  /*Verifica se o campo de entrada está vazio*/
  if (palavraDigitada == "") {
    document.getElementById("vazio").innerHTML = "Digite algo";
    document.getElementById("incorreta").innerHTML = "";
    return false;
  } else {
    /* Verifica se a palavra digitada é correta*/
    if (palavraDigitada == palavraGerada) {
      gerarStrings(); // Gera uma nova palavra
      document.getElementById("vazio").innerHTML = "";
      document.getElementById("incorreta").innerHTML = "";
      document.getElementById("escreverPalavra").value = "";
      document.getElementById("escreverPalavra").focus();
    } else {
      /*Exibe uma mensagem de erro se a palavra digitada estiver incorreta*/
      document.getElementById("incorreta").innerHTML =
        translations.ERROU[document.getElementById("languages").value];
      document.getElementById("vazio").innerHTML = "";
      return false;
    }
    return false;
  }
}
