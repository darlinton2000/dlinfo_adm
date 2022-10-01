<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da pagina SyncPagesLevels
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class SyncPagesLevels
{
    /**
     * Metodo SyncPagesLevels
     * Instancia a classe responsavel em sincronizar o nivel de acesso e as paginas
     *
     * @return void
     */
    public function index(): void
    {
        $syncPagesLevels = new \App\adms\Models\AdmsSyncPagesLevels();
        $syncPagesLevels->syncPagesLevels();

        $urlRedirect = URLADM . "list-access-levels/index";
        header("Location: $urlRedirect");
    }
}