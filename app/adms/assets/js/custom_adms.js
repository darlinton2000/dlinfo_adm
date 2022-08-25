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

//Formulário Cadastrar Usuário
const formAddUser = document.getElementById("form-add-user");
if (formAddUser) {
    formAddUser.addEventListener("submit", async (e) => {
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
        var user = document.querySelector("#user").value;
        //Verificar se o campo esta vazio
        if (user === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        //Verificar se o campo esta vazio
        if (adms_sits_user_id === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo situação!</p>";
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

//Formulário Editar Usuário
const formEditUser = document.getElementById("form-edit-user");
if (formEditUser) {
    formEditUser.addEventListener("submit", async (e) => {
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
        var user = document.querySelector("#user").value;
        //Verificar se o campo esta vazio
        if (user === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        //Verificar se o campo esta vazio
        if (adms_sits_user_id === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo situação!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}


//Formulário Editar Perfil
const formEditProfile = document.getElementById("form-edit-profile");
if (formEditProfile) {
    formEditProfile.addEventListener("submit", async (e) => {
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
        var user = document.querySelector("#user").value;
        //Verificar se o campo esta vazio
        if (user === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }
    });
}

//Formulário Login
const formLogin = document.getElementById("form-login");
if (formLogin) {
    formLogin.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        //Verificar se o campo esta vazio
        if (user === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        //Verificar se o campo esta vazio
        if (password === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Formulário Confirmar Email
const formNewConfEmail = document.getElementById("form-new-conf-email");
if (formNewConfEmail) {
    formNewConfEmail.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        //Verificar se o campo esta vazio
        if (email === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Formulário Recuperar Senha
const formRecoverPass = document.getElementById("form-recover-pass");
if (formRecoverPass) {
    formRecoverPass.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        //Verificar se o campo esta vazio
        if (email === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Formulário Nova Senha
const formUpdatePass = document.getElementById("form-udpdate-pass");
if (formUpdatePass) {
    formUpdatePass.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        //Verificar se o campo esta vazio
        if (password === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Formulário Editar Senha Perfil
const formEditProfPass = document.getElementById("form-edit-prof-pass");
if (formEditProfPass) {
    formEditProfPass.addEventListener("submit", async (e) => {
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

//Formulário Editar Imagem
const formEditUserImg = document.getElementById("form-edit-user-img");
if (formEditUserImg) {
    formEditUserImg.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo esta vazio
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Formulário Editar Imagem de perfil
const formEditProfImage = document.getElementById("form-edit-prof-img");
if (formEditProfImage) {
    formEditProfImage.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var new_image = document.querySelector("#new_image").value;
        //Verificar se o campo esta vazio
        if (new_image === ""){
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: red;'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

//Função para validar extensão da imagem
function inputFileValImg() {
    //Receber o valor do campo
    var new_image = document.querySelector("#new_image");

    var filePath = new_image.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImage(new_image);
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}

//Função para carregar a pré-imagem
function previewImage(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        // FileReader() - ler o conteúdo dos arquivos
        var reader = new FileReader();
        // onload - disparar um evento quando qualquer elemento tenha sido carregado
        reader.onload = function(e) {
            document.getElementById('preview-img').innerHTML = "<img src='" + e.target.result + "' alt='Imagem' style='width: 100px;'>";
        }
    }

    // readAsDataURL - Retorna os dados do formato blob como uma URL de dados - Blob representa um arquivo
    reader.readAsDataURL(new_image.files[0]);
}

/* Fim da validação dos formulários */ 