var translations = {
  // Palavras com traduções definidas
  Usuário: {
    en_us: "The 'User' field was not filled in!",
    pt_br: "O campo 'Usuário' não foi preenchido!",
    emptyInput: { en_us: "", pt_br: "" },
  },
  Senha: {
    en_us: "The 'Password' field was not filled in!",
    pt_br: "O campo 'Senha' não foi preenchido!",
    emptyInput: { en_us: "", pt_br: "" },
  },
};

// Função chamada quando o formulário é submetido para validação:
function valida() {
  // Obtém os valores dos campos de usuário e senha:
  var usuario = document.getElementById("usuario").value;
  var senha = document.getElementById("senha").value;

  // Verifica se o campo de usuário está vazio
  if (usuario == "") {
    // Exibe um alerta com a mensagem de erro de acordo com o idioma selecionado:
    alert(translations.Usuário[document.getElementById("languages").value]);
    return false;
  } else if (senha == "") {
    // Exibe um alerta informando que o campo de senha não foi preenchido:
    alert(translations.Senha[document.getElementById("languages").value]);
    return false;
  }
}
