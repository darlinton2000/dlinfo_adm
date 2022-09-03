<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar Cores</h2>";

echo "<a href='" . URLADM . "add-colors/index'>Cadastrar</a><br><br>"; 

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listColors'] as $cor){
    extract($cor);
    echo "ID: $id <br>";
    echo "Nome: <span>$name</span><br>";
    echo "Nome: <span style='color: $color;'>$color</span><br>";
    echo "<a href='".URLADM."view-colors/index/$id'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-colors/index/$id'>Editar</a><br>";
    echo "<a href='".URLADM."delete-colors/index/$id'>Apagar</a><br>";
    echo "<hr>";
}

echo $this->data['pagination'];
echo "Total de Registros: <b> {$_SESSION['total_registro']}</b><br>";