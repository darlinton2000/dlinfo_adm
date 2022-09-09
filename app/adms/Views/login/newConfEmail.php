<?php

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

?>

<div class="container-login">
    <div class="wrapper-login">

        <div class="title">
            <span>Novo Link</span>
        </div>

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <span id="msg"></span>

        <form method="POST" action="" id="form-new-conf-email" class="form-login">

            <div class="row">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; } ?>" required>
            </div>

            <div class="row button">
                <button type="submit" name="SendNewConfEmail" value="Enviar">Enviar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>

        </form>

    </div>
</div>