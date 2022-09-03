<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar as cores
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsListColors
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número da página */
    private int $page;

    /** @var int $limitResult Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 10;

    /** @var string|null $resultPg Recebe a paginação */
    private string|null $resultPg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * @return string|null Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    public function listColors(int $page = null): void
    {   
        $this->page = (int) $page ? $page : 1;
            
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(sit_user.id) AS num_result FROM adms_sits_users sit_user");
        $this->resultPg = $pagination->getResult();

        $listColors = new \App\adms\Models\helper\AdmsRead();
        $listColors->fullRead("SELECT id, name, color FROM adms_colors
                                    ORDER BY id DESC
                                    LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listColors->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Nenhuma cor encontrada!</p>";
            $this->result = false;
        }   
    }
}
