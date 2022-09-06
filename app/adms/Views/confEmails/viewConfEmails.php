<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

echo "<h2>Detalhes do E-mail</h2>";

echo "<a href='".URLADM."list-conf-emails/index'>Listar</a><br>";
if (!empty($this->data['viewConfEmail'])){
echo "<a href='".URLADM."edit-conf-emails/index/" . $this->data['viewConfEmail'][0]['id'] . "'>Editar</a><br>";
echo "<a href='".URLADM."edit-conf-emails-password/index/" . $this->data['viewConfEmail'][0]['id'] . "'>Editar Senha</a><br>";
echo "<a href='".URLADM."delete-conf-emails/index/" . $this->data['viewConfEmail'][0]['id'] . "'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewConfEmail'])){
    extract($this->data['viewConfEmail'][0]);

    echo "ID: $id <br>";
    echo "Título: $title <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    echo "Host: $host <br>";
    echo "Usuário: $username <br>";
    echo "SMTP: $smtpsecure <br>";
    echo "Porta: $port <br>";
    echo "Cadastrado: " . date('d/m/Y H:i:s', strtotime($created)). " <br>";
    echo "Editado: ";
    if (!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
}