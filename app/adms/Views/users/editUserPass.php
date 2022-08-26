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

<h1>Editar Senha</h1>

<?php
echo "<a href='".URLADM."list-users/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
echo "<a href='".URLADM."view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-pass">    
    <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

    <label>Senha:<span style="color: red;">*</span> </label>
    <input type="password" name="password" id="password" placeholder="Digite a nova senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php if (isset($valorForm['password'])) { echo $valorForm['password']; }?>" required>
    <span id="msgViewStrength"><br><br></span>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditUserPass" value="Salvar">Salvar</button>
</form>