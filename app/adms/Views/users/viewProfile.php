<?php 

echo "<h2>Perfil</h2>";

if (!empty($this->data['viewProfile'])){
    echo "<a href='".URLADM."edit-profile/index'>Editar</a><br>";
    echo "<a href='".URLADM."edit-profile-password/index'>Editar Senha</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewProfile'])){
    extract($this->data['viewProfile'][0]);

    //Verificando se existe uma imagem de perfil do usuário, se não existir irá atribuir uma imagem padrão
    if ((!empty($image)) and (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/$image"))){
        echo "<img src='" . URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] ."/$image' width='100' height='100'><br><br>";
    } else {
        echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height='100'><br><br>";
    }

    echo "Nome: $name <br>";
    echo "Apelido: $nickname <br>";
    echo "E-mail: $email <br>";
    echo "<br>";
}