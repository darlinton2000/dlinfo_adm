/* Permitir retorno do navegador no formulário após o erro */

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

/* Fim Permitir retorno do navegador no formulário após o erro* /

/* Calculcar a força da senha */

function passwordStrength(){
    var password = document.getElementById("password").value;
    console.log(password);
    var strength = 0; 

    //Senha maior ou igual a 6 e menor ou igual a 7, 10 pontos
    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    //Senha maior que 7, 25 pontos    
    } else if (password.length > 7) {
        strength += 25;
    }

    //Senha maior que 6 e letra minuscula, 10 pontos
    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 10;
    }

    //Senha maior ou igual a 7 e letra maiúscula, 20 pontos
    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    //Senha maior ou igual a 8 e os caracteres especiais (@#$%;*), 25 pontos
    if ((password.length >= 8) && (password.match(/[@#$%;*]+/))) {
        strength += 25;
    }

    //Senha com número repetido, -25 pontos
    if (password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }

    viewStrenght(strength);
}

/* Fim Calculcar a força da senha */

/* Imprimir a força da senha */

function viewStrenght(strength){
    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #f00;'>Senha Fraca</p>";
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #ff8c00;'>Senha Média</p>";
    } else if ((strength >= 50) && (strength < 69)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #7cfc00;'>Senha Boa</p>";
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #008000;'>Senha Forte</p>";
    } else {
        document.getElementById("msgViewStrength").innerHTML = "";
    }
}

/* Fim Imprimir a força da senha */

/* Início da validação dos formulários */ 

//Formulário Novo Usuário
const formNewUser = document.getElementById("form-new-user");
if (formNewUser) {
    formNewUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        //Verificar se o campo esta vazio
        if (name === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        //Verificar se o campo esta vazio
        if (email === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;

        //Verificar se o campo esta vazio
        if (password === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        //Verificar se o campo senha possui 6 caracteres
         if (password.length < 6){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }

        //Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }

        //Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Formulário Editar Nova Senha
const formEditUserPass = document.getElementById("form-edit-user-pass");
if (formEditUserPass) {
    formEditUserPass.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var password = document.querySelector("#password").value;

        //Verificar se o campo esta vazio
        if (password === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        //Verificar se o campo senha possui 6 caracteres
         if (password.length < 6){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }

        //Verificar se o campo senha não possui números repetidos
        if (password.match(/([1-9]+)\1{1,}/)){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }

        //Verificar se o campo senha possui letras
        if (!password.match(/[A-Za-z]/)){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}