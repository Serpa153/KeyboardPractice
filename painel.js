document.addEventListener("DOMContentLoaded", function () {
  // Seleciona o ícone do menu e os links de navegação
  const menuIcon = document.querySelector("#menuToggle input");
  const navLinks = document.querySelector("#menu");

  // Adiciona um evento de clique ao ícone do menu
  menuIcon.addEventListener("click", function () {
    // Alterna a exibição do menu entre visível e invisível com base no estado do ícone do menu
    navLinks.style.display = menuIcon.checked ? "block" : "none";
  });

  // Fecha o menu ao clicar em qualquer lugar fora dele
  document.addEventListener("click", function (event) {
    // Verifica se o clique não ocorreu dentro do ícone do menu ou dos links de navegação
    if (!menuIcon.contains(event.target) && !navLinks.contains(event.target)) {
      // Fecha o menu definindo o ícone do menu como desmarcado e ocultando os links de navegação
      menuIcon.checked = false;
      navLinks.style.display = "none";
    }
  });

  // Evita que o menu seja fechado ao clicar nos links do menu
  navLinks.addEventListener("click", function (event) {
    // Impede a propagação do evento de clique nos links de navegação para o documento pai
    event.stopPropagation();
  });
});
