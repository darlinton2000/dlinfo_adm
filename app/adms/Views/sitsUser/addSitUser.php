<?php

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Cadastrar Situação</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-sits-users/index' class='btn-info'>Listar</a> ";
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
            <form class="form-adm" method="POST" action="" id="form-add-user">
                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Nome:<span class="text-danger"> *</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome situação" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Cor:<span class="text-danger"> *</span></label>
                        <select name="adms_color_id" id="adms_color_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['color'] as $color) {
                                extract($color);
                                if ((isset($valorForm['adms_color_id'])) and ($valorForm['adms_color_id'] == $id_color)) {
                                    echo "<option value='$id_color' selected>$name_color</option>";
                                } else {
                                    echo "<option value='$id_color'>$name_color</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-success" name="SendAddSitUser" value="Cadastrar">Cadastrar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->