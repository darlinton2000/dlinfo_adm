<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar a cor no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteColors
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
     * Responsável por excluir uma determinada cor no banco de dados.
     * Retorna TRUE se conseguir excluir.
     * Retorna FALSE se não conseguir excluir.
     * 
     * @param integer $id
     * @return void
     */
    public function deleteColor(int $id): void
    {
        $this->id = (int) $id;

        if (($this->viewColor()) and ($this->checkColorUser())){
            $deleteColor = new \App\adms\Models\helper\AdmsDelete();
            $deleteColor->exeDelete("adms_colors", "WHERE id=:id", "id={$this->id}");

            if ($deleteColor->getResult()){
                $_SESSION['msg'] = "<p style='color: green;'>Cor apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: red;'>Erro: Cor não apagada com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Retorna o id da cor.
     *
     * @return boolean
     */
    private function viewColor(): bool
    {
        $viewColor = new \App\adms\Models\helper\AdmsRead();
        $viewColor->fullRead("SELECT id FROM adms_colors WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewColor->getResult();
        if ($this->resultBd){
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Cor não encontrada!</p>";
            return false;
        }   
    }

    /**
     * Método verifica se tem situação cadastrada usando a cor a ser excluída, caso tenha a exclusão não é permitida.
     * @return boolean
     */
    private function checkColorUser(): bool
    {
        $viewColorUsed = new \App\adms\Models\helper\AdmsRead();
        $viewColorUsed->fullRead("SELECT id FROM adms_sits_users WHERE adms_color_id =:adms_color_id LIMIT :limit", "adms_color_id={$this->id}&limit=1");
        if ($viewColorUsed->getResult()){
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Cor não pode ser apagada, há situações cadastradas com essa cor!</p>";
            return false;
        } else {    
            return true;
        }
    }
}
