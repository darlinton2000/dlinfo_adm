<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

//Criptografar a senha
//echo password_hash("123456a", PASSWORD_DEFAULT);
?>

<h1>Área Restrita</h1>

<?php
if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-login">
    <label>Usuário:</label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário" value="<?php if (isset($valorForm['user'])) { echo $valorForm['user']; }?>" required><br><br>

    <label>Senha:</label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" autocomplete="on" value="<?php if (isset($valorForm['password'])) { echo $valorForm['password']; }?>" required><br><br>

    <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
</form>

<p><a href="<?php echo URLADM; ?>new-user/index">Cadastrar</a> - <a href="<?php echo URLADM; ?>recover-password/index">Esqueceu a senha?</a></p>

Usuário: darlinton2000@gmail.com<br>
Senha: 123456a<br>