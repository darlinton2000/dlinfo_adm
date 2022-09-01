<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Usuários</h2>";

echo "<a href='" . URLADM . "add-users/index'>Cadastrar</a><br><br>"; 

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listUsers'] as $user){
    extract($user);
    echo "ID: $id <br>";
    echo "Nome: $name_usr <br>";
    echo "E-mail: $email <br>";
    echo "Situação: <span style='color: $color;'>$name_sit</span><br>";
    echo "<a href='".URLADM."view-users/index/$id'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-users/index/$id'>Editar</a><br>";
    echo "<a href='".URLADM."delete-users/index/$id'>Apagar</a><br>";
    echo "<hr>";
}

echo $this->data['pagination'];
echo "Total de Registros: <b> {$_SESSION['total_registro']}</b><br>";