<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar a configuração de e-mail do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteConfEmails
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

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
     * Responsável por excluir uma configuração de e-mail no banco de dados.
     * Retorna TRUE se conseguir excluir.
     * Retorna FALSE se não conseguir excluir.
     * 
     * @param integer $id
     * @return void
     */
    public function deleteConfEmail(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewConfEmail()){
            $deleteConfEmail = new \App\adms\Models\helper\AdmsDelete();
            $deleteConfEmail->exeDelete("adms_confs_emails", "WHERE id=:id", "id={$this->id}");

            if ($deleteConfEmail->getResult()){
                $_SESSION['msg'] = "<p style='color: green;'>Configuração de e-mail apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: red;'>Erro: Configuração de e-mail não apagada com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Retorna o id da configuração de e-mail.
     *
     * @return boolean
     */
    private function viewConfEmail(): bool
    {
        $viewConfEmail = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmail->fullRead("SELECT id FROM adms_confs_emails WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewConfEmail->getResult();
        if ($this->resultBd){
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Configuração de e-mail não encontrada!</p>";
            return false;
        }   
    }
}
