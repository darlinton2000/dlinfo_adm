<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

?>

<h1>Cadastrar Cor</h1>

<?php

echo "<a href='".URLADM."list-colors/index'>Listar</a><br><br>";

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-add-color">
    <label>Nome:<span style="color: red;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome da cor" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>Cor:<span style="color: red;">*</span> </label>
    <input type="text" name="color" id="color" placeholder="Digite a cor em Hexadecimal" value="<?php if (isset($valorForm['color'])) { echo $valorForm['color']; }?>" required><br><br>
    
    <span style="color: red;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddColor" value="Cadastrar">Cadastrar</button>
</form>