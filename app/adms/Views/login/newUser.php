<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

?>

<h1>Novo Usuário</h1>

<?php
if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-new-user">
    <label>Nome:</label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" id="email" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; }?>" required><br><br>

    <label>Senha:</label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" required>
    <span id="msgViewStrength"><br><br></span>

    <button type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
</form>

<p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>