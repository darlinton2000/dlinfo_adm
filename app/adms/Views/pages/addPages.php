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
            <span class="title-content">Cadastrar Página</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-pages/index' class='btn-info'>Listar</a> ";
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
            <form method="POST" action="" id="form-add-pages" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <?php
                        $name_page = "";
                        if (isset($valorForm['name_page'])) {
                            $name_page = $valorForm['name_page'];
                        }
                        ?>
                        <label class="title-input">Nome da Página:<span class="text-danger">*</span></label>
                        <input type="text" name="name_page" id="name_page" class="input-adm" placeholder="Nome da Página a ser apresentado no menu" value="<?php echo $name_page; ?>" required>
                    </div>
                </div>
                <div class="row-input">
                    <div class="column">
                        <?php
                        $controller = "";
                        if (isset($valorForm['controller'])) {
                            $controller = $valorForm['controller'];
                        }
                        ?>
                        <label class="title-input">Classe:<span class="text-danger">*</span></label>
                        <input type="text" name="controller" id="controller" class="input-adm" placeholder="Nome da Classe" value="<?php echo $controller; ?>" required>

                    </div>
                    <div class="column">
                        <?php
                        $metodo = "";
                        if (isset($valorForm['metodo'])) {
                            $metodo = $valorForm['metodo'];
                        }
                        ?>
                        <label class="title-input">Método:<span class="text-danger">*</span></label>
                        <input type="text" name="metodo" id="metodo" class="input-adm" placeholder="Nome do Método" value="<?php echo $metodo; ?>" required>

                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $menu_controller = "";
                        if (isset($valorForm['menu_controller'])) {
                            $menu_controller = $valorForm['menu_controller'];
                        }
                        ?>
                        <label class="title-input">Classe no menu:<span class="text-danger">*</span></label>
                        <input type="text" name="menu_controller" id="menu_controller" class="input-adm" placeholder="Nome da classe no menu" value="<?php echo $metodo; ?>" required>

                    </div>
                    <div class="column">
                        <?php
                        $menu_metodo = "";
                        if (isset($valorForm['menu_metodo'])) {
                            $menu_metodo = $valorForm['menu_metodo'];
                        }
                        ?>
                        <label class="title-input">Método no menu:<span class="text-danger">*</span></label>
                        <input type="text" name="menu_metodo" id="menu_metodo" class="input-adm" placeholder="Nome do método no menu" value="<?php echo $menu_metodo; ?>" required>

                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $icon = "";
                        if (isset($valorForm['icon'])) {
                            $icon = $valorForm['icon'];
                        }
                        ?>
                        <label class="title-input">Ícone:</label>
                        <input type="text" name="icon" id="icon" class="input-adm" placeholder="Ícone a ser apresentado no menu" value="<?php echo $icon; ?>">

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

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Página Pública:<span class="text-danger">*</span></label>
                        <select name="publish" id="publish" class="input-adm" required>
                            <?php
                            if (isset($valorForm['publish']) and $valorForm['publish'] == 1) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1' selected>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            } elseif (isset($valorForm['publish']) and $valorForm['publish'] == 2) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2' selected>Não</option>";
                            } else {
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Situação da Página:<span class="text-danger">*</span></label>
                        <select name="adms_sits_pgs_id" id="adms_sits_pgs_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['sit_page'] as $sitPage) {
                                extract($sitPage);
                                if (isset($valorForm['adms_sits_pgs_id']) and $valorForm['adms_sits_pgs_id'] == $id_sit) {
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
                        <label class="title-input">Grupo da Página:<span class="text-danger">*</span></label>
                        <select name="adms_groups_pgs_id" id="adms_groups_pgs_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['group_page'] as $group_page) {
                                extract($group_page);
                                if ((isset($valorForm['adms_groups_pgs_id'])) and ($valorForm['adms_groups_pgs_id'] == $id_group)) {
                                    echo "<option value='$id_group' selected>$name_group</option>";
                                } else {
                                    echo "<option value='$id_group'>$name_group</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Tipo da Página:<span class="text-danger">*</span></label>
                        <select name="adms_types_pgs_id" id="adms_types_pgs_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['type_page'] as $type_page) {
                                extract($type_page);
                                if ((isset($valorForm['adms_types_pgs_id'])) and ($valorForm['adms_types_pgs_id'] == $id_type)) {
                                    echo "<option value='$id_type' selected>$name_type</option>";
                                } else {
                                    echo "<option value='$id_type'>$type - $name_type</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" name="SendAddPages" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->