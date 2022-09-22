<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar tipos de páginas do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsListTypesPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 40;

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
     * Metodo faz a pesquisa dos grupos de páginas na tabela adms_types_pgs e lista as informações na view
     * Recebe o paramentro "page" para que seja feita a paginação do resultado
     * @param integer|null $page
     * @return void
     */
    public function listTypesPages(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-types-pages/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_types_pgs");
        $this->resultPg = $pagination->getResult();

        $listTypesPages = new \App\adms\Models\helper\AdmsRead();
        $listTypesPages->fullRead("SELECT id, type, name, order_type_pg 
                            FROM adms_types_pgs
                            ORDER BY order_type_pg ASC
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listTypesPages->getResult();
        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum tipo de página encontrado!</p>";
            $this->result = false;
        }
    }

    
}
