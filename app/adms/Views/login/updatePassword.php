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
            <span>Nova Senha</span>
        </div>

        <div class="msg-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo "<span id='msg'> " . $_SESSION['msg'] . "</span>";
                unset($_SESSION['msg']);
            } else {
                echo "<span id='msg'></span>";
            }
            ?>          
        </div>

        <form method="POST" action="" id="form-udpdate-pass" class="form-login">

            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a nova senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php if (isset($valorForm['password'])) { echo $valorForm['password']; } ?>" required>
            </div>

            <span id="msgViewStrength"></span>

            <div class="row button">
                <button type="submit" name="SendUpPass" value="Salvar">Salvar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>

        </form>

    </div>
</div>