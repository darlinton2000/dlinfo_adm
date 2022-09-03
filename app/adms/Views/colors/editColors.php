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

<h1>Editar Cor</h1>

<?php

echo "<a href='".URLADM."list-colors/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
echo "<a href='".URLADM."view-colors/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-color">    
    <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

    <label>Nome:<span style="color: red;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome situação" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>Cor:<span style="color: red;">*</span> </label>
    <input type="text" name="color" id="color" placeholder="Digite a cor em Hexadecimal" value="<?php if (isset($valorForm['color'])) { echo $valorForm['color']; }?>" required><br><br>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditColor" value="Salvar">Salvar</button>
</form>