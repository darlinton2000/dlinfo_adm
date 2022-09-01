<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar os usuários do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsListUsers
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

    public function listUsers(int $page = null): void
    {   
        $this->page = (int) $page ? $page : 1;
            
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-users/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(usr.id) AS num_result FROM adms_users usr");
        $this->resultPg = $pagination->getResult();

        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT usr.id, usr.name AS name_usr, usr.email, usr.adms_sits_user_id, 
                                             sit.name AS name_sit,
                                             col.color
                                             FROM adms_users AS usr
                                             INNER JOIN adms_sits_users AS sit ON sit.id = usr.adms_sits_user_id
                                             INNER JOIN adms_colors AS col ON col.id = sit.adms_color_id
                                             ORDER BY usr.id DESC
                                             LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listUsers->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }   
    }
}
