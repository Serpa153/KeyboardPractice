var translations = {
  // Palavras com traduções definidas
  errAtualizar: {
    en_us: "Error updating. Please try again.",
    pt_br: "Erro ao atualizar. Por favor, tente novamente.",
    emptyInput: { en_us: "", pt_br: "" },
  },
  excluirCo: {
    en_us:
      "Are you sure you want to delete your account? This action cannot be undone.",
    pt_br:
      "Tem certeza de que deseja excluir sua conta? Essa ação não pode ser desfeita.",
    emptyInput: { en_us: "", pt_br: "" },
  },
  errExcluir: {
    en_us: "Error deleting account. Please try again.",
    pt_br: "Erro ao excluir conta. Por favor, tente novamente.",
    emptyInput: { en_us: "", pt_br: "" },
  },
  sucessoAtualizarUsuario: {
    en_us: "Username updated successfully.",
    pt_br: "Nome de usuário atualizado com sucesso.",
    emptyInput: { en_us: "", pt_br: "" },
  },
  sucessoAtualizarEmail: {
    en_us: "Email updated successfully.",
    pt_br: "E-mail atualizado com sucesso.",
    emptyInput: { en_us: "", pt_br: "" },
  },
  sucessoAtualizarSenha: {
    en_us: "Password updated successfully.",
    pt_br: "Senha atualizada com sucesso.",
    emptyInput: { en_us: "", pt_br: "" },
  },
  sucessoExcluirConta: {
    en_us: "Account deleted successfully.",
    pt_br: "Conta excluída com sucesso.",
    emptyInput: { en_us: "", pt_br: "" },
  },
};

function editUsername() {
  var nomeUsuario = document.getElementById("nomeUsuario");
  var editNomeUsuario = document.getElementById("editNomeUsuario");
  var saveUsername = document.getElementsByName("saveUsername")[0];

  if (nomeUsuario.style.display !== "none") {
    nomeUsuario.style.visibility = "hidden";
    editNomeUsuario.style.display = "inline";
    editNomeUsuario.style.marginLeft = "0"; // Ajustando a posição do input
    editNomeUsuario.focus();
    saveUsername.style.display = "inline";
  } else {
    nomeUsuario.style.visibility = "visible";
    editNomeUsuario.style.display = "none";
    saveUsername.style.display = "none";
  }
}

function editEmail() {
  var email = document.getElementById("email");
  var editEmail = document.getElementById("editEmail");
  var saveEmail = document.getElementsByName("saveEmail")[0];

  if (email.style.display !== "none") {
    email.style.visibility = "hidden";
    editEmail.style.display = "inline";
    editEmail.style.marginLeft = "0"; // Ajustando a posição do input
    editEmail.focus();
    saveEmail.style.display = "inline";
  } else {
    email.style.visibility = "visible";
    editEmail.style.display = "none";
    saveEmail.style.display = "none";
  }
}

function editPassword() {
  var senha = document.getElementById("senha");
  var editPassword = document.getElementById("editPassword");
  var savePassword = document.getElementsByName("savePassword")[0];

  if (senha.style.display !== "none") {
    senha.style.visibility = "hidden";
    editPassword.style.display = "inline";
    editPassword.style.marginLeft = "0"; // Ajustando a posição do input
    editPassword.focus();
    savePassword.style.display = "inline";
  } else {
    senha.style.visibility = "visible";
    editPassword.style.display = "none";
    savePassword.style.display = "none";
  }
}

function deleteAccount() {
  if (
    confirm(translations.excluirCo[document.getElementById("languages").value])
  ) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_account.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          alert(
            translations.sucessoExcluirConta[
              document.getElementById("languages").value
            ]
          );
          window.location.href = "login.php"; // Redireciona para a página de logout após excluir a conta
        } else {
          alert(
            translations.errExcluir[document.getElementById("languages").value]
          );
          return false;
        }
      }
    };
    xhr.send();
  }
}

// Adicionando event listeners para os botões "Salvar"
document
  .getElementsByName("saveUsername")[0]
  .addEventListener("click", function () {
    var editNomeUsuario = document.getElementById("editNomeUsuario").value;
    updateInfo("update_username.php", "username=" + editNomeUsuario);
  });

document
  .getElementsByName("saveEmail")[0]
  .addEventListener("click", function () {
    var editEmail = document.getElementById("editEmail").value;
    updateInfo("update_email.php", "email=" + editEmail);
  });

document
  .getElementsByName("savePassword")[0]
  .addEventListener("click", function () {
    var editPassword = document.getElementById("editPassword").value;
    updateInfo("update_password.php", "password=" + editPassword);
  });

function updateInfo(url, data) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var field = url.includes("username")
          ? "sucessoAtualizarUsuario"
          : url.includes("email")
          ? "sucessoAtualizarEmail"
          : url.includes("password")
          ? "sucessoAtualizarSenha"
          : null;
        if (field) {
          alert(
            translations[field][document.getElementById("languages").value]
          );
        }
        window.location.reload(); // Recarrega a página após a atualização
      } else {
        alert(
          translations.errAtualizar[document.getElementById("languages").value]
        );
      }
    }
  };
  xhr.send(data);
}
