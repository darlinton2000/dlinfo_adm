<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar nivel de acesso do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsListAccessLevels
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 10;

    /** @var string|null $page Recebe a páginação */
    private string|null $resultPg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * @return bool Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    /**
     * Metodo faz a pesquisa dos niveis de acesso na tabela "adms_access_levels" e lista as informacoes na view
     * Recebe como parametro "page" para fazer a paginacao
     * @param integer|null $page
     * @return void
     */
    public function listAccessLevels(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-access-levels/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result 
                                    FROM adms_access_levels
                                    WHERE order_levels > :order_levels", "order_levels=" . $_SESSION['order_levels']);
        $this->resultPg = $pagination->getResult();

        $listAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $listAccessLevels->fullRead("SELECT id, name, order_levels 
                            FROM adms_access_levels
                            WHERE order_levels > :order_levels
                            ORDER BY order_levels ASC
                            LIMIT :limit OFFSET :offset", "order_levels=" . $_SESSION['order_levels'] . "&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listAccessLevels->getResult();        
        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum nível de acesso encontrado!</p>";
            $this->result = false;
        }
    }

    
}
