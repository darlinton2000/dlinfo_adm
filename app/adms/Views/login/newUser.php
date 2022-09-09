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
            <span>Novo Usuário</span>
        </div>

        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <span id="msg"></span>

        <form method="POST" action="" id="form-new-user" class="form-login">

            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php if (isset($valorForm['name'])) {
                                                                                                            echo $valorForm['name'];
                                                                                                        } ?>" required>
            </div>

            <div class="row">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) {
                                                                                                        echo $valorForm['email'];
                                                                                                    } ?>" required>
            </div>

            <div class="row">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" required>
            </div>
            
            <span id="msgViewStrength"></span>

            <div class="row button">
                <button type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>

        </form>

    </div>
</div>