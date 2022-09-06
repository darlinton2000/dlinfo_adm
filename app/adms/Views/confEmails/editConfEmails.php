<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])){
    $valorForm = $this->data['form'][0];
}
?>

<h1>Editar Configuração de E-mail</h1>

<?php

echo "<a href='".URLADM."list-conf-emails/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
echo "<a href='".URLADM."view-conf-emails/index/" . $valorForm['id'] . "'>Visualizar</a><br>";
echo "<a href='".URLADM."edit-conf-emails-password/index/" . $valorForm['id'] . "'>Editar Senha</a><br>";
echo "<a href='".URLADM."delete-conf-emails/index/" . $valorForm['id'] . "'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-conf-email">    
    <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

    <label>Título:<span style="color: red;">*</span> </label>
    <input type="text" name="title" id="title" placeholder="Digite o título para identificar o e-mail" value="<?php if (isset($valorForm['title'])) { echo $valorForm['title']; }?>" required><br><br>

    <label>Nome:<span style="color: red;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Nome que será apresentado" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>E-mail:<span style="color: red;">*</span> </label>
    <input type="email" name="email" id="email" placeholder="E-mail que será apresentado" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; }?>" required><br><br>

    <label>Host:<span style="color: red;">*</span> </label>
    <input type="text" name="host" id="host" placeholder="Servidor utilizado para enviar o e-mail" value="<?php if (isset($valorForm['host'])) { echo $valorForm['host']; }?>" required><br><br>

    <label>Usuário:<span style="color: red;">*</span> </label>
    <input type="text" name="username" id="username" placeholder="Usuário do e-mail, na maioria" value="<?php if (isset($valorForm['username'])) { echo $valorForm['username']; }?>" required><br><br>

    <label>SMTP:<span style="color: red;">*</span> </label>
    <input type="text" name="smtpsecure" id="smtpsecure" placeholder="SMTP" value="<?php if (isset($valorForm['smtpsecure'])) { echo $valorForm['smtpsecure']; }?>" required><br><br>

    <label>Porta:<span style="color: red;">*</span> </label>
    <input type="number" name="port" id="port" placeholder="Porta" value="<?php if (isset($valorForm['port'])) { echo $valorForm['port']; }?>" required><br><br>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditConfEmail" value="Salvar">Salvar</button>
</form>