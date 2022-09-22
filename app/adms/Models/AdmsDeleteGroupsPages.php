<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar grupo de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteGroupsPages
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
     * Chama as funções viewGroupsPages e checkStatusUsed para fazer a confirmação do registro antes de excluir
     * @param integer $id
     * @return void
     */
    public function deleteGroupsPages(int $id): void
    {
        $this->id = (int) $id;

        if(($this->viewGroupsPages()) and ($this->checkStatusUsed())){
            $deleteGroupsPages = new \App\adms\Models\helper\AdmsDelete();
            $deleteGroupsPages->exeDelete("adms_groups_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteGroupsPages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Grupo de página apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não apagado com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    /**
     * Metodo verifica se o grupo de página esta cadastrado na tabela e envia o resultado para a função deleteGroupsPages
     * @return boolean
     */
    private function viewGroupsPages(): bool
    {

        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id
                            FROM adms_groups_pgs                           
                            WHERE id=:id
                            LIMIT :limit","id={$this->id}&limit=1");

        $this->resultBd = $viewGroupsPages->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não encontrado!</p>";
            return false;
        }
    }

    /**
     * Metodo verifica se tem páginas cadastradas usando o grupo de página a ser excluido, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteGroupsPages
     * @return boolean
     */
    private function checkStatusUsed(): bool
    {
        $viewPagesAdd = new \App\adms\Models\helper\AdmsRead();
        $viewPagesAdd->fullRead("SELECT id FROM adms_pages WHERE adms_groups_pgs_id =:adms_groups_pgs_id LIMIT :limit", "adms_groups_pgs_id={$this->id}&limit=1");
        if($viewPagesAdd->getResult()){
            $_SESSION['msg'] = "<p class='alert-warning'>Erro: Grupo de página não pode ser apagado, há páginas cadastradas com esse grupo!</p>";
            return false;
        }else{
            return true;
        }
    }
}
