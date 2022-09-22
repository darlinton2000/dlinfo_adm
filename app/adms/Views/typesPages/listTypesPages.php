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
            <span class="title-content">Listar Tipos de Páginas</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "add-types-pages/index' class='btn-success'>Cadastrar</a>";
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
                    <th class="list-head-content table-sm-none">ID</th>
                    <th class="list-head-content">Tipo - Nome</th>
                    <th class="list-head-content">Ordem</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listTypesPages'] as $typesPages) {
                    extract($typesPages);
                ?>
                    <tr>
                        <td class="list-body-content table-sm-none"><?php echo $id; ?></td>
                        <td class="list-body-content">
                            <?php echo $type ." - ".$name; ?>
                        </td>
                        <td class="list-body-content"><?php echo $order_type_pg; ?></td>
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    echo "<a href='" . URLADM . "order-types-pages/index/$id?pag=" . $this->data['pag'] . "'><i class='fa-solid fa-angles-up'></i> Ordem</a>";
                                    echo "<a href='" . URLADM . "view-types-pages/index/$id'><i class='fa-solid fa-eye'></i> Visualizar</a>";
                                    echo "<a href='" . URLADM . "edit-types-pages/index/$id'><i class='fa-solid fa-pen-to-square'></i> Editar</a>";
                                    echo "<a href='" . URLADM . "delete-types-pages/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><i class='fa-solid fa-trash-can'></i> Apagar</a>";
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