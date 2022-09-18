<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar as configurações do email do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsListConfEmails
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

    public function listConfEmails(int $page = null): void
    {   
        $this->page = (int) $page ? $page : 1;
            
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-conf-emails/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_confs_emails");
        $this->resultPg = $pagination->getResult();

        $listConfEmails = new \App\adms\Models\helper\AdmsRead();
        $listConfEmails->fullRead("SELECT id, title, name, email FROM adms_confs_emails
                                    ORDER BY id DESC
                                    LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listConfEmails->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma configuração de e-mail encontrada!</p>";
            $this->result = false;
        }   
    }
}
