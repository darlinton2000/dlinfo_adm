<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar grupos de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsViewGroupsPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

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
     * Metodo para visualizar os detalhes do grupo de página
     * Recebe o ID do grupo de página que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    public function viewGroupsPages(int $id): void
    {
        $this->id = $id;

        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id, name, order_group_pg, created, modified
                            FROM adms_groups_pgs
                            WHERE id=:id
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewGroupsPages->getResult();        
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não encontrado!</p>";
            $this->result = false;
        }
    }
}
