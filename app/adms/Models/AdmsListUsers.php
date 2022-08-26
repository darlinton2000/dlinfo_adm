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

    public function listUsers(): void
    {
        $listUsers = new \App\adms\Models\helper\AdmsRead();
        $listUsers->fullRead("SELECT id, name, email FROM adms_users ORDER BY id DESC");

        $this->resultBd = $listUsers->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Nenhum usuário encontrado!</p>";
            $this->result = false;
        }   
    }
}
