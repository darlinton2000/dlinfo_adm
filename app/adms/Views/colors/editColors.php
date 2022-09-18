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
            <span class="title-content">Editar Cor</span>
            <div class="top-list-right">
                <?php
                echo "<a href='".URLADM."list-colors/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                echo "<a href='".URLADM."view-colors/index/" . $valorForm['id'] . "' class='btn-info'>Visualizar</a> ";
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
            <form class="form-adm" method="POST" action="" id="form-add-color">

                <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Nome:<span class="text-danger"> *</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome da cor" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Cor:<span class="text-danger"> *</span></label>
                        <input type="text" name="color" id="color" class="input-adm" placeholder="Digite a cor em Hexadecimal" value="<?php if (isset($valorForm['color'])) { echo $valorForm['color']; } ?>" required>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-success" name="SendEditColor" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->