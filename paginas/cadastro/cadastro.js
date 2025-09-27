// define a constante form, pegando o elemento por ID lá do HTML
const form = document.getElementById("formCadastro");

// vai ouvir quando o botao lá de submit for clickado
form.addEventListener("submit", function(event) {
    event.preventDefault();

    // limpa o espaço da senha
    document.getElementById("password").value = "";

    // limpa o espaço da confirmação da senha
    document.getElementById("password_confirm").value = "";
});
