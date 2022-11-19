<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Alterar ordem do item de menu no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsOrderPageMenu
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $resultBdPrev Recebe os registros do banco de dados */
    private array|null $resultBdPrev;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function orderPageMenu(int $id): void
    {
        $this->id = $id;

        $viewAccessLevel = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevel->fullRead("SELECT lev_pag.id, lev_pag.order_level_page, lev_pag.adms_access_level_id
                                        FROM adms_levels_pages lev_pag   
                                        INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                                        LEFT JOIN adms_pages AS pag ON pag.id=lev_pag.adms_page_id 
                                        WHERE lev_pag.id=:id 
                                        AND lev.order_levels >=:order_levels
                                        AND (((SELECT permission 
                                        FROM adms_levels_pages 
                                        WHERE adms_page_id = lev_pag.adms_page_id 
                                        AND adms_access_level_id = {$_SESSION['adms_access_level_id']}) = 1) 
                                        OR (publish = 1)) 
                                        LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultBd = $viewAccessLevel->getResult();
        if ($this->resultBd) {
            $this->viewPrevPageMenu();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Item de menu não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para recuperar a ordem do item de menu superior
     * Retorna FALSE se houver algum erro
     * @return void
     */
    private function viewPrevPageMenu(): void
    {
        $prevPageMenu = new \App\adms\Models\helper\AdmsRead();
        $prevPageMenu->fullRead("SELECT lev_pag.id, lev_pag.order_level_page
                                        FROM adms_levels_pages AS lev_pag
                                        LEFT JOIN adms_pages AS pag ON pag.id=lev_pag.adms_page_id 
                                        WHERE lev_pag.order_level_page < :order_level_page 
                                        AND lev_pag.adms_access_level_id = :adms_access_level_id
                                        AND (((SELECT permission 
                                        FROM adms_levels_pages 
                                        WHERE adms_page_id = lev_pag.adms_page_id 
                                        AND adms_access_level_id = {$_SESSION['adms_access_level_id']}) = 1) 
                                        OR (publish = 1))
                                        ORDER BY lev_pag.order_level_page DESC
                                        LIMIT :limit", "order_level_page={$this->resultBd[0]['order_level_page']}&adms_access_level_id={$this->resultBd[0]['adms_access_level_id']}&limit=1");

        $this->resultBdPrev = $prevPageMenu->getResult();
        if ($this->resultBdPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Item de menu não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do item de menu superior para ser inferior
     * Retorna FALSE se houver algum erro
     * @return void
     */
    private function editMoveDown(): void
    {
        $this->data['order_level_page'] = $this->resultBd[0]['order_level_page'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->resultBdPrev[0]['id']}");

        if ($moveDown->getResult()){
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ordem do item de menu não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do item de menu inferior para ser superior
     * Retorna FALSE se houver algum erro
     * @return void
     */
    private function editMoveUp(): void
    {
        $this->data['order_level_page'] = $this->resultBdPrev[0]['order_level_page'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveUp = new \App\adms\Models\helper\AdmsUpdate();
        $moveUp->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($moveUp->getResult()){
            $_SESSION['msg'] = "<p class='alert-success'>Ordem do item de menu editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ordem do item de menu não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
