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

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Perfil</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "view-profile/index' class='btn-info'>Perfil</a> ";
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
            <form class="form-adm" method="POST" action="" id="form-edit-profile">
                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Nome:<span class="text-danger"> *</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome completo" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Apelido:<span class="text-danger"> *</span></label>
                        <input type="text" name="nickname" id="nickname" class="input-adm" placeholder="Digite o apelido" value="<?php if (isset($valorForm['nickname'])) { echo $valorForm['nickname']; } ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">E-mail:<span class="text-danger"> *</span></label>
                        <input type="email" name="email" id="email" class="input-adm" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Usuário:<span class="text-danger"> *</span></label>
                        <input type="text" name="user" id="user" class="input-adm" placeholder="Digite o usuário para acessar o administrativo" value="<?php if (isset($valorForm['user'])) { echo $valorForm['user']; } ?>" required>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-success" name="SendEditProfile" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->