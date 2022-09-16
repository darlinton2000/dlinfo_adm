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
            <span class="title-content">Detalhes da Cor</span>
            <div class="top-list-right">
                <?php
                echo "<a href='".URLADM."list-colors/index' class='btn-info'>Listar</a> ";
                if (!empty($this->data['viewColor'])){
                echo "<a href='".URLADM."edit-colors/index/" . $this->data['viewColor'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                echo "<a href='".URLADM."delete-colors/index/" . $this->data['viewColor'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir o registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewColor'])) {
                extract($this->data['viewColor'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cor: </span>
                    <span class="view-adm-info">
                        <?php  
                        echo "<span style='color: $color;'>$color</span>";
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