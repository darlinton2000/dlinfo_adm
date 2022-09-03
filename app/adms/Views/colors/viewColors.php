<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes da Cor</h2>";

echo "<a href='".URLADM."list-colors/index'>Listar</a><br>";
if (!empty($this->data['viewColor'])){
echo "<a href='".URLADM."edit-colors/index/" . $this->data['viewColor'][0]['id'] . "'>Editar</a><br>";
echo "<a href='".URLADM."delete-colors/index/" . $this->data['viewColor'][0]['id'] . "'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewColor'])){
    extract($this->data['viewColor'][0]);

    echo "ID: $id <br>";
    echo "Nome: <span>$name</span><br>";
    echo "Cor: <span style='color: $color;'>$color</span><br>";
    echo "Cadastrada: " . date('d/m/Y H:i:s', strtotime($created)). " <br>";
    echo "Editada: ";
    if (!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
}