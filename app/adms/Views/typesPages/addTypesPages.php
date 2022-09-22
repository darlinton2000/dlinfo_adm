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
            <span class="title-content">Cadastrar Tipo de Página</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-types-pages/index' class='btn-info'>Listar</a> ";
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
            <form method="POST" action="" id="form-add-types-pages" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                        $type = "";
                        if (isset($valorForm['type'])) {
                            $type = $valorForm['type'];
                        }
                        ?>
                        <label class="title-input">Tipo:<span class="text-danger">*</span></label>
                        <input type="text" name="type" id="type" class="input-adm" placeholder="Digite o tipo da página" value="<?php echo $type; ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $name = "";
                        if (isset($valorForm['name'])) {
                            $name = $valorForm['name'];
                        }
                        ?>
                        <label class="title-input">Nome:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome do tipo de página" value="<?php echo $name; ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $obs = "";
                        if (isset($valorForm['obs'])) {
                            $obs = $valorForm['obs'];
                        }
                        ?>
                        <label class="title-input">Observação:</label>
                        <input type="text" name="obs" id="obs" class="input-adm" placeholder="Observação" value="<?php echo $obs; ?>">
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" name="SendAddTypesPages" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->