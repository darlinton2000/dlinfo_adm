<?php
if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

$sidebar_active = "";
if (isset($this->data['sidebarActive'])){
    $sidebar_active = $this->data['sidebarActive'];
}
?>   

<!-- Inicio Conteudo -->
<div class="content">
        <!-- Inicio da Sidebar -->
        <div class="sidebar">
            <a href="<?php echo URLADM; ?>dashboard/index" class="sidebar-nav <?php if ($sidebar_active == "dashboard") { echo "active"; } ?>"><i class="icon fa-solid fa-house"></i><span>Dashboard</span></a>

            <a href="<?php echo URLADM; ?>list-users/index" class="sidebar-nav <?php if ($sidebar_active == "list-users") { echo "active"; } ?>"><i class="icon fa-solid fa-users"></i><span>Usuários</span></a>

            <a href="<?php echo URLADM; ?>list-sits-users/index" class="sidebar-nav <?php if ($sidebar_active == "list-sits-users") { echo "active"; } ?>"><i class="icon fa-solid fa-user-check"></i><span>Situações do Usuário</span></a>

            <a href="<?php echo URLADM; ?>list-access-levels/index" class="sidebar-nav <?php if ($sidebar_active == "list-access-levels") { echo "active"; } ?>"><i class="icon fa-solid fa-key"></i><span>Nível de Acesso</span></a>

            <a href="<?php echo URLADM; ?>list-colors/index" class="sidebar-nav <?php if ($sidebar_active == "list-colors") { echo "active"; } ?>"><i class="icon fa-solid fa-palette"></i><span>Cores</span></a>

            <a href="<?php echo URLADM; ?>list-conf-emails/index" class="sidebar-nav <?php if ($sidebar_active == "list-conf-emails") { echo "active"; } ?>"><i class="icon fa-solid fa-envelope"></i><span>Configurações de E-mail</span></a>

            <!-- <a href="<?php echo URLADM; ?>logout/index" class="sidebar-nav"><i class="icon fa-solid fa-arrow-right-from-bracket"></i><span>Sair</span></a> -->
        </div>
        <!-- Fim da Sidebar -->