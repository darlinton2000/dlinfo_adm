<?php

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Imagem</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                    echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] . "' class='btn-info'>Visualizar</a> ";
                }
                ?>
            </div>
        </div>

        <div class="content-adm-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <span id="msg"></span>
        </div>

        <div class="content-adm">
            <form class="form-adm" method="POST" action="" id="form-edit-user-img" enctype="multipart/form-data">

                <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; } ?>">

                <?php
                //Verificando se existe uma imagem de perfil do usuário, se não existir irá atribuir uma imagem padrão
                if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image']))) {
                    $old_image = URLADM . "app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image'];
                } else {
                    $old_image = URLADM . "app/adms/assets/image/users/icon_user.png";
                }
                ?>

                <span id="preview-img">
                    <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
                </span>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Imagem:<span class="text-danger"> *</span> 300x300</label><br>
                        <input type="file" name="new_image" id="new_image" class="input-adm" onchange="inputFileValImg()" required>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-success" name="SendEditUserImage" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->