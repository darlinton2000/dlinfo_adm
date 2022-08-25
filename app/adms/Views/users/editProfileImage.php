<?php 
if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])){
    $valorForm = $this->data['form'][0];
}
?>

<h1>Editar Imagem</h1>

<?php
echo "<a href='".URLADM."view-profile/index'>Perfil</a><br><br>";

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-prof-img" enctype="multipart/form-data">
    <label>Imagem:<span style="color: red;">*</span> 300x300</label>
    <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()" required><br><br>

    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditProfImage" value="Salvar">Salvar</button>
</form>