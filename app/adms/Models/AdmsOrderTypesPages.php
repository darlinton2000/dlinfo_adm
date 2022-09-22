<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Alterar ordem do tipo de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsOrderTypesPages
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
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Metodo para alterar ordem do tipo de página
     * Recebe o ID do tipo de página que sera usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function orderTypesPages(int $id): void
    {
        $this->id = $id;

        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id, order_type_pg 
                            FROM adms_types_pgs 
                            WHERE id=:id 
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewTypesPages->getResult();
        if ($this->resultBd) {
            $this->viewPrevOrderType();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para recuperar o ordem do tipo de página superior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function viewPrevOrderType(): void
    {
        $prevOrderType = new \App\adms\Models\helper\AdmsRead();
        $prevOrderType->fullRead("SELECT id, order_type_pg 
                            FROM adms_types_pgs 
                            WHERE order_type_pg <:order_type_pg
                            ORDER BY order_type_pg DESC 
                            LIMIT :limit", "order_type_pg={$this->resultBd[0]['order_type_pg']}&limit=1");

        $this->resultBdPrev = $prevOrderType->getResult();
        if ($this->resultBdPrev) {
            $this->editMoveDown();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do tipo de página superior para ser inferior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function editMoveDown(): void
    {
        $this->data['order_type_pg'] = $this->resultBd[0]['order_type_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultBdPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ordem do tipo de página não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do tipo de página inferior para ser superior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function editMoveUp(): void
    {
        $this->data['order_type_pg'] = $this->resultBdPrev[0]['order_type_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveUp = new \App\adms\Models\helper\AdmsUpdate();
        $moveUp->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Ordem do tipo de página editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ordem do tipo de página não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
