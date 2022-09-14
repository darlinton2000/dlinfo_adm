<?php 

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Situações</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "add-sits-users/index' class='btn-success'>Cadastrar</a>";
                ?>
            </div>
        </div>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <table class="table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content">ID</th>
                    <th class="list-head-content">Nome</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listSitsUsers'] as $user) {
                    extract($user);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id; ?></td>
                        <td class="list-body-content">
                            <?php echo "<span style='color: $color'>$name_sit</span>"; ?>
                        </td>
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    echo "<a href='".URLADM."view-sits-users/index/$id'>Visualizar</a>";
                                    echo "<a href='".URLADM."edit-sits-users/index/$id'>Editar</a>";
                                    echo "<a href='".URLADM."delete-sits-users/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir o registro?\")'>Apagar</a>";
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
        <!-- echo "Total de Registros: <b> {$_SESSION['total_registro']}</b><br> -->
    </div>
</div>
<!-- Fim do conteudo do administrativo -->
