<?php 
if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

?>

<h1>Cadastrar Usuário</h1>

<?php
if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-add-user">
    <label>Nome:<span style="color: red;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>Email:<span style="color: red;">*</span> </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; }?>" required><br><br>

    <label>Usuário:<span style="color: red;">*</span> </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o administrativo" value="<?php if (isset($valorForm['user'])) { echo $valorForm['user']; }?>" required><br><br>

    <label>Situação:<span style="color: red;">*</span> </label>
    <select name="adms_sits_user_id" id="adms_sits_user_id" required>
        <option value="">Selecione</option>
        <?php
        foreach ($this->data['select']['sit'] as $sit){
            extract($sit);
            if ((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)){
                echo "<option value='$id_sit' selected>$name_sit</option>";
            } else {
                echo "<option value='$id_sit'>$name_sit</option>";
            }
        }
        ?>
    </select><br><br>

    <label>Senha:<span style="color: red;">*</span> </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" required>
    <span id="msgViewStrength"><br><br></span>
    
    <span style="color: red;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>