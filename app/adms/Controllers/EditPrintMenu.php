<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar imprimir o item de menu
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditPrintMenu
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var int|string|null $level Recebe o nivel de acesso */
    private int|string|null $level;

    /** @var int|string|null $pag Recebe o numero da pagina */
    private int|string|null $pag;

    /**
     * Metodo editar imprimir o item de menu
     * Receber o id do item de menu que deve ser editado
     * 
     * Se os parametros id, level e pag são diferente de vazio, instancia a MODELS para editar item de menu. Se não existir redireciona para o listar nivel de acesso.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->id = $id;
        $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if ((!empty($this->id)) and (!empty($this->level)) and (!empty($this->pag))) {
            $editPrintMenu = new \App\adms\Models\AdmsEditPrintMenu();
            $editPrintMenu->editPrintMenu($this->id);

            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar o item de menu!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
