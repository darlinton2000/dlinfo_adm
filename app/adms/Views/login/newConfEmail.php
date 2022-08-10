<?php 
if (isset($this->data['form'])){
    $valorForm = $this->data['form'];
}

?>

<h1>Novo Link</h1>

<?php
if (isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset ($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-new-conf-email">
    <label>Email:</label>
    <input type="email" name="email" id="email" placeholder="Digite o seu email" value="<?php if (isset($valorForm['email'])) { echo $valorForm['email']; }?>" required><br><br>

    <button type="submit" name="SendNewConfEmail" value="Enviar">Enviar</button>
</form>

<p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>