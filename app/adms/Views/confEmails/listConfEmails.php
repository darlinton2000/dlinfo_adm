<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Listar E-mail</h2>";

echo "<a href='" . URLADM . "add-conf-emails/index'>Cadastrar</a><br><br>"; 

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach ($this->data['listConfEmails'] as $confEmail){
    extract($confEmail);
    echo "ID: $id <br>";
    echo "Título: $title <br>";
    echo "Nome: $name</span><br>";
    echo "E-mail: $email</span><br>";
    echo "<a href='".URLADM."view-conf-emails/index/$id'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-conf-emails/index/$id'>Editar</a><br>";
    echo "<a href='".URLADM."delete-conf-emails/index/$id'>Apagar</a><br>";
    echo "<hr>";
}

echo $this->data['pagination'];
echo "Total de Registros: <b> {$_SESSION['total_registro']}</b><br>";