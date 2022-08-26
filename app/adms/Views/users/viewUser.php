<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes do Usuário</h2>";

echo "<a href='".URLADM."list-users/index'>Listar</a><br>";
if (!empty($this->data['viewUser'])){
echo "<a href='".URLADM."edit-users/index/" . $this->data['viewUser'][0]['id'] . "'>Editar</a><br>";
echo "<a href='".URLADM."edit-users-password/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Senha</a><br>";
echo "<a href='".URLADM."edit-users-image/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Imagem</a><br>";
echo "<a href='".URLADM."delete-users/index/" . $this->data['viewUser'][0]['id'] . "'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewUser'])){
    extract($this->data['viewUser'][0]);

    //Verificando se existe uma imagem de perfil do usuário, se não existir irá atribuir uma imagem padrão
    if ((!empty($image)) and (file_exists("app/adms/assets/image/users/$id/$image"))){
        echo "<img src='" . URLADM . "app/adms/assets/image/users/$id/$image' width='100' height='100'><br><br>";
    } else {
        echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height='100'><br><br>";
    }

    echo "ID: $id <br>";
    echo "Nome: $name_usr <br>";
    echo "Apelido: $nickname <br>";
    echo "E-mail: $email <br>";
    echo "Usuário: $user <br>";
    echo "Situação do Usuário: <span style='color: $color;'>$name_sit</span><br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)). " <br>";
    echo "Editado: ";
    if (!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
}