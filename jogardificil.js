var translations = {
  // Translation definitions for keywords
  cavalo: {
    en_us: "Horse",
    pt_br: "Cavalo",
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
  albatroz: {
    en_us: "Albatross",
    pt_br: "Albatroz",
    emptyInput: { en_us: "", pt_br: "" },
  },
  avestruz: {
    en_us: "Ostrich",
    pt_br: "Avestruz",
    emptyInput: { en_us: "", pt_br: "" },
  },
  andorinha: {
    en_us: "Swallow",
    pt_br: "Andorinha",
    emptyInput: { en_us: "", pt_br: "" },
  },

  antílope: {
    en_us: "Antelope",
    pt_br: "Antílope",
    emptyInput: { en_us: "", pt_br: "" },
  },

  abotoadura: {
    en_us: "Cufflink",
    pt_br: "Abotoadura",
    emptyInput: { en_us: "", pt_br: "" },
  },
  espectrofotometria: {
    en_us: "Spectrophotometry",
    pt_br: "Espectrofotometria",
    emptyInput: { en_us: "", pt_br: "" },
  },
  bumerangue: {
    en_us: "Boomerang",
    pt_br: "Bumerangue",
    emptyInput: { en_us: "", pt_br: "" },
  },
  calçadeira: {
    en_us: "Tamper",
    pt_br: "Calçadeira",
    emptyInput: { en_us: "", pt_br: "" },
  },
  detergente: {
    en_us: "Detergent",
    pt_br: "Detergente",
    emptyInput: { en_us: "", pt_br: "" },
  },
  espartilho: {
    en_us: "Corset",
    pt_br: "Espartilho",
    emptyInput: { en_us: "", pt_br: "" },
  },
  grampeador: {
    en_us: "Stapler",
    pt_br: "Grampeador",
    emptyInput: { en_us: "", pt_br: "" },
  },
  pipoqueira: {
    en_us: "Popcorn maker",
    pt_br: "Pipoqueira",
    emptyInput: { en_us: "", pt_br: "" },
  },
  tempoEncerr: {
    en_us: "Time's up",
    pt_br: "Tempo encerrado!",
    emptyInput: { en_us: "", pt_br: "" },
  },
  ERROU: {
    en_us: "Wrong... try again!",
    pt_br: "ERROU... tente outra vez!",
    emptyInput: { en_us: "", pt_br: "" },
  },
};

var palavraGerada = ""; // stores the generated word
var pts = 0; // score
var contador; // time counter
var jogoIniciado = false; // game state

document.cookie = "cpts=" + pts; // Sets the cookie to store the score

// Function to generate words according to the selected category
function gerarStrings() {
  var categoria = document.getElementById("categoria").value; // Get the selected category
  var palavras = [];

  // Select words based on the chosen category
  switch (categoria) {
    case "programacao":
      palavras = ["Javascript", "html", "css", "php", "python", "java"];
      break;
    case "animais":
      palavras = [
        "Cavalo",
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

  // Choose a random word from the list
  palavraGerada = palavras[Math.floor(Math.random() * palavras.length)];

  // Translate the generated word to the selected language
  var palavraTraduzida =
    translations[palavraGerada.toLowerCase()]?.[
      document.getElementById("languages").value
    ];

  // If translation is not available, use the original word in English
  palavraGerada = palavraTraduzida ? palavraTraduzida : palavraGerada;

  // Display the generated word on the screen
  document.getElementById("palavra").innerHTML = palavraGerada;
}

// Function to assign points and manage the game
function pontos() {
  var palavraDigitada = document.getElementById("escreverPalavra").value;

  if (palavraDigitada == "") {
    document.getElementById("vazio").innerHTML = "Type something"; // Show a message if nothing is typed
    document.getElementById("incorreta").innerHTML = "";
    return false;
  } else {
    if (palavraDigitada.toLowerCase() == palavraGerada.toLowerCase()) {
      gerarStrings(); // Generate a new word
      pts += 1; // Increment score
      document.cookie = "cpts=" + pts; // Update the cookie with the new score
      document.getElementById("pontos").innerHTML = pts; // Show the updated score on the screen
      document.getElementById("vazio").innerHTML = "";
      document.getElementById("incorreta").innerHTML = "";
      document.getElementById("escreverPalavra").value = ""; // Clear the input field
      document.getElementById("escreverPalavra").focus(); // Focus back on the input field
    } else {
      document.getElementById("incorreta").innerHTML =
        translations.ERROU[document.getElementById("languages").value]; // Show an error message
      document.getElementById("vazio").innerHTML = "";
      return false;
    }
    return false;
  }
}

// Function to start the countdown timer
function iniciarContador() {
  var segundos = 10; // Initial time in seconds
  contador = setInterval(function () {
    document.getElementById("segundos").value = "Time: " + segundos + "s"; // Show the remaining time on the screen
    segundos--;

    // End the counter when time runs out
    if (segundos < 0) {
      clearInterval(contador); // Clear the interval
      document.getElementById("segundos").value = "TIMER"; // Show "TIMER" when time runs out
      tempoEncerrado(); // Execute the function to handle the end of time
    }
  }, 1000); // Update every second
}

// Mark the start of the game
function marcarJogoIniciado() {
  jogoIniciado = true;
}

// Function to handle the end of time
function tempoEncerrado() {
  if (jogoIniciado) {
    alert(translations.tempoEncerr[document.getElementById("languages").value]); // Show a "Time's up" message
    gerarStrings(); // Generate a new word
    marcarJogoIniciado(); // Mark the game as started
  }
}

// Function to choose a category and generate a corresponding word
function escolherCategoria() {
  gerarStrings(); // Generate words for the selected category
}

// Confirm the selected category and execute the function to choose the category
function confirmarCategoria() {
  escolherCategoria(); // Call the function to choose the category
  document.getElementById("categoriaEscolhida").style.display = "block"; // Show the chosen category option
}

// Start the game
function startJogo() {
  escolherCategoria(); // Choose a category and generate a corresponding word
  marcarJogoIniciado(); // Mark the game as started
  iniciarContador(); // Start the countdown timer
  document.getElementById("escreverPalavra").removeAttribute("disabled"); // Enable the text input field
}

// Disable the text input field initially
document.getElementById("escreverPalavra").setAttribute("disabled", "disabled");

// Add event listener to clear error message when input field is clicked
document
  .getElementById("escreverPalavra")
  .addEventListener("click", function () {
    document.getElementById("incorreta").innerHTML = "";
  });
