<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "VIEW - Página Dashboard!<br>";
echo $this->data . " " . $_SESSION['user_name'] . "!<br>";