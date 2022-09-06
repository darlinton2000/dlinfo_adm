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

<h1>Editar Senha da Configuração de E-mail</h1>

<?php

echo "<a href='".URLADM."list-conf-emails/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
echo "<a href='".URLADM."view-conf-emails/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-pass-conf-email">    
    <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

    <label>Senha:<span style="color: red;">*</span> </label>
    <input type="password" name="password" id="password" placeholder="Senha do e-mail" value="<?php if (isset($valorForm['password'])) { echo $valorForm['password']; }?>" required><br><br>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditPassConfEmail" value="Salvar">Salvar</button>
</form>