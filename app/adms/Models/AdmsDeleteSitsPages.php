<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar situação de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteSitsPages
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
     * Metodo recebe como parametro o ID do registro que será excluido
     * Chama as funções viewSitPages e checkStatusUsed para fazer a confirmação do registro antes de excluir
     * @param integer $id
     * @return void
     */
    public function deleteSitPages(int $id): void
    {
        $this->id = (int) $id;

        if(($this->viewSitPages()) and ($this->checkStatusUsed())){
            $deletePages = new \App\adms\Models\helper\AdmsDelete();
            $deletePages->exeDelete("adms_sits_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deletePages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Situação de página apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação de página não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    /**
     * Metodo verifica se a situação esta cadastrada na tabela e envia o resultado para a função deleteSitPages
     * @return boolean
     */
    private function viewSitPages(): bool
    {

        $viewSitPages = new \App\adms\Models\helper\AdmsRead();
        $viewSitPages->fullRead("SELECT id
                            FROM adms_sits_pgs                           
                            WHERE id=:id
                            LIMIT :limit","id={$this->id}&limit=1");

        $this->resultBd = $viewSitPages->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação de página não encontrada!</p>";
            return false;
        }
    }

    /**
     * Metodo verifica se tem páginas cadastradas usando a situação a ser excluida, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteSitPages
     * @return boolean
     */
    private function checkStatusUsed(): bool
    {
        $viewPagesAdd = new \App\adms\Models\helper\AdmsRead();
        $viewPagesAdd->fullRead("SELECT id FROM adms_pages WHERE adms_sits_pgs_id =:adms_sits_pgs_id LIMIT :limit", "adms_sits_pgs_id={$this->id}&limit=1");
        if($viewPagesAdd->getResult()){
            $_SESSION['msg'] = "<p class='alert-warning'>Erro: Situação não pode ser apagada, há páginas cadastradas com essa situação!</p>";
            return false;
        }else{
            return true;
        }
    }
}
