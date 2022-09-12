<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Página inicial do sistema administrativo "dashboard"
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDashboard
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os dados
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Método retornar dados para o dashboard
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    public function countUsers(): void
    {
        $countUsers = new \App\adms\Models\helper\AdmsRead();
        $countUsers->fullRead("SELECT count(id) AS qnt_users FROM adms_users");

        $this->resultBd = $countUsers->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $this->result = false;
        }   
    }
}
