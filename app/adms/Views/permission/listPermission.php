<?php

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Permissões do Nível de Acesso <?php echo $this->data['viewAccessLevel'][0]['name'];?> </span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-access-levels/index' class='btn-info'>Listar Nível de Acesso</a>";
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
        </div>
        <table class="table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content">ID</th>
                    <th class="list-head-content">Página</th>
                    <th class="list-head-content table-sm-none">Ordem</th>
                    <th class="list-head-content table-sm-none">Permissão</th>
                    <th class="list-head-content table-md-none">Menu</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listPermission'] as $permission) {
                    extract($permission);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $name_page; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $order_level_page; ?></td>
                        <td class="list-body-content table-sm-none">
                            <?php
                                if ($permission == 1){
                                    echo "<a href='".URLADM."edit-permission/index/$id?&level=$adms_access_level_id&pag=" . $this->data['pag'] . "'><span class='text-success'>Liberado</span></a>";
                                } else {
                                    echo "<a href='".URLADM."edit-permission/index/$id?&level=$adms_access_level_id&pag=" . $this->data['pag'] . "'><span class='text-danger'>Bloqueado</span></a>";
                                }
                            ?>
                        </td>
                        <td class="list-body-content table-md-none">
                            <?php
                                if ($print_menu == 1){
                                    echo "<a href='".URLADM."edit-print-menu/index/$id?&level=$adms_access_level_id&pag=" . $this->data['pag'] . "'><span class='text-success'>Liberado</span></a>";
                                } else {
                                    echo "<a href='".URLADM."edit-print-menu/index/$id?&level=$adms_access_level_id&pag=" . $this->data['pag'] . "'><span class='text-danger'>Bloqueado</span></a>";
                                }
                            ?>
                        </td>
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    echo "<a href='" . URLADM . "order-page-menu/index/$id?&level=$adms_access_level_id&pag=" . $this->data['pag'] . "'><i class='fa-solid fa-angles-up'></i> Ordem</a>";
                                    /* echo "<a href='" . URLADM . "order-access-levels/index/$id?pag=".$this->data['pag']."'><i class='fa-solid fa-angles-up'></i> Ordem</a>";
                                    echo "<a href='" . URLADM . "list-permission/index?level=$id'><i class='fa-solid fa-house-lock'></i> Permissão</a>";
                                    echo "<a href='" . URLADM . "view-access-levels/index/$id'><i class='fa-solid fa-eye'></i> Visualizar</a>";
                                    echo "<a href='" . URLADM . "edit-access-levels/index/$id'><i class='fa-solid fa-pen-to-square'></i> Editar</a>";
                                    echo "<a href='" . URLADM . "delete-access-levels/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><i class='fa-regular fa-trash-can'></i> Apagar</a>"; */
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <?php echo $this->data['pagination']; ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->