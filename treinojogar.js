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
};

var palavraGerada = "";
var numeroGerado = 0; // Variável para armazenar o número gerado

document.getElementById("escreverPalavra").onpaste = false;

// Gerar strings aleatórias
function gerarStrings() {
  var categoria = document.getElementById("categoria").value;
  var palavras = [];

  // Seleciona a lista de palavras com base na categoria selecionada
  switch (categoria) {
    case "programacao":
      palavras = ["JavaScript", "Html", "Css", "Php", "Python", "Java"];
      break;
    case "animais":
      palavras = ["gato", "cachorro", "elefante", "leão", "tigre", "girafa"];
      break;
    case "objetos":
      palavras = ["computador", "carro", "cadeira", "celular", "livro"];
      break;
    case "adjetivos":
      palavras = ["grande", "pequeno", "bonito", "feio", "rápido", "lento"];
      break;
  }

  palavraGerada = palavras[Math.floor(Math.random() * palavras.length)];
  var language = document.getElementById("languages").value;
  document.getElementById("palavra").innerHTML =
    translations[palavraGerada]?.[language] || palavraGerada;
}

function confirmarCategoria() {
  // Chama a função para gerar as palavras
  gerarStrings();

  // Exibe a opção de categoria escolhida
  var categoriaEscolhida = document.getElementById("categoria").value;
  document.getElementById("categoriaEscolhida").style.display = "none"; // Oculta o elemento que exibe a categoria escolhida
}

function verificarPalavra() {
  var palavraDigitada = document.getElementById("escreverPalavra").value;

  if (palavraDigitada == "") {
    document.getElementById("vazio").innerHTML = "Digite algo";
    document.getElementById("incorreta").innerHTML = "";
    return false;
  } else {
    if (palavraDigitada == palavraGerada) {
      gerarStrings();
      document.getElementById("vazio").innerHTML = "";
      document.getElementById("incorreta").innerHTML = "";
      document.getElementById("escreverPalavra").value = "";
      document.getElementById("escreverPalavra").focus();
    } else {
      document.getElementById("incorreta").innerHTML =
        "ERROU... tente outra vez!";
      document.getElementById("vazio").innerHTML = "";
      return false;
    }
    return false;
  }
}
