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
            <span class="title-content">Editar Senha da Configuração de E-mail</span>
            <div class="top-list-right">
                <?php
                echo "<a href='".URLADM."list-conf-emails/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                echo "<a href='".URLADM."view-conf-emails/index/" . $valorForm['id'] . "' class='btn-info'>Visualizar</a><br><br>";
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
            <form class="form-adm" method="POST" action="" id="form-edit-pass-conf-email">

                <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Senha:<span class="text-danger"> *</span></label>
                        <input type="password" name="password" id="password" class="input-adm" placeholder="Senha do e-mail" required>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-success" name="SendEditPassConfEmail" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->