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

<h1>Editar Situação</h1>

<?php

echo "<a href='".URLADM."list-sits-users/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
echo "<a href='".URLADM."view-sits-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-sit-user">    
    <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

    <label>Nome:<span style="color: red;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome situação" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; }?>" required><br><br>

    <label>Cor:<span style="color: red;">*</span> </label>
    <select name="adms_color_id" id="adms_color_id" required>
        <option value="">Selecione</option>
        <?php
        foreach ($this->data['select']['color'] as $color){
            extract($color);
            if ((isset($valorForm['adms_color_id'])) and ($valorForm['adms_color_id'] == $id_color)){
                echo "<option value='$id_color' selected>$name_color</option>";
            } else {
                echo "<option value='$id_color'>$name_color</option>";
            }
        }
        ?>
    </select><br><br>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditSitUser" value="Salvar">Salvar</button>
</form>