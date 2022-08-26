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

<h1>Editar Imagem</h1>

<?php
echo "<a href='".URLADM."list-users/index'>Listar</a><br>";
if (isset($valorForm['id'])) {
    echo "<a href='".URLADM."view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-img" enctype="multipart/form-data">    
    <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

    <label>Imagem:<span style="color: red;">*</span> 300x300</label>
    <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()" required><br><br>

    <?php
        //Verificando se existe uma imagem de perfil do usuário, se não existir irá atribuir uma imagem padrão
        if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image']))){
            $old_image = URLADM . "app/adms/assets/image/users/" . $valorForm['id'] ."/". $valorForm['image'];
        } else {
            $old_image = URLADM . "app/adms/assets/image/users/icon_user.png";
        }
    ?>

    <span id="preview-img">
        <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
    </span><br><br>


    <span style="color: red;">* Campo Obrigatório</span><br><br>
    
    <button type="submit" name="SendEditUserImage" value="Salvar">Salvar</button>
</form>