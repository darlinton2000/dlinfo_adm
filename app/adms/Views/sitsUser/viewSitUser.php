<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes da Situação</h2>";

echo "<a href='".URLADM."list-sits-users/index'>Listar</a><br>";
if (!empty($this->data['viewSitUser'])){
echo "<a href='".URLADM."edit-sits-users/index/" . $this->data['viewSitUser'][0]['id'] . "'>Editar</a><br>";
echo "<a href='".URLADM."delete-sits-users/index/" . $this->data['viewSitUser'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir o registro?\")'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewSitUser'])){
    extract($this->data['viewSitUser'][0]);

    echo "ID: $id <br>";
    echo "Nome da Situação: <span style='color: $color;'>$name_sit</span><br>";
    echo "Cadastrada: " . date('d/m/Y H:i:s', strtotime($created)). " <br>";
    echo "Editada: ";
    if (!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
}