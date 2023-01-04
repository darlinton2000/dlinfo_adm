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
            <span class="title-content">Editar Configuração do Formulário Página de Login</span>
            <div class="top-list-right">
                <?php
                    if (isset($valorForm['id'])) {
                        echo "<a href='".URLADM."view-levels-forms/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a> ";
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
            <form class="form-adm" method="POST" action="" id="form-edit-level-form">

                <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Situação:<span class="text-danger"> *</span></label>
                        <select name="adms_sits_user_id" id="adms_sits_user_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['sit'] as $sit) {
                                extract($sit);
                                if ((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)) {
                                    echo "<option value='$id_sit' selected>$name_sit</option>";
                                } else {
                                    echo "<option value='$id_sit'>$name_sit</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Nível de Acesso:<span class="text-danger"> *</span></label>
                        <select name="adms_access_level_id" id="adms_access_level_id" class="input-adm" required>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->data['select']['lev'] as $lev) {
                            extract($lev);
                            if ((isset($valorForm['adms_access_level_id'])) and ($valorForm['adms_access_level_id'] == $id_lev)) {
                                echo "<option value='$id_lev' selected>$name_lev</option>";
                            } else {
                                echo "<option value='$id_lev'>$name_lev</option>";
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-warning" name="SendEditLevelForm" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->