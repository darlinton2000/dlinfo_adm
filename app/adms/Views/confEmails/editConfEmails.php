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
            <span class="title-content">Editar Configuração de E-mail</span>
            <div class="top-list-right">
                <?php
                echo "<a href='".URLADM."list-conf-emails/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                echo "<a href='".URLADM."view-conf-emails/index/" . $valorForm['id'] . "' class='btn-info'>Visualizar</a> ";
                echo "<a href='".URLADM."edit-conf-emails-password/index/" . $valorForm['id'] . "' class='btn-warning'>Editar Senha</a> ";
                echo "<a href='".URLADM."delete-conf-emails/index/" . $valorForm['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir o registro?\")' class='btn-danger'>Apagar</a> ";
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
            <form class="form-adm" method="POST" action="" id="form-edit-conf-email">

                <input type="hidden" name="id" id="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; }?>">

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Título:<span class="text-danger"> *</span></label>
                        <input type="text" name="title" id="title" class="input-adm" placeholder="Digite o título para identificar o e-mail" value="<?php if (isset($valorForm['title'])) { echo $valorForm['title']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Nome:<span class="text-danger"> *</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Nome que será apresentado" value="<?php if (isset($valorForm['name'])) { echo $valorForm['name']; } ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">E-mail:<span class="text-danger"> *</span></label>
                        <input type="email" name="email" id="email" class="input-adm" placeholder="E-mail que será apresentado" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Host:<span class="text-danger"> *</span></label>
                        <input type="text" name="host" id="host" class="input-adm" placeholder="Servidor utilizado para enviar o e-mail" value="<?php if (isset($valorForm['host'])) { echo $valorForm['host']; }?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Usuário:<span class="text-danger"> *</span></label>
                        <input type="text" name="username" id="username" class="input-adm" placeholder="Usuário do e-mail" value="<?php if (isset($valorForm['username'])) { echo $valorForm['username']; } ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">SMTP:<span class="text-danger"> *</span></label>
                        <input type="text" name="smtpsecure" id="smtpsecure" class="input-adm" placeholder="SMTP" value="<?php if (isset($valorForm['smtpsecure'])) { echo $valorForm['smtpsecure']; } ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Porta:<span class="text-danger"> *</span></label>
                        <input type="number" name="port" id="port" class="input-adm" placeholder="Porta" value="<?php if (isset($valorForm['port'])) { echo $valorForm['port']; }?>" required>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" class="btn-success" name="SendEditConfEmail" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->