<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar páginas do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsListPages
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
     * Metodo faz a pesquisa das páginas na tabela adms_pages e lista as informações na view
     * Recebe o paramentro "page" para que seja feita a paginação do resultado
     * @param integer|null $page
     * @return void
     */
    public function listPages(int $page = null):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-pages/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_pages");
        $this->resultPg = $pagination->getResult();

        $listPages = new \App\adms\Models\helper\AdmsRead();
        $listPages->fullRead("SELECT pg.id, pg.name_page,
                        tpg.type type_tpg, tpg.name name_tpg,
                        sit.name name_sit,
                        col.color 
                        FROM adms_pages AS pg
                        LEFT JOIN adms_types_pgs AS tpg ON tpg.id=pg.adms_types_pgs_id
                        LEFT JOIN adms_sits_pgs AS sit ON sit.id=pg.adms_sits_pgs_id
                        LEFT JOIN adms_colors AS col ON col.id=sit.adms_color_id
                        ORDER BY id DESC
                        LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listPages->getResult();
        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma página encontrada!</p>";
            $this->result = false;
        }
    }

    
}
