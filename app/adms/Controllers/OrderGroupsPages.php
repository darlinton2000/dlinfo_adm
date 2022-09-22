<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da pagina alterar ordem do grupo de página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class OrderGroupsPages
{
    /** @var array|string|null $pag Recebe o numero da pagina */
    private array|string|null $pag;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo alterar ordem do grupo de página  
     * Recebe como parametro o ID que sera usado para pesquisar as informacoes no banco de dados e instancia a MODELS AdmsOrderGroupsPages
     * Apos editar ou erro redireciona para o listar grupos de página
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);
        
        if ((!empty($id)) and (!empty($this->pag))) {
            $this->id = (int) $id;

            $viewGroupsPages = new \App\adms\Models\AdmsOrderGroupsPages();
            $viewGroupsPages->orderGroupsPages($this->id);
            if ($viewGroupsPages->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
