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
            <span class="title-content">Detalhes da Situação</span>
            <div class="top-list-right">
                <?php
                echo "<a href='".URLADM."list-sits-users/index' class='btn-info'>Listar</a> ";
                if (!empty($this->data['viewSitUser'])){
                echo "<a href='".URLADM."edit-sits-users/index/" . $this->data['viewSitUser'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                echo "<a href='".URLADM."delete-sits-users/index/" . $this->data['viewSitUser'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir o registro?\")' class='btn-danger'>Apagar</a> ";
                }
                ?>
            </div>
        </div>

        <div class="content-adm">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>

        <div class="content-adm">
            <?php
            if (!empty($this->data['viewSitUser'])) {
                extract($this->data['viewSitUser'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome da Situação: </span>
                    <span class="view-adm-info">
                        <?php 
                        echo "<span style='color: $color;'>$name_sit</span>";
                        ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrada: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Editada: </span>
                    <span class="view-adm-info">
                        <?php
                        if (!empty($modified)) {
                            echo date('d/m/Y H:i:s', strtotime($modified));
                        }
                        ?>
                    </span>
                </div>

            <?php } ?>
        </div>
    </div>
</div>

<!-- Fim do conteudo do administrativo -->

<!-- echo "<h2>Detalhes da Situação</h2>";

echo "<a href='".URLADM."list-sits-users/index'>Listar</a><br>";
if (!empty($this->data['viewSitUser'])){
echo "<a href='".URLADM."edit-sits-users/index/" . $this->data['viewSitUser'][0]['id'] . "'>Editar</a><br>";
echo "<a href='".URLADM."delete-sits-users/index/" . $this->data['viewSitUser'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir o registro?\")'>Apagar</a><br><br>";
}

if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewSitUser'])){
    extract($this->data['viewSitUser'][0]);

    echo "ID: $id <br>";
    echo "Nome da Situação: <span style='color: $color;'>$name_sit</span><br>";
    echo "Cadastrada: " . date('d/m/Y H:i:s', strtotime($created)). " <br>";
    echo "Editada: ";
    if (!empty($modified)){
        echo date('d/m/Y H:i:s', strtotime($modified));
    }
    echo "<br>";
} -->