<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página alterar ordem do item de menu
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class OrderPageMenu
{
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var int|string|null $level Recebe o nivel de acesso */
    private int|string|null $level;

    /** @var int|string|null $pag Recebe o numero da pagina */
    private int|string|null $pag;

    /**
     * Metodo alterar ordem do item de menu
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->id = (int) $id;
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if ((!empty($this->id)) and (!empty($this->level)) and (!empty($this->pag))){
            $editOrderPageMenu = new \App\adms\Models\AdmsOrderPageMenu();
            $editOrderPageMenu->orderPageMenu($this->id);

            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um item de menu!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
