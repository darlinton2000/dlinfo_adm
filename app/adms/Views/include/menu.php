<?php
if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>   

<a href="<?php echo URLADM; ?>dashboard/index">Dashboard</a><br>
<a href="<?php echo URLADM; ?>list-users/index">Usuários</a><br>
<a href="<?php echo URLADM; ?>list-sits-users/index">Situações do Usuário</a><br>
<a href="<?php echo URLADM; ?>list-colors/index">Cores</a><br>
<a href="<?php echo URLADM; ?>list-conf-emails/index">Configurações de E-mail</a><br>
<a href="<?php echo URLADM; ?>view-profile/index">Perfil</a><br>

<a href="<?php echo URLADM; ?>logout/index">Sair</a><br>