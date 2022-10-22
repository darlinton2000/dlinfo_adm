<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar as permissoes do nivel de acesso do banco de dados
 *
 * @author Darlinton Luis Siqueira darlinton2000@gmail.com
 */
class AdmsListPermission
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $resultBdLevel Recebe o registro do banco de dados referente ao nivel de acesso */
    private array|null $resultBdLevel;

    /** @var int $page Recebe o numero pagina */
    private int $page;

    /** @var int $level Recebe o id do nivel de acesso */
    private int $level;

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
     * @return bool Retorna o registro do banco de dados referente ao nivel de acesso
     */
    function getResultBdLevel(): array|null
    {
        return $this->resultBdLevel;
    }

    /**
     * @return bool Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    /**
     * Metodo para listar a permissoes do nivel de acesso.
     * Intancia o metodo "viewAccessLevels" para verificar se o usuario tem a permissao de acessar as permissoes do nivel de acesso solicitado.
     * Quando o usuario tem permissao de acesso, pesquisa as permissoes na tabela "adms_levels_pages" e lista as informacoes na view
     * Recebe como parametro "page" para fazer a paginacao
     * Recebe como parametro "level" para indicar de qual nivel de acesso deve retornar as permissoes
     * @param integer|null $page
     * @param integer|null $level
     * @return void
     */
    public function listPermission(int $page = null, int $level = null): void
    {
        $this->page = (int) $page ? $page : 1;
        $this->level = (int) $level;

        if ($this->viewAccessLevels()) {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-permission/index', "?level={$this->level}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination(
                "SELECT COUNT(id) AS num_result 
                                    FROM adms_levels_pages
                                    WHERE adms_access_level_id =:adms_access_level_id",
                "adms_access_level_id={$this->level}"
            );
            $this->resultPg = $pagination->getResult();

            $listPermission = new \App\adms\Models\helper\AdmsRead();
            $listPermission->fullRead("SELECT lev_pag.id, lev_pag.permission, lev_pag.order_level_page, adms_access_level_id, lev_pag.adms_page_id,
                                pag.name_page
                                FROM adms_levels_pages AS lev_pag
                                LEFT JOIN adms_pages AS pag ON pag.id=adms_page_id
                                WHERE lev_pag.adms_access_level_id =:adms_access_level_id
                                ORDER BY lev_pag.order_level_page ASC
                                LIMIT :limit OFFSET :offset", "adms_access_level_id={$this->level}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listPermission->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma permissão encontrada para o nível acesso!</p>";
                $this->result = false;
            }
        } else {
            //$_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma permissão encontrada para o nível acesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para visualizar os detalhes do nivel de acesso
     * Retorna TRUE quando encontrar o registro no banco de dados
     * Senao retorna FALSE indicando que nao tem o nivel de acesso no BD ou o nivel de acesso do usuario nao permite acessa o nivel de acesso superior
     * @return bool
     */
    private function viewAccessLevels(): bool
    {
        $viewAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevels->fullRead("SELECT name
                                FROM adms_access_levels 
                                WHERE id=:id AND order_levels >:order_levels
                                LIMIT :limit", "id={$this->level}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultBdLevel = $viewAccessLevels->getResult();
        if ($this->resultBdLevel) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nível de acesso não encontrado!</p>";
            return false;
        }
    }
}
