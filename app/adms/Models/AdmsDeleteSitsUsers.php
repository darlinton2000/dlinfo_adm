<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar a situação do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteSitsUsers
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var string $delDirectory Recebe o endereço para apagar o diretório */
    private string $delDirectory;

    /** @var string $delImg Recebe o endereço para apagar a imagem */
    private string $delImg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Responsável por excluir uma determinada situação no banco de dados.
     * Retorna TRUE se conseguir excluir.
     * Retorna FALSE se não conseguir excluir.
     * 
     * @param integer $id
     * @return void
     */
    public function deleteSitUser(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewSit()){
            $deleteSitUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteSitUser->exeDelete("adms_sits_users ", "WHERE id=:id", "id={$this->id}");

            if ($deleteSitUser->getResult()){
                $_SESSION['msg'] = "<p style='color: green;'>Situação apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: red;'>Erro: Situação não apagada com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Retorna o id da situção.
     *
     * @return boolean
     */
    private function viewSit(): bool
    {
        $viewSit = new \App\adms\Models\helper\AdmsRead();
        $viewSit->fullRead("SELECT id FROM adms_sits_users WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewSit->getResult();
        if ($this->resultBd){
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Situação não encontrada!</p>";
            return false;
        }   
    }
}
