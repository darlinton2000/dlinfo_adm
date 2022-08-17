<?php 
if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])){
    $valorForm = $this->data['form'][0];
}
?>

<h1>Editar Perfil</h1>

<?php
/* if (isset($valorForm['id'])) {
echo "<a href='".URLADM."view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
} */

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-profile">    
    <label>Nome:<span style="color: red;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>Apelido: </label>
    <input type="text" name="nickname" id="nickname" placeholder="Digite o apelido" value="<?php if (isset($valorForm['nickname'])) { echo $valorForm['nickname']; }?>"><br><br>

    <label>Email:<span style="color: red;">*</span> </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; }?>" required><br><br>

    <label>Usuário:<span style="color: red;">*</span> </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o administrativo" value="<?php if (isset($valorForm['user'])) { echo $valorForm['user']; }?>" required><br><br>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditProfile" value="Salvar">Salvar</button>
</form>